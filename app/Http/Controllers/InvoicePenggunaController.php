<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Company;
use App\Models\InvoicePenggunaHeader;
use App\Models\InvoicePenggunaDetail;
use App\Models\PembayaranLangganan;
use App\Models\SubscriptionHeader;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TagihanPelangganExport;

use Midtrans\Config;
use Midtrans\Snap;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PenjualanPaketExport;

class InvoicePenggunaController extends Controller
{
    public function View(Request $request){
        $datatagihan = InvoicePenggunaHeader::where('TotalBayar','<', 'TotalTagihan')
                        ->where(DB::raw("Status <> 'D'"))->get();

        $title = 'Pembatalan Invoice';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("Admin.InvoicePelanggan",[
            'datatagihan' => $datatagihan
        ]);
    }

    public function VoidInvoice(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
        try {
            $update = DB::table('tagihanpenggunaheader')
                        ->where('NoTransaksi','=', $request->NoTransaksi)
                        ->update(
                            [
                                'Status'=>'D'
                            ]
                        );
            $data['success'] = true;
        } catch (\Throwable $th) {
            // alert()->error('Error',$th->getMessage());
            $data['success'] = false;
            $data['message'] = $th->getMessage();
        }

        return response()->json($data);
    }
    public function Form($NoTransaksi = null){

    }

    function GetHeader(Request $request) {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');

        $tagihan = InvoicePenggunaHeader::selectRaw("tagihanpenggunaheader.*, subscriptionheader.NamaSubscription, company.NamaPartner ,
                    pembayarantagihan.TglTransaksi AS TglBayar, pembayarantagihan.MetodePembayaran, pembayarantagihan.NoReff ReffPembayaran, 
                    pembayarantagihan.Keterangan PaymentNote ")
                    ->leftJoin('subscriptionheader', 'subscriptionheader.NoTransaksi', 'tagihanpenggunaheader.KodePaketLangganan')
                    ->leftJoin('company', 'company.KodePartner', 'tagihanpenggunaheader.KodePelanggan')
                    ->leftJoin('pembayarantagihan', 'pembayarantagihan.BaseReff','tagihanpenggunaheader.NoTransaksi')
                    ->whereBetween('tagihanpenggunaheader.TglTransaksi', [$TglAwal, $TglAkhir])
                    ->where('tagihanpenggunaheader.Status','<>', 'D')
                    ->get();
        $data['data'] = $tagihan;
        return response()->json($data);
    }

    function GetPerCompany(Request $request)  {
        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');
        $Status = $request->input('Status');

        $tagihan = InvoicePenggunaHeader::selectRaw("tagihanpenggunaheader.*, subscriptionheader.NamaSubscription, company.NamaPartner, case when tagihanpenggunaheader.TotalBayar > 0 THEN 'LUNAS' ELSE 'BELUM DIBAYAR' END StatusPembayaran ")
                    ->leftJoin('subscriptionheader', 'subscriptionheader.NoTransaksi', 'tagihanpenggunaheader.KodePaketLangganan')
                    ->leftJoin('company', 'company.KodePartner', 'tagihanpenggunaheader.KodePelanggan')
                    ->whereBetween('tagihanpenggunaheader.TglTransaksi', [$TglAwal, $TglAkhir])
                    ->where('KodePelanggan', Auth::user()->RecordOwnerID);
        if ($Status != "") {
            $tagihan->where('tagihanpenggunaheader.Status', $Status);
        }

        return response()->json($tagihan->get());
    }
    public function storeJson(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
        Log::debug($request->all());
        DB::beginTransaction();

        $errorCount = 0;
        $jsonData = $request->json()->all();

        try {
            $NoTransaksi = "";
            $prefix = "INV";
            $lastNoTrx = InvoicePenggunaHeader::where(DB::raw('LEFT(NoTransaksi,3)'),'=',$prefix)->count()+1;
            $NoTransaksi = $prefix.str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);

            $model = new InvoicePenggunaHeader;
            $model->NoTransaksi = $NoTransaksi;
            $model->TglTransaksi = $jsonData['TglTransaksi'];
            $model->TglJatuhTempo = $jsonData['TglJatuhTempo'];
            $model->KodePaketLangganan = $jsonData['KodePaketLangganan'];
            $model->Catatan = $jsonData['Catatan'];
            $model->KodePelanggan = $jsonData['KodePelanggan'];
            $model->TotalTagihan = $jsonData['TotalTagihan'];
            $model->TotalBayar = $jsonData['TotalBayar'];
            $model->Status = 'O';
            $model->StartSubs = $jsonData['StartSubs'];
            $model->EndSubs = $jsonData['EndSubs'];
            $save = $model->save();

            if (!$save) {
                $data['message'] = "Gagal Menyimpan Data Tagihan Pengguna";
                $errorCount += 1;
                goto jump;
            }

            if (count($jsonData['Detail']) == 0) {
                $data['message'] = "Data Detail Item Harus diisi";
                $errorCount += 1;
                goto jump;
            }

            $index = 0;
            foreach ($jsonData['Detail'] as $key) {
                $modelDetail = new InvoicePenggunaDetail;

                $modelDetail->NoTransaksi = $NoTransaksi;
                $modelDetail->NoUrut = $index;
                $modelDetail->Harga = $key['Harga'];
                $modelDetail->Catatan = $key['Catatan'];
                $modelDetail->KodePelanggan = $key['KodePelanggan'];

                $save = $modelDetail->save();

                if (!$save) {
                    $data['message'] = "Gagal Menyimpan Data Detail di Row ".$key->NoUrut;
                    $errorCount += 1;
                    goto jump;
                }

                $index += 1;
            }


            jump:

            if ($errorCount > 0) {
                DB::rollback();
                $data['success'] = false;
            }
            else{
                DB::commit();
                $data['success'] = true;
            }

        } catch (\Exception $e) {
            $data['message'] = $e->getMessage();
        }
        
        return response()->json($data);
    }

