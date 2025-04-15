<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\FakturPenjualanHeader;
use App\Models\FakturPenjualanDetail;
use App\Models\ItemMaster;
use App\Models\InvoicePenggunaHeader;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $awalTahun = Carbon::now()->startOfYear()->toDateString();;
        $TglAwal = Carbon::now()->startOfMonth()->toDateString();
        $TglAkhir = Carbon::now();

        $daybyday = FakturPenjualanHeader::selectRaw("SUM(TotalPembelian) Total")
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween(DB::raw('DATE(fakturpenjualanheader.TglTransaksi)'),[DB::raw("DATE('".$TglAkhir."')"), DB::raw("DATE('".$TglAkhir."')")])
                        ->where('Status','<>',DB::raw("'D'"))
                        ->get();
        $mtd = FakturPenjualanHeader::selectRaw("SUM(TotalPembelian) Total")
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween(DB::raw('DATE(fakturpenjualanheader.TglTransaksi)'),[$TglAwal, $TglAkhir])
                        ->where('Status','<>',DB::raw("'D'"))
                        ->get();
        $ytd = FakturPenjualanHeader::selectRaw("SUM(TotalPembelian) Total")
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween(DB::raw('DATE(fakturpenjualanheader.TglTransaksi)'),[$awalTahun, $TglAkhir])
                        ->where('Status','<>',DB::raw("'D'"))
                        ->get();
        
        $stockMinimum = ItemMaster::selectRaw("KodeItem, NamaItem, Stock")
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->where('Stock','<=', 'StockMinimum')
                        ->where('Active','=', DB::raw("'Y'"))
                        ->get();

        $grafikpenjualan = FakturPenjualanHeader::selectRaw("DATE(fakturpenjualanheader.TglTransaksi) Tanggal ,SUM(TotalPembelian) Total")
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween(DB::raw('DATE(fakturpenjualanheader.TglTransaksi)'),[$TglAwal, $TglAkhir])
                        ->where('Status','<>',DB::raw("'D'"))
                        ->groupBy(DB::raw('DATE(fakturpenjualanheader.TglTransaksi)'))
                        ->orderBy(DB::raw('DATE(fakturpenjualanheader.TglTransaksi)'))
                        ->get();

        $perbandinganharga = DB::select('CALL rsp_perbandinganhargasupplier(?, ?, ?)', [$awalTahun, $TglAkhir, Auth::user()->RecordOwnerID]);
        // var_dump($perbandinganharga);
    	return view("dashboard",[
            'daybyday' => $daybyday[0]['Total'],
            'mtd' => $mtd[0]['Total'],
            'ytd' => $ytd[0]['Total'],
            'stockMinimum' => $stockMinimum,
            'grafikpenjualan' => $grafikpenjualan,
            'perbandinganharga' => $perbandinganharga
        ]);
    }

    function dashboardAdmin() {
        // dd(Auth::user()->RecordOwnerID);
        if(Auth::user()->RecordOwnerID != '999999'){
            auth()->user()->tokens()->delete();
            Auth::logout();
            return redirect('/');
        }
        $awalTahun = Carbon::now()->startOfYear()->toDateString();;
        $TglAwal = Carbon::now()->startOfMonth()->toDateString();
        $TglAkhir = Carbon::now();

        $daybyday = InvoicePenggunaHeader::selectRaw("SUM(TotalBayar) Total")
                        ->whereBetween(DB::raw('DATE(tagihanpenggunaheader.TglTransaksi)'),[DB::raw("DATE('".$TglAkhir."')"), DB::raw("DATE('".$TglAkhir."')")])
                        ->get();
        
        $mtd = InvoicePenggunaHeader::selectRaw("SUM(TotalBayar) Total")
                        ->whereBetween(DB::raw('DATE(tagihanpenggunaheader.TglTransaksi)'),[$TglAwal, $TglAkhir])
                        ->get();
        $ytd = InvoicePenggunaHeader::selectRaw("SUM(TotalBayar) Total")
                        ->whereBetween(DB::raw('DATE(tagihanpenggunaheader.TglTransaksi)'),[$awalTahun, $TglAkhir])
                        ->get();
        
        $grafikpenjualan = InvoicePenggunaHeader::selectRaw("DATE(tagihanpenggunaheader.TglTransaksi) Tanggal ,SUM(TotalBayar) Total")
                        ->whereBetween(DB::raw('DATE(tagihanpenggunaheader.TglTransaksi)'),[$TglAwal, $TglAkhir])
                        ->groupBy(DB::raw('DATE(tagihanpenggunaheader.TglTransaksi)'))
                        ->orderBy(DB::raw('DATE(tagihanpenggunaheader.TglTransaksi)'))
                        ->get();
        return view("dashboardadmin",[
            'daybyday' => $daybyday[0]['Total'],
            'mtd' => $mtd[0]['Total'],
            'ytd' => $ytd[0]['Total'],
            'grafikpenjualan' => $grafikpenjualan,
        ]);
    }
}
