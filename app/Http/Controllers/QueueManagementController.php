<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\TitikLampu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class QueueManagementController extends Controller
{
    /**
     * Display the queue management dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index($id)
    {
        $idE = base64_decode($id); // ⬅️ decode di sini
        $company = Company::where('KodePartner','=',$idE)->first();

        $oImageData = [];

        if (!empty($company->ImageCustDisplay1)) {
            $image = array('type' => 'image', 'url' => $company->ImageCustDisplay1);
            array_push($oImageData, $image);
        }

        if (!empty($company->ImageCustDisplay2)) {
            $image = array('type' => 'image', 'url' => $company->ImageCustDisplay2);
            array_push($oImageData, $image);
        }

        if (!empty($company->ImageCustDisplay3)) {
            $image = array('type' => 'image', 'url' => $company->ImageCustDisplay3);
            array_push($oImageData, $image);
        }

        if (!empty($company->ImageCustDisplay4)) {
            $image = array('type' => 'image', 'url' => $company->ImageCustDisplay4);
            array_push($oImageData, $image);
        }

        if (!empty($company->ImageCustDisplay5)) {
            $image = array('type' => 'image', 'url' => $company->ImageCustDisplay5);
            array_push($oImageData, $image);
        }

        if (!empty($company->VideoCustomerDisplay1)) {
            $url = "https://www.youtube.com/embed/".$company->VideoCustomerDisplay1."?&mute=1&enablejsapi=1";
            $image = array('type' => 'video', 'url' => $url);
            array_push($oImageData, $image);
        }

        if (!empty($company->VideoCustomerDisplay2)) {
            $url = "https://www.youtube.com/embed/".$company->VideoCustomerDisplay2."?&mute=1&enablejsapi=1";
            $image = array('type' => 'video', 'url' => $url);
            array_push($oImageData, $image);
        }

        if (!empty($company->VideoCustomerDisplay3)) {
            $url = "https://www.youtube.com/embed/".$company->VideoCustomerDisplay3."?&mute=1&enablejsapi=1";
            $image = array('type' => 'video', 'url' => $url);
            array_push($oImageData, $image);
        }

        if (!empty($company->VideoCustomerDisplay4)) {
            $url = "https://www.youtube.com/embed/".$company->VideoCustomerDisplay4."?&mute=1&enablejsapi=1";
            $image = array('type' => 'video', 'url' => $url);
            array_push($oImageData, $image);
        }

        if (!empty($company->VideoCustomerDisplay5)) {
            $url = "https://www.youtube.com/embed/".$company->VideoCustomerDisplay5."?&mute=1&enablejsapi=1";
            $image = array('type' => 'video', 'url' => $url);
            array_push($oImageData, $image);
        }



        $viewName = $company->QueueDesignSetting ?? 'QueueManagement';
        if (empty($viewName)) {
            $viewName = 'QueueManagement';
        }

        return view('Transaksi.Penjualan.QueueManagement.'.$viewName,[
            'oImageData' => $oImageData,
            'company' => $company,
            'idE' => $idE
        ]);
    }

    /**
     * Handle the queue management logic.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handleQueue(Request $request)
    {
        // Logic to handle queue management goes here
        $availableTable = TitikLampu::selectRaw("titiklampu.*,
                            CASE WHEN COALESCE(titiklampu.status,0) = 0 THEN 'KOSONG' ELSE 
                                CASE WHEN titiklampu.Status = 1 THEN 'AKTIF' ELSE 
                                    CASE WHEN titiklampu.status = -1 THEN 'CHECKOUT' ELSE 
                                        CASE WHEN titiklampu.status = 99 THEN 'HAMPIR HABIS' ELSE '' END
                                    END
                                END
                            END StatusMeja,
                            COALESCE(tableorderheader.NoTransaksi,'') AS NoTransaksi,
                            tableorderheader.TglPencatatan,
                            tableorderheader.paketid,
                            pakettransaksi.NamaPaket,
                            tableorderheader.KodeSales,
                            sales.NamaSales,
                            tableorderheader.DurasiPaket,
                            DATE_FORMAT(tableorderheader.JamMulai,  '%H:%i') JamMulai,
                            DATE_FORMAT(tableorderheader.JamSelesai,  '%H:%i') JamSelesai,
                            tableorderheader.JenisPaket,
                            tableorderheader.paketid,
                            tableorderheader.TglTransaksi,
                            tableorderheader.KodePelanggan,
                            pelanggan.NamaPelanggan,
                            gruppelanggan.NamaGrup,
                            gruppelanggan.DiskonPersen,
                            CASE WHEN COALESCE(bookingtableonline.NoTransaksi,'') != '' THEN 'BOOKING' ELSE 'TIDAKBOOKING' END AS StatusBooking,
                            COALESCE(bookingtableonline.TotalTransaksi,0) AS BookingTotalTransaksi,
                            COALESCE(bookingtableonline.TotalTax,0) AS BookingTotalTax,
                            COALESCE(bookingtableonline.TotalDiskon,0) AS BookingTotalDiskon,
                            COALESCE(bookingtableonline.TotalLainLain,0) AS BookingTotalLainLain,
                            COALESCE(bookingtableonline.NetTotal,0) AS BookingNetTotal,
                            COALESCE(bookingtableonline.Keterangan,'') AS BookingPaymentReffNumber,
                            COALESCE(CASE WHEN fakturpenjualanheader.TotalPembayaran > fakturpenjualanheader.TotalPembelian THEN fakturpenjualanheader.TotalPembelian ELSE fakturpenjualanheader.TotalPembayaran END ,0) as TotalPembayaran,
                            COALESCE(tkelompoklampu.NamaKelompok,'') AS NamaKelompok
                        ")
                        ->leftJoin('tableorderheader', function ($value)  {
                            $value->on('titiklampu.id','=','tableorderheader.tableid')
                            ->on('titiklampu.RecordOwnerID','=','tableorderheader.RecordOwnerID')
                            // ->on(DB::raw("DATE_FORMAT(COALESCE(tableorderheader.JamSelesai, now()), '%Y-%m-%d')"),'>=',DB::raw("DATE_FORMAT(NOW(), '%Y-%m-%d')"))
                            ->on('tableorderheader.Status','!=',DB::raw('0'));
                        })
                        ->leftJoin('pakettransaksi', function ($value)  {
                            $value->on('tableorderheader.paketid','=','pakettransaksi.id')
                            ->on('tableorderheader.RecordOwnerID','=','pakettransaksi.RecordOwnerID');
                        })
                        ->leftJoin('sales', function ($value)  {
                            $value->on('tableorderheader.KodeSales','=','sales.KodeSales')
                            ->on('tableorderheader.RecordOwnerID','=','sales.RecordOwnerID');
                        })
                        ->leftJoin('pelanggan', function ($value)  {
                            $value->on('tableorderheader.KodePelanggan','=','pelanggan.KodePelanggan')
                            ->on('tableorderheader.RecordOwnerID','=','pelanggan.RecordOwnerID');
                        })
                        ->leftJoin('gruppelanggan', function ($value)  {
                            $value->on('pelanggan.KodeGrupPelanggan','=','gruppelanggan.KodeGrup')
                            ->on('pelanggan.RecordOwnerID','=','gruppelanggan.RecordOwnerID');
                        })
                        ->leftJoin('bookingtableonline', function ($value)  {
                            $value->on('bookingtableonline.NoTransaksi','=','tableorderheader.NoTransaksi')
                            ->on('bookingtableonline.RecordOwnerID','=','tableorderheader.RecordOwnerID');
                        })
                        ->leftJoin('fakturpenjualandetail', function ($value)  {
                            $value->on('fakturpenjualandetail.BaseReff','=','tableorderheader.NoTransaksi')
                            ->on('fakturpenjualandetail.RecordOwnerID','=','tableorderheader.RecordOwnerID');
                        })
                        ->leftJoin('fakturpenjualanheader', function ($value)  {
                            $value->on('fakturpenjualanheader.NoTransaksi','=','fakturpenjualandetail.NoTransaksi')
                            ->on('fakturpenjualanheader.RecordOwnerID','=','fakturpenjualandetail.RecordOwnerID')
                            ->where('fakturpenjualanheader.Status', '=', 'C') // kondisi nilai tetap
                            ->where('fakturpenjualanheader.TotalPembayaran', '>', 0); // kondisi angka tetap
                        })
                        ->leftjoin('tkelompoklampu', function ($value)  {
                            $value->on('titiklampu.KelompokLampu','=','tkelompoklampu.KodeKelompok')
                            ->on('titiklampu.RecordOwnerID','=','tkelompoklampu.RecordOwnerID');
                        })
                        ->where('titiklampu.RecordOwnerID', '=', $request->RecordOwnerID)
                        ->where('titiklampu.Status', '=', '0')
                        ->get();
        $usedTable = TitikLampu::selectRaw("titiklampu.*,
                            CASE WHEN COALESCE(titiklampu.status,0) = 0 THEN 'KOSONG' ELSE 
                                CASE WHEN titiklampu.Status = 1 THEN 'AKTIF' ELSE 
                                    CASE WHEN titiklampu.status = -1 THEN 'CHECKOUT' ELSE 
                                        CASE WHEN titiklampu.status = 99 THEN 'HAMPIR HABIS' ELSE '' END
                                    END
                                END
                            END StatusMeja,
                            COALESCE(tableorderheader.NoTransaksi,'') AS NoTransaksi,
                            tableorderheader.TglPencatatan,
                            tableorderheader.paketid,
                            pakettransaksi.NamaPaket,
                            tableorderheader.KodeSales,
                            sales.NamaSales,
                            tableorderheader.DurasiPaket,
                            DATE_FORMAT(tableorderheader.JamMulai,  '%H:%i') JamMulai,
                            DATE_FORMAT(tableorderheader.JamSelesai,  '%H:%i') JamSelesai,
                            tableorderheader.JenisPaket,
                            tableorderheader.paketid,
                            tableorderheader.TglTransaksi,
                            tableorderheader.KodePelanggan,
                            pelanggan.NamaPelanggan,
                            gruppelanggan.NamaGrup,
                            gruppelanggan.DiskonPersen,
                            CASE WHEN COALESCE(bookingtableonline.NoTransaksi,'') != '' THEN 'BOOKING' ELSE 'TIDAKBOOKING' END AS StatusBooking,
                            COALESCE(bookingtableonline.TotalTransaksi,0) AS BookingTotalTransaksi,
                            COALESCE(bookingtableonline.TotalTax,0) AS BookingTotalTax,
                            COALESCE(bookingtableonline.TotalDiskon,0) AS BookingTotalDiskon,
                            COALESCE(bookingtableonline.TotalLainLain,0) AS BookingTotalLainLain,
                            COALESCE(bookingtableonline.NetTotal,0) AS BookingNetTotal,
                            COALESCE(bookingtableonline.Keterangan,'') AS BookingPaymentReffNumber,
                            COALESCE(CASE WHEN fakturpenjualanheader.TotalPembayaran > fakturpenjualanheader.TotalPembelian THEN fakturpenjualanheader.TotalPembelian ELSE fakturpenjualanheader.TotalPembayaran END ,0) as TotalPembayaran,
                            COALESCE(tkelompoklampu.NamaKelompok,'') AS NamaKelompok
                        ")
                        ->leftJoin('tableorderheader', function ($value)  {
                            $value->on('titiklampu.id','=','tableorderheader.tableid')
                            ->on('titiklampu.RecordOwnerID','=','tableorderheader.RecordOwnerID')
                            // ->on(DB::raw("DATE_FORMAT(COALESCE(tableorderheader.JamSelesai, now()), '%Y-%m-%d')"),'>=',DB::raw("DATE_FORMAT(NOW(), '%Y-%m-%d')"))
                            ->on('tableorderheader.Status','!=',DB::raw('0'));
                        })
                        ->leftJoin('pakettransaksi', function ($value)  {
                            $value->on('tableorderheader.paketid','=','pakettransaksi.id')
                            ->on('tableorderheader.RecordOwnerID','=','pakettransaksi.RecordOwnerID');
                        })
                        ->leftJoin('sales', function ($value)  {
                            $value->on('tableorderheader.KodeSales','=','sales.KodeSales')
                            ->on('tableorderheader.RecordOwnerID','=','sales.RecordOwnerID');
                        })
                        ->leftJoin('pelanggan', function ($value)  {
                            $value->on('tableorderheader.KodePelanggan','=','pelanggan.KodePelanggan')
                            ->on('tableorderheader.RecordOwnerID','=','pelanggan.RecordOwnerID');
                        })
                        ->leftJoin('gruppelanggan', function ($value)  {
                            $value->on('pelanggan.KodeGrupPelanggan','=','gruppelanggan.KodeGrup')
                            ->on('pelanggan.RecordOwnerID','=','gruppelanggan.RecordOwnerID');
                        })
                        ->leftJoin('bookingtableonline', function ($value)  {
                            $value->on('bookingtableonline.NoTransaksi','=','tableorderheader.NoTransaksi')
                            ->on('bookingtableonline.RecordOwnerID','=','tableorderheader.RecordOwnerID');
                        })
                        ->leftJoin('fakturpenjualandetail', function ($value)  {
                            $value->on('fakturpenjualandetail.BaseReff','=','tableorderheader.NoTransaksi')
                            ->on('fakturpenjualandetail.RecordOwnerID','=','tableorderheader.RecordOwnerID');
                        })
                        ->leftJoin('fakturpenjualanheader', function ($value)  {
                            $value->on('fakturpenjualanheader.NoTransaksi','=','fakturpenjualandetail.NoTransaksi')
                            ->on('fakturpenjualanheader.RecordOwnerID','=','fakturpenjualandetail.RecordOwnerID')
                            ->where('fakturpenjualanheader.Status', '=', 'C') // kondisi nilai tetap
                            ->where('fakturpenjualanheader.TotalPembayaran', '>', 0); // kondisi angka tetap
                        })
                        ->leftjoin('tkelompoklampu', function ($value)  {
                            $value->on('titiklampu.KelompokLampu','=','tkelompoklampu.KodeKelompok')
                            ->on('titiklampu.RecordOwnerID','=','tkelompoklampu.RecordOwnerID');
                        })
                        ->where('titiklampu.RecordOwnerID', '=', $request->RecordOwnerID)
                        ->where('titiklampu.Status', '=', '1')
                        ->get();
        $hampirHabisTable = TitikLampu::selectRaw("titiklampu.*,
                            CASE WHEN COALESCE(titiklampu.status,0) = 0 THEN 'KOSONG' ELSE 
                                CASE WHEN titiklampu.Status = 1 THEN 'AKTIF' ELSE 
                                    CASE WHEN titiklampu.status = -1 THEN 'CHECKOUT' ELSE 
                                        CASE WHEN titiklampu.status = 99 THEN 'HAMPIR HABIS' ELSE '' END
                                    END
                                END
                            END StatusMeja,
                            COALESCE(tableorderheader.NoTransaksi,'') AS NoTransaksi,
                            tableorderheader.TglPencatatan,
                            tableorderheader.paketid,
                            pakettransaksi.NamaPaket,
                            tableorderheader.KodeSales,
                            sales.NamaSales,
                            tableorderheader.DurasiPaket,
                            DATE_FORMAT(tableorderheader.JamMulai,  '%H:%i') JamMulai,
                            DATE_FORMAT(tableorderheader.JamSelesai,  '%H:%i') JamSelesai,
                            tableorderheader.JenisPaket,
                            tableorderheader.paketid,
                            tableorderheader.TglTransaksi,
                            tableorderheader.KodePelanggan,
                            pelanggan.NamaPelanggan,
                            gruppelanggan.NamaGrup,
                            gruppelanggan.DiskonPersen,
                            CASE WHEN COALESCE(bookingtableonline.NoTransaksi,'') != '' THEN 'BOOKING' ELSE 'TIDAKBOOKING' END AS StatusBooking,
                            COALESCE(bookingtableonline.TotalTransaksi,0) AS BookingTotalTransaksi,
                            COALESCE(bookingtableonline.TotalTax,0) AS BookingTotalTax,
                            COALESCE(bookingtableonline.TotalDiskon,0) AS BookingTotalDiskon,
                            COALESCE(bookingtableonline.TotalLainLain,0) AS BookingTotalLainLain,
                            COALESCE(bookingtableonline.NetTotal,0) AS BookingNetTotal,
                            COALESCE(bookingtableonline.Keterangan,'') AS BookingPaymentReffNumber,
                            COALESCE(CASE WHEN fakturpenjualanheader.TotalPembayaran > fakturpenjualanheader.TotalPembelian THEN fakturpenjualanheader.TotalPembelian ELSE fakturpenjualanheader.TotalPembayaran END ,0) as TotalPembayaran,
                            COALESCE(tkelompoklampu.NamaKelompok,'') AS NamaKelompok
                        ")
                        ->leftJoin('tableorderheader', function ($value)  {
                            $value->on('titiklampu.id','=','tableorderheader.tableid')
                            ->on('titiklampu.RecordOwnerID','=','tableorderheader.RecordOwnerID')
                            // ->on(DB::raw("DATE_FORMAT(COALESCE(tableorderheader.JamSelesai, now()), '%Y-%m-%d')"),'>=',DB::raw("DATE_FORMAT(NOW(), '%Y-%m-%d')"))
                            ->on('tableorderheader.Status','!=',DB::raw('0'));
                        })
                        ->leftJoin('pakettransaksi', function ($value)  {
                            $value->on('tableorderheader.paketid','=','pakettransaksi.id')
                            ->on('tableorderheader.RecordOwnerID','=','pakettransaksi.RecordOwnerID');
                        })
                        ->leftJoin('sales', function ($value)  {
                            $value->on('tableorderheader.KodeSales','=','sales.KodeSales')
                            ->on('tableorderheader.RecordOwnerID','=','sales.RecordOwnerID');
                        })
                        ->leftJoin('pelanggan', function ($value)  {
                            $value->on('tableorderheader.KodePelanggan','=','pelanggan.KodePelanggan')
                            ->on('tableorderheader.RecordOwnerID','=','pelanggan.RecordOwnerID');
                        })
                        ->leftJoin('gruppelanggan', function ($value)  {
                            $value->on('pelanggan.KodeGrupPelanggan','=','gruppelanggan.KodeGrup')
                            ->on('pelanggan.RecordOwnerID','=','gruppelanggan.RecordOwnerID');
                        })
                        ->leftJoin('bookingtableonline', function ($value)  {
                            $value->on('bookingtableonline.NoTransaksi','=','tableorderheader.NoTransaksi')
                            ->on('bookingtableonline.RecordOwnerID','=','tableorderheader.RecordOwnerID');
                        })
                        ->leftJoin('fakturpenjualandetail', function ($value)  {
                            $value->on('fakturpenjualandetail.BaseReff','=','tableorderheader.NoTransaksi')
                            ->on('fakturpenjualandetail.RecordOwnerID','=','tableorderheader.RecordOwnerID');
                        })
                        ->leftJoin('fakturpenjualanheader', function ($value)  {
                            $value->on('fakturpenjualanheader.NoTransaksi','=','fakturpenjualandetail.NoTransaksi')
                            ->on('fakturpenjualanheader.RecordOwnerID','=','fakturpenjualandetail.RecordOwnerID')
                            ->where('fakturpenjualanheader.Status', '=', 'C') // kondisi nilai tetap
                            ->where('fakturpenjualanheader.TotalPembayaran', '>', 0); // kondisi angka tetap
                        })
                        ->leftjoin('tkelompoklampu', function ($value)  {
                            $value->on('titiklampu.KelompokLampu','=','tkelompoklampu.KodeKelompok')
                            ->on('titiklampu.RecordOwnerID','=','tkelompoklampu.RecordOwnerID');
                        })
                        ->where('titiklampu.RecordOwnerID', '=', $request->RecordOwnerID)
                        ->where('titiklampu.Status', '=', '99')
                        ->get();

            return response()->json([
                'availableTable' => $availableTable,
                'usedTable' => $usedTable,
                'hampirHabisTable' => $hampirHabisTable,
                'message' => 'Queue processed successfully'
            ]);
    }
}
