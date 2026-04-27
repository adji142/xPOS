<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\ItemMaster;
use App\Models\JenisItem;
use App\Models\Kertas;
use App\Models\Pelanggan;
use App\Models\Supplier;
use App\Models\Gudang;
use App\Models\KelompokRekening;
use App\Models\Company;
use App\Models\Rekening;

class ReportController extends Controller
{
    function KartuStock(Request $request){

        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');
        $KodeItem = $request->input('KodeItem');
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $kartustock = DB::select('CALL rsp_laporan_kartu_stock(?, ?, ?, ?)', [$TglAwal, $TglAkhir, $KodeItem, $RecordOwnerID]);
        $itemmaster = ItemMaster::where('RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->where('Active', DB::raw("'Y'"))
                        ->get();

        return view("report.inventory.KartuStock",[
			'kartustock' => $kartustock,
            'itemmaster' => $itemmaster,
            'oldTglAwal' => $TglAwal,
            'oldTglAkhir' => $TglAkhir,
            'oldKodeItem' => $KodeItem,
		]);
    }

    function RptSaldoStock(Request $request) {
        $KodeGudang = $request->input('KodeGudang');
        $ShowZero = $request->input('ShowZero');
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $sakdostock = DB::select('CALL rsp_SaldoStock(?, ?, ?)', [(empty($KodeGudang) ? "" : $KodeGudang), $RecordOwnerID, $ShowZero]);
        $gudang = Gudang::where('RecordOwnerID', Auth::user()->RecordOwnerID)
                    ->get();
        
        return view("report.inventory.saldostock",[
			'sakdostock' => $sakdostock,
            'gudang' => $gudang,
            'oldKodeGudang' => $KodeGudang,
            'oldShowZero' => $ShowZero
		]);
    }

    function GetKertas(Request $request) {
        $data = array('success'=>false, 'message'=>'', 'data'=>array());
        
        $IDKertas = $request->input('IDKertas');

        $kertas = Kertas::where('id', $IDKertas)->get();
        $data['success'] = true;
        $data['data'] = $kertas;
        return response()->json($data);
    }

    function GenerateBarcode(Request $request) {
        $itemmaster = ItemMaster::where('RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->where('Active', DB::raw("'Y'"))
                        ->get();
        $kertas = Kertas::all();
        $jenisitem = JenisItem::where('RecordOwnerID', Auth::user()->RecordOwnerID)
                            ->get();

        // GenerateBarcode
        return view("report.inventory.GenerateBarcode",[
			'kertas' => $kertas,
            'itemmaster' => $itemmaster,
            'jenisitem' => $jenisitem
		]);
    }

    function GenerateBarcodeTemplate(Request $request) {
        // $Orientasi, $JenisKertas, $PanjangLabel, $LebarLabel, $Gap, $KodeItemAwal, $KodeItemAkhir, $JenisItem
        $Orientasi = $request->input('Orientasi');
        $JenisKertas = $request->input('JenisKertas');
        $PanjangLabel = $request->input('PanjangLabel');
        $LebarLabel = $request->input('LebarLabel');
        $Gap = $request->input('Gap');
        $KodeItemAwal = $request->input('KodeItemAwal');
        $KodeItemAkhir = $request->input('KodeItemAkhir');
        $JenisItem = $request->input('JenisItem');

        $itemmaster = ItemMaster::where('RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->whereBetween('KodeItem', [$KodeItemAwal, $KodeItemAkhir])
                        ->where('Active', DB::raw("'Y'"))
                        ->where('KodeJenisItem', $JenisItem)
                        ->get();
        $detailkertas = Kertas::where('id', $JenisKertas)->get();
        // var_dump($itemmaster);

        return view("report.inventory.GenerateTemplateBarcode",[
			'Orientasi' => $Orientasi,
            'JenisKertas' => $JenisKertas,
            'PanjangLabel' => $PanjangLabel,
            'LebarLabel' => $LebarLabel,
            'Gap' => $Gap,
            'itemmaster' => $itemmaster,
            'detailkertas' => $detailkertas
		]);
    }

    function RptPenjualan(Request $request) {
        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');
        $Pelanggan = $request->input('Pelanggan');
        $StatusTransaksi = $request->input('StatusTransaksi');
        $TipeLaporan = $request->input('TipeLaporan');
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $penjualan = DB::select('CALL rsp_Penjualan(?, ?, ?, ?,?)', [$TglAwal, $TglAkhir, (empty($Pelanggan) ? "" : $Pelanggan), $RecordOwnerID, (empty($StatusTransaksi) ? "" : $StatusTransaksi)]);
        $opelanggan = Pelanggan::where('RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->where('Status', 1)
                        ->get();
        
        return view("report.penjualan.penjualan",[
			'penjualan' => $penjualan,
            'pelanggan' => $opelanggan,
            'oldTglAwal' => $TglAwal,
            'oldTglAkhir' => $TglAkhir,
            'oldPelanggan' => $Pelanggan,
            'oldStatus' => $StatusTransaksi,
            'oldTipeLaporan' => $TipeLaporan
		]);
    }

    function RptReturPenjualan(Request $request) {
        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');
        $Pelanggan = $request->input('Pelanggan');
        $TipeLaporan = $request->input('TipeLaporan');
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $penjualan = DB::select('CALL rps_ReturPenjualan(?, ?, ?, ?)', [$TglAwal, $TglAkhir, (empty($Pelanggan) ? "" : $Pelanggan), $RecordOwnerID]);
        $opelanggan = Pelanggan::where('RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->where('Status', 1)
                        ->get();
        
        return view("report.penjualan.returpenjualan",[
			'penjualan' => $penjualan,
            'pelanggan' => $opelanggan,
            'oldTglAwal' => $TglAwal,
            'oldTglAkhir' => $TglAkhir,
            'oldPelanggan' => $Pelanggan,
            'oldTipeLaporan' => $TipeLaporan
		]);
    }

    function RptPembayaranPenjualan(Request $request) {
        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $penjualan = DB::select('CALL rsp_PembayaranPenjualan(?, ?, ?)', [$TglAwal, $TglAkhir, $RecordOwnerID]);

        
        return view("report.penjualan.pembayaranpenjualan",[
			'penjualan' => $penjualan,
            'oldTglAwal' => $TglAwal,
            'oldTglAkhir' => $TglAkhir,
		]);
    }

    function RptPembelian(Request $request) {
        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');
        $Supplier = $request->input('Supplier');
        $StatusTransaksi = $request->input('StatusTransaksi');
        $TipeLaporan = $request->input('TipeLaporan');
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $pembelian = DB::select('CALL rsp_Pembelian(?, ?, ?, ?,?)', [$TglAwal, $TglAkhir, (empty($Supplier) ? "" : $Supplier), $RecordOwnerID, (empty($StatusTransaksi) ? "" : $StatusTransaksi)]);
        $osupplier = Supplier::where('RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->where('Status', 1)
                        ->get();
        
        return view("report.pembelian.pembelian",[
			'pembelian' => $pembelian,
            'supplier' => $osupplier,
            'oldTglAwal' => $TglAwal,
            'oldTglAkhir' => $TglAkhir,
            'oldSupplier' => $Supplier,
            'oldStatus' => $StatusTransaksi,
            'oldTipeLaporan' => $TipeLaporan
		]);
    }

    function RptReturPembelian(Request $request) {
        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');
        $Supplier = $request->input('Supplier');
        $TipeLaporan = $request->input('TipeLaporan');
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $pembelian = DB::select('CALL rsp_ReturPembelian(?, ?, ?, ?)', [$TglAwal, $TglAkhir, (empty($Supplier) ? "" : $Supplier), $RecordOwnerID]);
        $osupplier = Supplier::where('RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->where('Status', 1)
                        ->get();
        
        return view("report.pembelian.returpembelian",[
			'pembelian' => $pembelian,
            'supplier' => $osupplier,
            'oldTglAwal' => $TglAwal,
            'oldTglAkhir' => $TglAkhir,
            'oldSupplier' => $Supplier,
            'oldTipeLaporan' => $TipeLaporan
		]);
    }

    function RptPembayaranPembelian(Request $request) {
        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $pembelian = DB::select('CALL rsp_PembayaranPembelian(?, ?, ?)', [$TglAwal, $TglAkhir, $RecordOwnerID]);

        
        return view("report.pembelian.pembayaranpembelian",[
			'pembelian' => $pembelian,
            'oldTglAwal' => $TglAwal,
            'oldTglAkhir' => $TglAkhir,
		]);
    }

    // Akutansi

    function RptSaldoRekening(Request $request) {
        $KelompokRekening = $request->input('KelompokRekening');
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $saldorekening = DB::select('CALL rsp_SaldoRekening(?, ?)', [(empty($KelompokRekening) ? "" : $KelompokRekening), $RecordOwnerID]);
        $kelompokrekening = KelompokRekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
                            ->get();
        
        return view("report.akutansi.saldorekening",[
			'saldorekening' => $saldorekening,
            'kelompokrekening' => $kelompokrekening,
            'oldKelompokRekening' => $KelompokRekening,
		]);
    }

    function RptNeracaSaldo(Request $request) {
        $Bulan = $request->input('Bulan');
        $Tahun = $request->input('Tahun');
        $Level = $request->input('Level', 5);
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $currentYear = Carbon::now()->year;
        $year = [];
        for ($i = -4; $i <= 4; $i++) {
            $year[] = ['Year' => $currentYear + $i];
        }
        usort($year, fn($a, $b) => $a['Year'] - $b['Year']);

        $neracasaldo = [];

        if ($Bulan && $Tahun) {
            $periode = $Tahun . str_pad($Bulan, 2, '0', STR_PAD_LEFT);

            $rows = DB::table('rekeningakutansi as ra')
                ->leftJoin('kelompokrekening as kr', 'kr.id', '=', 'ra.KodeKelompok')
                ->leftJoin('detailjurnal as dj', function ($join) use ($RecordOwnerID) {
                    $join->on('dj.KodeRekening', '=', 'ra.KodeRekening')
                         ->where('dj.RecordOwnerID', $RecordOwnerID);
                })
                ->leftJoin('headerjurnal as hj', function ($join) use ($RecordOwnerID) {
                    $join->on('hj.NoTransaksi', '=', 'dj.NoTransaksi')
                         ->on('hj.KodeTransaksi', '=', 'dj.KodeTransaksi')
                         ->where('hj.RecordOwnerID', $RecordOwnerID);
                })
                ->where('ra.RecordOwnerID', $RecordOwnerID)
                ->where('ra.Level', '<=', $Level)
                ->selectRaw("
                    ra.KodeRekening,
                    ra.NamaRekening,
                    ra.Level,
                    COALESCE(kr.NamaKelompok, '') as NamaKelompok,
                    COALESCE(kr.Posisi, 1) as Posisi,
                    SUM(CASE WHEN hj.Periode < ? AND dj.DK = 1 THEN dj.Jumlah ELSE 0 END) as PreDebet,
                    SUM(CASE WHEN hj.Periode < ? AND dj.DK = 2 THEN dj.Jumlah ELSE 0 END) as PreKredit,
                    SUM(CASE WHEN hj.Periode = ? AND dj.DK = 1 THEN dj.Jumlah ELSE 0 END) as MutasiDebet,
                    SUM(CASE WHEN hj.Periode = ? AND dj.DK = 2 THEN dj.Jumlah ELSE 0 END) as MutasiKredit
                ", [$periode, $periode, $periode, $periode])
                ->groupBy('ra.KodeRekening', 'ra.NamaRekening', 'ra.Level', 'kr.NamaKelompok', 'kr.Posisi')
                ->orderBy('ra.KodeRekening')
                ->get();

            foreach ($rows as $row) {
                $posisi = $row->Posisi ?? 1;
                $saldoAwal = ($posisi == 1)
                    ? $row->PreDebet - $row->PreKredit
                    : $row->PreKredit - $row->PreDebet;
                $saldoAkhir = ($posisi == 1)
                    ? $saldoAwal + $row->MutasiDebet - $row->MutasiKredit
                    : $saldoAwal - $row->MutasiDebet + $row->MutasiKredit;

                $neracasaldo[] = [
                    'KodeRekening' => $row->KodeRekening,
                    'NamaRekening' => $row->NamaRekening,
                    'Level'        => $row->Level,
                    'NamaKelompok' => $row->NamaKelompok,
                    'Posisi'       => $posisi,
                    'SaldoAwal'    => $saldoAwal,
                    'MutasiDebet'  => $row->MutasiDebet,
                    'MutasiKredit' => $row->MutasiKredit,
                    'SaldoAkhir'   => $saldoAkhir,
                ];
            }
        }

        return view("report.akutansi.neracasaldo", [
            'neracasaldo' => $neracasaldo,
            'year'        => $year,
            'nowyear'     => $currentYear,
            'OldTahun'    => empty($Tahun) ? $currentYear : $Tahun,
            'OldBulan'    => empty($Bulan) ? Carbon::now()->month : $Bulan,
            'OldLevel'    => $Level,
        ]);
    }

    function RptBukuBesar(Request $request) {
        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');
        $KodeRekening = $request->input('KodeRekening');
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $rekening = Rekening::where('RecordOwnerID', $RecordOwnerID)
                        ->where('Jenis', 2)
                        ->orderBy('KodeRekening')
                        ->get();

        $bukubesar = [];

        if ($TglAwal && $TglAkhir) {
            // Fetch journal entries in period
            $query = DB::table('detailjurnal as dj')
                ->join('headerjurnal as hj', function ($join) use ($RecordOwnerID) {
                    $join->on('hj.NoTransaksi', '=', 'dj.NoTransaksi')
                         ->on('hj.KodeTransaksi', '=', 'dj.KodeTransaksi')
                         ->where('hj.RecordOwnerID', $RecordOwnerID);
                })
                ->join('rekeningakutansi as ra', function ($join) use ($RecordOwnerID) {
                    $join->on('ra.KodeRekening', '=', 'dj.KodeRekening')
                         ->where('ra.RecordOwnerID', $RecordOwnerID);
                })
                ->leftJoin('kelompokrekening as kr', 'kr.id', '=', 'ra.KodeKelompok')
                ->selectRaw("
                    hj.TglTransaksi,
                    hj.NoTransaksi,
                    hj.NoReff,
                    dj.KodeRekening,
                    ra.NamaRekening,
                    dj.Keterangan,
                    CASE WHEN dj.DK = 1 THEN dj.Jumlah ELSE 0 END AS Debet,
                    CASE WHEN dj.DK = 2 THEN dj.Jumlah ELSE 0 END AS Kredit,
                    COALESCE(kr.Posisi, 1) as Posisi
                ")
                ->where('dj.RecordOwnerID', $RecordOwnerID)
                ->whereBetween('hj.TglTransaksi', [$TglAwal, $TglAkhir])
                ->orderBy('dj.KodeRekening')
                ->orderBy('hj.TglTransaksi')
                ->orderBy('hj.NoTransaksi');

            if (!empty($KodeRekening)) {
                $query->where('dj.KodeRekening', $KodeRekening);
            }

            $rows = $query->get();

            // Saldo awal per akun = sum semua jurnal SEBELUM TglAwal
            $saldoAwalQuery = DB::table('detailjurnal as dj')
                ->join('headerjurnal as hj', function ($join) use ($RecordOwnerID) {
                    $join->on('hj.NoTransaksi', '=', 'dj.NoTransaksi')
                         ->on('hj.KodeTransaksi', '=', 'dj.KodeTransaksi')
                         ->where('hj.RecordOwnerID', $RecordOwnerID);
                })
                ->join('rekeningakutansi as ra', function ($join) use ($RecordOwnerID) {
                    $join->on('ra.KodeRekening', '=', 'dj.KodeRekening')
                         ->where('ra.RecordOwnerID', $RecordOwnerID);
                })
                ->leftJoin('kelompokrekening as kr', 'kr.id', '=', 'ra.KodeKelompok')
                ->selectRaw("
                    dj.KodeRekening,
                    SUM(CASE WHEN dj.DK = 1 THEN dj.Jumlah ELSE 0 END) as TotalDebet,
                    SUM(CASE WHEN dj.DK = 2 THEN dj.Jumlah ELSE 0 END) as TotalKredit,
                    MAX(COALESCE(kr.Posisi, 1)) as Posisi
                ")
                ->where('dj.RecordOwnerID', $RecordOwnerID)
                ->where('hj.TglTransaksi', '<', $TglAwal)
                ->groupBy('dj.KodeRekening');

            if (!empty($KodeRekening)) {
                $saldoAwalQuery->where('dj.KodeRekening', $KodeRekening);
            }

            $saldoAwalMap = [];
            foreach ($saldoAwalQuery->get() as $s) {
                // Posisi 1 = normal Debet (Aset, Biaya), Posisi 2 = normal Kredit
                $saldoAwalMap[$s->KodeRekening] = ($s->Posisi == 1)
                    ? $s->TotalDebet - $s->TotalKredit
                    : $s->TotalKredit - $s->TotalDebet;
            }

            // Group rows per akun dan hitung saldo berjalan
            $grouped = [];
            foreach ($rows as $row) {
                $grouped[$row->KodeRekening][] = $row;
            }

            foreach ($grouped as $kodeRek => $items) {
                $saldoAwal = $saldoAwalMap[$kodeRek] ?? 0;
                $saldo = $saldoAwal;
                $posisi = $items[0]->Posisi ?? 1;

                $bukubesar[] = [
                    'KodeRekening' => $kodeRek,
                    'NamaRekening' => $items[0]->NamaRekening,
                    'TglTransaksi' => null,
                    'NoTransaksi'  => '-',
                    'NoReff'       => '',
                    'Keterangan'   => 'Saldo Awal',
                    'Debet'        => 0,
                    'Kredit'       => 0,
                    'Saldo'        => $saldoAwal,
                ];

                foreach ($items as $item) {
                    $saldo += ($posisi == 1)
                        ? $item->Debet - $item->Kredit
                        : $item->Kredit - $item->Debet;

                    $bukubesar[] = [
                        'KodeRekening' => $kodeRek,
                        'NamaRekening' => $item->NamaRekening,
                        'TglTransaksi' => $item->TglTransaksi,
                        'NoTransaksi'  => $item->NoTransaksi,
                        'NoReff'       => $item->NoReff,
                        'Keterangan'   => $item->Keterangan,
                        'Debet'        => $item->Debet,
                        'Kredit'       => $item->Kredit,
                        'Saldo'        => $saldo,
                    ];
                }
            }
        }

        return view("report.akutansi.bukubesar", [
            'bukubesar'       => $bukubesar,
            'rekening'        => $rekening,
            'oldTglAwal'      => $TglAwal,
            'oldTglAkhir'     => $TglAkhir,
            'oldKodeRekening' => $KodeRekening,
        ]);
    }

    function rptLabaRugi(Request $request) {
        $Bulan       = $request->input('Bulan');
        $Tahun       = $request->input('Tahun');
        $TipeLaporan = $request->input('TipeLaporan', '1');
        $ShowZero    = "0";
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $ocompany = Company::where('KodePartner', $RecordOwnerID)->first();

        $currentYear = Carbon::now()->year;
        $year = [];
        for ($i = -4; $i <= 4; $i++) {
            $year[] = ['Year' => $currentYear + $i];
        }
        usort($year, fn($a, $b) => $a['Year'] - $b['Year']);

        $oData = [];

        if ($Bulan && $Tahun) {
            $periode  = $Tahun . str_pad($Bulan, 2, '0', STR_PAD_LEFT);
            $ytdStart = $Tahun . '01';

            if ($TipeLaporan == '1') {
                // Ambil seluruh akun Laba Rugi (semua level) untuk struktur hierarki
                $allAccounts = DB::table('rekeningakutansi as ra')
                    ->join('kelompokrekening as kr', function ($join) use ($RecordOwnerID) {
                        $join->on('kr.id', '=', 'ra.KodeKelompok')
                             ->where('kr.RecordOwnerID', $RecordOwnerID);
                    })
                    ->leftJoin('rekeningakutansi as ri', function ($join) {
                        $join->on('ri.KodeRekening', '=', 'ra.KodeRekeningInduk')
                             ->on('ri.RecordOwnerID', '=', 'ra.RecordOwnerID');
                    })
                    ->where('ra.RecordOwnerID', $RecordOwnerID)
                    ->where('kr.Kelompok', 2)
                    ->select(
                        'ra.KodeRekening', 'ra.NamaRekening', 'ra.Level',
                        'ra.KodeKelompok', 'ra.KodeRekeningInduk',
                        'kr.NamaKelompok', 'kr.Posisi', 'kr.FooterLaporan',
                        DB::raw('COALESCE(ri.NamaRekening, ra.NamaRekening) AS NamaRekeningInduk')
                    )
                    ->orderBy('ra.KodeRekening')
                    ->get();

                // Hitung Nilai & YTD dari jurnal untuk setiap akun
                $journalRows = DB::table('detailjurnal as dj')
                    ->join('headerjurnal as hj', function ($join) use ($RecordOwnerID) {
                        $join->on('hj.NoTransaksi', '=', 'dj.NoTransaksi')
                             ->on('hj.KodeTransaksi', '=', 'dj.KodeTransaksi')
                             ->where('hj.RecordOwnerID', $RecordOwnerID);
                    })
                    ->join('rekeningakutansi as ra', function ($join) use ($RecordOwnerID) {
                        $join->on('ra.KodeRekening', '=', 'dj.KodeRekening')
                             ->where('ra.RecordOwnerID', $RecordOwnerID);
                    })
                    ->join('kelompokrekening as kr', function ($join) use ($RecordOwnerID) {
                        $join->on('kr.id', '=', 'ra.KodeKelompok')
                             ->where('kr.RecordOwnerID', $RecordOwnerID);
                    })
                    ->where('dj.RecordOwnerID', $RecordOwnerID)
                    ->where('kr.Kelompok', 2)
                    ->selectRaw("
                        dj.KodeRekening,
                        SUM(CASE WHEN hj.Periode = ?   AND dj.DK = 2 THEN dj.Jumlah ELSE 0 END)
                      - SUM(CASE WHEN hj.Periode = ?   AND dj.DK = 1 THEN dj.Jumlah ELSE 0 END) AS Nilai,
                        SUM(CASE WHEN hj.Periode >= ? AND hj.Periode <= ? AND dj.DK = 2 THEN dj.Jumlah ELSE 0 END)
                      - SUM(CASE WHEN hj.Periode >= ? AND hj.Periode <= ? AND dj.DK = 1 THEN dj.Jumlah ELSE 0 END) AS YTD
                    ", [$periode, $periode, $ytdStart, $periode, $ytdStart, $periode])
                    ->groupBy('dj.KodeRekening')
                    ->get()
                    ->keyBy('KodeRekening');

                // Inisialisasi map nilai per akun
                $nilaiMap = [];
                $ytdMap   = [];
                foreach ($allAccounts as $acc) {
                    $nilaiMap[$acc->KodeRekening] = isset($journalRows[$acc->KodeRekening])
                        ? $journalRows[$acc->KodeRekening]->Nilai : 0;
                    $ytdMap[$acc->KodeRekening]   = isset($journalRows[$acc->KodeRekening])
                        ? $journalRows[$acc->KodeRekening]->YTD   : 0;
                }

                // Rollup dari leaf ke parent (proses terbalik agar child lebih dulu)
                foreach ($allAccounts->reverse() as $acc) {
                    $induk = $acc->KodeRekeningInduk;
                    if (!empty($induk) && $induk !== $acc->KodeRekening && isset($nilaiMap[$induk])) {
                        $nilaiMap[$induk] += $nilaiMap[$acc->KodeRekening];
                        $ytdMap[$induk]   += $ytdMap[$acc->KodeRekening];
                    }
                }

                foreach ($allAccounts as $acc) {
                    $oData[] = [
                        'KodeRekening'     => $acc->KodeRekening,
                        'NamaRekening'     => $acc->NamaRekening,
                        'Level'            => $acc->Level,
                        'KodeKelompok'     => $acc->KodeKelompok,
                        'NamaKelompok'     => $acc->NamaKelompok,
                        'Posisi'           => $acc->Posisi,
                        'FooterLaporan'    => $acc->FooterLaporan,
                        'KodeRekeningInduk'=> $acc->KodeRekeningInduk ?? $acc->KodeRekening,
                        'NamaRekeningInduk'=> $acc->NamaRekeningInduk,
                        'Nilai'            => $nilaiMap[$acc->KodeRekening] ?? 0,
                        'YTD'              => $ytdMap[$acc->KodeRekening]   ?? 0,
                    ];
                }

            } elseif ($TipeLaporan == '2') {
                $oData = DB::select('CALL rsp_ProfitandLostPerItem(?, ?, ?)', [$Tahun . $Bulan, $RecordOwnerID, $ShowZero]);
            }
        }

        return view("report.akutansi.labarugi", [
            'labarugi'       => $oData,
            'year'           => $year,
            'nowyear'        => $currentYear,
            'OldTahun'       => empty($Tahun) ? $currentYear : $Tahun,
            'OldBulan'       => empty($Bulan) ? Carbon::now()->month : $Bulan,
            'OldTipeLaporan' => $TipeLaporan,
            'OldShowZero'    => $ShowZero,
            'AksesAccounting'=> $ocompany->isPostingAkutansi ?? 1,
            'ocompany'       => $ocompany,
        ]);
    }

    function rptCashFlow(Request $request) {
        $Bulan         = $request->input('Bulan');
        $Tahun         = $request->input('Tahun');
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $ocompany    = Company::where('KodePartner', $RecordOwnerID)->first();
        $currentYear = Carbon::now()->year;
        $year        = [];
        for ($i = -4; $i <= 4; $i++) $year[] = ['Year' => $currentYear + $i];
        usort($year, fn($a, $b) => $a['Year'] - $b['Year']);

        $cashflow = null;

        if ($Bulan && $Tahun) {
            $periode = $Tahun . str_pad($Bulan, 2, '0', STR_PAD_LEFT);

            $prevMonth = intval($Bulan) - 1;
            $prevYear  = intval($Tahun);
            if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }
            $periodePrev = $prevYear . str_pad($prevMonth, 2, '0', STR_PAD_LEFT);

            // ── 1. Laba Bersih from P&L journals (current period only) ──
            $plRow = DB::table('detailjurnal as dj')
                ->join('headerjurnal as hj', function ($j) use ($RecordOwnerID) {
                    $j->on('hj.NoTransaksi', '=', 'dj.NoTransaksi')
                      ->on('hj.KodeTransaksi', '=', 'dj.KodeTransaksi')
                      ->where('hj.RecordOwnerID', $RecordOwnerID);
                })
                ->join('rekeningakutansi as ra', function ($j) use ($RecordOwnerID) {
                    $j->on('ra.KodeRekening', '=', 'dj.KodeRekening')
                      ->where('ra.RecordOwnerID', $RecordOwnerID);
                })
                ->join('kelompokrekening as kr', function ($j) use ($RecordOwnerID) {
                    $j->on('kr.id', '=', 'ra.KodeKelompok')
                      ->where('kr.RecordOwnerID', $RecordOwnerID);
                })
                ->where('dj.RecordOwnerID', $RecordOwnerID)
                ->where('kr.Kelompok', 2)
                ->where('hj.Periode', $periode)
                ->selectRaw("
                    SUM(CASE WHEN dj.DK = 2 THEN dj.Jumlah ELSE 0 END) -
                    SUM(CASE WHEN dj.DK = 1 THEN dj.Jumlah ELSE 0 END) AS LabaBersih
                ")
                ->first();
            $labaBersih = $plRow->LabaBersih ?? 0;

            // ── 2. Penyusutan (non-cash add-back, accounts 65xxxxx) ──
            $depRow = DB::table('detailjurnal as dj')
                ->join('headerjurnal as hj', function ($j) use ($RecordOwnerID) {
                    $j->on('hj.NoTransaksi', '=', 'dj.NoTransaksi')
                      ->on('hj.KodeTransaksi', '=', 'dj.KodeTransaksi')
                      ->where('hj.RecordOwnerID', $RecordOwnerID);
                })
                ->where('dj.RecordOwnerID', $RecordOwnerID)
                ->where('hj.Periode', $periode)
                ->where('dj.KodeRekening', 'LIKE', '65%')
                ->selectRaw("
                    SUM(CASE WHEN dj.DK = 1 THEN dj.Jumlah ELSE 0 END) -
                    SUM(CASE WHEN dj.DK = 2 THEN dj.Jumlah ELSE 0 END) AS Penyusutan
                ")
                ->first();
            $penyusutan = $depRow->Penyusutan ?? 0;

            // ── 3. All balance-sheet account structure ──
            $bsAccounts = DB::table('rekeningakutansi as ra')
                ->join('kelompokrekening as kr', function ($j) use ($RecordOwnerID) {
                    $j->on('kr.id', '=', 'ra.KodeKelompok')
                      ->where('kr.RecordOwnerID', $RecordOwnerID);
                })
                ->where('ra.RecordOwnerID', $RecordOwnerID)
                ->where('kr.Kelompok', 1)
                ->select('ra.KodeRekening', 'ra.NamaRekening', 'ra.Level',
                         'ra.KodeRekeningInduk', 'kr.Posisi', 'kr.NamaKelompok')
                ->orderBy('ra.KodeRekening')
                ->get();

            // ── 4. Cumulative journal sums per account ──
            $buildSaldo = function ($periodeMax) use ($RecordOwnerID) {
                return DB::table('detailjurnal as dj')
                    ->join('headerjurnal as hj', function ($j) use ($RecordOwnerID) {
                        $j->on('hj.NoTransaksi', '=', 'dj.NoTransaksi')
                          ->on('hj.KodeTransaksi', '=', 'dj.KodeTransaksi')
                          ->where('hj.RecordOwnerID', $RecordOwnerID);
                    })
                    ->where('dj.RecordOwnerID', $RecordOwnerID)
                    ->where('hj.Periode', '<=', $periodeMax)
                    ->selectRaw("
                        dj.KodeRekening,
                        SUM(CASE WHEN dj.DK = 1 THEN dj.Jumlah ELSE 0 END) AS Debit,
                        SUM(CASE WHEN dj.DK = 2 THEN dj.Jumlah ELSE 0 END) AS Kredit
                    ")
                    ->groupBy('dj.KodeRekening')
                    ->get()
                    ->keyBy('KodeRekening');
            };

            $journalAwal  = $buildSaldo($periodePrev);
            $journalAkhir = $buildSaldo($periode);

            // ── 5. Compute saldo (sign per Posisi) ──
            $saldoAwal  = [];
            $saldoAkhir = [];
            foreach ($bsAccounts as $acc) {
                $rA = $journalAwal[$acc->KodeRekening]  ?? null;
                $rK = $journalAkhir[$acc->KodeRekening] ?? null;
                if ($acc->Posisi == 1) {
                    $saldoAwal[$acc->KodeRekening]  = $rA ? ($rA->Debit  - $rA->Kredit)  : 0;
                    $saldoAkhir[$acc->KodeRekening] = $rK ? ($rK->Debit  - $rK->Kredit)  : 0;
                } else {
                    $saldoAwal[$acc->KodeRekening]  = $rA ? ($rA->Kredit - $rA->Debit)   : 0;
                    $saldoAkhir[$acc->KodeRekening] = $rK ? ($rK->Kredit - $rK->Debit)   : 0;
                }
            }

            // ── 6. Rollup leaf → parent ──
            foreach ($bsAccounts->reverse() as $acc) {
                $induk = $acc->KodeRekeningInduk;
                if (!empty($induk) && $induk !== $acc->KodeRekening && isset($saldoAwal[$induk])) {
                    $saldoAwal[$induk]  += $saldoAwal[$acc->KodeRekening];
                    $saldoAkhir[$induk] += $saldoAkhir[$acc->KodeRekening];
                }
            }

            // ── 7. Classify account codes ──
            $classify = function ($kode) {
                if (preg_match('/^111/', $kode) || preg_match('/^112/', $kode)) return 'kas';
                if (preg_match('/^122/', $kode)) return 'skip';   // Akumulasi Penyusutan (handled via penyusutan line)
                if (preg_match('/^12/', $kode))  return 'investing';
                if (preg_match('/^3/', $kode))   return 'financing';
                if (preg_match('/^[12]/', $kode)) return 'operating';
                return 'other';
            };

            // ── 8. Kas opening & closing (Level-3 KAS/BANK accounts after rollup) ──
            $kasAwal  = 0;
            $kasAkhir = 0;
            foreach ($bsAccounts->filter(fn($a) => $classify($a->KodeRekening) === 'kas' && $a->Level == 3) as $acc) {
                $kasAwal  += $saldoAwal[$acc->KodeRekening]  ?? 0;
                $kasAkhir += $saldoAkhir[$acc->KodeRekening] ?? 0;
            }

            // ── 9. Working capital changes (operating, Level 3, non-kas, non-skip) ──
            $workingCapital = [];
            foreach ($bsAccounts->filter(fn($a) => $a->Level == 3 && $classify($a->KodeRekening) === 'operating') as $acc) {
                $delta      = ($saldoAkhir[$acc->KodeRekening] ?? 0) - ($saldoAwal[$acc->KodeRekening] ?? 0);
                // Asset Posisi=1: increase uses cash → negative CF; Liability Posisi=2: increase provides cash → positive CF
                $cashImpact = ($acc->Posisi == 1) ? -$delta : $delta;
                if (round($cashImpact, 2) != 0) {
                    $workingCapital[] = ['NamaRekening' => $acc->NamaRekening, 'Nilai' => $cashImpact, 'Posisi' => $acc->Posisi];
                }
            }

            // ── 10. Investing activities (Level 3, classify=investing) ──
            $investing = [];
            foreach ($bsAccounts->filter(fn($a) => $a->Level == 3 && $classify($a->KodeRekening) === 'investing') as $acc) {
                $delta      = ($saldoAkhir[$acc->KodeRekening] ?? 0) - ($saldoAwal[$acc->KodeRekening] ?? 0);
                $cashImpact = -$delta; // Increase in gross assets = cash used
                if (round($cashImpact, 2) != 0) {
                    $investing[] = ['NamaRekening' => $acc->NamaRekening, 'Nilai' => $cashImpact];
                }
            }

            // ── 11. Financing activities (Level 3, classify=financing) ──
            $financing = [];
            foreach ($bsAccounts->filter(fn($a) => $a->Level == 3 && $classify($a->KodeRekening) === 'financing') as $acc) {
                $delta      = ($saldoAkhir[$acc->KodeRekening] ?? 0) - ($saldoAwal[$acc->KodeRekening] ?? 0);
                $cashImpact = $delta; // Increase in equity = cash inflow
                if (round($cashImpact, 2) != 0) {
                    $financing[] = ['NamaRekening' => $acc->NamaRekening, 'Nilai' => $cashImpact];
                }
            }

            // ── 12. Totals ──
            $kasOperasi   = $labaBersih + $penyusutan + array_sum(array_column($workingCapital, 'Nilai'));
            $kasInvestasi = array_sum(array_column($investing, 'Nilai'));
            $kasPendanaan = array_sum(array_column($financing, 'Nilai'));
            $kenaikanKas  = $kasOperasi + $kasInvestasi + $kasPendanaan;

            $cashflow = compact(
                'labaBersih', 'penyusutan', 'workingCapital',
                'kasOperasi', 'investing', 'kasInvestasi',
                'financing', 'kasPendanaan', 'kenaikanKas',
                'kasAwal', 'kasAkhir'
            );
        }

        return view("report.akutansi.cashflow", [
            'cashflow' => $cashflow,
            'year'     => $year,
            'nowyear'  => $currentYear,
            'OldTahun' => empty($Tahun) ? $currentYear : $Tahun,
            'OldBulan' => empty($Bulan) ? Carbon::now()->month : $Bulan,
            'ocompany' => $ocompany,
        ]);
    }
}
