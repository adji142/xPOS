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
use App\Models\Company;

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

        // TopSpender

        $topspender = FakturPenjualanHeader::selectRaw('pelanggan.NamaPelanggan, SUM(TotalPembelian) Total')
                    ->leftJoin('pelanggan', function ($value){
                        $value->on('pelanggan.KodePelanggan','=','fakturpenjualanheader.KodePelanggan')
                        ->on('pelanggan.RecordOwnerID','=','fakturpenjualanheader.RecordOwnerID');
                    })
                    ->where('fakturpenjualanheader.RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->whereBetween(DB::raw('DATE(fakturpenjualanheader.TglTransaksi)'),[$TglAwal, $TglAkhir])
                    ->where('fakturpenjualanheader.Status','<>',DB::raw("'D'"))
                    ->groupBy(DB::raw('pelanggan.NamaPelanggan'))
                    ->orderByDesc(DB::raw('Total'))
                    ->take(5)
                    ->get();
        
        $topItemPerformance = FakturPenjualanDetail::selectRaw('itemmaster.NamaItem, itemmaster.Satuan , SUM(TotalPembelian) Total, SUM(Qty) AS Qty')
                            ->leftJoin('fakturpenjualanheader', function ($value){
                                $value->on('fakturpenjualanheader.NoTransaksi','=','fakturpenjualandetail.NoTransaksi')
                                ->on('fakturpenjualanheader.RecordOwnerID','=','fakturpenjualandetail.RecordOwnerID');
                            })
                            ->leftJoin('itemmaster', function ($value){
                                $value->on('itemmaster.KodeItem','=','fakturpenjualandetail.KodeItem')
                                ->on('itemmaster.RecordOwnerID','=','fakturpenjualandetail.RecordOwnerID');
                            })
                            ->where('fakturpenjualanheader.RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->whereBetween(DB::raw('DATE(fakturpenjualanheader.TglTransaksi)'),[$TglAwal, $TglAkhir])
                            ->where('fakturpenjualanheader.Status','<>',DB::raw("'D'"))
                            ->groupBy(DB::raw('itemmaster.NamaItem, itemmaster.Satuan'))
                            ->orderBy(DB::raw('itemmaster.NamaItem'))
                            ->get();

        // var_dump($perbandinganharga);
    	return view("dashboard",[
            'daybyday' => $daybyday[0]['Total'],
            'mtd' => $mtd[0]['Total'],
            'ytd' => $ytd[0]['Total'],
            'stockMinimum' => $stockMinimum,
            'grafikpenjualan' => $grafikpenjualan,
            'perbandinganharga' => $perbandinganharga,
            'topspender' => $topspender,
            'topItemPerformance' => $topItemPerformance
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

        $subshampirhabis = Company::join('userrole', 'company.KodePartner', '=', 'userrole.RecordOwnerID')
                            ->join('roles', function($join) {
                                $join->on('userrole.roleid', '=', 'roles.id')
                                    ->on('userrole.RecordOwnerID', '=', 'roles.RecordOwnerID');
                            })
                            ->join('users', function($join) {
                                $join->on('userrole.userid', '=', 'users.id')
                                    ->on('userrole.RecordOwnerID', '=', 'users.RecordOwnerID');
                            })
                            ->where('roles.RoleName', 'SuperAdmin')
                            ->where(function($query) {
                                $query->where('company.EndSubs', '>', DB::raw('NOW()'))
                                    ->orWhereBetween('company.EndSubs', [
                                        DB::raw('NOW()'),
                                        DB::raw('DATE_ADD(NOW(), INTERVAL 7 DAY)')
                                    ]);
                            })
                            ->select(
                                'company.NamaPartner',
                                'company.NamaPIC',
                                'company.NoTlp',
                                'users.email',
                                'company.EndSubs'
                            )->get();

        $subshabis = Company::join('userrole', 'company.KodePartner', '=', 'userrole.RecordOwnerID')
                            ->join('roles', function($join) {
                                $join->on('userrole.roleid', '=', 'roles.id')
                                    ->on('userrole.RecordOwnerID', '=', 'roles.RecordOwnerID');
                            })
                            ->join('users', function($join) {
                                $join->on('userrole.userid', '=', 'users.id')
                                    ->on('userrole.RecordOwnerID', '=', 'users.RecordOwnerID');
                            })
                            ->where('roles.RoleName', 'SuperAdmin')
                            ->where(DB::raw('NOW()'), '>', DB::raw('EndSubs'))
                            ->select(
                                'company.NamaPartner',
                                'company.NamaPIC',
                                'company.NoTlp',
                                'users.email'
                            )->get();
        $daftarbelumbayar = Company::join('userrole', 'company.KodePartner', '=', 'userrole.RecordOwnerID')
                            ->join('roles', function($join) {
                                $join->on('userrole.roleid', '=', 'roles.id')
                                    ->on('userrole.RecordOwnerID', '=', 'roles.RecordOwnerID');
                            })
                            ->join('users', function($join) {
                                $join->on('userrole.userid', '=', 'users.id')
                                    ->on('userrole.RecordOwnerID', '=', 'users.RecordOwnerID');
                            })
                            ->whereNull('EndSubs')
                            ->select(
                                'company.NamaPartner',
                                'company.NamaPIC',
                                'company.NoTlp',
                                'users.email'
                            )->get();
        $companyPerJenis = Company::select('JenisUsaha', DB::raw('COUNT(*) as jumlah'))
                            ->groupBy('JenisUsaha')
                            ->get();

        return view("dashboardadmin",[
            'daybyday' => $daybyday[0]['Total'],
            'mtd' => $mtd[0]['Total'],
            'ytd' => $ytd[0]['Total'],
            'grafikpenjualan' => $grafikpenjualan,
            'subshampirhabis' => $subshampirhabis,
            'subshabis' => $subshabis,
            'daftarbelumbayar' => $daftarbelumbayar,
            'companyPerJenis' => $companyPerJenis
        ]);
    }
}
