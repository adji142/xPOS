<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Log;
use Exception;

use App\Models\User;
use App\Models\TableOrderHeader;
use App\Models\TableOrderFnB;
use App\Models\FakturPenjualanHeader;
use App\Models\FakturPenjualanDetail;
use App\Models\PembayaranPenjualanHeader;
use App\Models\PembayaranPenjualanDetail;
use App\Models\MetodePembayaran;
use App\Models\DocumentNumbering;
use App\Models\Company;
use App\Services\AccountingService;

class GenerateDocumentController extends Controller
{
    public function generate(Request $request)
    {
        $data = [
            'success'         => false,
            'message'         => '',
            'total_processed' => 0,
            'generated'       => [],
        ];

        set_time_limit(0);
        ini_set('memory_limit', '256M');

        $RecordOwnerID = $request->input('RecordOwnerID');
        Log::info("[GenerateDocument] START - RecordOwnerID: {$RecordOwnerID}");

        if (empty($RecordOwnerID)) {
            $data['message'] = 'RecordOwnerID tidak boleh kosong';
            return response()->json($data);
        }

        // Set auth user sementara agar DocumentNumbering & AccountingService bisa berjalan
        Log::info("[GenerateDocument] Mencari user dengan RecordOwnerID: {$RecordOwnerID}");
        $user = User::where('RecordOwnerID', $RecordOwnerID)->first();
        if (!$user) {
            $data['message'] = "User dengan RecordOwnerID '{$RecordOwnerID}' tidak ditemukan";
            Log::warning("[GenerateDocument] User tidak ditemukan: {$RecordOwnerID}");
            return response()->json($data);
        }
        Auth::setUser($user);
        Log::info("[GenerateDocument] Auth user set: {$user->name}");

        $oCompany = Company::where('KodePartner', $RecordOwnerID)->first();
        if (!$oCompany) {
            $data['message'] = "Data company untuk RecordOwnerID '{$RecordOwnerID}' tidak ditemukan";
            Log::warning("[GenerateDocument] Company tidak ditemukan: {$RecordOwnerID}");
            return response()->json($data);
        }
        Log::info("[GenerateDocument] Company ditemukan, isPostingAkutansi: {$oCompany->isPostingAkutansi}");

        $metodeCash = MetodePembayaran::where('RecordOwnerID', $RecordOwnerID)
            ->where('NamaMetodePembayaran', 'CASH')
            ->first();

        if (!$metodeCash || empty($metodeCash->AkunPembayaran)) {
            $data['message'] = "Metode pembayaran CASH tidak ditemukan atau AkunPembayaran belum dikonfigurasi";
            Log::warning("[GenerateDocument] MetodePembayaran CASH tidak valid untuk RecordOwnerID: {$RecordOwnerID}");
            return response()->json($data);
        }
        Log::info("[GenerateDocument] MetodePembayaran CASH ditemukan, AkunPembayaran: {$metodeCash->AkunPembayaran}");

        $totalOrders = TableOrderHeader::where('RecordOwnerID', $RecordOwnerID)->count();

        if ($totalOrders === 0) {
            $data['message'] = "Tidak ada data di tableorderheader untuk RecordOwnerID '{$RecordOwnerID}'";
            Log::warning("[GenerateDocument] tableorderheader kosong untuk RecordOwnerID: {$RecordOwnerID}");
            return response()->json($data);
        }
        Log::info("[GenerateDocument] Total order ditemukan: {$totalOrders}");

        try {
            TableOrderHeader::where('RecordOwnerID', $RecordOwnerID)
                ->orderBy('NoTransaksi')
                ->chunk(50, function ($orders) use ($metodeCash, $oCompany, $RecordOwnerID, &$data) {
                    foreach ($orders as $order) {
                        Log::info("[GenerateDocument] Memproses order: {$order->NoTransaksi}");

                        // Lewati order yang sudah punya faktur
                        $existing = FakturPenjualanHeader::where('NoReff', $order->NoTransaksi)
                            ->where('RecordOwnerID', $RecordOwnerID)
                            ->first();

                        if ($existing) {
                            Log::info("[GenerateDocument] Order {$order->NoTransaksi} di-skip, faktur sudah ada: {$existing->NoTransaksi}");
                            $data['generated'][] = [
                                'NoOrder' => $order->NoTransaksi,
                                'status'  => 'skipped',
                                'message' => 'Faktur sudah ada: ' . $existing->NoTransaksi,
                            ];
                            continue;
                        }

                        DB::beginTransaction();
                        try {
                            $result = $this->processOrder($order, $metodeCash, $oCompany, $RecordOwnerID);
                            DB::commit();
                            $data['generated'][] = $result;
                            $data['total_processed']++;
                            Log::info("[GenerateDocument] Order {$order->NoTransaksi} selesai - Faktur: {$result['NoFaktur']}, Pembayaran: {$result['NoPembayaran']}");
                        } catch (Exception $e) {
                            DB::rollback();
                            Log::error("[GenerateDocument] ERROR order {$order->NoTransaksi} - " . $e->getMessage(), [
                                'file'  => $e->getFile(),
                                'line'  => $e->getLine(),
                                'trace' => $e->getTraceAsString(),
                            ]);
                            $data['generated'][] = [
                                'NoOrder' => $order->NoTransaksi,
                                'status'  => 'error',
                                'message' => $e->getMessage(),
                            ];
                        }
                    }
                });

            $data['success'] = true;
            $data['message']  = $data['total_processed'] . " order berhasil diproses";
            Log::info("[GenerateDocument] SELESAI - Total diproses: {$data['total_processed']}");

        } catch (Exception $e) {
            Log::error("[GenerateDocument] ERROR FATAL - " . $e->getMessage(), [
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }

    private function processOrder($order, $metodeCash, $oCompany, $RecordOwnerID)
    {
        $result = [
            'NoOrder'      => $order->NoTransaksi,
            'NoFaktur'     => null,
            'NoPembayaran' => null,
            'status'       => 'success',
        ];

        $TglTransaksi = $order->TglTransaksi;
        $tgl   = Carbon::parse($TglTransaksi);
        $Year  = $tgl->format('Y');
        $Month = $tgl->format('m');
        $Gross             = floatval($order->Gross        ?? $order->GrossTotal ?? 0);
        $TotalDiskon       = floatval($order->TotalDiskon  ?? $order->DiscTotal  ?? 0);
        $TotalMakanan      = floatval($order->TotalMakanan ?? 0);
        $TotalTax          = floatval($order->TotalTax     ?? $order->TaxTotal   ?? 0);
        $TotalPajakHiburan = floatval($order->TotalPajakHiburan ?? 0);
        $BiayaLayanan      = floatval($order->BiayaLayanan ?? 0);
        $NetTotal          = floatval($order->NetTotal     ?? 0);
        $TotalTerbayar     = floatval($order->TotalTerbayar ?? $NetTotal);

        $numbering = new DocumentNumbering();

        // =========================================================
        // STEP 1: FAKTUR PENJUALAN HEADER
        // =========================================================
        Log::info("[GenerateDocument][{$order->NoTransaksi}] STEP 1 - Generate FakturPenjualanHeader");
        $NoFaktur = $numbering->GetNewDocMobile("OINV", "fakturpenjualanheader", "NoTransaksi", $RecordOwnerID);
        Log::info("[GenerateDocument][{$order->NoTransaksi}] NoFaktur generated: {$NoFaktur}");

        $faktur = new FakturPenjualanHeader;
        $faktur->Periode        = $Year . $Month;
        $faktur->Transaksi      = 'PJL';
        $faktur->NoTransaksi    = $NoFaktur;
        $faktur->TglTransaksi   = $TglTransaksi;
        $faktur->TglJatuhTempo  = $TglTransaksi;
        $faktur->NoReff         = "POS";
        $faktur->KodePelanggan  = $order->KodePelanggan;
        $faktur->KodeTermin     = '';
        $faktur->Termin         = 'COD';
        $faktur->TotalTransaksi = $Gross;
        $faktur->Potongan       = $TotalDiskon;
        $faktur->Pajak          = $TotalTax;
        $faktur->PajakHiburan   = $TotalPajakHiburan;
        $faktur->BiayaLayanan   = $BiayaLayanan;
        $faktur->TotalPembelian = $NetTotal;
        $faktur->TotalRetur     = 0;
        $faktur->TotalPembayaran = $TotalTerbayar;
        $faktur->Status         = 'O';
        $faktur->Keterangan     = 'Generated from TableOrder ' . $order->NoTransaksi;
        $faktur->MetodeBayar    = 'CASH';
        $faktur->ReffPembayaran = '';
        $faktur->KodeSales      = $order->KodeSales ?? '';
        $faktur->Posted         = 0;
        $faktur->CreatedBy      = 'SYSTEM';
        $faktur->UpdatedBy      = '';
        $faktur->TipeOrder      = 1;
        $faktur->NomorMeja      = (string) ($order->tableid ?? '');
        $faktur->RecordOwnerID  = $RecordOwnerID;
        $faktur->save();
        Log::info("[GenerateDocument][{$order->NoTransaksi}] FakturPenjualanHeader tersimpan: {$NoFaktur}");

        $result['NoFaktur'] = $NoFaktur;

        // =========================================================
        // STEP 2: FAKTUR PENJUALAN DETAIL
        // =========================================================
        Log::info("[GenerateDocument][{$order->NoTransaksi}] STEP 2 - Generate FakturPenjualanDetail");
        $noUrut = 1;

        // Detail baris 1: Biaya sewa meja / paket (Gross dikurangi total makanan)
        $serviceFee = $Gross - $TotalMakanan;
        Log::info("[GenerateDocument][{$order->NoTransaksi}] ServiceFee (Gross - TotalMakanan): {$serviceFee}");
        if ($serviceFee > 0) {
            $det = new FakturPenjualanDetail;
            $det->NoTransaksi         = $NoFaktur;
            $det->BaseReff            = $order->NoTransaksi;
            $det->NoUrut              = $noUrut;
            $det->BaseLine            = $noUrut;
            $det->KodeItem            = 'JS0001';
            $det->Qty                 = $order->DurasiPaket ?? 1;
            $det->QtyKonversi         = $order->DurasiPaket ?? 1;
            $det->QtyRetur            = 0;
            $det->Satuan              = $order->JenisPaket ?? 'Jam';
            $det->Harga               = $serviceFee;
            $det->Discount            = 0;
            $det->HargaNet            = $serviceFee;
            $det->LineStatus          = 'O';
            $det->KodeGudang          = '';
            $det->Keterangan          = 'Sewa Meja / Paket';
            $det->VatPercent          = 0;
            $det->HargaPokokPenjualan = 0;
            $det->Pajak               = 0;
            $det->PajakHiburan        = $TotalPajakHiburan;
            $det->VatTotal            = 0;
            $det->RecordOwnerID       = $RecordOwnerID;
            $det->save();
            Log::info("[GenerateDocument][{$order->NoTransaksi}] Detail sewa meja tersimpan - NoUrut: {$noUrut}, KodeItem: JS0001, Qty: {$det->Qty}, Harga: {$serviceFee}");
            $noUrut++;
        }

        // Detail baris FnB: dari tableorderfnb
        $fnbItems = TableOrderFnB::where('NoTransaksi', $order->NoTransaksi)
            ->where('RecordOwnerID', $RecordOwnerID)
            ->get();
        Log::info("[GenerateDocument][{$order->NoTransaksi}] Total FnB items: {$fnbItems->count()}");

        foreach ($fnbItems as $fnb) {
            $det = new FakturPenjualanDetail;
            $det->NoTransaksi         = $NoFaktur;
            $det->BaseReff            = $order->NoTransaksi;
            $det->NoUrut              = $noUrut;
            $det->BaseLine            = $fnb->LineNumber;
            $det->KodeItem            = $fnb->KodeItem;
            $det->Qty                 = $fnb->Qty;
            $det->QtyKonversi         = $fnb->Qty;
            $det->QtyRetur            = 0;
            $det->Satuan              = 'PCs';
            $det->Harga               = $fnb->Harga;
            $det->Discount            = floatval($fnb->Discount ?? 0);
            $det->HargaNet            = $fnb->LineTotal;
            $det->LineStatus          = 'O';
            $det->KodeGudang          = '';
            $det->Keterangan          = '';
            $det->VatPercent          = 0;
            $det->HargaPokokPenjualan = 0;
            $det->Pajak               = floatval($fnb->Tax ?? 0);
            $det->PajakHiburan        = 0;
            $det->VatTotal            = floatval($fnb->Tax ?? 0);
            $det->RecordOwnerID       = $RecordOwnerID;
            $det->save();
            Log::info("[GenerateDocument][{$order->NoTransaksi}] Detail FnB tersimpan - NoUrut: {$noUrut}, KodeItem: {$fnb->KodeItem}, Qty: {$fnb->Qty}");
            $noUrut++;
        }

        // =========================================================
        // STEP 3: PEMBAYARAN PENJUALAN HEADER
        // =========================================================
        Log::info("[GenerateDocument][{$order->NoTransaksi}] STEP 3 - Generate PembayaranPenjualanHeader");
        $NoPembayaran = $numbering->GetNewDocMobile("INPAY", "pembayaranpenjualanheader", "NoTransaksi", $RecordOwnerID);
        Log::info("[GenerateDocument][{$order->NoTransaksi}] NoPembayaran generated: {$NoPembayaran}");

        $bayar = new PembayaranPenjualanHeader;
        $bayar->Periode               = $Year . $Month;
        $bayar->NoTransaksi           = $NoPembayaran;
        $bayar->TglTransaksi          = $TglTransaksi;
        $bayar->KodePelanggan         = $order->KodePelanggan;
        $bayar->TotalPembelian        = $NetTotal;
        $bayar->TotalPembayaran       = $TotalTerbayar;
        $bayar->BiayaLayanan          = $BiayaLayanan;
        $bayar->KodeMetodePembayaran  = $metodeCash->id;
        $bayar->NoReff                = $NoFaktur;
        $bayar->Keterangan            = 'Pembayaran Cash Faktur ' . $NoFaktur;
        $bayar->CreatedBy             = 'SYSTEM';
        $bayar->UpdatedBy             = '';
        $bayar->Posted                = 0;
        $bayar->Status                = 'O';
        $bayar->RecordOwnerID         = $RecordOwnerID;
        $bayar->save();
        Log::info("[GenerateDocument][{$order->NoTransaksi}] PembayaranPenjualanHeader tersimpan: {$NoPembayaran}, TotalTerbayar: {$TotalTerbayar}");

        $result['NoPembayaran'] = $NoPembayaran;

        // =========================================================
        // STEP 4: PEMBAYARAN PENJUALAN DETAIL
        // =========================================================
        Log::info("[GenerateDocument][{$order->NoTransaksi}] STEP 4 - Generate PembayaranPenjualanDetail");
        $bayarDet = new PembayaranPenjualanDetail;
        $bayarDet->NoTransaksi          = $NoPembayaran;
        $bayarDet->NoUrut               = 0;
        $bayarDet->BaseReff             = $NoFaktur;
        $bayarDet->TotalPembayaran      = $TotalTerbayar;
        $bayarDet->KodeMetodePembayaran = $metodeCash->id;
        $bayarDet->Keterangan           = 'Pembayaran Cash Faktur ' . $NoFaktur;
        $bayarDet->RecordOwnerID        = $RecordOwnerID;
        $bayarDet->save();
        Log::info("[GenerateDocument][{$order->NoTransaksi}] PembayaranPenjualanDetail tersimpan - BaseReff: {$NoFaktur}");

        // =========================================================
        // STEP 5: JURNAL (hanya jika isPostingAkutansi aktif)
        // =========================================================
        if ($oCompany->isPostingAkutansi == 1) {
            Log::info("[GenerateDocument][{$order->NoTransaksi}] STEP 5 - Generate Jurnal");

            // --- Jurnal Faktur Penjualan ---
            Log::info("[GenerateDocument][{$order->NoTransaksi}] STEP 5a - Jurnal Faktur OINV: {$NoFaktur}, NetTotal: {$NetTotal}, TotalTax: {$TotalTax}, PajakHiburan: {$TotalPajakHiburan}");
            $jFaktur = new AccountingService();
            $jFaktur->initialize("OINV", $TglTransaksi, $NoFaktur, "O", false);

            // Dr. Piutang Usaha
            $res = $jFaktur->addDetailFromSetting("PjAcctPiutang", 1, $NetTotal, "Faktur " . $NoFaktur);
            if (!$res['success']) throw new Exception("[Jurnal Faktur - PjAcctPiutang] " . $res['message']);

            // Cr. PPN Keluaran
            if ($TotalTax > 0) {
                $res = $jFaktur->addDetailFromSetting("PjAcctPajakPenjualan", 2, $TotalTax, "Faktur " . $NoFaktur);
                if (!$res['success']) throw new Exception("[Jurnal Faktur - PjAcctPajakPenjualan] " . $res['message']);
            }

            // Cr. Pajak Hiburan
            if ($TotalPajakHiburan > 0) {
                $res = $jFaktur->addDetailFromSetting("PjAcctPajakHiburan", 2, $TotalPajakHiburan, "Faktur " . $NoFaktur);
                if (!$res['success']) throw new Exception("[Jurnal Faktur - PjAcctPajakHiburan] " . $res['message']);
            }

            // Cr. Penjualan Jasa (DPP = NetTotal dikurangi pajak)
            $nilaiPenjualan = $NetTotal - $TotalTax - $TotalPajakHiburan;
            Log::info("[GenerateDocument][{$order->NoTransaksi}] NilaiPenjualan (DPP): {$nilaiPenjualan}");
            if ($nilaiPenjualan > 0) {
                $res = $jFaktur->addDetailFromSetting("InvAcctPendapatanJasa", 2, $nilaiPenjualan, "Faktur " . $NoFaktur);
                if (!$res['success']) throw new Exception("[Jurnal Faktur - InvAcctPendapatanJasa] " . $res['message']);
            }

            $res = $jFaktur->save();
            if (!$res['success']) throw new Exception("[Jurnal Faktur - save] " . $res['message']);
            Log::info("[GenerateDocument][{$order->NoTransaksi}] Jurnal Faktur tersimpan");

            // --- Jurnal Pembayaran Penjualan ---
            Log::info("[GenerateDocument][{$order->NoTransaksi}] STEP 5b - Jurnal Pembayaran INPAY: {$NoPembayaran}, TotalTerbayar: {$TotalTerbayar}");
            $jBayar = new AccountingService();
            $jBayar->initialize("INPAY", $TglTransaksi, $NoPembayaran, "O", false);

            // Dr. Kas
            $res = $jBayar->addDetailWithAccount($metodeCash->AkunPembayaran, 1, $TotalTerbayar, "Pembayaran " . $NoPembayaran);
            if (!$res['success']) throw new Exception("[Jurnal Pembayaran - Kas] " . $res['message']);

            // Cr. Piutang Usaha
            $res = $jBayar->addDetailFromSetting("PjAcctPiutang", 2, $TotalTerbayar, "Pembayaran " . $NoPembayaran);
            if (!$res['success']) throw new Exception("[Jurnal Pembayaran - PjAcctPiutang] " . $res['message']);

            $res = $jBayar->save();
            if (!$res['success']) throw new Exception("[Jurnal Pembayaran - save] " . $res['message']);
            Log::info("[GenerateDocument][{$order->NoTransaksi}] Jurnal Pembayaran tersimpan");

        } else {
            Log::info("[GenerateDocument][{$order->NoTransaksi}] STEP 5 - Jurnal di-skip (isPostingAkutansi != 1)");
        }

        return $result;
    }
}
