<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\ClosingPeriod;

class ClosingPeriodController extends Controller
{
    function Closing(Request $request)  {
        $periode = $request->input('periode');
        $currentDate = Carbon::now();
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $date = Carbon::createFromFormat('Ymd', $periode);
        $TglAwal = $date->format('Y-m-d');;
        $TglAkhir = Carbon::now()->endOfMonth()->toDateString();

        $errorCount = 0;

        // Inserting to Posting Period
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'periode'=>'required'
            ]);

            $model = new ClosingPeriod;
            $model->Periode = $periode;
            $model->TanggalProses = $currentDate;
            $model->CreatedBy = Auth::user()->name;
            $model->UpdatedBy = "";
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();
            
            if (!save) {
                $errorCount +=1;
                alert()->error('Error',"Gagal Proses Closing Period");
                goto jump;
            }

            // pembelian
            $update = DB::table('fakturpembelianheader')
                        ->where('Posted','=', DB::raw("0"))
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween('TglTransaksi', [$TglAwal, $TglAkhir])
                        ->update(
                            [
                                'Posted'=>1,
                                'UpdatedBy'=> Auth::user()->name
                            ]
                        );

            // retur pembelian
            $update = DB::table('returpembelianheader')
                        ->where('Posted','=', DB::raw("0"))
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween('TglTransaksi', [$TglAwal, $TglAkhir])
                        ->update(
                            [
                                'Posted'=>1,
                                'UpdatedBy'=> Auth::user()->name
                            ]
                        );
            
            // pembayaran
            $update = DB::table('pembayaranheader')
                        ->where('Posted','=', DB::raw("0"))
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween('TglTransaksi', [$TglAwal, $TglAkhir])
                        ->update(
                            [
                                'Posted'=>1,
                                'UpdatedBy'=> Auth::user()->name
                            ]
                        );
            
            // Delivery
            $update = DB::table('deliverynoteheader')
                        ->where('Posted','=', DB::raw("0"))
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween('TglTransaksi', [$TglAwal, $TglAkhir])
                        ->update(
                            [
                                'Posted'=>1,
                                'UpdatedBy'=> Auth::user()->name
                            ]
                        ); 

            // Faktur Penjualan
            $update = DB::table('fakturpenjualanheader')
                        ->where('Posted','=', DB::raw("0"))
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween(DB::raw("DATE(TglTransaksi)"), [$TglAwal, $TglAkhir])
                        ->update(
                            [
                                'Posted'=>1,
                                'UpdatedBy'=> Auth::user()->name
                            ]
                        ); 
             // Retur Penjualan
            $update = DB::table('returpenjualanheader')
                        ->where('Posted','=', DB::raw("0"))
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween('TglTransaksi', [$TglAwal, $TglAkhir])
                        ->update(
                            [
                                'Posted'=>1,
                                'UpdatedBy'=> Auth::user()->name
                            ]
                        ); 

            // Pembayaran Penjualan
            $update = DB::table('pembayaranpenjualanheader')
                        ->where('Posted','=', DB::raw("0"))
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween('TglTransaksi', [$TglAwal, $TglAkhir])
                        ->update(
                            [
                                'Posted'=>1,
                                'UpdatedBy'=> Auth::user()->name
                            ]
                        ); 
            
            // Konsinyasi
            $update = DB::table('penerimaankonsinyasiheader')
                        ->where('Posted','=', DB::raw("0"))
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween('TglTransaksi', [$TglAwal, $TglAkhir])
                        ->update(
                            [
                                'Posted'=>1,
                                'UpdatedBy'=> Auth::user()->name
                            ]
                        ); 
            
            // Retur Konsinyasi
            $update = DB::table('returkonsinyasiheader')
                        ->where('Posted','=', DB::raw("0"))
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween('TglTransaksi', [$TglAwal, $TglAkhir])
                        ->update(
                            [
                                'Posted'=>1,
                                'UpdatedBy'=> Auth::user()->name
                            ]
                        );
            
            // Pembayaran Konsinyasi
            $update = DB::table('pembayarankonsinyasiheader')
                        ->where('Posted','=', DB::raw("0"))
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween('TglTransaksi', [$TglAwal, $TglAkhir])
                        ->update(
                            [
                                'Posted'=>1,
                                'UpdatedBy'=> Auth::user()->name
                            ]
                        );

            // pengakuanbarangheader
            $update = DB::table('pengakuanbarangheader')
                        ->where('Posted','=', DB::raw("0"))
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween('TglTransaksi', [$TglAwal, $TglAkhir])
                        ->update(
                            [
                                'Posted'=>1,
                                'UpdatedBy'=> Auth::user()->name
                            ]
                        );

            // penghapusanbarangheader
            $update = DB::table('penghapusanbarangheader')
                        ->where('Posted','=', DB::raw("0"))
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween('TglTransaksi', [$TglAwal, $TglAkhir])
                        ->update(
                            [
                                'Posted'=>1,
                                'UpdatedBy'=> Auth::user()->name
                            ]
                        );

            // headerjurnal
            $update = DB::table('headerjurnal')
                        ->where('Posted','=', DB::raw("0"))
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween('TglTransaksi', [$TglAwal, $TglAkhir])
                        ->update(
                            [
                                'Posted'=>1,
                                'UpdatedBy'=> Auth::user()->name
                            ]
                        );

            // biayaheader
            $update = DB::table('biayaheader')
                        ->where('Posted','=', DB::raw("0"))
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->whereBetween('TglTransaksi', [$TglAwal, $TglAkhir])
                        ->update(
                            [
                                'Posted'=>1,
                                'UpdatedBy'=> Auth::user()->name
                            ]
                        );
            jump:
            if ($errorCount > 0) {
		        DB::rollback();
                alert()->error('Error',"Gagal Closing Periode");
                return redirect('closing');
	        }
	        else{
		        DB::commit();
                alert()->success('Success','Berhasil Closing Periode.');
                return redirect('closing');
	        }
        } catch (\Exception $e) {
            alert()->error('Error',$e->getMessage());
            return redirect('closing');
        }
    }
}
