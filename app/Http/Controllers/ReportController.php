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
}
