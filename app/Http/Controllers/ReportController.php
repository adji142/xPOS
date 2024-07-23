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
        $Level = $request->input('Level');

        $year = array();
        $countYear = 5;
        
        $currentYear = Carbon::now()->year;

        // var_dump($currentYear);
        for ($i=0; $i < $countYear; $i++) { 
            $item = array(
                'Year' => $currentYear - $i
            );
            array_push($year, $item);
        }
        for ($i=1; $i < $countYear; $i++) { 
            $item = array(
                'Year' => $currentYear + $i
            );
            array_push($year, $item);
        }

        uasort($year, function($a, $b) {
            return $a['Year'] - $b['Year']; // Ascending order
            // var_dump($b);
        });

        // var_dump(json_encode($year));
        $neracasaldo = DB::select('CALL rsp_NeracaSaldo(?, ?)', [$Tahun.$Bulan, $Level]);

        return view("report.akutansi.neracasaldo",[
            'neracasaldo' => $neracasaldo,
			'year' => $year,
            'nowyear' => $currentYear,
            'OldTahun' => empty($Tahun) ? $currentYear : $Tahun,
            'OldBulan' => empty($Bulan) ? Carbon::now()->month : $Tahun,
            'OldLevel' => $Level
		]);

    }
}