    public function SaveInvoice($jsonData){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
        // Log::debug($request->all());
        DB::beginTransaction();

        $errorCount = 0;
        // $jsonData = $request->json()->all();

        try {
            $NoTransaksi = "";
            $prefix = "INV";
            $lastNoTrx = InvoicePenggunaHeader::where(DB::raw('LEFT(NoTransaksi,3)'),'=',$prefix)->count()+1;
            $NoTransaksi = $prefix.str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);

            $taxRate = (float) env('TAX_RATE', 0);

            // Header amounts
            $hTotal   = (float) ($jsonData['Total']  ?? $jsonData['TotalTagihan']);
            $hDiskon  = (float) ($jsonData['Diskon']  ?? 0);
            $hDPP     = $hTotal - $hDiskon;
            $hTax     = round($hDPP * $taxRate / 100, 2);
            $hTagihan = round($hDPP + $hTax, 2);

            $model = new InvoicePenggunaHeader;
            $model->NoTransaksi       = $NoTransaksi;
            $model->TglTransaksi      = $jsonData['TglTransaksi'];
            $model->TglJatuhTempo     = $jsonData['TglJatuhTempo'];
            $model->KodePaketLangganan= $jsonData['KodePaketLangganan'];
            $model->Catatan           = $jsonData['Catatan'];
            $model->KodePelanggan     = $jsonData['KodePelanggan'];
            $model->Total             = $hTotal;
            $model->Diskon            = $hDiskon;
            $model->Tax               = $hTax;
            $model->TotalTagihan      = $hTagihan;
            $model->TotalBayar        = $jsonData['TotalBayar'];
            $model->Status            = 'O';
            $model->StartSubs         = $jsonData['StartSubs'];
            $model->EndSubs           = $jsonData['EndSubs'];
            $save = $model->save();

            if (!$save) {
                $data['message'] = "Gagal Menyimpan Data Tagihan Pengguna";
                $errorCount += 1;
                goto jump;
            }

            if (count($jsonData['Detail']) == 0) {
                $data['message'] = "Data Detail Item Harus diisi";
                $errorCount += 1;
                goto jump;
            }

            // Detail amounts
            $dHarga  = (float) ($jsonData['Detail']['Harga']);
            $dDiskon = (float) ($jsonData['Detail']['Diskon'] ?? 0);
            $dDPP    = $dHarga - $dDiskon;
            $dTax    = round($dDPP * $taxRate / 100, 2);
            $dTotal  = round($dDPP + $dTax, 2);

            $modelDetail = new InvoicePenggunaDetail;
            $modelDetail->NoTransaksi   = $NoTransaksi;
            $modelDetail->NoUrut        = 0;
            $modelDetail->Harga         = $dHarga;
            $modelDetail->Diskon        = $dDiskon;
            $modelDetail->Tax           = $dTax;
            $modelDetail->Total         = $dTotal;
            $modelDetail->Catatan       = $jsonData['Detail']['Catatan'];
            $modelDetail->KodePelanggan = $jsonData['Detail']['KodePelanggan'];

            $save = $modelDetail->save();

            if (!$save) {
                $data['message'] = "Gagal Menyimpan Data Detail di Row 0";
                $errorCount += 1;
                goto jump;
            }


            jump:

            if ($errorCount > 0) {
                DB::rollback();
                $data['success'] = false;
            }
            else{
                DB::commit();
                $data['success'] = true;
            }

        } catch (\Exception $e) {
            DB::rollback();
            Log::debug('SaveInvoice error: ' . $e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }

    public function createMidTransTransaction(Request $request)
    {
		$jsonData = $request->json()->all();

		$TotalPembelian = $jsonData['TotalPembelian'];
		$oCompany = Company::where('KodePartner','=',Auth::user()->RecordOwnerID)->first();
		
		Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Data transaksi yang akan dikirimkan ke Midtrans
        $transaction_details = [
            'order_id' => uniqid(),
            'gross_amount' => floatval($TotalPembelian), // Jumlah total transaksi
        ];

        $customer_details = [
            'first_name' => $oCompany->NamaPartner,
        ];

        $transaction = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        ];

        try {
            $snapToken = Snap::getSnapToken($transaction);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    function SimpanPembayaran(Request $request) {
        Log::debug($request->all());
        try {
            DB::beginTransaction();

            $prefix = "PMB";
            $lastNoTrx = PembayaranLangganan::where(DB::raw('LEFT(NoTransaksi,3)'), '=', $prefix)->count() + 1;
            $NoTransaksi = $prefix . str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);

            $model = new PembayaranLangganan;
            $model->NoTransaksi      = $NoTransaksi;
            $model->TglTransaksi     = $request->input('TglTransaksi');
            $model->BaseReff         = $request->input('BaseReff');
            $model->MetodePembayaran = $request->input('MetodePembayaran');
            $model->NoReff           = $request->input('NoReff');
            $model->Keterangan       = $request->input('Keterangan');
            $model->TotalBayar       = $request->input('TotalBayar');

            if (!$model->save()) {
                throw new \Exception('Penambahan Data Pembayaran Gagal');
            }

            $RecordOwnerID = Auth::user()->RecordOwnerID;
            $company = Company::where('KodePartner', $RecordOwnerID)->first();

            // Insert default data on first activation
            $terminId = null;
            if ($company && ($company->isInitialSetting === null || $company->isInitialSetting != 0)) {
                $terminId = $this->insertDefaultData($RecordOwnerID);
            } else {
                $termin = DB::table('terminpembayaran')->where('RecordOwnerID', $RecordOwnerID)->first();
                $terminId = $termin ? $termin->id : null;
            }

            // Update invoice TotalBayar
            DB::table('tagihanpenggunaheader')
                ->where('NoTransaksi', $request->input('BaseReff'))
                ->update(['TotalBayar' => DB::raw('TotalBayar + ' . floatval($request->input('TotalBayar')))]);

            // Update company subscription
            DB::table('company')
                ->where('KodePartner', $RecordOwnerID)
                ->update([
                    'StartSubs'        => Carbon::now()->format('Y-m-d'),
                    'EndSubs'          => Carbon::now()->addMonth()->format('Y-m-d'),
                    'isActive'         => 1,
                    'GudangPoS'        => 'UMM',
                    'TerminBayarPoS'   => $terminId,
                    'isInitialSetting' => 0,
                ]);

            DB::commit();
            alert()->success('Success', 'Data Pembayaran Berhasil disimpan.');
            return redirect('tagihanpengguna');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug($e->getMessage());

            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    function SimpanPembayaranJson(Request $request) {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jsonData = $request->json()->all();
        try {
            DB::beginTransaction();

            $prefix = "PMB";
            $lastNoTrx = PembayaranLangganan::where(DB::raw('LEFT(NoTransaksi,3)'), '=', $prefix)->count() + 1;
            $NoTransaksi = $prefix . str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);

            $model = new PembayaranLangganan;
            $model->NoTransaksi      = $NoTransaksi;
            $model->TglTransaksi     = Carbon::now()->format('Y-m-d');
            $model->BaseReff         = $jsonData['BaseReff'];
            $model->MetodePembayaran = $jsonData['MetodePembayaran'];
            $model->NoReff           = $jsonData['NoReff'];
            $model->Keterangan       = $jsonData['Keterangan'];
            $model->TotalBayar       = $jsonData['TotalBayar'];

            if (!$model->save()) {
                DB::rollBack();
                $data['message'] = 'Penambahan Data Pembayaran Gagal';
                return response()->json($data);
            }

            $RecordOwnerID = Auth::user()->RecordOwnerID;
            $company = Company::where('KodePartner', $RecordOwnerID)->first();

            // Insert default data on first activation
            $terminId = null;
            if ($company && ($company->isInitialSetting === null || $company->isInitialSetting != 0)) {
                $terminId = $this->insertDefaultData($RecordOwnerID);
            } else {
                $termin = DB::table('terminpembayaran')->where('RecordOwnerID', $RecordOwnerID)->first();
                $terminId = $termin ? $termin->id : null;
            }

            // Update invoice TotalBayar
            DB::table('tagihanpenggunaheader')
                ->where('NoTransaksi', $jsonData['BaseReff'])
                ->update(['TotalBayar' => DB::raw('TotalBayar + ' . floatval($jsonData['TotalBayar']))]);

            // Update company subscription
            DB::table('company')
                ->where('KodePartner', $RecordOwnerID)
                ->update([
                    'StartSubs'        => Carbon::now()->format('Y-m-d'),
                    'EndSubs'          => Carbon::now()->addMonth()->format('Y-m-d'),
                    'isActive'         => 1,
                    'GudangPoS'        => 'UMM',
                    'TerminBayarPoS'   => $terminId,
                    'isInitialSetting' => 0,
                ]);

            DB::commit();
            $data['success'] = true;
        } catch (\Exception $e) {
            DB::rollBack();
            $data['success'] = false;
            $data['message'] = $e->getMessage();
            Log::debug($e->getMessage());
        }

        return response()->json($data);
    }

    private function insertDefaultData(string $RecordOwnerID): ?int
    {
        // 1. kelompokrekening
        if (!DB::table('kelompokrekening')->where('RecordOwnerID', $RecordOwnerID)->exists()) {
            DB::table('kelompokrekening')->insert([
                ['NamaKelompok' => 'ASSETS',                                  'Kelompok' => 1, 'Posisi' => 1, 'FooterLaporan' => '',                              'NeracaLR' => 1, 'RecordOwnerID' => $RecordOwnerID, 'created_at' => null, 'updated_at' => null, 'TempKelompok' => null],
                ['NamaKelompok' => 'HUTANG 1',                                'Kelompok' => 1, 'Posisi' => 2, 'FooterLaporan' => null,                            'NeracaLR' => 1, 'RecordOwnerID' => $RecordOwnerID, 'created_at' => null, 'updated_at' => null, 'TempKelompok' => null],
                ['NamaKelompok' => 'EKUITAS',                                 'Kelompok' => 1, 'Posisi' => 2, 'FooterLaporan' => '',                              'NeracaLR' => 1, 'RecordOwnerID' => $RecordOwnerID, 'created_at' => null, 'updated_at' => null, 'TempKelompok' => null],
                ['NamaKelompok' => 'TURNOVER',                                'Kelompok' => 2, 'Posisi' => 2, 'FooterLaporan' => '',                              'NeracaLR' => 2, 'RecordOwnerID' => $RecordOwnerID, 'created_at' => null, 'updated_at' => null, 'TempKelompok' => null],
                ['NamaKelompok' => 'COST OF SALES',                           'Kelompok' => 2, 'Posisi' => 1, 'FooterLaporan' => '01. LABA KOTOR',               'NeracaLR' => 2, 'RecordOwnerID' => $RecordOwnerID, 'created_at' => null, 'updated_at' => null, 'TempKelompok' => null],
                ['NamaKelompok' => 'OPERATING COSTS',                         'Kelompok' => 2, 'Posisi' => 1, 'FooterLaporan' => '02. LABA USAHA',               'NeracaLR' => 2, 'RecordOwnerID' => $RecordOwnerID, 'created_at' => null, 'updated_at' => null, 'TempKelompok' => null],
                ['NamaKelompok' => 'NON-OPERATING INCOME AND EXPENDITURE',    'Kelompok' => 2, 'Posisi' => 2, 'FooterLaporan' => '03. LABA SEBELUM PAJAK',      'NeracaLR' => 2, 'RecordOwnerID' => $RecordOwnerID, 'created_at' => null, 'updated_at' => null, 'TempKelompok' => null],
                ['NamaKelompok' => 'TAXATION AND EXTRAORDINARY ITEMS',        'Kelompok' => 2, 'Posisi' => 1, 'FooterLaporan' => '04. LABA BERSIH',              'NeracaLR' => 2, 'RecordOwnerID' => $RecordOwnerID, 'created_at' => null, 'updated_at' => null, 'TempKelompok' => null],
            ]);
        }

        // 2. rekeningakutansi
        if (!DB::table('rekeningakutansi')->where('RecordOwnerID', $RecordOwnerID)->exists()) {
            DB::table('rekeningakutansi')->insert([
                ['KodeRekening' => '1000', 'NamaRekening' => 'ASSETS',                              'KodeKelompok' => 1, 'Level' => 1, 'Jenis' => 1, 'KodeRekeningInduk' => null,   'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1101', 'NamaRekening' => 'KAS KECIL',                           'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1102', 'NamaRekening' => 'BANK BCA',                            'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1103', 'NamaRekening' => 'BANK BNI',                            'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1104', 'NamaRekening' => 'BANK MANDIRI',                        'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1105', 'NamaRekening' => 'BANK BSI',                            'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1106', 'NamaRekening' => 'BANK BRI',                            'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1107', 'NamaRekening' => 'E-MONEY - GOPAY',                     'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1108', 'NamaRekening' => 'E-MONEY - OVO',                       'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1109', 'NamaRekening' => 'E-MONEY - SHOPEE',                    'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1110', 'NamaRekening' => 'E-MONEY - DANA',                      'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1111', 'NamaRekening' => 'PIUTANG USAHA',                       'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1112', 'NamaRekening' => 'PERSEDIAAN',                          'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1113', 'NamaRekening' => 'PERSEDIAAN DALAM PERJALANAN',         'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1114', 'NamaRekening' => 'PERSEDIAAN KONSINYASI',               'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1115', 'NamaRekening' => 'PPN MASUKAN',                         'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1116', 'NamaRekening' => 'PPH PASAL 23 DIBAYAR DIMUKA',         'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1117', 'NamaRekening' => 'BANGUNAN',                            'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1118', 'NamaRekening' => 'PERALATAN',                           'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1119', 'NamaRekening' => 'KENDARAAN',                           'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1120', 'NamaRekening' => 'AKUMULASI PENYUSUTAN BANGUNAN',       'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1121', 'NamaRekening' => 'AKUMULASI PENYUSUTAN PERALATAN',      'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1122', 'NamaRekening' => 'AKUMULASI PENYUSUTAN KENDARAAN',      'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '1123', 'NamaRekening' => 'UANG MUKA PEMBELIAN',                 'KodeKelompok' => 1, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '1000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '2000', 'NamaRekening' => 'HUTANG',                              'KodeKelompok' => 2, 'Level' => 1, 'Jenis' => 1, 'KodeRekeningInduk' => null,   'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '2101', 'NamaRekening' => 'HUTANG USAHA',                        'KodeKelompok' => 2, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '2000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '2102', 'NamaRekening' => 'PENDAPATAN DIBAYAR DIMUKA',           'KodeKelompok' => 2, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '2000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '2103', 'NamaRekening' => 'PENJUALAN DIMUKA TRANSIT',            'KodeKelompok' => 2, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '2000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '2104', 'NamaRekening' => 'HUTANG PPH PASAL 21',                 'KodeKelompok' => 2, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '2000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '2105', 'NamaRekening' => 'HUTANG PPH PASAL 23',                 'KodeKelompok' => 2, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '2000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '2106', 'NamaRekening' => 'PPN KELUARAN',                        'KodeKelompok' => 2, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '2000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '2107', 'NamaRekening' => 'HUTANG PPN',                          'KodeKelompok' => 2, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '2000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '2108', 'NamaRekening' => 'HUTANG BANK',                         'KodeKelompok' => 2, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '2000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '2109', 'NamaRekening' => 'UANG MUKA PENJUALAN',                 'KodeKelompok' => 2, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '2000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '2110', 'NamaRekening' => 'PAJAK HIBURAN',                       'KodeKelompok' => 2, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '2000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '2111', 'NamaRekening' => 'HUTANG KONSINYASI',                   'KodeKelompok' => 2, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '2000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '3000', 'NamaRekening' => 'MODAL',                               'KodeKelompok' => 3, 'Level' => 1, 'Jenis' => 1, 'KodeRekeningInduk' => null,   'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '3101', 'NamaRekening' => 'MODAL DISETOR',                       'KodeKelompok' => 3, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '3000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '3102', 'NamaRekening' => 'LABA DITAHAN',                        'KodeKelompok' => 3, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '3000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '3103', 'NamaRekening' => 'LABA TAHUN BERJALAN',                 'KodeKelompok' => 3, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '3000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '3104', 'NamaRekening' => 'DEVIDEN',                             'KodeKelompok' => 3, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '3000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '3105', 'NamaRekening' => 'SALDO EKUITAS AWAL',                  'KodeKelompok' => 3, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '3000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '4000', 'NamaRekening' => 'PENDAPATAN',                          'KodeKelompok' => 4, 'Level' => 1, 'Jenis' => 1, 'KodeRekeningInduk' => null,   'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '4101', 'NamaRekening' => 'PENJUALAN UMUM',                      'KodeKelompok' => 4, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '4000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '4102', 'NamaRekening' => 'PENJUALAN JASA',                      'KodeKelompok' => 4, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '4000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '4103', 'NamaRekening' => 'PENJUALAN PRODUK',                    'KodeKelompok' => 4, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '4000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '4104', 'NamaRekening' => 'PENDAPATAN PENGIRIMAN',               'KodeKelompok' => 4, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '4000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '4105', 'NamaRekening' => 'DISKON PENJUALAN',                    'KodeKelompok' => 4, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '4000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '4106', 'NamaRekening' => 'RETUR PENJUALAN',                     'KodeKelompok' => 4, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '4000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '4107', 'NamaRekening' => 'PENJUALAN LAIN LAIN',                 'KodeKelompok' => 4, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '4000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '4108', 'NamaRekening' => 'PRIVE',                               'KodeKelompok' => 4, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '4000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '5000', 'NamaRekening' => 'HARGA POKOK PENJUALAN',               'KodeKelompok' => 5, 'Level' => 1, 'Jenis' => 1, 'KodeRekeningInduk' => null,   'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '5101', 'NamaRekening' => 'HARGA POKOK PENJUALAN',               'KodeKelompok' => 5, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '5000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '5102', 'NamaRekening' => 'BIAYA PENGIRIMAN',                    'KodeKelompok' => 5, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '5000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '5103', 'NamaRekening' => 'BIAYA PEMBELIAN',                     'KodeKelompok' => 5, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '5000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '5104', 'NamaRekening' => 'DISKON PEMBELIAN',                    'KodeKelompok' => 5, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '5000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '5105', 'NamaRekening' => 'RETUR PEMBELIAN',                     'KodeKelompok' => 5, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '5000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6000', 'NamaRekening' => 'BIAYA OPERASIONAL',                   'KodeKelompok' => 6, 'Level' => 1, 'Jenis' => 1, 'KodeRekeningInduk' => null,   'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6101', 'NamaRekening' => 'BIAYA GAJI OPERASIONAL',              'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6102', 'NamaRekening' => 'BIAYA GAJI ADMINISTRASI',             'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6103', 'NamaRekening' => 'BIAYA PENCAIRAN DIGITAL PAYMENT',     'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6104', 'NamaRekening' => 'BIAYA PEMBAYARAN KELUAR',             'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6105', 'NamaRekening' => 'BIAYA LISTRIK',                       'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6106', 'NamaRekening' => 'BIAYA AIR',                           'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6107', 'NamaRekening' => 'BIAYA KENDARAAN DAN TRANSPORTASI',   'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6108', 'NamaRekening' => 'BIAYA ATK',                           'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6109', 'NamaRekening' => 'BIAYA INTERNET',                      'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6110', 'NamaRekening' => 'BIAYA ENTERTAIMENT',                  'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6111', 'NamaRekening' => 'BIAYA PEMELIHARAN',                   'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6112', 'NamaRekening' => 'BIAYA SEWA',                          'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6113', 'NamaRekening' => 'BIAYA ASURANSI',                      'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6114', 'NamaRekening' => 'BIAYA PERIZINAN',                     'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6115', 'NamaRekening' => 'BIAYA PENYUSUTAN BANGUNAN',           'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6116', 'NamaRekening' => 'BIAYA PENYUSUTAN KENDARAAN',          'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '6117', 'NamaRekening' => 'BIAYA PENYUSUTAN PERALATAN',          'KodeKelompok' => 6, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '6000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '7000', 'NamaRekening' => 'PENDAPATAN LAIN LAIN',                'KodeKelompok' => 7, 'Level' => 1, 'Jenis' => 1, 'KodeRekeningInduk' => null,   'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '7101', 'NamaRekening' => 'PENDAPATAN BUNGA',                    'KodeKelompok' => 7, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '7000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '7102', 'NamaRekening' => 'KEUNTUNGAN SELISIH KURS',             'KodeKelompok' => 7, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '7000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '7103', 'NamaRekening' => 'KEUNTUNGAN PENJUALAN AKTIVA TETAP',   'KodeKelompok' => 7, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '7000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '7104', 'NamaRekening' => 'BIAYA BUNGA',                         'KodeKelompok' => 7, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '7000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '7105', 'NamaRekening' => 'BIAYA ADMINISTRASI BANK',             'KodeKelompok' => 7, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '7000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '7106', 'NamaRekening' => 'BIAYA SELISIH KURS',                  'KodeKelompok' => 7, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '7000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '7107', 'NamaRekening' => 'KERUGIAN PENJUALAN AKTIVA TETAP',     'KodeKelompok' => 7, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '7000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
                ['KodeRekening' => '7108', 'NamaRekening' => 'AYAT SILANG',                         'KodeKelompok' => 7, 'Level' => 2, 'Jenis' => 2, 'KodeRekeningInduk' => '7000', 'SaldoValas' => 0, 'SaldoBase' => 0, 'RecordOwnerID' => $RecordOwnerID],
            ]);
        }

        // 3. gruppelanggan
        if (!DB::table('gruppelanggan')->where('RecordOwnerID', $RecordOwnerID)->exists()) {
            DB::table('gruppelanggan')->insert([
                ['KodeGrup' => '1001', 'NamaGrup' => 'UMUM', 'LevelHarga' => 1, 'DiskonPersen' => 0, 'RecordOwnerID' => $RecordOwnerID],
            ]);
        }

        // 4. pelanggan
        if (!DB::table('pelanggan')->where('RecordOwnerID', $RecordOwnerID)->exists()) {
            DB::table('pelanggan')->insert([
                [
                    'KodePelanggan' => 'CL0001', 'NamaPelanggan' => 'UMUM', 'KodeGrupPelanggan' => '1001',
                    'LimitPiutang' => 0, 'ProvID' => '-1', 'KotaID' => '-1', 'KelID' => '-1', 'KecID' => '-1',
                    'Email' => '', 'NoTlp1' => '', 'NoTlp2' => '', 'Alamat' => '', 'Keterangan' => '',
                    'Status' => 1, 'isPaidMembership' => 0, 'MaxPlay' => 0, 'MemberPrice' => 0,
                    'maxTimePerPlay' => 0, 'PelangganID' => null, 'RecordOwnerID' => $RecordOwnerID,
                    'AllowedDay' => null, 'ValidUntil' => null, 'TglBerlanggananPaketBulanan' => null,
                ],
            ]);
        }

        // 5. supplier
        if (!DB::table('supplier')->where('RecordOwnerID', $RecordOwnerID)->exists()) {
            DB::table('supplier')->insert([
                [
                    'KodeSupplier' => 'SP0001', 'NamaSupplier' => 'UMUM',
                    'ProvID' => '-1', 'KotaID' => '-1', 'KelID' => '-1', 'KecID' => '-1',
                    'Email' => '', 'NoTlp1' => '', 'NoTlp2' => '', 'Alamat' => '',
                    'Keterangan' => '', 'Status' => 1, 'NPWP' => null,
                    'Bank' => null, 'NoRekening' => null, 'PemilikRekening' => null,
                    'RecordOwnerID' => $RecordOwnerID,
                ],
            ]);
        }

        // 6. jenisitem
        if (!DB::table('jenisitem')->where('RecordOwnerID', $RecordOwnerID)->exists()) {
            DB::table('jenisitem')->insert([
                ['KodeJenis' => '10007', 'NamaJenis' => 'BISKUIT',         'RecordOwnerID' => $RecordOwnerID, 'TampilkanEMenu' => 0],
                ['KodeJenis' => '10021', 'NamaJenis' => 'MAKANAN',         'RecordOwnerID' => $RecordOwnerID, 'TampilkanEMenu' => 1],
                ['KodeJenis' => '10022', 'NamaJenis' => 'MAKANAN BAYI',    'RecordOwnerID' => $RecordOwnerID, 'TampilkanEMenu' => 0],
                ['KodeJenis' => '10023', 'NamaJenis' => 'MAKANAN HEWAN',   'RecordOwnerID' => $RecordOwnerID, 'TampilkanEMenu' => 0],
                ['KodeJenis' => '10024', 'NamaJenis' => 'MAKANAN KALENG',  'RecordOwnerID' => $RecordOwnerID, 'TampilkanEMenu' => 0],
                ['KodeJenis' => '10025', 'NamaJenis' => 'MAKANAN PAGI',    'RecordOwnerID' => $RecordOwnerID, 'TampilkanEMenu' => 0],
                ['KodeJenis' => '10029', 'NamaJenis' => 'MINUMAN',         'RecordOwnerID' => $RecordOwnerID, 'TampilkanEMenu' => 1],
                ['KodeJenis' => '10042', 'NamaJenis' => 'ROKOK',           'RecordOwnerID' => $RecordOwnerID, 'TampilkanEMenu' => 1],
            ]);
        }

        // 7. gudang
        if (!DB::table('gudang')->where('RecordOwnerID', $RecordOwnerID)->exists()) {
            DB::table('gudang')->insert([
                ['KodeGudang' => 'UMM', 'NamaGudang' => 'UMUM', 'RecordOwnerID' => $RecordOwnerID],
            ]);
        }

        // 8. satuan
        if (!DB::table('satuan')->where('RecordOwnerID', $RecordOwnerID)->exists()) {
            DB::table('satuan')->insert([
                ['KodeSatuan' => 'BALL',    'NamaSatuan' => 'BALL',    'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'BOTOL',   'NamaSatuan' => 'BOTOL',   'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'BOX',     'NamaSatuan' => 'BOX',     'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'BUNGKUS', 'NamaSatuan' => 'BUNGKUS', 'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'CANs',    'NamaSatuan' => 'CANs',    'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'GONI',    'NamaSatuan' => 'GONI',    'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'KALENG',  'NamaSatuan' => 'KALENG',  'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'KARDUS',  'NamaSatuan' => 'KARDUS',  'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'KARTON',  'NamaSatuan' => 'KARTON',  'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'LITER',   'NamaSatuan' => 'LITER',   'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'LUSIN',   'NamaSatuan' => 'LUSIN',   'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'PACKs',   'NamaSatuan' => 'PACKs',   'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'PAPAN',   'NamaSatuan' => 'PAPAN',   'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'PCs',     'NamaSatuan' => 'PCs',     'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'SLOF',    'NamaSatuan' => 'SLOF',    'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'STRIP',   'NamaSatuan' => 'STRIP',   'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'SUPPORT', 'NamaSatuan' => 'SUPPORT', 'RecordOwnerID' => $RecordOwnerID],
                ['KodeSatuan' => 'TABLET',  'NamaSatuan' => 'TABLET',  'RecordOwnerID' => $RecordOwnerID],
            ]);
        }

        // 9. metodepembayaran
        if (!DB::table('metodepembayaran')->where('RecordOwnerID', $RecordOwnerID)->exists()) {
            DB::table('metodepembayaran')->insert([
                ['NamaMetodePembayaran' => 'QRIS',         'AkunPembayaran' => '1107',    'Active' => 'Y', 'MetodeVerifikasi' => 'AUTO',   'TipePembayaran' => 'NON TUNAI', 'RecordOwnerID' => $RecordOwnerID],
                ['NamaMetodePembayaran' => 'CASH',         'AkunPembayaran' => '1101',    'Active' => 'Y', 'MetodeVerifikasi' => 'MANUAL', 'TipePembayaran' => 'TUNAI',     'RecordOwnerID' => $RecordOwnerID],
                ['NamaMetodePembayaran' => 'EDC BNI',      'AkunPembayaran' => '1103',    'Active' => 'Y', 'MetodeVerifikasi' => 'MANUAL', 'TipePembayaran' => 'NON TUNAI', 'RecordOwnerID' => $RecordOwnerID],
                ['NamaMetodePembayaran' => 'EDC BCA',      'AkunPembayaran' => '1102',    'Active' => 'Y', 'MetodeVerifikasi' => 'MANUAL', 'TipePembayaran' => 'NON TUNAI', 'RecordOwnerID' => $RecordOwnerID],
                ['NamaMetodePembayaran' => 'OFFLINE QRIS', 'AkunPembayaran' => '1110001', 'Active' => 'Y', 'MetodeVerifikasi' => 'MANUAL', 'TipePembayaran' => 'NON TUNAI', 'RecordOwnerID' => $RecordOwnerID],
                ['NamaMetodePembayaran' => 'BANK BCA',     'AkunPembayaran' => '1120001', 'Active' => 'Y', 'MetodeVerifikasi' => 'MANUAL', 'TipePembayaran' => 'NON TUNAI', 'RecordOwnerID' => $RecordOwnerID],
            ]);
        }

        // 10. terminpembayaran — return the ID for use in company update
        $existingTermin = DB::table('terminpembayaran')->where('RecordOwnerID', $RecordOwnerID)->first();
        if ($existingTermin) {
            $terminId = $existingTermin->id;
        } else {
            $terminId = DB::table('terminpembayaran')->insertGetId([
                'NamaTermin'    => 'COD',
                'JumlahHari'    => 0,
                'ExtraDays'     => 1,
                'RecordOwnerID' => $RecordOwnerID,
            ]);
        }

        // 11. settingaccount
        if (!DB::table('settingaccount')->where('RecordOwnerID', $RecordOwnerID)->exists()) {
            DB::table('settingaccount')->insert([
                [
                    'InvAcctHargaPokokPenjualan'    => '5101', 'InvAcctPendapatanJual'           => '4101',
                    'InvAcctPendapatanJasa'         => '4102', 'InvAcctPersediaan'               => '1112',
                    'InvAcctPendapatanNonInventory' => '4107', 'InvAcctPendapatanLainLain'       => '4107',
                    'InvAcctPenyesuaiaanStockMasuk' => '7108', 'InvAcctPenyesuaiaanStockKeluar'  => '7108',
                    'PbAcctPajakPembelian'          => '1115', 'PbAcctPembayaranTunai'           => '1101',
                    'PbAcctPembayaranNonTunai'      => '1102', 'PbAcctHutang'                    => '2101',
                    'PbAcctUangMukaPembelian'       => '1123', 'PjAcctPajakPenjualan'            => '2106',
                    'PjAcctPenjualanTunai'          => '1101', 'PjAcctPenjualanNonTunai'         => '1102',
                    'PjAcctPiutang'                 => '1111', 'PjAcctUangMukaPenjualan'         => '2109',
                    'PjAcctGoodsInTransit'          => '1113', 'PjAcctReturnPenjualan'           => '4106',
                    'PjAcctPajakHiburan'            => '2110', 'KnAcctHutangKonsinyasi'          => '2111',
                    'KnAcctPembayaranHutang'        => '1101', 'KnAcctPenerimaanKonsinyasi'      => '1114',
                    'OthAcctModal'                  => '3101', 'OthAcctPrive'                    => '4108',
                    'OthAcctLabaDitahan'            => '3102', 'OthAcctLabaTahunBerjalan'        => '3103',
                    'OthPajakHiburan'               => null,   'RecordOwnerID'                   => $RecordOwnerID,
                ],
            ]);
        }

        // 12. itemmaster
        if (!DB::table('itemmaster')->where('RecordOwnerID', $RecordOwnerID)->exists()) {
            DB::table('itemmaster')->insert([
                [
                    'KodeItem' => 'JS0001', 'NamaItem' => 'JASA SEWA PERMAINAN', 'KodeJenisItem' => 'JS',
                    'KodeMerk' => '', 'TypeItem' => '4', 'Rak' => '',
                    'KodeGudang' => 'UMM', 'KodeSupplier' => 'SP0001', 'Satuan' => 'manual',
                    'Barcode' => 'JS0001', 'Gambar' => '',
                    'HargaPokokPenjualan' => 0, 'HargaJual' => 0, 'HargaBeliTerakhir' => 0,
                    'Stock' => 0, 'StockMinimum' => 0, 'isKonsinyasi' => 'N', 'Active' => 'Y',
                    'AcctHPP' => '', 'AcctPenjualan' => '', 'AcctPenjualanJasa' => '', 'AcctPersediaan' => '',
                    'VatPercent' => 0.00, 'TampilkanEMenu' => 0, 'RecordOwnerID' => $RecordOwnerID,
                ],
            ]);
        }

        return $terminId;
    }

    public function Export($TglAwal, $TglAkhir)
    {
        return Excel::download(new TagihanPelangganExport($TglAwal, $TglAkhir), 'Daftar Tagihan Pengguna Aplikasi.xlsx');
    }

    public function LaporanPenjualanPaket(Request $request) {
        return view("Admin.LaporanPenjualanPaket");
    }

    public function GetPenjualanPaket(Request $request) {
        $data = array('success' => false, 'message' => '', 'data' => array());

        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');

        $tagihan = InvoicePenggunaHeader::selectRaw("tagihanpenggunaheader.*, subscriptionheader.NamaSubscription, company.NamaPartner ,
                    pembayarantagihan.TglTransaksi AS TglBayar")
                    ->leftJoin('subscriptionheader', 'subscriptionheader.NoTransaksi', 'tagihanpenggunaheader.KodePaketLangganan')
                    ->leftJoin('company', 'company.KodePartner', 'tagihanpenggunaheader.KodePelanggan')
                    ->leftJoin('pembayarantagihan', 'pembayarantagihan.BaseReff','tagihanpenggunaheader.NoTransaksi')
                    ->whereBetween('tagihanpenggunaheader.TglTransaksi', [$TglAwal, $TglAkhir])
                    ->where('tagihanpenggunaheader.Status','<>', 'D')
                    ->get();
        $data['data'] = $tagihan;
        $data['success'] = true;
        return response()->json($data);
    }

    public function ExportPenjualanPaketExcel($TglAwal, $TglAkhir) {
        return Excel::download(new PenjualanPaketExport($TglAwal, $TglAkhir), 'LaporanPenjualanPaket.xlsx');
    }

    public function ExportPenjualanPaketPDF($TglAwal, $TglAkhir) {
        $tagihan = InvoicePenggunaHeader::selectRaw("tagihanpenggunaheader.*, subscriptionheader.NamaSubscription, company.NamaPartner ,
                    pembayarantagihan.TglTransaksi AS TglBayar")
                    ->leftJoin('subscriptionheader', 'subscriptionheader.NoTransaksi', 'tagihanpenggunaheader.KodePaketLangganan')
                    ->leftJoin('company', 'company.KodePartner', 'tagihanpenggunaheader.KodePelanggan')
                    ->leftJoin('pembayarantagihan', 'pembayarantagihan.BaseReff','tagihanpenggunaheader.NoTransaksi')
                    ->whereBetween('tagihanpenggunaheader.TglTransaksi', [$TglAwal, $TglAkhir])
                    ->where('tagihanpenggunaheader.Status','<>', 'D')
                    ->get();

        $pdf = Pdf::loadView('Admin.LaporanPenjualanPaketPDF', ['tagihan' => $tagihan, 'TglAwal' => $TglAwal, 'TglAkhir' => $TglAkhir])->setPaper('a4', 'landscape');
        return $pdf->download('LaporanPenjualanPaket.pdf');
    }


    function CreateNewInvoice(Request $request) {
        $data = array('success' => false, 'message' => '', 'data' => array());
        // Carbon::now()->format('Y-m-d');
        $TglAwal = Carbon::now()->subDays(7)->format('Y-m-d');
        $TglAkhir = Carbon::now()->format('Y-m-d');
        $oCompany = Company::whereBetween('company.EndSubs', [$TglAwal, $TglAkhir])->get();

        $errorCount = 0;
        if (count($oCompany)) {
            foreach ($oCompany as $key) {
                $subs = SubscriptionHeader::where('NoTransaksi',$key->KodePaketLangganan)->first();

                if ($subs) {
                    $NoTransaksi = "";
                    $prefix = "INV";
                    $lastNoTrx = InvoicePenggunaHeader::where(DB::raw('LEFT(NoTransaksi,3)'),'=',$prefix)->count()+1;
                    $NoTransaksi = $prefix.str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);

                    $model = new InvoicePenggunaHeader;
                    $model->NoTransaksi = $NoTransaksi;
                    $model->TglTransaksi = $TglAkhir;
                    $model->TglJatuhTempo = '';
                    $model->KodePaketLangganan = $key->KodePaketLangganan;
                    $model->Catatan = 'Automaticly Generated by System';
                    $model->KodePelanggan = $key->KodePartner;
                    $model->TotalTagihan = $subs->Harga - $subs->Potongan;
                    $model->TotalBayar = $subs->Harga - $subs->Potongan;
                    $model->Status = 'O';
                    $model->StartSubs = Carbon::parse($key->EndSubs)->addDay()->format('Y-m-d');
                    $model->EndSubs = Carbon::parse($key->EndSubs)->subDays(30)->format('Y-m-d');
                    $save = $model->save();

                    if (!$save) {
                        $data['message'] = "Gagal Menyimpan Data Tagihan Pengguna";
                        $errorCount += 1;
                        goto jump;
                    }

                    // if (count($jsonData['Detail']) == 0) {
                    //     $data['message'] = "Data Detail Item Harus diisi";
                    //     $errorCount += 1;
                    //     goto jump;
                    // }

                    $index = 0;
                    // var_dump($jsonData['Detail']["Harga"]);

                    $modelDetail = new InvoicePenggunaDetail;

                    $modelDetail->NoTransaksi = $NoTransaksi;
                    $modelDetail->NoUrut = 0;
                    $modelDetail->Harga = $subs->Harga - $subs->Potongan;
                    $modelDetail->Catatan = 'Automaticly By System';
                    $modelDetail->KodePelanggan = $key->KodePartner;

                    $save = $modelDetail->save();

                    if (!$save) {
                        $data['message'] = "Gagal Menyimpan Data Detail di Row 0";
                        $errorCount += 1;
                        goto jump;
                    }

                    if ($errorCount > 0) {
                        DB::rollback();
                        $data['success'] = false;
                    }
                    else{
                        DB::commit();
                        $data['success'] = true;
                    }

                    // Send Mail
                }
            }
        }

        jump:
    }
}
