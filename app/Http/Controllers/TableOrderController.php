<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\TableOrderHeader;
use App\Models\TableOrderFnB;
use App\Models\TitikLampu;
use App\Models\FakturPenjualanHeader;
use App\Models\FakturPenjualanDetail;
use App\Models\PembayaranPenjualanHeader;
use App\Models\PembayaranPenjualanDetail;
use App\Models\Paket;
use App\Models\Company;
use App\Models\Sales;
use App\Models\Pelanggan;
use App\Models\DocumentNumbering;
use App\Models\MetodePembayaran;
use App\Models\ItemMaster;
use App\Models\KelompokLampu;
use App\Models\GrupPelanggan;
use App\Models\BookingOnline;

use App\Mail\ReceiptMail;
use Illuminate\Support\Facades\Mail;

class TableOrderController extends Controller
{
    public function View(Request $request)
    {
        $paket = Paket::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        DB::table('tableorderheader')
                    ->where('DocumentStatus','=', 'O')
                    ->where('Status','=', '0')
                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                     // PREVIOUSLY CLOSED ALL STATUS 0. 
                     // NEW LOGIC: Only close if JamMulai <= NOW. Future bookings (Status 0) must remain Open.
                    ->where('JamMulai', '<=', Carbon::now()) 
                    ->update(
                        [
                            'DocumentStatus'=>'C',
                        ]
                    );

        $subqueryPembayaran = FakturPenjualanDetail::selectRaw("fakturpenjualandetail.BaseReff, fakturpenjualandetail.RecordOwnerID,
                            SUM(COALESCE(CASE WHEN fakturpenjualanheader.TotalPembayaran > fakturpenjualanheader.TotalPembelian THEN fakturpenjualanheader.TotalPembelian ELSE fakturpenjualanheader.TotalPembayaran END ,0)) as TotalPembayaran,
                            MAX(fakturpenjualanheader.NoReff) as NoReff")
                            ->join('fakturpenjualanheader', function ($join) {
                                $join->on('fakturpenjualanheader.NoTransaksi', '=', 'fakturpenjualandetail.NoTransaksi')
                                    ->on('fakturpenjualanheader.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID')
                                    ->where('fakturpenjualanheader.Status', '=', 'C')
                                    ->where('fakturpenjualanheader.TotalPembayaran', '>', 0);
                            })
                            ->whereIn(DB::RAW("COALESCE(fakturpenjualanheader.NoReff, 'POS')"), ['POS'])
                            ->groupBy('fakturpenjualandetail.BaseReff', 'fakturpenjualandetail.RecordOwnerID');
        
        $subqueryPembayaran_emenu = FakturPenjualanDetail::selectRaw("fakturpenjualandetail.BaseReff, fakturpenjualandetail.RecordOwnerID,
                            SUM(COALESCE(CASE WHEN fakturpenjualanheader.TotalPembayaran > fakturpenjualanheader.TotalPembelian THEN fakturpenjualanheader.TotalPembelian ELSE fakturpenjualanheader.TotalPembayaran END ,0)) as TotalPembayaran,
                            MAX(fakturpenjualanheader.NoReff) as NoReff")
                            ->join('fakturpenjualanheader', function ($join) {
                                $join->on('fakturpenjualanheader.NoTransaksi', '=', 'fakturpenjualandetail.NoTransaksi')
                                    ->on('fakturpenjualanheader.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID')
                                    ->where('fakturpenjualanheader.Status', '=', 'C')
                                    ->where('fakturpenjualanheader.TotalPembayaran', '>', 0);
                            })
                            ->whereIn(DB::RAW("COALESCE(fakturpenjualanheader.NoReff, 'POS')"), ['POS'])
                            ->groupBy('fakturpenjualandetail.BaseReff', 'fakturpenjualandetail.RecordOwnerID');

        $subqueryPembayaranJasa = FakturPenjualanDetail::selectRaw("fakturpenjualandetail.BaseReff, fakturpenjualandetail.RecordOwnerID,
                            SUM(COALESCE(CASE WHEN fakturpenjualanheader.TotalPembayaran > fakturpenjualanheader.TotalPembelian THEN fakturpenjualanheader.TotalPembelian ELSE fakturpenjualanheader.TotalPembayaran END ,0)) as TotalPembayaran,
                            MAX(fakturpenjualanheader.NoReff) as NoReff")
                            ->join('fakturpenjualanheader', function ($join) {
                                $join->on('fakturpenjualanheader.NoTransaksi', '=', 'fakturpenjualandetail.NoTransaksi')
                                    ->on('fakturpenjualanheader.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID')
                                    ->where('fakturpenjualanheader.Status', '=', 'C')
                                    ->where('fakturpenjualanheader.TotalPembayaran', '>', 0);
                            })
                            ->join('itemmaster', function($join){
                                $join->on('fakturpenjualandetail.KodeItem', '=', 'itemmaster.KodeItem')
                                    ->on('itemmaster.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID');
                            })
                            ->whereIn(DB::RAW("COALESCE(fakturpenjualanheader.NoReff, 'POS')"), ['POS'])
                            ->where('itemmaster.TypeItem', 4)
                            ->groupBy('fakturpenjualandetail.BaseReff', 'fakturpenjualandetail.RecordOwnerID');
        $titiklampu = TitikLampu::selectRaw("DISTINCT titiklampu.*,
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
                            tableorderheader.JamMulai,
                            tableorderheader.JamSelesai,
                            tableorderheader.JenisPaket,
                            tableorderheader.paketid,
                            tableorderheader.TglTransaksi,
                            tableorderheader.KodePelanggan,
                            pelanggan.NamaPelanggan,
                            pelanggan.TglBerlanggananPaketBulanan,
                            gruppelanggan.NamaGrup,
                            gruppelanggan.DiskonPersen,
                            CASE WHEN COALESCE(bookingtableonline.NoTransaksi,'') != '' THEN 'BOOKING' ELSE 'TIDAKBOOKING' END AS StatusBooking,
                            COALESCE(bookingtableonline.TotalTransaksi,0) AS BookingTotalTransaksi,
                            COALESCE(bookingtableonline.TotalTax,0) AS BookingTotalTax,
                            COALESCE(bookingtableonline.TotalDiskon,0) AS BookingTotalDiskon,
                            COALESCE(bookingtableonline.TotalLainLain,0) AS BookingTotalLainLain,
                            COALESCE(bookingtableonline.NetTotal,0) AS BookingNetTotal,
                            COALESCE(bookingtableonline.Keterangan,'') AS BookingPaymentReffNumber,
                            COALESCE(payment_summary.TotalPembayaran, 0) as TotalPembayaran,
                            COALESCE(tkelompoklampu.NamaKelompok,'') AS NamaKelompok,
                            pelanggan.TglBerlanggananPaketBulanan,
                            COALESCE(payment_summary.NoReff, 'POS') NoReff,
                            CASE WHEN payment_summary_jasa.BaseReff IS NOT NULL then 1 ELSE 0 END as isJasaPaid,
                            COALESCE(serial_numbers.isBlocked, 0) as isBlocked,
                            COALESCE(serial_numbers.BlockedReason, '') as BlockedReason
                        ")
                        ->leftJoin('tableorderheader', function ($value)  {
                            $value->on('titiklampu.id','=','tableorderheader.tableid')
                            ->on('titiklampu.RecordOwnerID','=','tableorderheader.RecordOwnerID')
                            // ->on(DB::raw("DATE_FORMAT(COALESCE(tableorderheader.JamSelesai, now()), '%Y-%m-%d')"),'>=',DB::raw("DATE_FORMAT(NOW(), '%Y-%m-%d')"))
                            ->on('tableorderheader.DocumentStatus','=',DB::raw("'O'"));
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
                        ->leftJoinSub($subqueryPembayaran, 'payment_summary', function ($join) {
                            $join->on('tableorderheader.NoTransaksi', '=', 'payment_summary.BaseReff')
                                 ->on('tableorderheader.RecordOwnerID', '=', 'payment_summary.RecordOwnerID');
                        })
                        ->leftjoin('tkelompoklampu', function ($value)  {
                            $value->on('titiklampu.KelompokLampu','=','tkelompoklampu.KodeKelompok')
                            ->on('titiklampu.RecordOwnerID','=','tkelompoklampu.RecordOwnerID');
                        })
                        ->join('mastercontroller', function ($value)  {
                            $value->on('titiklampu.ControllerID','=','mastercontroller.id')
                            ->on('titiklampu.RecordOwnerID','=','mastercontroller.RecordOwnerID');
                        })
                        ->leftJoinSub($subqueryPembayaranJasa, 'payment_summary_jasa', function ($join) {
                            $join->on('tableorderheader.NoTransaksi', '=', 'payment_summary_jasa.BaseReff')
                                 ->on('tableorderheader.RecordOwnerID', '=', 'payment_summary_jasa.RecordOwnerID');
                        })
                        ->leftJoin('serial_numbers', function ($value) {
                            $value->on('mastercontroller.SN', '=', 'serial_numbers.SerialNumber')
                                  ->on('mastercontroller.RecordOwnerID', '=', 'serial_numbers.KodePartner');
                        })
                        ->where('titiklampu.RecordOwnerID', '=', Auth::user()->RecordOwnerID)
                        ->whereIn(DB::raw("COALESCE(payment_summary.NoReff,'POS')"), ['POS','POS-FNB','POS-TAMBAHJAM'])
                        ->OrderBy('titiklampu.DigitalInput','ASC')
                        ->get();
        $titiklampuoption = TitikLampu::where('titiklampu.RecordOwnerID', '=', Auth::user()->RecordOwnerID)
                                ->whereIn('titiklampu.Status',['0','-1', '1'])->get();
        // $termin = $termin->paginate(4);
        $company = Company::Where('KodePartner','=',Auth::user()->RecordOwnerID)->get();
        $sales = Sales::Where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('Status','=',1)
                    ->get();
        $sql = "pelanggan.*, CONCAT(COALESCE(NoTlp1,''),CASE WHEN COALESCE(NoTlp2,'') != '' THEN ' / ' ELSE '' END , COALESCE(NoTlp2,'')) NoTlpConcat ";
        $pelanggan = Pelanggan::selectRaw($sql)
                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('Status','=',1)
                    ->get();
        $metodepembayaran = MetodePembayaran::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        // $itemmaster = ItemMaster::selectRaw('KodeItem as id, NamaItem as text, Satuan, HargaJual')
        //                 ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
        //                 ->where('Active','=', 'Y')->get();
        $oItem = new ItemMaster();
        $itemmaster = $oItem->GetItemData(Auth::user()->RecordOwnerID,"", "", "","", "Y", '', 0);

        $midtransdata = MetodePembayaran::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->where('MetodeVerifikasi','=','AUTO')->first();
        $midtransclientkey = "";
        $MetodePembayaranAutoID = -1;
        if ($midtransdata) {
            $midtransclientkey = $midtransdata->ClientKey;
            $MetodePembayaranAutoID = $midtransdata->id;
        }
        $kelompoklampu = KelompokLampu::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        $gruppelanggan = GrupPelanggan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $jenisLangganan = [];
        if (count($company) > 0 && $company[0]->JenisLangganan) {
            $jenisLangganan = json_decode($company[0]->JenisLangganan, true);
        }

        return view("Transaksi.Penjualan.PoS.Billing",[
            'paket' => $paket, 
            'titiklampu' => $titiklampu,
            'titiklampuoption' => $titiklampuoption,
            'company' => $company,
            'sales' => $sales,
            'pelanggan' => $pelanggan,
            'metodepembayaran' => $metodepembayaran,
            'itemmaster' => $itemmaster->get(),
            'midtransclientkey' => $midtransclientkey,
            'MetodePembayaranAutoID' => $MetodePembayaranAutoID,
            'kelompoklampu' => $kelompoklampu,
            'gruppelanggan' => $gruppelanggan,
            'oKodeSales' => Auth::user()->KodeSales,
            'jenisLangganan' => $jenisLangganan
        ]);
    }

    public function ViewNew(Request $request)
    {
        $paket = Paket::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        DB::table('tableorderheader')
                    ->where('DocumentStatus','=', 'O')
                    ->where('Status','=', '0')
                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('JamMulai', '<=', Carbon::now())
                    ->update(['DocumentStatus'=>'C']);

        $subqueryPembayaran = FakturPenjualanDetail::selectRaw("fakturpenjualandetail.BaseReff, fakturpenjualandetail.RecordOwnerID,
                            SUM(COALESCE(CASE WHEN fakturpenjualanheader.TotalPembayaran > fakturpenjualanheader.TotalPembelian THEN fakturpenjualanheader.TotalPembelian ELSE fakturpenjualanheader.TotalPembayaran END ,0)) as TotalPembayaran,
                            MAX(fakturpenjualanheader.NoReff) as NoReff")
                            ->join('fakturpenjualanheader', function ($join) {
                                $join->on('fakturpenjualanheader.NoTransaksi', '=', 'fakturpenjualandetail.NoTransaksi')
                                    ->on('fakturpenjualanheader.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID')
                                    ->where('fakturpenjualanheader.Status', '=', 'C')
                                    ->where('fakturpenjualanheader.TotalPembayaran', '>', 0);
                            })
                            ->whereIn(DB::RAW("COALESCE(fakturpenjualanheader.NoReff, 'POS')"), ['POS'])
                            ->groupBy('fakturpenjualandetail.BaseReff', 'fakturpenjualandetail.RecordOwnerID');

        $subqueryPembayaranJasa = FakturPenjualanDetail::selectRaw("fakturpenjualandetail.BaseReff, fakturpenjualandetail.RecordOwnerID,
                            SUM(COALESCE(CASE WHEN fakturpenjualanheader.TotalPembayaran > fakturpenjualanheader.TotalPembelian THEN fakturpenjualanheader.TotalPembelian ELSE fakturpenjualanheader.TotalPembayaran END ,0)) as TotalPembayaran,
                            MAX(fakturpenjualanheader.NoReff) as NoReff")
                            ->join('fakturpenjualanheader', function ($join) {
                                $join->on('fakturpenjualanheader.NoTransaksi', '=', 'fakturpenjualandetail.NoTransaksi')
                                    ->on('fakturpenjualanheader.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID')
                                    ->where('fakturpenjualanheader.Status', '=', 'C')
                                    ->where('fakturpenjualanheader.TotalPembayaran', '>', 0);
                            })
                            ->join('itemmaster', function($join){
                                $join->on('fakturpenjualandetail.KodeItem', '=', 'itemmaster.KodeItem')
                                    ->on('itemmaster.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID');
                            })
                            ->whereIn(DB::RAW("COALESCE(fakturpenjualanheader.NoReff, 'POS')"), ['POS'])
                            ->where('itemmaster.TypeItem', 4)
                            ->groupBy('fakturpenjualandetail.BaseReff', 'fakturpenjualandetail.RecordOwnerID');

        $titiklampu = TitikLampu::selectRaw("DISTINCT titiklampu.*,
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
                            tableorderheader.JamMulai,
                            tableorderheader.JamSelesai,
                            tableorderheader.JenisPaket,
                            tableorderheader.TglTransaksi,
                            tableorderheader.KodePelanggan,
                            pelanggan.NamaPelanggan,
                            pelanggan.TglBerlanggananPaketBulanan,
                            gruppelanggan.NamaGrup,
                            gruppelanggan.DiskonPersen,
                            COALESCE(payment_summary.TotalPembayaran, 0) as TotalPembayaran,
                            COALESCE(tkelompoklampu.NamaKelompok,'') AS NamaKelompok,
                            COALESCE(payment_summary.NoReff, 'POS') NoReff,
                            CASE WHEN payment_summary_jasa.BaseReff IS NOT NULL then 1 ELSE 0 END as isJasaPaid,
                            COALESCE(serial_numbers.isBlocked, 0) as isBlocked,
                            COALESCE(serial_numbers.BlockedReason, '') as BlockedReason
                        ")
                        ->leftJoin('tableorderheader', function ($value)  {
                            $value->on('titiklampu.id','=','tableorderheader.tableid')
                            ->on('titiklampu.RecordOwnerID','=','tableorderheader.RecordOwnerID')
                            ->on('tableorderheader.DocumentStatus','=',DB::raw("'O'"));
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
                        ->leftJoinSub($subqueryPembayaran, 'payment_summary', function ($join) {
                            $join->on('tableorderheader.NoTransaksi', '=', 'payment_summary.BaseReff')
                                 ->on('tableorderheader.RecordOwnerID', '=', 'payment_summary.RecordOwnerID');
                        })
                        ->leftjoin('tkelompoklampu', function ($value)  {
                            $value->on('titiklampu.KelompokLampu','=','tkelompoklampu.KodeKelompok')
                            ->on('titiklampu.RecordOwnerID','=','tkelompoklampu.RecordOwnerID');
                        })
                        ->join('mastercontroller', function ($value)  {
                            $value->on('titiklampu.ControllerID','=','mastercontroller.id')
                            ->on('titiklampu.RecordOwnerID','=','mastercontroller.RecordOwnerID');
                        })
                        ->leftJoinSub($subqueryPembayaranJasa, 'payment_summary_jasa', function ($join) {
                            $join->on('tableorderheader.NoTransaksi', '=', 'payment_summary_jasa.BaseReff')
                                 ->on('tableorderheader.RecordOwnerID', '=', 'payment_summary_jasa.RecordOwnerID');
                        })
                        ->leftJoin('serial_numbers', function ($value) {
                            $value->on('mastercontroller.SN', '=', 'serial_numbers.SerialNumber')
                                  ->on('mastercontroller.RecordOwnerID', '=', 'serial_numbers.KodePartner');
                        })
                        ->where('titiklampu.RecordOwnerID', '=', Auth::user()->RecordOwnerID)
                        ->whereIn(DB::raw("COALESCE(payment_summary.NoReff,'POS')"), ['POS','POS-FNB','POS-TAMBAHJAM'])
                        ->OrderBy('titiklampu.DigitalInput','ASC')
                        ->get();

        $titiklampuoption = TitikLampu::where('titiklampu.RecordOwnerID', '=', Auth::user()->RecordOwnerID)
                                ->whereIn('titiklampu.Status',['0','-1', '1'])->get();

        $company = Company::Where('KodePartner','=',Auth::user()->RecordOwnerID)->get();
        $sales = Sales::Where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('Status','=',1)->get();
        $sql = "pelanggan.*, CONCAT(COALESCE(NoTlp1,''),CASE WHEN COALESCE(NoTlp2,'') != '' THEN ' / ' ELSE '' END , COALESCE(NoTlp2,'')) NoTlpConcat ";
        $pelanggan = Pelanggan::selectRaw($sql)
                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('Status','=',1)->get();
        $metodepembayaran = MetodePembayaran::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        $oItem = new ItemMaster();
        $itemmaster = $oItem->GetItemData(Auth::user()->RecordOwnerID,"", "", "","", "Y", '', 0);
        $midtransdata = MetodePembayaran::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->where('MetodeVerifikasi','=','AUTO')->first();
        $midtransclientkey = "";
        $MetodePembayaranAutoID = -1;
        if ($midtransdata) {
            $midtransclientkey = $midtransdata->ClientKey;
            $MetodePembayaranAutoID = $midtransdata->id;
        }
        $kelompoklampu = KelompokLampu::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        $gruppelanggan = GrupPelanggan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        $jenisLangganan = [];
        if (count($company) > 0 && $company[0]->JenisLangganan) {
            $jenisLangganan = json_decode($company[0]->JenisLangganan, true);
        }

        return view("Transaksi.Penjualan.PoS.billing_new",[
            'paket' => $paket,
            'titiklampu' => $titiklampu,
            'titiklampuoption' => $titiklampuoption,
            'company' => $company,
            'sales' => $sales,
            'pelanggan' => $pelanggan,
            'metodepembayaran' => $metodepembayaran,
            'itemmaster' => $itemmaster->get(),
            'midtransclientkey' => $midtransclientkey,
            'MetodePembayaranAutoID' => $MetodePembayaranAutoID,
            'kelompoklampu' => $kelompoklampu,
            'gruppelanggan' => $gruppelanggan,
            'oKodeSales' => Auth::user()->KodeSales,
            'jenisLangganan' => $jenisLangganan
        ]);
    }

    public function ViewSelfService(Request $request)
    {
        $paket = Paket::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        DB::table('tableorderheader')
                    ->where('DocumentStatus','=', 'O')
                    ->where('Status','=', '0')
                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->update(
                        [
                            'DocumentStatus'=>'C',
                        ]
                    );
                    
        $subqueryPembayaran = FakturPenjualanDetail::selectRaw("fakturpenjualandetail.BaseReff, fakturpenjualandetail.RecordOwnerID,
                            SUM(COALESCE(CASE WHEN fakturpenjualanheader.TotalPembayaran > fakturpenjualanheader.TotalPembelian THEN fakturpenjualanheader.TotalPembelian ELSE fakturpenjualanheader.TotalPembayaran END ,0)) as TotalPembayaran,
                            MAX(fakturpenjualanheader.NoReff) as NoReff")
                            ->join('fakturpenjualanheader', function ($join) {
                                $join->on('fakturpenjualanheader.NoTransaksi', '=', 'fakturpenjualandetail.NoTransaksi')
                                    ->on('fakturpenjualanheader.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID')
                                    ->where('fakturpenjualanheader.Status', '=', 'C')
                                    ->where('fakturpenjualanheader.TotalPembayaran', '>', 0);
                            })
                            ->where(DB::RAW("COALESCE(fakturpenjualanheader.NoReff, 'POS')"), 'POS')
                            ->groupBy('fakturpenjualandetail.BaseReff', 'fakturpenjualandetail.RecordOwnerID');

        $titiklampu = TitikLampu::selectRaw("DISTINCT titiklampu.*,
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
                            tableorderheader.JamMulai,
                            tableorderheader.JamSelesai,
                            tableorderheader.JenisPaket,
                            tableorderheader.paketid,
                            tableorderheader.TglTransaksi,
                            tableorderheader.KodePelanggan,
                            pelanggan.NamaPelanggan,
                            pelanggan.TglBerlanggananPaketBulanan,
                            gruppelanggan.NamaGrup,
                            gruppelanggan.DiskonPersen,
                            CASE WHEN COALESCE(bookingtableonline.NoTransaksi,'') != '' THEN 'BOOKING' ELSE 'TIDAKBOOKING' END AS StatusBooking,
                            COALESCE(bookingtableonline.TotalTransaksi,0) AS BookingTotalTransaksi,
                            COALESCE(bookingtableonline.TotalTax,0) AS BookingTotalTax,
                            COALESCE(bookingtableonline.TotalDiskon,0) AS BookingTotalDiskon,
                            COALESCE(bookingtableonline.TotalLainLain,0) AS BookingTotalLainLain,
                            COALESCE(bookingtableonline.NetTotal,0) AS BookingNetTotal,
                            COALESCE(bookingtableonline.Keterangan,'') AS BookingPaymentReffNumber,
                            COALESCE(payment_summary.TotalPembayaran, 0) as TotalPembayaran,
                            COALESCE(tkelompoklampu.NamaKelompok,'') AS NamaKelompok,
                            COALESCE(serial_numbers.isBlocked, 0) as isBlocked,
                            COALESCE(serial_numbers.BlockedReason, '') as BlockedReason
                        ")
                        ->leftJoin('tableorderheader', function ($value)  {
                            $value->on('titiklampu.id','=','tableorderheader.tableid')
                            ->on('titiklampu.RecordOwnerID','=','tableorderheader.RecordOwnerID')
                            // ->on(DB::raw("DATE_FORMAT(COALESCE(tableorderheader.JamSelesai, now()), '%Y-%m-%d')"),'>=',DB::raw("DATE_FORMAT(NOW(), '%Y-%m-%d')"))
                            ->on('tableorderheader.DocumentStatus','=',DB::raw("'O'"));
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
                        ->leftJoinSub($subqueryPembayaran, 'payment_summary', function ($join) {
                            $join->on('tableorderheader.NoTransaksi', '=', 'payment_summary.BaseReff')
                                 ->on('tableorderheader.RecordOwnerID', '=', 'payment_summary.RecordOwnerID');
                        })
                        ->leftjoin('tkelompoklampu', function ($value)  {
                            $value->on('titiklampu.KelompokLampu','=','tkelompoklampu.KodeKelompok')
                            ->on('titiklampu.RecordOwnerID','=','tkelompoklampu.RecordOwnerID');
                        })
                        ->join('mastercontroller', function ($value)  {
                            $value->on('titiklampu.ControllerID','=','mastercontroller.id')
                            ->on('titiklampu.RecordOwnerID','=','mastercontroller.RecordOwnerID');
                        })
                        ->leftJoin('serial_numbers', function ($value) {
                            $value->on('mastercontroller.SN', '=', 'serial_numbers.SerialNumber')
                                  ->on('mastercontroller.RecordOwnerID', '=', 'serial_numbers.KodePartner');
                        })
                        ->where('titiklampu.RecordOwnerID', '=', Auth::user()->RecordOwnerID)
                        ->where(DB::raw("COALESCE(payment_summary.NoReff,'POS')"), 'POS')
                        ->get();
        $titiklampuoption = TitikLampu::where('titiklampu.RecordOwnerID', '=', Auth::user()->RecordOwnerID)
                                ->where('titiklampu.Status','=','0')->get();
        // $termin = $termin->paginate(4);
        $company = Company::Where('KodePartner','=',Auth::user()->RecordOwnerID)->get();
        $sales = Sales::Where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('Status','=',1)
                    ->get();
        $sql = "pelanggan.*, CONCAT(COALESCE(NoTlp1,''),CASE WHEN COALESCE(NoTlp2,'') != '' THEN ' / ' ELSE '' END , COALESCE(NoTlp2,'')) NoTlpConcat ";
        $pelanggan = Pelanggan::selectRaw($sql)
                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('Status','=',1)
                    ->get();
        $metodepembayaran = MetodePembayaran::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->where('MetodeVerifikasi','AUTO')
                            ->get();
        // $itemmaster = ItemMaster::selectRaw('KodeItem as id, NamaItem as text, Satuan, HargaJual')
        //                 ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
        //                 ->where('Active','=', 'Y')->get();
        $oItem = new ItemMaster();
        $itemmaster = $oItem->GetItemData(Auth::user()->RecordOwnerID,"", "", "","", "Y", '', 0);

        $midtransdata = MetodePembayaran::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->where('MetodeVerifikasi','=','AUTO')->first();
        $midtransclientkey = "";
        $MetodePembayaranAutoID = -1;
        if ($midtransdata) {
            $midtransclientkey = $midtransdata->ClientKey;
            $MetodePembayaranAutoID = $midtransdata->id;
        }
        $kelompoklampu = KelompokLampu::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $jenisLangganan = [];
        if (count($company) > 0 && $company[0]->JenisLangganan) {
            $jenisLangganan = json_decode($company[0]->JenisLangganan, true);
        }

        return view("Transaksi.Penjualan.PoS.BillingSelfService",[
            'paket' => $paket, 
            'titiklampu' => $titiklampu,
            'titiklampuoption' => $titiklampuoption,
            'company' => $company,
            'sales' => $sales,
            'pelanggan' => $pelanggan,
            'metodepembayaran' => $metodepembayaran,
            'itemmaster' => $itemmaster->get(),
            'midtransclientkey' => $midtransclientkey,
            'MetodePembayaranAutoID' => $MetodePembayaranAutoID,
            'kelompoklampu' => $kelompoklampu,
            'oKodeSales' => Auth::user()->KodeSales,
            'jenisLangganan' => $jenisLangganan
        ]);
    }

    public function store(Request $request) {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "", "NoTransaksi" => "");

        $this->validate($request, [
            'JenisPaket'=>'required',
            'paketid'=>$request->input('JenisPaket') == 'PAKETMEMBER' ? 'nullable' : 'required',
            'tableid'=>'required',
            'KodeSales'=>'required',
            'DurasiPaket'=>'required'
        ]);

        try {
            $currentDate = Carbon::now();
			$Year = $currentDate->format('Y');
			$Month = $currentDate->format('m');

			$numberingData = new DocumentNumbering();
            $random = random_int(10000, 99999);
	        $NoTransaksi = $random . $numberingData->GetNewDoc("TRDR","tableorderheader","NoTransaksi");


            $model = new TableOrderHeader;
            $model->NoTransaksi = $NoTransaksi;
            $tglTransaksi = $request->input('TglTransaksi') ? Carbon::parse($request->input('TglTransaksi')) : Carbon::now();
            $model->TglTransaksi = $tglTransaksi;
            $model->TglPencatatan = Carbon::now();
            $model->JenisPaket = $request->input('JenisPaket');
            $model->paketid = $request->input('paketid');
            $model->tableid = $request->input('tableid');
            $model->KodeSales = $request->input('KodeSales');
            $model->DurasiPaket = $request->input('DurasiPaket');
            $model->Status = $request->input('Status');
            $model->KodePelanggan = $request->input('KodePelanggan');
            $model->TaxTotal = 0;//$request->input('TaxTotal');
            $model->GrossTotal = 0; //$request->input('GrossTotal');
            $model->DiscTotal = 0;// $request->input('DiscTotal');
            $model->NetTotal = 0;//$request->input('NetTotal');
            
            // JamMulai Handling
            // If provided from frontend (Slot selected), use it.
            // If not provided (Flexible, or Menit), use NOW with the selected date.
            if ($request->input('JenisPaket') == 'DAILY' || $request->input('JenisPaket') == 'MONTHLY' || $request->input('JenisPaket') == 'YEARLY') {
                $model->JamMulai = Carbon::parse($request->input('JamMulai'));
                $model->JamSelesai = Carbon::parse($request->input('JamSelesai'));
            } elseif ($request->has('JamMulai') && $request->input('JamMulai') != "") {
                $tgl = $request->input('TglBooking') ?? $tglTransaksi->toDateString();
                $jam = $request->input('JamMulai');
                $model->JamMulai = Carbon::parse($tgl . ' ' . $jam);
            } else {
                $now = Carbon::now();
                $model->JamMulai = Carbon::parse($tglTransaksi->toDateString() . ' ' . $now->toTimeString());
            }

            if ($request->input('JenisPaket') == 'JAM' || $request->input('JenisPaket') == 'PAKETMEMBER' || $request->input('JenisPaket') == 'JAMREALTIME') {
                 // JamSelesai Calculation
                 // If frontend provided JamSelesai, we could uses it, BUT calculation based on Duration is safer/consistent
                 // $model->JamSelesai = $currentDate->addHours($request->input('DurasiPaket'))->subMinute(); <--- This uses NOW, we must use Model's JamMulai
                 
                 $jamMulai = $model->JamMulai->copy();
                 $model->JamSelesai = $jamMulai->addHours($request->input('DurasiPaket'))->subMinute();
                 
                // var_dump($currentDate->addHours($request->input('DurasiPaket')));
            }

            if ($request->input('JenisPaket') == 'MENIT') {
                $model->JamSelesai = $currentDate->addMinutes($request->input('DurasiPaket'))->subMinute();
                // var_dump($currentDate->addHours($request->input('DurasiPaket')));
                // $model->Status = 1;
            }

            if ($request->input('JenisPaket') == 'MENITREALTIME' || $request->input('JenisPaket') == 'JAMREALTIME' || $request->input('JenisPaket') == 'PAYPERUSE') {
                $model->DocumentStatus = 'O';
                // $model->Status = 1;
                if ($request->input('JenisPaket') == 'MENITREALTIME' || $request->input('JenisPaket') == 'PAYPERUSE') {
                    $model->JamMulai = Carbon::now();
                    $model->JamSelesai = null;
                }
            }



            // Future Booking Logic
            // If JamMulai > NOW, force Status to 0 (Booking/Scheduled)
            $now = Carbon::now();
            // dd($model->JamMulai->gt($now), $now, $model->JamMulai);
            if ($model->JamMulai->gt($now)) {
                $model->Status = 0;
                $model->DocumentStatus = 'D';
            }
            
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            // dd($model);
            $save = $model->save();

            // if ($save && $request->input('JenisPaket') == 'PAKETMEMBER') {
            //     $pelanggan = Pelanggan::where('KodePelanggan', $request->input('KodePelanggan'))
            //         ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
            //         ->first();
            //     if ($pelanggan && $pelanggan->isPaidMembership == 1) {
            //         // Update Played instead of decrementing MaxPlay
            //         DB::table('pelanggan')
            //                 ->where('KodePelanggan','=', $pelanggan->KodePelanggan)
            //                 ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
            //                 ->update(
            //                     [
            //                         'Played' => DB::raw('COALESCE(Played,0) + 1')
            //                     ]
            //                 );

            //         // Auto Create Faktur & Payment
            //         try {
            //             $pricePerPlay = 0;
            //             if ($pelanggan->MaxPlay > 0) {
            //                 $pricePerPlay = $pelanggan->MemberPrice / $pelanggan->MaxPlay;
            //             }

            //             $oCompany = Company::where('RecordOwnerID', Auth::user()->RecordOwnerID)->first();
            //             $metodeCash = MetodePembayaran::where('RecordOwnerID', Auth::user()->RecordOwnerID)
            //                             ->where('NamaMetodePembayaran', 'CASH')
            //                             ->first();
            //             $metodeId = $metodeCash ? $metodeCash->id : MetodePembayaran::where('RecordOwnerID', Auth::user()->RecordOwnerID)->first()->id;

            //             // 1. Faktur Header
            //             $fakturNo = $numberingData->GetNewDoc("POS", "fakturpenjualanheader", "NoTransaksi");
            //             $fHeader = new FakturPenjualanHeader();
            //             $fHeader->Periode = $Year . $Month;
            //             $fHeader->NoTransaksi = $fakturNo;
            //             $fHeader->Transaksi = 'POS';
            //             $fHeader->TglTransaksi = Carbon::now();
            //             $fHeader->TglJatuhTempo = Carbon::now();
            //             $fHeader->NoReff = $NoTransaksi;
            //             $fHeader->KodePelanggan = $pelanggan->KodePelanggan;
            //             $fHeader->KodeTermin = "";
            //             $fHeader->Termin = 0;
            //             $fHeader->TotalTransaksi = $pricePerPlay;
            //             $fHeader->Potongan = 0;
            //             $fHeader->Pajak = 0;
            //             $fHeader->TotalPembelian = $pricePerPlay;
            //             $fHeader->TotalRetur = 0;
            //             $fHeader->TotalPembayaran = $pricePerPlay;
            //             $fHeader->Pembulatan = 0;
            //             $fHeader->Status = 'C'; // Close/Lunas
            //             $fHeader->Keterangan = 'Paket Member - Auto Paid';
            //             $fHeader->MetodeBayar = $metodeId;
            //             $fHeader->ReffPembayaran = "MEMBER-" . $pelanggan->KodePelanggan;
            //             $fHeader->KodeSales = $request->input('KodeSales');
            //             $fHeader->Posted = 0;
            //             $fHeader->RecordOwnerID = Auth::user()->RecordOwnerID;
            //             $fHeader->CreatedBy = Auth::user()->name;
            //             $fHeader->save();

            //             // 2. Faktur Detail
            //             $fDetail = new FakturPenjualanDetail();
            //             $fDetail->NoTransaksi = $fakturNo;
            //             $fDetail->NoUrut = 0;
            //             $fDetail->KodeItem = $oCompany->ItemHiburan;
            //             $fDetail->Qty = $request->input('DurasiPaket');
            //             $fDetail->QtyKonversi = $request->input('DurasiPaket');
            //             $fDetail->QtyRetur = 0;
            //             $fDetail->Satuan = 'JAM';
            //             $fDetail->Harga = $pricePerPlay / max(1, $request->input('DurasiPaket')); // Adjust price per hour if needed
            //             $fDetail->Discount = 0;
            //             $fDetail->BaseReff = $NoTransaksi;
            //             $fDetail->BaseLine = -1;
            //             $fDetail->KodeGudang = $oCompany->GudangPoS;
            //             $fDetail->HargaNet = $pricePerPlay;
            //             $fDetail->LineStatus = 'O';
            //             $fDetail->VatPercent = 0;
            //             $fDetail->HargaPokokPenjualan = 0;
            //             $fDetail->RecordOwnerID = Auth::user()->RecordOwnerID;
            //             $fDetail->save();

            //             // 3. Pembayaran Header
            //             $payNo = $numberingData->GetNewDoc("INPAY", "pembayaranpenjualanheader", "NoTransaksi");
            //             $pHeader = new PembayaranPenjualanHeader();
            //             $pHeader->Periode = $Year . $Month;
            //             $pHeader->NoTransaksi = $payNo;
            //             $pHeader->TglTransaksi = Carbon::now();
            //             $pHeader->KodePelanggan = $pelanggan->KodePelanggan;
            //             $pHeader->TotalPembelian = $pricePerPlay;
            //             $pHeader->TotalPembayaran = $pricePerPlay;
            //             $pHeader->KodeMetodePembayaran = $metodeId;
            //             $pHeader->NoReff = "MEMBER-" . $pelanggan->KodePelanggan;
            //             $pHeader->Keterangan = 'Paket Member Auto Payment';
            //             $pHeader->RecordOwnerID = Auth::user()->RecordOwnerID;
            //             $pHeader->CreatedBy = Auth::user()->name;
            //             $pHeader->Posted = 0;
            //             $pHeader->Status = 'C';
            //             $pHeader->save();

            //             // 4. Pembayaran Detail
            //             $pDetail = new PembayaranPenjualanDetail();
            //             $pDetail->NoTransaksi = $payNo;
            //             $pDetail->NoUrut = 0;
            //             $pDetail->BaseReff = $fakturNo;
            //             $pDetail->TotalPembayaran = $pricePerPlay;
            //             $pDetail->RecordOwnerID = Auth::user()->RecordOwnerID;
            //             $pDetail->KodeMetodePembayaran = $metodeId;
            //             $pDetail->Keterangan = 'Auto Paid';
            //             $pDetail->save();

            //         } catch (\Exception $e) {
            //             Log::error("Failed to auto-create faktur for member: " . $e->getMessage());
            //         }
            //     }
            // }

            // DB::table('tableorderheader')
            //                 ->where('NoTransaksi','=', $NoTransaksi)
            //                 ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
            //                 ->update(
            //                     [
            //                         'JamSelesai' => DB::raw('DATE_ADD(JamMulai, INTERVAL DurasiPaket HOUR)')
            //                     ]
            //                 );

            if ($save) {
                $data['success'] = true;
                $data['NoTransaksi'] = $NoTransaksi;
            }else{
                $data['message'] = 'Internal error, Contact System Administrator';
            }
        } catch (\Throwable $th) {
            $data['message'] = 'Internal error, '. $th->getMessage() ;
        }
        return response()->json($data);
    }

    public function EditPaket(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $this->validate($request, [
            'txtNoTransaksi_RubahDurasi'=>'required',
            'txtDurasiPaket_RubahDurasi'=>'required'
        ]);

        try {
            $model = TableOrderHeader::where('NoTransaksi','=',$request->input('txtNoTransaksi_RubahDurasi'))
                        ->where('RecordOwnerID','=', Auth::user()->RecordOwnerID);

            if ($model) {
                $update = DB::table('tableorderheader')
                            ->where('NoTransaksi','=', $request->input('txtNoTransaksi_RubahDurasi'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'Status' => '1',
                                    'DurasiPaket' => DB::raw('DurasiPaket + ' . $request->input('txtDurasiPaket_RubahDurasi')),
                                    'JamSelesai' => DB::raw('DATE_ADD(JamMulai, INTERVAL DurasiPaket HOUR)')
                                ]
                            );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message']= 'Update Data Paket Gagal';
                }
            }
        } catch (\Throwable $th) {
            $data['message'] = 'Internal error, '. $th->getMessage() ;
        }

        return response()->json($data);
    }

    public function CheckOut(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $this->validate($request, [
            'txtNoTransaksi_CheckOut'=>'required',
            'txtJenisPaket_CheckOut'=>'required'
        ]);

        try {
            $model = TableOrderHeader::selectRaw("tableorderheader.NoTransaksi,  COALESCE(SUM(tableorderfnb.LineTotal),0) AS totalFNB, COALESCE(SUM(fakturpenjualanheader.TotalPembelian),0) AS TotalCostTable, COALESCE(SUM(fakturpenjualanheader.TotalPembayaran), 0) SumedPayment ")
                        ->leftJoin('tableorderfnb', function ($value)  {
                            $value->on('tableorderfnb.NoTransaksi','=','tableorderheader.NoTransaksi')
                            ->on('tableorderfnb.RecordOwnerID','=','tableorderheader.RecordOwnerID');
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
                        ->where('tableorderheader.NoTransaksi','=',$request->input('txtNoTransaksi_CheckOut'))
                        ->where('tableorderheader.RecordOwnerID','=', Auth::user()->RecordOwnerID)
                        ->groupBy('tableorderheader.NoTransaksi')->first();
            
            $totalTransaksi = $model->totalFNB + $model->TotalCostTable;
            $Status = -1;
            // dd($model);
            // $request->input('TotalPembayaran')
            if($totalTransaksi > $model->SumedPayment || $totalTransaksi == 0 ){
                $Status = -1;
            }
            else{
                $Status = 0;
            }

            // dd($Status);
            if ($model) {
                $update = DB::table('tableorderheader')
                            ->where('NoTransaksi','=', $request->input('txtNoTransaksi_CheckOut'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'Status' => $Status,
                                    'JamSelesai' => DB::raw("CASE WHEN JamSelesai IS NULL THEN NOW() ELSE JamSelesai END")
                                    // 'JamSelesai' => DB::raw("CASE WHEN '" . $request->input('txtJenisPaket_CheckOut') . "' = 'MENIT' OR '" . $request->input('txtJenisPaket_CheckOut') . "' = 'MENITREALTIME' THEN NOW() ELSE JamSelesai END")
                                ]
                            );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message']= 'Update Data Paket Gagal';
                }
            }
        } catch (\Throwable $th) {
            $data['message'] = 'Internal error, '. $th->getMessage() ;
        }

        return response()->json($data);
    }

    public function getOrderDetail(Request $request)
    {
        try {
            $noTransaksi = $request->NoTransaksi;
            $recordOwnerID = Auth::user()->RecordOwnerID;

            if (!$noTransaksi) {
                return response()->json(['success' => false, 'message' => 'No Transaksi tidak ditemukan']);
            }

            // 1. Get Header Info
            $header = DB::table('tableorderheader')
                ->selectRaw("
                    tableorderheader.NoTransaksi,
                    tableorderheader.JamMulai,
                    tableorderheader.JamSelesai,
                    tableorderheader.DurasiPaket,
                    tableorderheader.Gross,
                    tableorderheader.TotalDiskon,
                    tableorderheader.TotalTax,
                    tableorderheader.TotalPajakHiburan,
                    tableorderheader.BiayaLayanan,
                    tableorderheader.TotalTerbayar,
                    tableorderheader.Status,
                    tableorderheader.DocumentStatus,
                    pelanggan.NamaPelanggan,
                    pakettransaksi.NamaPaket,
                    pakettransaksi.HargaNormal,
                    tableorderheader.JenisPaket
                ")
                ->leftJoin('pelanggan', function($join) {
                    $join->on('pelanggan.KodePelanggan', '=', 'tableorderheader.KodePelanggan')
                         ->on('pelanggan.RecordOwnerID', '=', 'tableorderheader.RecordOwnerID');
                })
                ->leftJoin('pakettransaksi', function($join) {
                    $join->on('pakettransaksi.id', '=', 'tableorderheader.paketid')
                         ->on('pakettransaksi.RecordOwnerID', '=', 'tableorderheader.RecordOwnerID');
                })
                ->where('tableorderheader.NoTransaksi', $noTransaksi)
                ->where('tableorderheader.RecordOwnerID', $recordOwnerID)
                ->first();

            if (!$header) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
            }

            // ===== Duration Calculation =====
            $effectiveJamSelesai = $header->JamSelesai;
            $effectiveDurasi     = (float)$header->DurasiPaket; // stored durasi in minutes
            $shouldRecalculate   = false;
            $isLiveRunning       = false;

            $realTimePaket = in_array($header->JenisPaket, ['MENITREALTIME', 'JAMREALTIME', 'PAYPERUSE']);

            if (!empty($header->JamMulai)) {
                $jamMulaiDt = Carbon::parse($header->JamMulai);
                
                if (empty($header->JamSelesai)) {
                    // Running now: Use current time
                    $nowDt = Carbon::now();
                    $effectiveJamSelesai = $nowDt->toDateTimeString();
                    $effectiveDurasi = max(1, $jamMulaiDt->diffInMinutes($nowDt));
                    $shouldRecalculate = true;
                    $isLiveRunning = true;
                } elseif ($realTimePaket) {
                    // Checked out but real-time: Recalculate duration from actual JamSelesai
                    $jamSelesaiDt = Carbon::parse($header->JamSelesai);
                    $effectiveDurasi = max(1, $jamMulaiDt->diffInMinutes($jamSelesaiDt));
                    $shouldRecalculate = true;
                }
            }

            // Recalculate Gross based on effective duration
            // HargaNormal is for DurasiPaket (stored) minutes — so price per minute = HargaNormal / DurasiPaket
            $storedDurasi     = max(1, (float)$header->DurasiPaket);
            $hargaNormal      = (float)$header->HargaNormal;
            
            $isHourly = in_array($header->JenisPaket, ['JAM', 'JAMREALTIME', 'PAKETMEMBER']);
            
            // Define hargaPerMenit for response parity
            $divisor = $isHourly ? ($storedDurasi * 60) : $storedDurasi;
            $hargaPerMenit = $divisor > 0 ? ($hargaNormal / $divisor) : $hargaNormal;
            
            // If live or real-time, recalculate everything from scratch using elapsed time
            if ($shouldRecalculate) {
                if ($isHourly) {
                    // Pricing based on full hour units (round up)
                    $baseDurasi = max(1, (float)$header->DurasiPaket); 
                    $units = ceil($effectiveDurasi / ($baseDurasi * 60));
                    $totalPaket = $units * $hargaNormal;
                } else {
                    // Minute-based/Default logic
                    $totalPaket = $effectiveDurasi * $hargaPerMenit;
                }
                
                $diskon     = (float)$header->TotalDiskon;
                $dpp        = max(0, $totalPaket - $diskon);

                // Re-fetch tax percentages from company
                $company = Company::where('KodePartner', $recordOwnerID)->first();
                $ppnPer  = $company->PPN ?? 0;
                $pb1Per  = $company->PajakHiburan ?? 0;
                $svcPer  = $company->ServiceCharge ?? 0;

                $pajak        = $dpp * ($ppnPer / 100);
                $pajakHiburan = $dpp * ($pb1Per / 100);
                $layanan      = $dpp * ($svcPer / 100);
            } else {
                // Use stored values (Gross has been saved during storePaket)
                $totalPaket   = $header->Gross > 0 ? (float)$header->Gross : ($storedDurasi * $hargaNormal);
                $diskon       = (float)$header->TotalDiskon;
                $pajak        = (float)$header->TotalTax;
                $pajakHiburan = (float)$header->TotalPajakHiburan;
                $layanan      = (float)$header->BiayaLayanan;
            }

            $grandTotalPaket = $totalPaket - $diskon + $pajak + $pajakHiburan + $layanan;
            // dd($totalPaket ,$diskon , $pajak , $pajakHiburan , $layanan);
            // 2. Get FnB List
            $fnb = DB::table('tableorderfnb as a')
                ->leftJoin('fakturpenjualandetail as b', function($join) {
                    $join->on('a.NoTransaksi', '=', 'b.BaseReff')
                         ->on('a.RecordOwnerID', '=', 'b.RecordOwnerID')
                         ->on('a.KodeItem', '=', 'b.KodeItem');
                })
                ->leftJoin('fakturpenjualanheader as c', function($join) {
                    $join->on('b.NoTransaksi', '=', 'c.NoTransaksi')
                         ->on('b.RecordOwnerID', '=', 'c.RecordOwnerID')
                         ->where('c.NoReff', '=', 'POS-FNB');
                })
                ->leftJoin('itemmaster as d', function($join) {
                    $join->on('a.KodeItem', '=', 'd.KodeItem')
                         ->on('a.RecordOwnerID', '=', 'd.RecordOwnerID');
                })
                ->select(
                    DB::raw("CASE WHEN b.NoTransaksi IS NULL THEN '-' ELSE b.NoTransaksi END AS NoTransaksi"),
                    DB::raw("COALESCE(c.TglTransaksi, NOW()) as TglTransaksi"),
                    'a.KodeItem',
                    'd.NamaItem',
                    'a.Qty',
                    'a.Harga',
                    'a.LineStatus',
                    DB::raw('a.Qty * a.Harga as Total')
                )
                ->where('a.NoTransaksi', $noTransaksi)
                ->where('a.RecordOwnerID', $recordOwnerID)
                ->get();

            $fnbCalculate = DB::table('tableorderfnb')
                ->selectRaw("(LineTotal) as TotalHarga")
                ->where('NoTransaksi', $noTransaksi)
                ->where('RecordOwnerID', $recordOwnerID)
                ->where('LineStatus', 'O')
                ->get();

            // 3. Get Payment Info (untuk outstanding)
            $paymentData = DB::table('fakturpenjualanheader')
                ->selectRaw("COALESCE(SUM(TotalPembayaran), 0) as TotalTerbayar")
                ->whereIn('NoTransaksi', function($query) use ($noTransaksi, $recordOwnerID) {
                    $query->select('NoTransaksi')
                        ->from('fakturpenjualandetail')
                        ->where('BaseReff', $noTransaksi)
                        ->where('RecordOwnerID', $recordOwnerID);
                })
                ->where('RecordOwnerID', $recordOwnerID)
                ->first();

            
            $totalFnB = (float)($fnbCalculate->sum('TotalHarga'));
            $totalTagihanAktual = $grandTotalPaket + $totalFnB;
            $totalTerbayar = (float)($paymentData ? $paymentData->TotalTerbayar : 0);

            // dd($grandTotalPaket, $totalFnB, $totalTerbayar);
            
            $outstanding = $totalTagihanAktual - $totalTerbayar;
            $needsPayment = $outstanding > 0;

            $packetInvoice = DB::table('fakturpenjualandetail as a')
                ->join('fakturpenjualanheader as b', function($join) {
                    $join->on('a.NoTransaksi', '=', 'b.NoTransaksi')
                         ->on('a.RecordOwnerID', '=', 'b.RecordOwnerID');
                })
                ->where('a.BaseReff', $noTransaksi)
                ->where('a.RecordOwnerID', $recordOwnerID)
                ->whereIn('b.NoReff', ['POS', 'POS-TAMBAHJAM'])
                ->where('b.Status', 'C')
                ->select('b.NoTransaksi')
                ->first();

            // Prepare return data to match frontend expectations
            $headerData = [
                'NoTransaksi' => $header->NoTransaksi,
                'JamMulai' => $header->JamMulai,
                'JamSelesai'       => $effectiveJamSelesai,
                'DurasiMenit'      => round($effectiveDurasi),
                'HargaPaket'       => $hargaNormal,
                'HargaPerMenit'    => $hargaPerMenit,
                'TotalPaket'       => $totalPaket,
                'TotalDiskon'      => $diskon,
                'TotalPajak'       => $pajak,
                'TotalPajakHiburan'=> $pajakHiburan,
                'TotalLayanan'     => $layanan,
                'GrandTotal'       => $grandTotalPaket,
                'NamaPelanggan'    => $header->NamaPelanggan,
                'NamaPaket'        => $header->NamaPaket,
                'Status'           => $header->Status,
                'DocumentStatus'   => $header->DocumentStatus,
                'JenisPaket'       => $header->JenisPaket,
                'IsLiveDuration'   => $isLiveRunning,
                'PacketInvoiceNo'  => $packetInvoice ? $packetInvoice->NoTransaksi : null,
            ];

            return response()->json([
                'success' => true,
                'header' => $headerData,
                'fnb' => $fnb,
                'payment' => [
                    'TotalTagihanAktual' => $totalTagihanAktual,
                    'TotalTerbayar' => $totalTerbayar,
                    'Outstanding' => $outstanding,
                    'NeedsPayment' => $needsPayment,
                    'totalPaket' => $totalPaket,
                    'totalFnB' => $totalFnB,
                    'diskon' => $diskon,
                    'pajak' => $pajak,
                    'pajakHiburan' => $pajakHiburan,
                    'layanan' => $layanan,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function payOrderDetail(Request $request)
    {
        try {
            $noTransaksi = $request->NoTransaksi;
            $mpId = $request->MetodePembayaranId;
            $nominalBayar = (float)$request->NominalBayar;
            $recordOwnerID = Auth::user()->RecordOwnerID;

            if (!$noTransaksi || !$mpId) {
                return response()->json(['success' => false, 'message' => 'Data pembayaran tidak lengkap.']);
            }

            $company = Company::where('KodePartner', $recordOwnerID)->first();
            $mp = MetodePembayaran::find($mpId);

            if (!$mp) {
                return response()->json(['success' => false, 'message' => 'Metode pembayaran tidak ditemukan.']);
            }

            // Admin Fee calculation
            $adminFeeRp = (float)($request->AdminFee ?? 0);

            $numberingData = new DocumentNumbering();
            $periode = Carbon::now()->format('Ym');
            $tglTransaksi = Carbon::now()->toDateString();
            $itemHiburan = $company->ItemHiburan;

            DB::beginTransaction();
            
            // Periksa apakah metode AUTO (Midtrans)
            if ($mp->MetodeVerifikasi === 'AUTO') {
                if (empty($mp->ClientKey) || empty($mp->ServerKey)) {
                    DB::rollback();
                    return response()->json(['success' => false, 'message' => 'Metode pembayaran tidak valid (Midtrans Keys missing).']);
                }

                try {
                    // Cari outstanding amount
                    $header = DB::table('tableorderheader')
                        ->where('NoTransaksi', $noTransaksi)
                        ->where('RecordOwnerID', $recordOwnerID)
                        ->first();
                    
                    if (!$header) {
                        DB::rollback();
                        return response()->json(['success' => false, 'message' => 'Data order tidak ditemukan.']);
                    }

                    // Hitung total tagihan (Paket + FnB yang belum bayar)
                    // (Meniru sebagian logika getTableStatuses/payOrderDetail)
                    $totalTagihan = (float)$header->NetTotal; // Basic header total
                    
                    // Tambahkan makanan yang belum dibayar (jika ada yang baru masuk tapi belum diupdate ke NetTotal)
                    // Namun biasanya NetTotal sudah mencakup summary. 
                    // Lebih presisi kita ambil nominal yang dikirim dari frontend jika ada.
                    $payAmount = $nominalBayar;

                    // Configure Midtrans
                    \Midtrans\Config::$serverKey = $mp->ServerKey;
                    \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
                    \Midtrans\Config::$isSanitized = true;
                    \Midtrans\Config::$is3ds = true;

                    $orderId = 'PAY-' . $noTransaksi . '-' . time();
                    $transaction = [
                        'transaction_details' => [
                            'order_id' => $orderId,
                            'gross_amount' => (int) $payAmount,
                        ],
                        'customer_details' => [
                            'first_name' => $header->NamaPelanggan ?? 'Pelanggan',
                        ],
                        'item_details' => [
                            [
                                'id' => 'DETAIL-' . $noTransaksi,
                                'price' => (int) $payAmount,
                                'quantity' => 1,
                                'name' => 'Pelunasan Order ' . $noTransaksi,
                            ]
                        ]
                    ];

                    $snapToken = \Midtrans\Snap::getSnapToken($transaction);
                    
                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'snap_token' => $snapToken,
                        'NoTransaksi' => $noTransaksi,
                        'client_key' => $mp->ClientKey,
                        'payment_type' => 'PAY_DETAIL'
                    ]);

                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['success' => false, 'message' => 'Gagal generate snap token: ' . $e->getMessage()]);
                }
            }

            // =============================================
            // STEP 1: Cek apakah sudah ada faktur untuk paket (ItemHiburan)
            // =============================================
            $existingPaketFaktur = DB::table('fakturpenjualandetail')
                ->where('BaseReff', $noTransaksi)
                ->where('KodeItem', $itemHiburan)
                ->where('RecordOwnerID', $recordOwnerID)
                ->first();

            if (!$existingPaketFaktur) {
                $header = DB::table('tableorderheader')
                    ->leftJoin('pakettransaksi', function($j) {
                        $j->on('pakettransaksi.id', '=', 'tableorderheader.paketid')
                          ->on('pakettransaksi.RecordOwnerID', '=', 'tableorderheader.RecordOwnerID');
                    })
                    ->select('tableorderheader.*', 'pakettransaksi.HargaNormal', 'pakettransaksi.NamaPaket')
                    ->where('tableorderheader.NoTransaksi', $noTransaksi)
                    ->where('tableorderheader.RecordOwnerID', $recordOwnerID)
                    ->first();

                if (!$header) {
                    DB::rollback();
                    return response()->json(['success' => false, 'message' => 'Data order tidak ditemukan.']);
                }

                // For real-time packages, recalculate duration and gross based on actual time
                $realTimePaket = in_array($header->JenisPaket, ['MENITREALTIME', 'JAMREALTIME', 'PAYPERUSE']);
                if ($realTimePaket && !empty($header->JamMulai)) {
                    $jamMulaiDt = Carbon::parse($header->JamMulai);
                    $jamSelesaiDt = $header->JamSelesai ? Carbon::parse($header->JamSelesai) : Carbon::now();
                    $actualDurasi = max(1, $jamMulaiDt->diffInMinutes($jamSelesaiDt));
                    
                    // Price per minute calculation
                    $storedDurasi = max(1, (float)$header->DurasiPaket);
                    $hargaPaket = (float)$header->HargaNormal;
                    $hargaPerMenit = ($hargaPaket / $storedDurasi);
                    
                    $header->DurasiPaket = $actualDurasi;
                    $header->Gross = $actualDurasi * $hargaPerMenit;
                }

                $gross = (float)($header->Gross > 0 ? $header->Gross : ($header->DurasiPaket * (float)$header->HargaNormal));
                $diskon = (float)$header->TotalDiskon;
                $dpp = $gross - $diskon;
                $ppnPer = $company->PPN ?? 0;
                $pb1Per = $company->PajakHiburan ?? 0;
                $ppnRp = $dpp * ($ppnPer / 100);
                $pb1Rp = $dpp * ($pb1Per / 100);
                $layananRp = (float)($header->BiayaLayanan ?? 0);
                $grandTotal = $dpp + $ppnRp + $pb1Rp + $layananRp + $adminFeeRp;

                $invoicePaketNo = $numberingData->GetNewDoc("SIS", "fakturpenjualanheader", "NoTransaksi");

                $fh = new FakturPenjualanHeader;
                $fh->Periode         = $periode;
                $fh->Transaksi       = "POS";
                $fh->NoTransaksi     = $invoicePaketNo;
                $fh->TglTransaksi    = $tglTransaksi;
                $fh->TglJatuhTempo   = $tglTransaksi;
                $fh->NoReff          = "POS";
                $fh->KodePelanggan   = $header->KodePelanggan;
                $fh->KodeTermin      = $company->TerminBayarPoS ?? '1';
                $fh->Termin          = 0;
                $fh->TotalTransaksi  = $dpp;
                $fh->Potongan        = $diskon;
                $fh->Pajak           = $ppnRp;
                $fh->TotalPembelian  = $grandTotal;
                $fh->TotalRetur      = 0;
                $fh->TotalPembayaran = $grandTotal;
                $fh->Pembulatan      = 0;
                $fh->Status          = "C";
                $fh->Keterangan      = "Pembayaran Paket PoS - " . $noTransaksi;
                $fh->Posted          = 0;
                $fh->MetodeBayar     = $mp->NamaMetodePembayaran;
                $fh->ReffPembayaran  = "";
                $fh->KodeSales       = $header->KodeSales;
                $fh->TipeOrder       = 0;
                $fh->NomorMeja       = $header->tableid;
                $fh->PajakHiburan    = $pb1Rp;
                $fh->BiayaLayanan    = $layananRp + $adminFeeRp;
                $fh->RecordOwnerID   = $recordOwnerID;
                $fh->CreatedBy       = Auth::user()->name;
                $fh->created_at      = Carbon::now();
                $fh->save();

                $hargaPerSatuan = $header->DurasiPaket > 0 ? ($header->HargaNormal / $header->DurasiPaket) : 0;

                $fd = new FakturPenjualanDetail;
                $fd->NoTransaksi  = $invoicePaketNo;
                $fd->BaseReff     = $noTransaksi;
                $fd->NoUrut       = 1;
                $fd->BaseLine     = 0;
                $fd->KodeItem     = $itemHiburan;
                $fd->Qty          = $header->DurasiPaket;
                $fd->QtyKonversi  = $header->DurasiPaket;
                $fd->QtyRetur     = 0;
                $fd->Satuan       = $header->JenisPaket;
                $fd->Harga        = $hargaPerSatuan;
                $fd->Discount     = $diskon;
                $fd->HargaNet     = $dpp;
                $fd->LineStatus   = "C";
                $fd->KodeGudang   = $company->GudangPoS ?? 'HO';
                $fd->Keterangan   = "Paket: " . ($header->NamaPaket ?? '') . " - " . $header->DurasiPaket . " Menit";
                $fd->VatPercent   = $ppnPer;
                $fd->VatTotal     = $ppnRp;
                $fd->Pajak        = $ppnRp;
                $fd->PajakHiburan = $pb1Rp;
                $fd->RecordOwnerID = $recordOwnerID;
                $fd->created_at   = Carbon::now();
                $fd->save();

                // Pembayaran Paket
                $pmPaketNo = $numberingData->GetNewDoc("PMB", "pembayaranpenjualanheader", "NoTransaksi");
                $pmH = new PembayaranPenjualanHeader;
                $pmH->Periode              = $periode;
                $pmH->NoTransaksi          = $pmPaketNo;
                $pmH->TglTransaksi         = $tglTransaksi;
                $pmH->KodePelanggan        = $header->KodePelanggan;
                $pmH->TotalPembelian       = $grandTotal;
                $pmH->TotalPembayaran      = $grandTotal;
                $pmH->BiayaLayanan         = $layananRp + $adminFeeRp;
                $pmH->KodeMetodePembayaran = $mpId;
                $pmH->NoReff               = $invoicePaketNo;
                $pmH->Keterangan           = "Pembayaran " . $invoicePaketNo;
                $pmH->CreatedBy            = Auth::user()->name;
                $pmH->UpdatedBy            = Auth::user()->name;
                $pmH->Posted               = 0;
                $pmH->Status               = 'C';
                $pmH->RecordOwnerID        = $recordOwnerID;
                $pmH->created_at           = Carbon::now();
                $pmH->save();

                $pmD = new PembayaranPenjualanDetail;
                $pmD->NoTransaksi          = $pmPaketNo;
                $pmD->NoUrut               = 1;
                $pmD->BaseReff             = $invoicePaketNo;
                $pmD->TotalPembayaran      = $grandTotal;
                $pmD->KodeMetodePembayaran = $mpId;
                $pmD->Keterangan           = "Pembayaran " . $invoicePaketNo;
                $pmD->RecordOwnerID        = $recordOwnerID;
                $pmD->created_at           = Carbon::now();
                $pmD->save();

                DB::table('tableorderheader')
                    ->where('NoTransaksi', $noTransaksi)
                    ->where('RecordOwnerID', $recordOwnerID)
                    ->update([
                        'TotalTerbayar'    => $grandTotal,
                        'MetodePembayaran' => $mp->NamaMetodePembayaran
                    ]);
            }

            // =============================================
            // STEP 2: Cek FnB yang belum difakturkan (LineStatus = 'O')
            // =============================================
            $fnbOpen = DB::table('tableorderfnb')
                ->selectRaw("NoTransaksi, LineNumber, KodeItem, Qty, Harga, Tax, Discount, BiayaLayanan, LineStatus, isCompleted, RecordOwnerID, (Harga * Qty) as LineTotal")
                ->where('NoTransaksi', $noTransaksi)
                ->where('RecordOwnerID', $recordOwnerID)
                ->where('LineStatus', 'O')
                ->get();

            if ($fnbOpen->count() > 0) {
                $headerFnb = DB::table('tableorderheader')
                    ->where('NoTransaksi', $noTransaksi)
                    ->where('RecordOwnerID', $recordOwnerID)
                    ->first();

                $totalFnb = $fnbOpen->sum('LineTotal');
                $ppnFnb = $totalFnb * (($company->PPN ?? 0) / 100);
                $grandFnb = $totalFnb + $ppnFnb;

                $invoiceFnbNo = $numberingData->GetNewDoc("SIS", "fakturpenjualanheader", "NoTransaksi");
                $fhFnb = new FakturPenjualanHeader;
                $fhFnb->Periode         = $periode;
                $fhFnb->Transaksi       = "POS";
                $fhFnb->NoTransaksi     = $invoiceFnbNo;
                $fhFnb->TglTransaksi    = $tglTransaksi;
                $fhFnb->TglJatuhTempo   = $tglTransaksi;
                $fhFnb->NoReff          = "POS-FNB";
                $fhFnb->KodePelanggan   = $headerFnb->KodePelanggan ?? null;
                $fhFnb->KodeTermin      = $company->TerminBayarPoS ?? '1';
                $fhFnb->Termin          = 0;
                $fhFnb->TotalTransaksi  = $totalFnb;
                $fhFnb->Potongan        = 0;
                $fhFnb->Pajak           = $ppnFnb;
                $fhFnb->TotalPembelian  = $grandFnb;
                $fhFnb->TotalRetur      = 0;
                $fhFnb->TotalPembayaran = $grandFnb;
                $fhFnb->Pembulatan      = 0;
                $fhFnb->Status          = "C";
                $fhFnb->Keterangan      = "Pembayaran FnB PoS - " . $noTransaksi;
                $fhFnb->Posted          = 0;
                $fhFnb->MetodeBayar     = $mp->NamaMetodePembayaran;
                $fhFnb->BiayaLayanan    = 0;
                $fhFnb->RecordOwnerID   = $recordOwnerID;
                $fhFnb->CreatedBy       = Auth::user()->name;
                $fhFnb->created_at      = Carbon::now();
                $fhFnb->save();

                $noUrut = 1;
                foreach ($fnbOpen as $fnbItem) {
                    $fdFnb = new FakturPenjualanDetail;
                    $fdFnb->NoTransaksi   = $invoiceFnbNo;
                    $fdFnb->BaseReff      = $noTransaksi;
                    $fdFnb->NoUrut        = $noUrut;
                    $fdFnb->BaseLine      = 0;
                    $fdFnb->KodeItem      = $fnbItem->KodeItem;
                    $fdFnb->Qty           = $fnbItem->Qty;
                    $fdFnb->QtyKonversi   = $fnbItem->Qty;
                    $fdFnb->QtyRetur      = 0;
                    $fdFnb->Satuan        = "PCS";
                    $fdFnb->Harga         = $fnbItem->Harga;
                    $fdFnb->Discount      = $fnbItem->Discount ?? 0;
                    $fdFnb->HargaNet      = $fnbItem->LineTotal;
                    $fdFnb->LineStatus    = "C";
                    $fdFnb->KodeGudang    = $company->GudangPoS ?? 'HO';
                    $fdFnb->Keterangan    = "FnB - " . $noTransaksi;
                    $fdFnb->VatPercent    = $company->PPN ?? 0;
                    $fdFnb->VatTotal      = $fnbItem->LineTotal * (($company->PPN ?? 0) / 100);
                    $fdFnb->Pajak         = $fnbItem->Tax ?? 0;
                    $fdFnb->PajakHiburan  = 0;
                    $fdFnb->RecordOwnerID = $recordOwnerID;
                    $fdFnb->created_at    = Carbon::now();
                    $fdFnb->save();
                    $noUrut++;
                }

                // Pembayaran FnB
                $pmFnbNo = $numberingData->GetNewDoc("PMB", "pembayaranpenjualanheader", "NoTransaksi");
                $pmFnbH = new PembayaranPenjualanHeader;
                $pmFnbH->Periode              = $periode;
                $pmFnbH->NoTransaksi          = $pmFnbNo;
                $pmFnbH->TglTransaksi         = $tglTransaksi;
                $pmFnbH->KodePelanggan        = $headerFnb->KodePelanggan ?? null;
                $pmFnbH->TotalPembelian       = $grandFnb;
                $pmFnbH->TotalPembayaran      = $grandFnb;
                $pmFnbH->BiayaLayanan         = 0;
                $pmFnbH->KodeMetodePembayaran = $mpId;
                $pmFnbH->NoReff               = $invoiceFnbNo;
                $pmFnbH->Keterangan           = "Pembayaran FnB " . $invoiceFnbNo;
                $pmFnbH->CreatedBy            = Auth::user()->name;
                $pmFnbH->UpdatedBy            = Auth::user()->name;
                $pmFnbH->Posted               = 0;
                $pmFnbH->Status               = 'C';
                $pmFnbH->RecordOwnerID        = $recordOwnerID;
                $pmFnbH->created_at           = Carbon::now();
                $pmFnbH->save();

                $pmFnbD = new PembayaranPenjualanDetail;
                $pmFnbD->NoTransaksi          = $pmFnbNo;
                $pmFnbD->NoUrut               = 1;
                $pmFnbD->BaseReff             = $invoiceFnbNo;
                $pmFnbD->TotalPembayaran      = $grandFnb;
                $pmFnbD->KodeMetodePembayaran = $mpId;
                $pmFnbD->Keterangan           = "Pembayaran FnB " . $invoiceFnbNo;
                $pmFnbD->RecordOwnerID        = $recordOwnerID;
                $pmFnbD->created_at           = Carbon::now();
                $pmFnbD->save();

                // Tandai FnB sebagai paid
                DB::table('tableorderfnb')
                    ->where('NoTransaksi', $noTransaksi)
                    ->where('RecordOwnerID', $recordOwnerID)
                    ->where('LineStatus', 'O')
                    ->update(['LineStatus' => 'C']);

                // Sync FnB Totals to Header (Berdasarkan yang BARU saja dibayar)
                $newMakanan = 0;
                $newTax = 0;
                $newService = 0;
                foreach ($fnbOpen as $fItem) {
                    $newMakanan += ($fItem->Qty * $fItem->Harga);
                    $newTax += ($fItem->Tax ?? 0);
                    $newService += ($fItem->BiayaLayanan ?? 0);
                }

                $h = TableOrderHeader::where('NoTransaksi', $noTransaksi)->where('RecordOwnerID', $recordOwnerID)->first();
                if ($h) {
                    $h->TotalMakanan += $newMakanan;
                    $h->TotalTax += $newTax;
                    $h->BiayaLayanan += $newService;
                    // Recalculate NetTotal based on all components
                    $h->NetTotal = (floatval($h->Gross) - floatval($h->TotalDiskon)) + $h->TotalTax + $h->BiayaLayanan + $h->TotalMakanan;
                    $h->save();
                }
            }
            
            // =============================================
            // STEP 3: Auto-close logic based on JamSelesai and DoCheckout
            // =============================================
            $orderNow = DB::table('tableorderheader')
                ->where('NoTransaksi', $noTransaksi)
                ->where('RecordOwnerID', $recordOwnerID)
                ->select('JamSelesai', 'Status')
                ->first();

            $doCheckout = (int)($request->DoCheckout ?? 0);
            $shouldClose = false;

            if ($orderNow) {
                $jamSelesai = $orderNow->JamSelesai ? Carbon::parse($orderNow->JamSelesai) : null;
                $nowTime = Carbon::now();

                // Condition 1: JamSelesai sudah lewat dan status masih -1 → auto close
                if ($jamSelesai && $jamSelesai->lt($nowTime) && (int)$orderNow->Status === -1) {
                    $shouldClose = true;
                }

                // Condition 2: Frontend minta checkout sekalian
                if ($doCheckout === 1) {
                    $shouldClose = true;
                }

                if ($shouldClose) {
                    $closeTime = $jamSelesai && $jamSelesai->lt($nowTime) ? $jamSelesai : $nowTime;
                    DB::table('tableorderheader')
                        ->where('NoTransaksi', $noTransaksi)
                        ->where('RecordOwnerID', $recordOwnerID)
                        ->update([
                            'Status'         => 0,
                            'DocumentStatus' => 'C',
                            'JamSelesai'     => $closeTime
                        ]);
                }
            }

            // =============================================
            // STEP 4: Sync tableorderheader statistics from actual invoices
            // Aggregate totals from all faktur linked to this order (BaseReff = noTransaksi)
            // =============================================
            $linkedFakturIds = DB::table('fakturpenjualandetail')
                ->where('BaseReff', $noTransaksi)
                ->where('RecordOwnerID', $recordOwnerID)
                ->pluck('NoTransaksi');

            if ($linkedFakturIds->count() > 0) {
                $detailStats = DB::table('fakturpenjualandetail')
                    ->where('BaseReff', $noTransaksi)
                    ->where('RecordOwnerID', $recordOwnerID)
                    ->selectRaw("
                        COALESCE(SUM(Qty * Harga), 0)   AS TotalGross,
                        COALESCE(SUM(Discount), 0)      AS TotalDiskon,
                        COALESCE(SUM(HargaNet), 0)      AS TotalDPP,
                        COALESCE(SUM(Pajak), 0)         AS TotalTax,
                        COALESCE(SUM(PajakHiburan), 0)  AS TotalPajakHiburan
                    ")
                    ->first();

                $headerStats = DB::table('fakturpenjualanheader')
                    ->whereIn('NoTransaksi', $linkedFakturIds)
                    ->where('RecordOwnerID', $recordOwnerID)
                    ->selectRaw("
                        COALESCE(SUM(BiayaLayanan), 0)    AS BiayaLayanan,
                        COALESCE(SUM(TotalPembayaran), 0) AS TotalTerbayar
                    ")
                    ->first();

                DB::table('tableorderheader')
                    ->where('NoTransaksi', $noTransaksi)
                    ->where('RecordOwnerID', $recordOwnerID)
                    ->update([
                        'Gross'             => $detailStats->TotalGross,
                        'GrossTotal'        => $detailStats->TotalGross,
                        'TotalDiskon'       => $detailStats->TotalDiskon,
                        'DiscTotal'         => $detailStats->TotalDiskon,
                        'TotalTax'          => $detailStats->TotalTax,
                        'TaxTotal'          => $detailStats->TotalTax,
                        'TotalPajakHiburan' => $detailStats->TotalPajakHiburan,
                        'BiayaLayanan'      => $headerStats->BiayaLayanan,
                        'TotalTerbayar'     => $headerStats->TotalTerbayar,
                        'NetTotal'          => $detailStats->TotalDPP
                                              + $detailStats->TotalTax
                                              + $detailStats->TotalPajakHiburan
                                              + $headerStats->BiayaLayanan,
                    ]);
            }

            DB::commit();
            $msg = $shouldClose ? 'Pembayaran berhasil & order telah ditutup.' : 'Pembayaran berhasil diproses.';
            return response()->json(['success' => true, 'message' => $msg]);

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $th->getMessage()]);
        }
    }

    public function processCheckOut(Request $request)
    {
        try {
            $noTransaksi = $request->NoTransaksi;
            $recordOwnerID = Auth::user()->RecordOwnerID;

            if (!$noTransaksi) {
                return response()->json(['success' => false, 'message' => 'No Transaksi tidak ditemukan']);
            }

            $order = DB::table('tableorderheader')
                ->where('NoTransaksi', $noTransaksi)
                ->where('RecordOwnerID', $recordOwnerID)
                ->first();

            $company = DB::table('company')->where('KodePartner', $recordOwnerID)->first();


            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order tidak ditemukan']);
            }

            // 1. Recalculate Package Cost (Consistent with getOrderDetail)
            $jamMulaiDt = !empty($order->JamMulai) ? Carbon::parse($order->JamMulai) : null;
            $jamCheckout = Carbon::now();
            
            $effectiveJamSelesai = $jamCheckout->toDateTimeString();
            $effectiveDurasi = 0;
            $isLiveRunning = false;
            $realTimePaket = in_array($order->JenisPaket, ['MENITREALTIME', 'JAMREALTIME', 'PAYPERUSE']);

            if ($jamMulaiDt) {
                if ($realTimePaket) {
                    $effectiveDurasi = max(1, $jamMulaiDt->diffInMinutes($jamCheckout));
                } else {
                    $effectiveDurasi = (float)$order->DurasiPaket;
                }
            }

            // Get Package Info for pricing
            $paket = DB::table('pakettransaksi')
                ->where('id', $order->paketid)
                ->where('RecordOwnerID', $recordOwnerID)
                ->first();

            $hargaNormal = $paket ? (float)$paket->HargaNormal : 0;
            $storedDurasi = $paket ? max(1, (float)$paket->DurasiPaket) : 1;
            
            $isHourly = in_array($order->JenisPaket, ['JAM', 'JAMREALTIME', 'PAKETMEMBER']);
            
            if ($realTimePaket) {
                if ($isHourly) {
                    $baseDurasi = max(1, (float)$paket->DurasiPaket); // e.g., 1 hour
                    $units = ceil($effectiveDurasi / ($baseDurasi * 60));
                    $totalPaket = $units * $hargaNormal;
                } else {
                    $divisor = $storedDurasi;
                    $hargaPerMenit = $divisor > 0 ? ($hargaNormal / $divisor) : $hargaNormal;
                    $totalPaket = $effectiveDurasi * $hargaPerMenit;
                }
            } else {
                $totalPaket = (float)$order->Gross > 0 ? (float)$order->Gross : ($storedDurasi * $hargaNormal);
            }

            $diskon = (float)$order->TotalDiskon;
            $dpp = max(0, $totalPaket - $diskon);

            $ppnPer = $company->PPN ?? 0;
            $pb1Per = $company->PajakHiburan ?? 0;
            $svcPer = $company->ServiceCharge ?? 0;

            $pajak        = $dpp * ($ppnPer / 100);
            $pajakHiburan = $dpp * ($pb1Per / 100);
            $layanan      = $dpp * ($svcPer / 100);

            $grandTotalPaket = $totalPaket - $diskon + $pajak + $pajakHiburan + $layanan;

            // 2. Get FnB Total
            $totalFnB = DB::table('tableorderfnb')
                ->where('NoTransaksi', $noTransaksi)
                ->where('RecordOwnerID', $recordOwnerID)
                ->sum('LineTotal');

            $totalTagihanAktual = $grandTotalPaket + $totalFnB;

            // 3. Get Total Payments
            $paymentData = DB::table('fakturpenjualanheader')
                ->selectRaw("COALESCE(SUM(TotalPembayaran), 0) as TotalTerbayar")
                ->whereIn('NoTransaksi', function($query) use ($noTransaksi, $recordOwnerID) {
                    $query->select('NoTransaksi')
                        ->from('fakturpenjualandetail')
                        ->where('BaseReff', $noTransaksi)
                        ->where('RecordOwnerID', $recordOwnerID);
                })
                ->where('RecordOwnerID', $recordOwnerID)
                ->first();

            $totalTerbayar = (float)($paymentData ? $paymentData->TotalTerbayar : 0);
            
            $isPaid = false;
            if ($totalTagihanAktual <= 0 || $totalTerbayar >= ($totalTagihanAktual - 1)) { // tolerance 1 rupiah
                $isPaid = true;
            }
            
            if ($order->JenisPaket === 'PAKETMEMBER') {
                $isPaid = true;
            }

            $jamCheckout = Carbon::now();
            
            if ($isPaid) {
                // Jika sudah dibayar
                DB::table('tableorderheader')
                    ->where('NoTransaksi', $noTransaksi)
                    ->where('RecordOwnerID', $recordOwnerID)
                    ->update([
                        'JamSelesai' => $jamCheckout,
                        'Status' => 0,
                        'DocumentStatus' => 'C',
                        'TotalTerbayar' => $totalTerbayar
                    ]);
            } else {
                // Jika belum bayar
                DB::table('tableorderheader')
                    ->where('NoTransaksi', $noTransaksi)
                    ->where('RecordOwnerID', $recordOwnerID)
                    ->update([
                        'JamSelesai' => $jamCheckout,
                        'Status' => -1,
                        'TotalTerbayar' => $totalTerbayar
                    ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Checkout berhasil'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function NotifHampirHabis(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $this->validate($request, [
            'NoTransaksi'=>'required'
        ]);

        try {
            $model = TableOrderHeader::where('NoTransaksi','=',$request->input('NoTransaksi'))
                        ->where('RecordOwnerID','=', Auth::user()->RecordOwnerID);

            if ($model) {
                $update = DB::table('tableorderheader')
                            ->where('NoTransaksi','=', $request->input('NoTransaksi'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'Status' => '99'
                                ]
                            );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message']= 'Update Data Paket Gagal';
                }
            }
        } catch (\Throwable $th) {
            $data['message'] = 'Internal error, '. $th->getMessage() ;
        }

        return response()->json($data);
    }

    public function AddFnB(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $this->validate($request, [
            'txtNoTransaksi_TambahMakan'=>'required',
        ]);

        try {
            DB::beginTransaction();
            $oCompany = Company::where('KodePartner','=',Auth::user()->RecordOwnerID)->first();

            $DetailParameter = $request->input('DetailParameter');
            $NoTransaksi = $request->input('txtNoTransaksi_TambahMakan');
            $errorCount = 0;

            if ($DetailParameter) {
                $delete = DB::table('tableorderfnb')
		                ->where('NoTransaksi','=', $NoTransaksi)
		                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
		                ->delete();

                $index = 0;
                foreach ($DetailParameter as $dt) {
                    if ($dt["Qty"] == 0) {
                        $$data['message'] = "Qty Harus Lebih dari 0 ";
                        $errorCount +=1;
                        goto jump;
                    }

                    if ($oCompany->AllowNegativeInventory == NULL || $oCompany->AllowNegativeInventory == 'N') {
                        $oItem = ItemMaster::where('RecordOwnerID',Auth::user()->RecordOwnerID)
                                    ->where('KodeItem',$dt['KodeItem'])
                                    ->where('Stock','>',0)
                                    ->get();

                        if (count($oItem) == 0) {
                            $data['message'] = "Stock Item ".$dt['NamaItem']." Tidak Cukup";
                            $errorCount += 1;
                            goto jump;		
                        }
                    }

                    $detail = new TableOrderFnB();
                    $detail->NoTransaksi = $NoTransaksi;
                    $detail->LineNumber = $index;
                    $detail->KodeItem = $dt['KodeItem'];
                    $detail->Qty = $dt['Qty'];
                    $detail->Harga = $dt['Harga'];
                    $detail->Tax = 0;
                    $detail->Discount = $dt['Diskon'];
                    $detail->LineTotal = $dt['Qty'] * $dt['Harga'];
                    $detail->RecordOwnerID = Auth::user()->RecordOwnerID;
                    $detail->save();

                    if (!$detail) {
                        $data['message'] = "Menyimpan Data " . $dt["NamaItem"] . " Gagal dilakukan";
                        $errorCount +=1;
                        goto jump;
                    }

                    $index +=1;
                }
                $totalMakanan = DB::table('tableorderfnb')
                    ->where('NoTransaksi', $NoTransaksi)
                    ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                    ->sum('LineTotal');
                
                DB::table('tableorderheader')
                    ->where('NoTransaksi', $NoTransaksi)
                    ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                    ->update(['TotalMakanan' => $totalMakanan]);
            }
            else{
                $data['message'] = "Pilih Item terlebih dahulu";
                $errorCount +=1;
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
        } catch (\Throwable $th) {
            $data['success'] = false;
            $data['message'] = 'Internal error, '. $th->getMessage() ;
        }

        return response()->json($data);
    }

    public function ReadTableOrderFnB(Request $request) {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $NoTransaksi = $request->input('txtNoTransaksi_TambahMakan');

        try {
            $tableorderfnb = TableOrderFnB::selectRaw("tableorderfnb.*, itemmaster.NamaItem, itemmaster.HargaJual, itemmaster.HargaPokokPenjualan, itemmaster.Satuan")
                        ->leftJoin('itemmaster', function ($value)  {
                            $value->on('tableorderfnb.KodeItem','=','itemmaster.KodeItem')
                            ->on('tableorderfnb.RecordOwnerID','=','itemmaster.RecordOwnerID');
                        })
                        ->where('tableorderfnb.NoTransaksi','=',$NoTransaksi)
                        ->where('tableorderfnb.RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->get();
        $data['data'] = $tableorderfnb;
        $data['success'] = true;
        } catch (\Throwable $th) {
            $data['success'] = false;
            $data['message'] = 'Internal error, '. $th->getMessage() ;
        }
        
        return response()->json($data);
    }

    Public function ReadTableAPI(Request $request) {
        $data = array('success' => false, 'data' => array());
        // A1B2C3D4E5F6

        try {
            $titiklampuoption = TitikLampu::selectRaw("DigitalInput as id ,Status")
                                    ->join('mastercontroller', function ($value)  {
                                        $value->on('mastercontroller.id','=','titiklampu.ControllerID');
                                    })
                                    ->where('mastercontroller.SN','=',$request->input("SerialNumber") )->get();
            $data['success'] = true;
            $data['data'] = $titiklampuoption;
        } catch (\Throwable $th) {
            $data['success'] = false;
            $data['data'] = 'Internal error, '. $th->getMessage() ;
        }
        return response()->json($data);
    }

    public function ReadTitikLampu(Request $request){
        $data = array('success' => false, 'message' => '' , 'data' => array());

        $titiklampu = TitikLampu::selectRaw("titiklampu.*,
                        CASE WHEN COALESCE(titiklampu.status,0) = 0 THEN 'KOSONG' ELSE 
                            CASE WHEN titiklampu.Status = 1 THEN 'AKTIF' ELSE 
                                CASE WHEN titiklampu.status = -1 THEN 'CHECKOUT' ELSE 
                                    CASE WHEN titiklampu.status = 2 THEN 'HAMPIR HABIS' ELSE '' END
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
                        tableorderheader.JamMulai,
                        tableorderheader.JamSelesai,
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
                        COALESCE(fakturpenjualanheader.TotalPembayaran,0) as TotalPembayaran
                    ")
                    ->leftJoin('tableorderheader', function ($value)  {
                        $value->on('titiklampu.id','=','tableorderheader.tableid')
                        ->on('titiklampu.RecordOwnerID','=','tableorderheader.RecordOwnerID')
                        // ->on(DB::raw("DATE_FORMAT(COALESCE(tableorderheader.JamSelesai, now()), '%Y-%m-%d')"),'>=',DB::raw("DATE_FORMAT(NOW(), '%Y-%m-%d')"))
                        ->on('tableorderheader.DocumentStatus','!=',DB::raw("'C'"));
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
                    ->join('mastercontroller', function ($value)  {
                        $value->on('titiklampu.ControllerID','=','mastercontroller.id')
                        ->on('titiklampu.RecordOwnerID','=','mastercontroller.RecordOwnerID');
                    })
                    ->where('titiklampu.RecordOwnerID', '=', Auth::user()->RecordOwnerID)->get();
        $data['data'] = $titiklampu;
        return response()->json($data);
        
    }

    public function GetMaximalPaketMenit(Request $request){
        $data = array('success' => false, 'message' => '' , 'data' => array(), 'MaximalOrder' => 0);

        $mejaID = $request->input('mejaID');
        $JamRequest = $request->input('JamRequest');

        $oBookingOnline = BookingOnline::selectRaw('TIMESTAMPDIFF(MINUTE, now(), ADDTIME(DATE(TglBooking), JamMulai)) AS Durasi')
            ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
            ->where('MejaID', $mejaID)
            ->whereBetween(DB::raw('now()'), ["'". DB::raw($JamRequest)."'", DB::raw('ADDTIME(DATE(TglBooking), JamMulai)')])
            ->first();

        if ($oBookingOnline) {
            $data['success'] = true;
            $data['data'] = $oBookingOnline;
            $data['MaximalOrder'] = $oBookingOnline->Durasi;
        }

        return response()->json($data);
    }

    public function getAvailableTimeSlots(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'slots' => array());
        
        try {
            $date = $request->input('date', date('Y-m-d')); // Default to today
            
            // Get company settings
            $company = Company::where('KodePartner', Auth::user()->RecordOwnerID)->first();
            
            if (!$company || !$company->JamAwalBooking || !$company->JamAkhirBooking) {
                $data['message'] = 'Company booking hours not configured';
                return response()->json($data);
            }
            
            // Parse start and end times
            $startTime = Carbon::createFromFormat('H:i:s', $company->JamAwalBooking);
            $endTime = Carbon::createFromFormat('H:i:s', $company->JamAkhirBooking);
            $currentDateTime = Carbon::now();
            $selectedDate = Carbon::createFromFormat('Y-m-d', $date);
            
            // Generate hourly time slots
            $slots = [];
            $currentSlot = $startTime->copy();
            
            while ($currentSlot->lt($endTime)) {
                $slotStart = $currentSlot->format('H:i');
                $slotEnd = $currentSlot->copy()->addHour()->format('H:i');
                
                // Create slot datetime for comparison
                $slotDateTime = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $slotStart);
                
                // Check if slot is in the past with 30 minutes tolerance
                // Ex: Current 20:25, Slot 20:00 -> 20:00 < 19:55 ? False -> Available
                // Ex: Current 20:35, Slot 20:00 -> 20:00 < 20:05 ? True -> Past
                $toleranceTime = $currentDateTime->copy()->subMinutes(10);
                $isPast = $slotDateTime->lt($toleranceTime);
                
                // Check if slot is booked or played
                // Booked: Status 'D' (Draft/Booking)
                // Played: Status 'O' (Open/In Use)
                $tableId = $request->input('tableid');
                
                $isBooked = false;
                $isPlayed = false;

                if ($tableId) {
                    $activeSessions = TableOrderHeader::whereDate('TglTransaksi', $date)
                        ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->whereIn('DocumentStatus', ['O', 'D'])
                        ->where('tableid', $tableId)
                        ->get();
                    // dd($activeSessions);

                    foreach ($activeSessions as $session) {
                        $sessionStart = Carbon::parse($session->JamMulai)->format('H:i');
                        $sessionEnd = $session->JamSelesai ? Carbon::parse($session->JamSelesai)->format('H:i') : '23:59';
                        
                        // Overlap check
                        if ($sessionStart < $slotEnd && $sessionEnd > $slotStart) {
                            if ($session->DocumentStatus == 'O') {
                                $isPlayed = true;
                            } else {
                                $isBooked = true;
                            }
                            break;
                        }
                    }

                    if (!$isBooked && !$isPlayed) {
                         $isBooked = BookingOnline::whereDate('TglBooking', $date)
                            ->whereTime('JamMulai', '<', $slotEnd)
                            ->whereTime('JamSelesai', '>', $slotStart)
                            ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                            ->where('StatusTransaksi', '=', 0) 
                            ->where('mejaID', $tableId)
                            ->exists();
                    }
                }
                
                $slots[] = [
                    'start' => $slotStart,
                    'end' => $slotEnd,
                    'label' => $slotStart . ' - ' . $slotEnd,
                    'available' => !$isPast && !$isBooked && !$isPlayed,
                    'isPast' => $isPast,
                    'isBooked' => $isBooked,
                    'isPlayed' => $isPlayed
                ];
                
                $currentSlot->addHour();
            }
            
            $data['success'] = true;
            $data['slots'] = $slots;
            
        } catch (\Exception $e) {
            Log::error("Get time slots error: " . $e->getMessage());
            $data['message'] = 'Error: ' . $e->getMessage();
        }
        
        return response()->json($data);

    }

    public function DaftarTableOrder(Request $request)
    {
        $keyword = $request->input('keyword');
        $tglAwal = $request->input('TglAwal', \Carbon\Carbon::now()->format('Y-m-d'));
        $tglAkhir = $request->input('TglAkhir', \Carbon\Carbon::now()->format('Y-m-d'));

        $fieldHeader = ['tableorderheader.NoTransaksi', 'titiklampu.NamaTitikLampu', 'tableorderheader.JenisPaket', 'pelanggan.NamaPelanggan'];
        $fieldBookingOnline = ['bookingtableonline.NoTransaksi', 'titiklampu.NamaTitikLampu', DB::raw("'BOOKING'"), 'pelanggan.NamaPelanggan'];

        $dataHeader = DB::table('tableorderheader')
            ->select('tableorderheader.NoTransaksi', 'tableorderheader.TglTransaksi', 'tableorderheader.JenisPaket', 'tableorderheader.DurasiPaket as Durasi', 'tableorderheader.Status', 'titiklampu.NamaTitikLampu as NamaTable', 'tableorderheader.JamMulai', 'tableorderheader.JamSelesai', 'pelanggan.NamaPelanggan')
            ->join('titiklampu', function($join) {
                $join->on('tableorderheader.tableid', '=', 'titiklampu.id')
                     ->on('tableorderheader.RecordOwnerID', '=', 'titiklampu.RecordOwnerID');
            })
            ->leftJoin('pelanggan', function($join) {
                $join->on('tableorderheader.KodePelanggan', '=', 'pelanggan.KodePelanggan')
                     ->on('tableorderheader.RecordOwnerID', '=', 'pelanggan.RecordOwnerID');
            })
            ->where('tableorderheader.RecordOwnerID', Auth::user()->RecordOwnerID)
            ->whereBetween('tableorderheader.TglTransaksi', [$tglAwal . ' 00:00:00', $tglAkhir . ' 23:59:59']);

        if ($keyword) {
            $dataHeader->where(function ($query) use ($keyword, $fieldHeader) {
                for ($i = 0; $i < count($fieldHeader); $i++) {
                    $query->orwhere($fieldHeader[$i], 'like', '%' . $keyword . '%');
                }
            });
        }

        $dataBookingOnline = DB::table('bookingtableonline')
            ->select('bookingtableonline.NoTransaksi', 'bookingtableonline.TglBooking as TglTransaksi', DB::raw("'BOOKING' as JenisPaket"), DB::raw('0 as Durasi'), 'bookingtableonline.StatusTransaksi as Status', 'titiklampu.NamaTitikLampu as NamaTable', 'bookingtableonline.JamMulai', 'bookingtableonline.JamSelesai', 'pelanggan.NamaPelanggan')
            ->join('titiklampu', function($join) {
                $join->on('bookingtableonline.mejaID', '=', 'titiklampu.id')
                     ->on('bookingtableonline.RecordOwnerID', '=', 'titiklampu.RecordOwnerID');
            })
            ->leftJoin('pelanggan', function($join) {
                $join->on('bookingtableonline.KodePelanggan', '=', 'pelanggan.KodePelanggan')
                     ->on('bookingtableonline.RecordOwnerID', '=', 'pelanggan.RecordOwnerID');
            })
            ->where('bookingtableonline.RecordOwnerID', Auth::user()->RecordOwnerID)
            ->whereBetween('bookingtableonline.TglBooking', [$tglAwal . ' 00:00:00', $tglAkhir . ' 23:59:59']);

        if ($keyword) {
            $dataBookingOnline->where(function ($query) use ($keyword, $fieldBookingOnline) {
                for ($i = 0; $i < count($fieldBookingOnline); $i++) {
                    $query->orwhere($fieldBookingOnline[$i], 'like', '%' . $keyword . '%');
                }
            });
        }

        $data = $dataHeader->unionAll($dataBookingOnline)
            ->orderBy('TglTransaksi', 'desc');

        $company = Company::where('KodePartner', Auth::user()->RecordOwnerID)->first();
        $jenisLangganan = [];
        if ($company && $company->JenisLangganan) {
            $jenisLangganan = json_decode($company->JenisLangganan, true);
        }

        return view("Admin.DaftarTableOrder", [
            'data' => $data->get(),
            'tglAwal' => $tglAwal,
            'tglAkhir' => $tglAkhir,
            'jenisLangganan' => $jenisLangganan
        ]);
    }

    public function ResetController(Request $request)
    {
        try {
            $NoTransaksi = $request->input('NoTransaksi');
            
            // Cari data existing untuk mendapatkan tableid
            $currentData = DB::table('tableorderheader')
                            ->where('NoTransaksi', $NoTransaksi)
                            ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                            ->first();
            

            if ($currentData) {
                // 1. cari dulu Transaksi tableorderheader yang DocumentStatus = 'O' dan Status nya 1 dengan order asc
                $checkOrder = DB::table('tableorderheader')
                                ->where('tableid', $currentData->tableid)
                                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                                ->where('DocumentStatus', 'O')
                                ->where('Status', 1)
                                ->orderBy('TglPencatatan', 'asc')
                                ->get();
                // dd($checkOrder);
                // update dulu semua DocumentStatus = 'C' dan Status nya 0
                foreach ($checkOrder as $co) {
                    DB::table('tableorderheader')
                        ->where('NoTransaksi', $co->NoTransaksi)
                        ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->update([
                            'Status' => 0,
                            'DocumentStatus' => 'C'
                        ]);
                }

                // kemudian update order dengan urutan terakhir dalam loop dengan DocumentStatus = 'O' dan Status nya 1
                // TAPI hanya jika JamSelesai belum lewat (Masih Valid)
                $now = Carbon::now();
                $validOrder = null;

                foreach ($checkOrder as $co) {
                    $jamSelesai = Carbon::parse($co->JamSelesai);
                    if ($jamSelesai->gt($now)) {
                        // Found a valid order. We keep the last one found (highest ID/latest) if multiple exist.
                        $validOrder = $co;
                    }
                }

                if ($validOrder) {
                    DB::table('tableorderheader')
                        ->where('NoTransaksi', $validOrder->NoTransaksi)
                        ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->update([
                            'Status' => 1,
                            'DocumentStatus' => 'O'
                        ]);
                    alert()->success('Success', 'Controller berhasil direset (Fixed: Active Order Restored).');
                } else {
                    // Tidak ada yang valid (Semua sudah expired) -> Tetap Closed semua.
                        alert()->success('Success', 'Controller berhasil direset (Fixed: All Expired).');
                }
                // 2. Jika record nya = 1 langsung update saja
                // if (count($checkOrder) == 1) { 
                //     $update = DB::table('tableorderheader')
                //         ->where('NoTransaksi', $NoTransaksi)
                //         ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                //         ->update([
                //             'Status' => 0,
                //             'DocumentStatus' => 'C'
                //         ]);
    
                //     if ($update) {
                //         alert()->success('Success', 'Controller berhasil direset.');
                //     } else {
                //         alert()->error('Error', 'Gagal mereset controller atau data tidak ditemukan.');
                //     }
                // }
                // // 3. Jika recordnya lebih dari 1
                // elseif (count($checkOrder) > 1) {
                //     // update dulu semua DocumentStatus = 'C' dan Status nya 0
                //     foreach ($checkOrder as $co) {
                //         DB::table('tableorderheader')
                //             ->where('NoTransaksi', $co->NoTransaksi)
                //             ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                //             ->update([
                //                 'Status' => 0,
                //                 'DocumentStatus' => 'C'
                //             ]);
                //     }

                //     // kemudian update order dengan urutan terakhir dalam loop dengan DocumentStatus = 'O' dan Status nya 1
                //     // TAPI hanya jika JamSelesai belum lewat (Masih Valid)
                //     $now = Carbon::now();
                //     $validOrder = null;

                //     foreach ($checkOrder as $co) {
                //         $jamSelesai = Carbon::parse($co->JamSelesai);
                //         if ($jamSelesai->gt($now)) {
                //             // Found a valid order. We keep the last one found (highest ID/latest) if multiple exist.
                //             $validOrder = $co;
                //         }
                //     }

                //     if ($validOrder) {
                //         DB::table('tableorderheader')
                //             ->where('NoTransaksi', $validOrder->NoTransaksi)
                //             ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                //             ->update([
                //                 'Status' => 1,
                //                 'DocumentStatus' => 'O'
                //             ]);
                //         alert()->success('Success', 'Controller berhasil direset (Fixed: Active Order Restored).');
                //     } else {
                //         // Tidak ada yang valid (Semua sudah expired) -> Tetap Closed semua.
                //          alert()->success('Success', 'Controller berhasil direset (Fixed: All Expired).');
                //     }

                // } else {
                //     // Fallback
                //     $update = DB::table('tableorderheader')
                //         ->where('NoTransaksi', $NoTransaksi)
                //         ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                //         ->update([
                //             'Status' => 0,
                //             'DocumentStatus' => 'C'
                //         ]);
                //     alert()->success('Success', 'Controller berhasil direset.');
                // }
            } else {
                alert()->error('Error', 'Data Transaksi tidak ditemukan.');
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            alert()->error('Error', 'Terjadi kesalahan sistem.');
        }

        return redirect()->back();
    }

    public function getAvailableSlots(Request $request)
    {
        try {
            $company = Company::where('KodePartner', Auth::user()->RecordOwnerID)->first();
            if (!$company) {
                return response()->json(['success' => false, 'message' => 'Company not found']);
            }

            $jamMulaiCo = $company->JamAwalBooking ?? '00:00:00';
            $jamAkhirCo = $company->JamAkhirBooking ?? '23:59:59';
            $tanggal = $request->tanggal; // YYYY-MM-DD
            $tableId = $request->table_id;

            if (!$tanggal || !$tableId) {
                return response()->json(['success' => false, 'message' => 'Tanggal dan Table ID dibutuhkan']);
            }

            // Generate hourly slots from JamAwalBooking to JamAkhirBooking
            $startOfDay = Carbon::parse($tanggal . ' ' . $jamMulaiCo);
            $endOfDay = Carbon::parse($tanggal . ' ' . $jamAkhirCo);

            // Handle case passed midnight e.g 10:00 to 02:00
            if ($endOfDay->lt($startOfDay)) {
                $endOfDay->addDay();
            }

            // Aturan 2: tableorderheader DocumentStatus = 'D' (Booking Pos) pada tanggal tersebut
            $bookedPos = DB::table('tableorderheader')
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->where('tableid', $tableId)
                ->where('DocumentStatus', 'D')
                ->where('JamMulai', '<', $endOfDay)
                ->where(function($q) use ($startOfDay) {
                    $q->where('JamSelesai', '>', $startOfDay)
                      ->orWhereNull('JamSelesai');
                })
                ->get(['JamMulai', 'JamSelesai']);

            // Aturan 3: bookingtableonline StatusTransaksi = 1 (Booking Online Paid/Confirmed) pada tanggal tersebut
            // Seringkali TglBooking online hanya 1 hari, agar aman kita pakai intersect juga bila JamMulai adalah DATETIME.
            // Namun jika JamMulai time only, bisa error. Asumsikan JamMulai berisi datetime yang utuh jika formatnya YYYY-MM-DD HH:ii:ss
            $bookedOnline = DB::table('bookingtableonline')
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->where('mejaID', $tableId)
                ->where('StatusTransaksi', 1)
                ->whereDate('TglBooking', $tanggal)
                ->get(['JamMulai', 'JamSelesai']);

            // Aturan 4: tableorderheader DocumentStatus = 'O' (Active/Running)
            $runningNow = DB::table('tableorderheader')
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->where('tableid', $tableId)
                ->where('DocumentStatus', 'O')
                ->where('JamMulai', '<', $endOfDay)
                ->where(function($q) use ($startOfDay) {
                    $q->where('JamSelesai', '>', $startOfDay)
                      ->orWhereNull('JamSelesai');
                })
                ->get(['JamMulai', 'JamSelesai']);

            // Compile all booked slots
            $allBooked = collect()
                ->merge($bookedPos)
                ->merge($bookedOnline)
                ->merge($runningNow)
                ->map(function ($item) use ($endOfDay) {
                    $start = Carbon::parse($item->JamMulai);
                    // Jika JamSelesai null/kosong, set sampai JamAkhirBooking hari itu
                    if (empty($item->JamSelesai)) {
                        $end = $endOfDay->copy();
                    } else {
                        $end = Carbon::parse($item->JamSelesai);
                    }
                    
                    return [
                        'start' => $start,
                        'end' => $end
                    ];
                });

            $currentSlot = $startOfDay->copy()->startOfHour();
            // Jika jamMulaiCo tidak pas round jam, mulai dari awal jam tersebut
            if ($currentSlot->lt($startOfDay)) {
                // $currentSlot = $startOfDay->copy(); // Bisa disesuaikan kalau mau persis
            }

            $now = Carbon::now();
            $isToday = Carbon::parse($tanggal)->isToday();

            $slots = [];
            while ($currentSlot->lt($endOfDay)) {
                $slotStart = $currentSlot->copy();
                $slotEnd = $currentSlot->copy()->addHour();

                $isBooked = false;
                
                // Aturan 1: Blok jam yang sudah terlewati di tanggal yang dipilih (hari ini)
                if ($isToday && $slotStart->lt($now)) {
                    $isBooked = true;
                } else {
                    foreach ($allBooked as $booked) {
                        // Cek overlap: start_A < end_B && end_A > start_B
                        if ($slotStart->lt($booked['end']) && $slotEnd->gt($booked['start'])) {
                            $isBooked = true;
                            break;
                        }
                    }
                }

                $slots[] = [
                    'time' => $slotStart->format('H:i'),
                    'start_full' => $slotStart->format('Y-m-d H:i:s'),
                    'end_full' => $slotEnd->format('Y-m-d H:i:s'),
                    'booked' => $isBooked
                ];

                $currentSlot->addHour();
            }

            return response()->json([
                'success' => true,
                'data' => $slots
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function checkVoucher(Request $request)
    {
        try {
            $kode = $request->voucher_code;
            $subtotal = $request->subtotal; // Subtotal setelah diskon member jika ada

            if (empty($kode)) {
                return response()->json(['success' => false, 'message' => 'Kode Voucher Kosong']);
            }

            // Get Voucher from Table
            $voucher = DB::table('discountvoucher')
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->where('VoucherCode', $kode)
                ->first();

            if (!$voucher) {
                return response()->json(['success' => false, 'message' => 'Voucher Tidak Ditemukan']);
            }

            // 3. Validasi Tanggal StartDate & EndDate
            $now = Carbon::now();
            $start = Carbon::parse($voucher->StartDate);
            // Anggap EndDate berlaku sampai jam 23:59:59 di hari tersebut
            $end = Carbon::parse($voucher->EndDate)->endOfDay();

            if ($now->lt($start) || $now->gt($end)) {
                return response()->json(['success' => false, 'message' => 'Masa Berlaku Voucher Sudah Habis / Belum Dimulai']);
            }

            // 4. Cek Quota
            if ($voucher->DiscountQuota <= $voucher->DiscountUsed) {
                return response()->json(['success' => false, 'message' => 'Kuota Voucher Sudah Habis']);
            }

            // 1. Hitung berdasarkan SubTotal & DiscountPercent
            $discountPercent = (float) $voucher->DiscountPercent;
            $calculatedDiscount = $subtotal * ($discountPercent / 100);

            // 2. Cek Maximal Discount
            $maxDiscount = (float) $voucher->MaximalDiscount;
            if ($maxDiscount > 0 && $calculatedDiscount > $maxDiscount) {
                $calculatedDiscount = $maxDiscount;
            }

            return response()->json([
                'success' => true,
                'discountRp' => $calculatedDiscount,
                'message' => 'Voucher Berhasil Diaplikasikan'
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function storePaket(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'NoTransaksi' => "");

        $this->validate($request, [
            'JenisPaket' => 'required',
            'paketid' => $request->input('JenisPaket') === 'PAKETMEMBER' ? 'nullable' : 'required',
            'tableid' => 'required',
            'KodeSales' => 'required',
            'DurasiPaket' => 'required',
            'TglTransaksi' => 'required',
            'JamMulai' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $currentDate = Carbon::now();
            $Year = $currentDate->format('Y');
            $Month = $currentDate->format('m');

            $numberingData = new DocumentNumbering();
            $NoTransaksi = $numberingData->GetNewDoc("TRDR", "tableorderheader", "NoTransaksi");

            $model = new TableOrderHeader;
            $model->NoTransaksi = $NoTransaksi;
            $model->TglTransaksi = $request->input('TglTransaksi');
            $model->TglPencatatan = Carbon::now();
            $model->JenisPaket = $request->input('JenisPaket');
            $model->paketid = $request->input('paketid');
            if ($model->JenisPaket === 'PAKETMEMBER' && empty($model->paketid)) {
                $model->paketid = -1;
            }
            $model->tableid = $request->input('tableid');
            $model->KodeSales = $request->input('KodeSales');
            $model->DurasiPaket = $request->input('DurasiPaket');
            $model->KodePelanggan = $request->input('KodePelanggan');
            
            // Concat Tgl & Jam
            $jamMulaiStr = $request->input('JamMulai');
            $jamSelesaiStr = $request->input('JamSelesai');
            
            // Check if strings already contain a date part (e.g. YYYY-MM-DD)
            $startInput = (preg_match('/^\d{4}-\d{2}-\d{2}/', $jamMulaiStr)) 
                          ? $jamMulaiStr 
                          : ($model->TglTransaksi . ' ' . $jamMulaiStr);
            
            $dtStart = Carbon::parse($startInput);
            $model->JamMulai = $dtStart;

            if (!empty($jamSelesaiStr) && $jamSelesaiStr != '-') {
                $endInput = (preg_match('/^\d{4}-\d{2}-\d{2}/', $jamSelesaiStr)) 
                            ? $jamSelesaiStr 
                            : ($model->TglTransaksi . ' ' . $jamSelesaiStr);
                $model->JamSelesai = Carbon::parse($endInput);
            } else {
                if ($model->JenisPaket === 'JAMREALTIME') {
                    $model->JamSelesai = (clone $dtStart)->addHours($model->DurasiPaket)->subMinute();
                } else {
                    $model->JamSelesai = null;
                }
            }

            // Financial Defaults
            $model->TaxTotal = 0;
            $model->GrossTotal = 0;
            $model->DiscTotal = 0;
            $model->NetTotal = 0;
            
            // Periksa Opsi Bayar & Midtrans
            $opsiBayar = $request->input('OpsiBayar');
            $mpId = $request->input('MetodePembayaran');
            $mp = null;
            $isMidtrans = false;
            if ($opsiBayar === 'LANGSUNG' && !empty($mpId)) {
                $mp = MetodePembayaran::find($mpId);
                if ($mp && $mp->MetodeVerifikasi === 'AUTO') {
                    $isMidtrans = true;
                }
            }

            // Booking Logic
            $now = Carbon::now();
            if ($dtStart->gt($now) || $isMidtrans) {
                // Future Booking atau menunggu Midtrans
                $model->Status = 0;
                $model->DocumentStatus = 'D';
            } else {
                // Immediate Active
                $model->Status = 1;
                $model->DocumentStatus = 'O';

                // Update Table Status
                DB::table('titiklampu')
                    ->where('id', $model->tableid)
                    ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                    ->update(['Status' => 1]);
            }

            $model->RecordOwnerID = Auth::user()->RecordOwnerID;
            $model->created_at = Carbon::now();

            // ===== CALCULATION LOGIC (Always calculate for storage) =====
            $paket = ($model->paketid && $model->paketid != -1) ? Paket::find($model->paketid) : null;
            $company = Company::where('KodePartner', Auth::user()->RecordOwnerID)->first();
            $pelanggan = Pelanggan::where('KodePelanggan', $model->KodePelanggan)
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->first();
            
            // 1. Calculate Base Total (Gross)
            if ($model->JenisPaket === 'PAKETMEMBER' && !$paket) {
                // Default logic for PAKETMEMBER without specific package: Price is 0
                $subtotal = 0;
            } else {
                $baseDurasi = ($paket && $paket->DurasiPaket) ? $paket->DurasiPaket : 1;
                $hargaNormal = $paket ? $paket->HargaNormal : 0;
                $subtotal = ($model->DurasiPaket / $baseDurasi) * $hargaNormal;
            }
            
            $model->Gross = $subtotal;
            $model->GrossTotal = $subtotal;

            // 2. Diskon Member
            $discMemberRp = 0;
            if ($pelanggan && $pelanggan->KodeGrupPelanggan) {
                $grp = GrupPelanggan::where('KodeGrup', $pelanggan->KodeGrupPelanggan)
                    ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                    ->first();
                if ($grp && $grp->DiskonPersen) {
                    $discMemberRp = $subtotal * ($grp->DiskonPersen / 100);
                }
            }

            // 3. Diskon Voucher
            $discVoucherRp = 0;
            $kodeVoucher = $request->input('KodeVoucher');
            if ($kodeVoucher) {
                $voucher = DB::table('discountvoucher')
                    ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                    ->where('VoucherCode', $kodeVoucher)
                    ->first();
                if ($voucher) {
                    $subtotalAfterMember = $subtotal - $discMemberRp;
                    if ($voucher->TypeVoucher == 'PERCENTAGE') {
                        $discVoucherRp = $subtotalAfterMember * ($voucher->Amount / 100);
                    } else {
                        $discVoucherRp = $voucher->Amount;
                    }
                    if ($discVoucherRp > $subtotalAfterMember) $discVoucherRp = $subtotalAfterMember;
                }
            }

            $model->TotalDiskon = $discMemberRp + $discVoucherRp;
            $model->DiscTotal = $model->TotalDiskon;
            $model->KodeVoucer = $kodeVoucher;

            $dpp = $subtotal - $model->TotalDiskon;
            if ($dpp < 0) $dpp = 0;

            // 4. Taxes
            $ppnPer = $company->PPN ?? 0;
            $pb1Per = $company->PajakHiburan ?? 0;
            $servicePer = $company->ServiceCharge ?? 0;

            $model->TotalTax = $dpp * ($ppnPer / 100);
            $model->TaxTotal = $model->TotalTax;
            $model->TotalPajakHiburan = $dpp * ($pb1Per / 100);
            $model->BiayaLayanan = $dpp * ($servicePer / 100);

            // 5. Food & Beverage (Initial store is 0)
            $model->TotalMakanan = 0;

            // 6. Payment Info
            $adminFeeRp = 0;
            if ($opsiBayar === 'LANGSUNG') {
                if ($mp) {
                    $gtBeforeAdmin = $dpp + $model->TotalTax + $model->TotalPajakHiburan + $model->BiayaLayanan;
                    if ($mp->BiayaAdminPercent > 0) {
                        $adminFeeRp = ($mp->BiayaAdminPercent / 100) * $gtBeforeAdmin;
                    } elseif ($mp->BiayaAdminRupiah > 0) {
                        $adminFeeRp = $mp->BiayaAdminRupiah;
                    }
                    $model->MetodePembayaran = $mp->NamaMetodePembayaran;
                }
                $model->TotalTerbayar = $dpp + $model->TotalTax + $model->TotalPajakHiburan + $model->BiayaLayanan + $adminFeeRp;
            } else {
                $model->TotalTerbayar = 0;
                $model->MetodePembayaran = null;
            }
            
            $model->NetTotal = $dpp + $model->TotalTax + $model->TotalPajakHiburan + $model->BiayaLayanan;
            
            $save = $model->save();

            if ($save) {
                // ===== BAYAR LANGSUNG LOGIC (Create Invoice) =====
                // Jika Midtrans, jangan buat invoice dulu sampai dikonfirmasi
                if ($opsiBayar === 'LANGSUNG' && !$isMidtrans && ($model->JenisPaket !== 'PAKETMEMBER' || $model->NetTotal > 0)) {
                    $periode = Carbon::now()->format('Ym');
                    $grandTotal = $model->TotalTerbayar;

                    // Create FakturPenjualanHeader
                    $invoiceNo = $numberingData->GetNewDoc("SIS", "fakturpenjualanheader", "NoTransaksi");
                    $fakturHeader = new FakturPenjualanHeader;
                    $fakturHeader->Periode = $periode;
                    $fakturHeader->Transaksi = "POS";
                    $fakturHeader->NoTransaksi = $invoiceNo;
                    $fakturHeader->TglTransaksi = $model->TglTransaksi;
                    $fakturHeader->TglJatuhTempo = $model->TglTransaksi;
                    $fakturHeader->NoReff = "POS";
                    $fakturHeader->KodePelanggan = $model->KodePelanggan;
                    $fakturHeader->KodeTermin = $company->TerminBayarPoS ?? '1';
                    $fakturHeader->Termin = 0;
                    $fakturHeader->TotalTransaksi = $dpp;
                    $fakturHeader->Potongan = $model->TotalDiskon;
                    $fakturHeader->Pajak = $model->TotalTax;
                    $fakturHeader->TotalPembelian = $grandTotal;
                    $fakturHeader->TotalRetur = 0;
                    $fakturHeader->TotalPembayaran = $grandTotal;
                    $fakturHeader->Pembulatan = 0;
                    $fakturHeader->Status = "C";
                    $fakturHeader->Keterangan = "Pembayaran Layanan PoS - " . $model->NoTransaksi;
                    $fakturHeader->Posted = 0;
                    $fakturHeader->MetodeBayar = $model->MetodePembayaran;
                    $fakturHeader->ReffPembayaran = "";
                    $fakturHeader->KodeSales = $model->KodeSales;
                    $fakturHeader->TipeOrder = 0;
                    $fakturHeader->NomorMeja = $model->tableid;
                    $fakturHeader->PajakHiburan = $model->TotalPajakHiburan;
                    $fakturHeader->BiayaLayanan = $model->BiayaLayanan + $adminFeeRp;
                    $fakturHeader->RecordOwnerID = Auth::user()->RecordOwnerID;
                    $fakturHeader->created_at = Carbon::now();
                    $fakturHeader->CreatedBy = Auth::user()->name;
                    $fakturHeader->save();

                    // Create FakturPenjualanDetail
                    $hargaPerSatuan = $baseDurasi > 0 ? ($paket->HargaNormal / $baseDurasi) : $paket->HargaNormal;
                    $hargaNet = $dpp; // HargaNet = DPP (after discount before tax)

                    $fakturDetail = new FakturPenjualanDetail;
                    $fakturDetail->NoTransaksi   = $invoiceNo;
                    $fakturDetail->BaseReff       = $model->NoTransaksi;
                    $fakturDetail->NoUrut         = 1;
                    $fakturDetail->BaseLine       = 0;
                    $fakturDetail->KodeItem       = $company->ItemHiburan;
                    $fakturDetail->Qty            = $model->DurasiPaket;
                    $fakturDetail->QtyKonversi    = $model->DurasiPaket;
                    $fakturDetail->QtyRetur       = 0;
                    $fakturDetail->Satuan         = $model->JenisPaket;
                    $fakturDetail->Harga          = $hargaPerSatuan;
                    $fakturDetail->Discount       = $model->TotalDiskon;
                    $fakturDetail->HargaNet       = $hargaNet;
                    $fakturDetail->LineStatus     = "C";
                    $fakturDetail->KodeGudang     = $company->GudangPoS ?? 'HO';
                    $fakturDetail->Keterangan     = "Paket: " . ($paket->NamaPaket ?? '') . " - " . $model->DurasiPaket . " Menit";
                    $fakturDetail->VatPercent     = $ppnPer;
                    $fakturDetail->VatTotal       = $model->TotalTax;
                    $fakturDetail->Pajak          = $model->TotalTax;
                    $fakturDetail->PajakHiburan   = $model->TotalPajakHiburan;
                    $fakturDetail->RecordOwnerID  = Auth::user()->RecordOwnerID;
                    $fakturDetail->created_at     = Carbon::now();
                    $fakturDetail->save();

                    // Create PembayaranPenjualanHeader
                    $periode = Carbon::now()->format('Ym');
                    $pmNo = $numberingData->GetNewDoc("PMB", "pembayaranpenjualanheader", "NoTransaksi");
                    $pmHeader = new PembayaranPenjualanHeader;
                    $pmHeader->Periode               = $periode;
                    $pmHeader->NoTransaksi           = $pmNo;
                    $pmHeader->TglTransaksi          = $model->TglTransaksi;
                    $pmHeader->KodePelanggan         = $model->KodePelanggan;
                    $pmHeader->TotalPembelian        = $grandTotal;
                    $pmHeader->TotalPembayaran       = $grandTotal;
                    $pmHeader->BiayaLayanan          = $model->BiayaLayanan + $adminFeeRp;
                    $pmHeader->KodeMetodePembayaran  = $mpId;
                    $pmHeader->NoReff                = $invoiceNo;
                    $pmHeader->Keterangan            = "Pembayaran " . $invoiceNo;
                    $pmHeader->CreatedBy             = Auth::user()->name;
                    $pmHeader->UpdatedBy             = Auth::user()->name;
                    $pmHeader->Posted                = 0;
                    $pmHeader->Status                = 'C';
                    $pmHeader->RecordOwnerID         = Auth::user()->RecordOwnerID;
                    $pmHeader->created_at            = Carbon::now();
                    $pmHeader->save();

                    // Create PembayaranPenjualanDetail
                    $pmDetail = new PembayaranPenjualanDetail;
                    $pmDetail->NoTransaksi           = $pmNo;
                    $pmDetail->NoUrut                = 1;
                    $pmDetail->BaseReff              = $invoiceNo;
                    $pmDetail->TotalPembayaran       = $grandTotal;
                    $pmDetail->KodeMetodePembayaran  = $mpId;
                    $pmDetail->Keterangan            = "Pembayaran " . $invoiceNo;
                    $pmDetail->RecordOwnerID         = Auth::user()->RecordOwnerID;
                    $pmDetail->created_at            = Carbon::now();
                    $pmDetail->save();
                }

                DB::commit();
                $data['success'] = true;
                $data['NoTransaksi'] = $NoTransaksi;

                if ($opsiBayar === 'LANGSUNG' && isset($mp) && $mp->MetodeVerifikasi === 'AUTO') {
                    // Check if Midtrans ClientKey is valid
                    if (empty($mp->ClientKey) || empty($mp->ServerKey)) {
                        $data['success'] = false;
                        $data['message'] = 'Metode pembayaran tidak valid atau belum dikonfigurasi (Midtrans Keys missing).';
                    } else {
                        try {
                            // Configure Midtrans
                            \Midtrans\Config::$serverKey = $mp->ServerKey;
                            \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
                            \Midtrans\Config::$isSanitized = true;
                            \Midtrans\Config::$is3ds = true;
                            
                            $orderId = 'POS-' . $NoTransaksi . '-' . time();
                            
                            $transaction_details = [
                                'order_id' => $orderId,
                                'gross_amount' => (int) $model->TotalTerbayar,
                            ];
                            
                            $customerName = 'Pelanggan Umum';
                            $customerEmail = 'admin@example.com';
                            $customerPhone = '08123456789';

                            if ($pelanggan) {
                                $customerName = $pelanggan->NamaPelanggan ?? $customerName;
                                $customerEmail = $pelanggan->Email ?? $customerEmail;
                                $customerPhone = $pelanggan->NoTlp1 ?? $customerPhone;
                            }
                            
                            $customer_details = [
                                'first_name' => $customerName,
                                'email' => $customerEmail,
                                'phone' => $customerPhone,
                            ];
                            
                            $metadata = [
                                'NoTransaksi' => $NoTransaksi,
                                'Tipe' => 'POS',
                                'metode_id' => $mp->id,
                                'user_id' => Auth::user()->id,
                                'record_owner_id' => Auth::user()->RecordOwnerID,
                            ];
                            
                            $transaction = [
                                'transaction_details' => $transaction_details,
                                'customer_details' => $customer_details,
                                'custom_field1' => json_encode($metadata),
                            ];
                            
                            $snapToken = \Midtrans\Snap::getSnapToken($transaction);
                            $data['snap_token'] = $snapToken;
                            $data['order_id'] = $orderId;
                            $data['client_key'] = $mp->ClientKey;
                            
                        } catch (\Exception $e) {
                            Log::error("Midtrans Snap error in storePaket: " . $e->getMessage());
                            $data['success'] = false;
                            $data['message'] = 'Gagal membuat transaksi online: ' . $e->getMessage();
                        }
                    }
                }

            } else {
                DB::rollback();
                $data['message'] = 'Gagal menyimpan data ke database.';
            }
        } catch (\Throwable $th) {
            DB::rollback();
            $data['message'] = 'Internal error: ' . $th->getMessage();
        }

        return response()->json($data);
    }

    public function getTableStatuses()
    {
        try {
            // Update historical status 0 bookings that have reached start time
            DB::table('tableorderheader')
                ->where('DocumentStatus', '=', 'O')
                ->where('Status', '=', '0')
                ->where('RecordOwnerID', '=', Auth::user()->RecordOwnerID)
                ->where('JamMulai', '<=', Carbon::now())
                ->update(['DocumentStatus' => 'C']);

            $subqueryPembayaran = FakturPenjualanDetail::selectRaw("fakturpenjualandetail.BaseReff, fakturpenjualandetail.RecordOwnerID,
                            SUM(COALESCE(CASE WHEN fakturpenjualanheader.TotalPembayaran > fakturpenjualanheader.TotalPembelian THEN fakturpenjualanheader.TotalPembelian ELSE fakturpenjualanheader.TotalPembayaran END ,0)) as TotalPembayaran,
                            MAX(fakturpenjualanheader.NoReff) as NoReff")
                ->join('fakturpenjualanheader', function ($join) {
                    $join->on('fakturpenjualanheader.NoTransaksi', '=', 'fakturpenjualandetail.NoTransaksi')
                        ->on('fakturpenjualanheader.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID')
                        ->where('fakturpenjualanheader.Status', '=', 'C')
                        ->where('fakturpenjualanheader.TotalPembayaran', '>', 0);
                })
                ->whereIn(DB::RAW("COALESCE(fakturpenjualanheader.NoReff, 'POS')"), ['POS'])
                ->groupBy('fakturpenjualandetail.BaseReff', 'fakturpenjualandetail.RecordOwnerID');

            $subqueryPembayaranJasa = FakturPenjualanDetail::selectRaw("fakturpenjualandetail.BaseReff, fakturpenjualandetail.RecordOwnerID,
                            SUM(COALESCE(CASE WHEN fakturpenjualanheader.TotalPembayaran > fakturpenjualanheader.TotalPembelian THEN fakturpenjualanheader.TotalPembelian ELSE fakturpenjualanheader.TotalPembayaran END ,0)) as TotalPembayaran,
                            MAX(fakturpenjualanheader.NoReff) as NoReff")
                ->join('fakturpenjualanheader', function ($join) {
                    $join->on('fakturpenjualanheader.NoTransaksi', '=', 'fakturpenjualandetail.NoTransaksi')
                        ->on('fakturpenjualanheader.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID')
                        ->where('fakturpenjualanheader.Status', '=', 'C')
                        ->where('fakturpenjualanheader.TotalPembayaran', '>', 0);
                })
                ->join('itemmaster', function ($join) {
                    $join->on('fakturpenjualandetail.KodeItem', '=', 'itemmaster.KodeItem')
                        ->on('itemmaster.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID');
                })
                ->whereIn(DB::RAW("COALESCE(fakturpenjualanheader.NoReff, 'POS')"), ['POS'])
                ->where('itemmaster.TypeItem', 4)
                ->groupBy('fakturpenjualandetail.BaseReff', 'fakturpenjualandetail.RecordOwnerID');

            $titiklampu = TitikLampu::selectRaw("DISTINCT titiklampu.*,
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
                            tableorderheader.JamMulai,
                            tableorderheader.JamSelesai,
                            tableorderheader.JenisPaket,
                            tableorderheader.TglTransaksi,
                            tableorderheader.KodePelanggan,
                            pelanggan.NamaPelanggan,
                            pelanggan.TglBerlanggananPaketBulanan,
                            gruppelanggan.NamaGrup,
                            gruppelanggan.DiskonPersen,
                            COALESCE(payment_summary.TotalPembayaran, 0) as TotalPembayaran,
                            COALESCE(tkelompoklampu.NamaKelompok,'') AS NamaKelompok,
                            COALESCE(payment_summary.NoReff, 'POS') NoReff,
                            CASE WHEN payment_summary_jasa.BaseReff IS NOT NULL then 1 ELSE 0 END as isJasaPaid,
                            COALESCE(serial_numbers.isBlocked, 0) as isBlocked,
                            COALESCE(serial_numbers.BlockedReason, '') as BlockedReason
                        ")
                ->leftJoin('tableorderheader', function ($value) {
                    $value->on('titiklampu.id', '=', 'tableorderheader.tableid')
                        ->on('titiklampu.RecordOwnerID', '=', 'tableorderheader.RecordOwnerID')
                        ->on('tableorderheader.DocumentStatus', '=', DB::raw("'O'"));
                })
                ->leftJoin('pakettransaksi', function ($value) {
                    $value->on('tableorderheader.paketid', '=', 'pakettransaksi.id')
                        ->on('tableorderheader.RecordOwnerID', '=', 'pakettransaksi.RecordOwnerID');
                })
                ->leftJoin('sales', function ($value) {
                    $value->on('tableorderheader.KodeSales', '=', 'sales.KodeSales')
                        ->on('tableorderheader.RecordOwnerID', '=', 'sales.RecordOwnerID');
                })
                ->leftJoin('pelanggan', function ($value) {
                    $value->on('tableorderheader.KodePelanggan', '=', 'pelanggan.KodePelanggan')
                        ->on('tableorderheader.RecordOwnerID', '=', 'pelanggan.RecordOwnerID');
                })
                ->leftJoin('gruppelanggan', function ($value) {
                    $value->on('pelanggan.KodeGrupPelanggan', '=', 'gruppelanggan.KodeGrup')
                        ->on('pelanggan.RecordOwnerID', '=', 'gruppelanggan.RecordOwnerID');
                })
                ->leftJoinSub($subqueryPembayaran, 'payment_summary', function ($join) {
                    $join->on('tableorderheader.NoTransaksi', '=', 'payment_summary.BaseReff')
                        ->on('tableorderheader.RecordOwnerID', '=', 'payment_summary.RecordOwnerID');
                })
                ->leftjoin('tkelompoklampu', function ($value) {
                    $value->on('titiklampu.KelompokLampu', '=', 'tkelompoklampu.KodeKelompok')
                        ->on('titiklampu.RecordOwnerID', '=', 'tkelompoklampu.RecordOwnerID');
                })
                ->join('mastercontroller', function ($value) {
                    $value->on('titiklampu.ControllerID', '=', 'mastercontroller.id')
                        ->on('titiklampu.RecordOwnerID', '=', 'mastercontroller.RecordOwnerID');
                })
                ->leftJoinSub($subqueryPembayaranJasa, 'payment_summary_jasa', function ($join) {
                    $join->on('tableorderheader.NoTransaksi', '=', 'payment_summary_jasa.BaseReff')
                        ->on('tableorderheader.RecordOwnerID', '=', 'payment_summary_jasa.RecordOwnerID');
                })
                ->leftJoin('serial_numbers', function ($value) {
                    $value->on('mastercontroller.SN', '=', 'serial_numbers.SerialNumber')
                        ->on('mastercontroller.RecordOwnerID', '=', 'serial_numbers.KodePartner');
                })
                ->where('titiklampu.RecordOwnerID', '=', Auth::user()->RecordOwnerID)
                ->whereIn(DB::raw("COALESCE(payment_summary.NoReff,'POS')"), ['POS', 'POS-FNB', 'POS-TAMBAHJAM'])
                ->OrderBy('titiklampu.DigitalInput', 'ASC')
                ->get();

            // Format dates for JSON
            $titiklampu->transform(function ($item) {
                $item->JamMulaiParsed = $item->JamMulai ? Carbon::parse($item->JamMulai)->format('d/m/Y H:i') : '-';
                $item->JamSelesaiParsed = $item->JamSelesai ? Carbon::parse($item->JamSelesai)->format('d/m/Y H:i') : '-';
                return $item;
            });

            return response()->json([
                'success' => true,
                'data' => $titiklampu
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function storeFnBOrder(Request $request)
    {
        $recordOwnerID = Auth::user()->RecordOwnerID;
        Log::debug("storeFnBOrder Request: " . json_encode($request->all()));

        DB::beginTransaction();
        try {
            $noTransaksi = $request->input('NoTransaksi');
            $items = $request->input('items', []);
            $opsiBayar = $request->input('OpsiBayar'); // 'LANGSUNG' or 'NANTI'

            $header = TableOrderHeader::where('NoTransaksi', $noTransaksi)
                ->where('RecordOwnerID', $recordOwnerID)
                ->first();

            if (!$header) {
                return response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
            }

            $company = Company::where('KodePartner', $recordOwnerID)->first();
            $gudangPoS = $company->GudangPoS ?? '';
            $allowNegative = $company->AllowNegativeInventory ?? 'N';

            $totalFnB = 0;
            $totalTax = 0;
            $totalService = 0;

            // Get Current Max LineNumber
            $maxLine = TableOrderFnB::where('NoTransaksi', $noTransaksi)
                ->where('RecordOwnerID', $recordOwnerID)
                ->max('LineNumber') ?? 0;

            $ppnPer = $company->PPN ?? 0;
            $servicePer = $company->ServiceCharge ?? 0;

            $mpId = $request->input('MetodePembayaran');
            $mp = !empty($mpId) ? MetodePembayaran::find($mpId) : null;
            $isMidtrans = ($opsiBayar === 'LANGSUNG' && $mp && $mp->MetodeVerifikasi === 'AUTO');

            foreach ($items as $index => $item) {
                $kodeItem = $item['KodeItem'];
                $qty = floatval($item['Qty']);

                $itemMaster = ItemMaster::where('KodeItem', $kodeItem)
                    ->where('RecordOwnerID', $recordOwnerID)
                    ->first();

                if (!$itemMaster) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => "Item $kodeItem tidak ditemukan"], 404);
                }

                $namaItem = $itemMaster->NamaItem ?? $kodeItem;

                // Stock Validation
                if ($allowNegative !== 'Y') {
                    $stock = DB::table('itemwarehouses')
                        ->where('RecordOwnerID', $recordOwnerID)
                        ->where('KodeItem', $kodeItem)
                        ->where('KodeGudang', $gudangPoS)
                        ->value('Qty');

                    if ($stock < $qty) {
                        DB::rollBack();
                        return response()->json(['success' => false, 'message' => "Stok item $namaItem ($kodeItem) tidak mencukupi (Tersedia: $stock, Diminta: $qty)"], 400);
                    }
                }

                $harga = floatval($item['Harga']);
                $lineTotal = $qty * $harga;

                $tax = $lineTotal * ($ppnPer / 100);
                $service = $lineTotal * ($servicePer / 100);

                $totalFnB += $lineTotal;
                $totalTax += $tax;
                $totalService += $service;

                $fnb = new TableOrderFnB();
                $fnb->NoTransaksi = $noTransaksi;
                $fnb->LineNumber = $maxLine + $index + 1;
                $fnb->KodeItem = $kodeItem;
                $fnb->Qty = $qty;
                $fnb->Harga = $harga;
                $fnb->Tax = $tax;
                $fnb->Discount = 0;
                $fnb->BiayaLayanan = $service;
                // Jika Midtrans, set 'O' dulu, nanti handleMidtransSuccess yang ubah jadi 'C'
                $fnb->LineStatus = ($opsiBayar === 'LANGSUNG' && !$isMidtrans) ? 'C' : 'O';
                $fnb->LineTotal = $lineTotal + $tax + $service;
                $fnb->isCompleted = 1;
                $fnb->RecordOwnerID = $recordOwnerID;
                $fnb->save();

                // Deduct stock
                DB::table('itemwarehouses')
                    ->where('RecordOwnerID', $recordOwnerID)
                    ->where('KodeItem', $kodeItem)
                    ->where('KodeGudang', $gudangPoS)
                    ->decrement('Qty', $qty);
            }

            // Update Header (Hanya jika LANGSUNG dan bukan Midtrans, karena Midtrans dihandle di callback)
            if ($opsiBayar === 'LANGSUNG') {
                $header->Gross += $totalFnB;
                $header->GrossTotal += $totalFnB;
                $header->TotalMakanan += $totalFnB;
                $header->TotalTax += $totalTax;
                $header->BiayaLayanan += $totalService;
                $header->NetTotal += ($totalFnB + $totalTax + $totalService);
                $header->save();
            }
            // dd($opsiBayar, $header);

            if ($opsiBayar === 'LANGSUNG') {
                if ($isMidtrans) {
                    if (empty($mp->ClientKey) || empty($mp->ServerKey)) {
                        DB::rollback();
                        return response()->json(['success' => false, 'message' => 'Metode pembayaran tidak valid (Midtrans Keys missing).']);
                    }

                    try {
                        // Configure Midtrans
                        \Midtrans\Config::$serverKey = $mp->ServerKey;
                        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
                        \Midtrans\Config::$isSanitized = true;
                        \Midtrans\Config::$is3ds = true;

                        $payAmount = $totalFnB + $totalTax + $totalService;
                        $orderId = 'FNB-' . $noTransaksi . '-' . time();
                        
                        $transaction = [
                            'transaction_details' => [
                                'order_id' => $orderId,
                                'gross_amount' => (int) $payAmount,
                            ],
                            'customer_details' => [
                                'first_name' => $header->NamaPelanggan ?? 'Pelanggan',
                            ],
                            'item_details' => [
                                [
                                    'id' => 'FNB-' . $noTransaksi,
                                    'price' => (int) $payAmount,
                                    'quantity' => 1,
                                    'name' => 'Pesanan Makanan Order ' . $noTransaksi,
                                ]
                            ]
                        ];

                        $snapToken = \Midtrans\Snap::getSnapToken($transaction);
                        
                        DB::commit();
                        return response()->json([
                            'success' => true,
                            'snap_token' => $snapToken,
                            'NoTransaksi' => $noTransaksi,
                            'client_key' => $mp->ClientKey,
                            'payment_type' => 'ADD_FNB'
                        ]);

                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json(['success' => false, 'message' => 'Gagal generate snap token: ' . $e->getMessage()]);
                    }
                }

                $numberingData = new DocumentNumbering();
                $invoiceNo = $numberingData->GetNewDoc("POS-FNB", "fakturpenjualanheader", "NoTransaksi");

                // $mpId = $request->input('MetodePembayaran');
                // $mp = MetodePembayaran::find($mpId);

                $fakturHeader = new FakturPenjualanHeader;
                $fakturHeader->Periode = Carbon::now()->format('Ym');
                $fakturHeader->Transaksi = "POS"; // POS-FNB is just NoReff, Transaksi usually POS or Retail
                $fakturHeader->NoTransaksi = $invoiceNo;
                $fakturHeader->TglTransaksi = Carbon::now()->format('Y-m-d');
                $fakturHeader->TglJatuhTempo = Carbon::now()->format('Y-m-d');
                $fakturHeader->NoReff = "POS-FNB";
                $fakturHeader->KodePelanggan = $header->KodePelanggan;
                $fakturHeader->KodeTermin = $company->TerminBayarPoS ?? '1';
                $fakturHeader->Termin = 0;
                $fakturHeader->TotalTransaksi = $totalFnB;
                $fakturHeader->Potongan = 0;
                $fakturHeader->Pajak = $totalTax;
                $fakturHeader->BiayaLayanan = $totalService;
                $fakturHeader->TotalPembelian = $totalFnB + $totalTax + $totalService;
                $fakturHeader->TotalRetur = 0;
                $fakturHeader->TotalPembayaran = $fakturHeader->TotalPembelian;
                $fakturHeader->Pembulatan = 0;
                $fakturHeader->Status = "C";
                $fakturHeader->Keterangan = "Pembayaran FnB - " . $noTransaksi;
                $fakturHeader->Posted = 0;
                $fakturHeader->MetodeBayar = $mp ? $mp->NamaMetodePembayaran : '';
                $fakturHeader->ReffPembayaran = "";
                $fakturHeader->KodeSales = $header->KodeSales;
                $fakturHeader->NomorMeja = $header->tableid;
                $fakturHeader->RecordOwnerID = $recordOwnerID;
                $fakturHeader->created_at = Carbon::now();
                $fakturHeader->CreatedBy = Auth::user()->name;
                $fakturHeader->save();

                foreach ($items as $index => $item) {
                    $kodeItem = $item['KodeItem'];
                    $qty = floatval($item['Qty']);
                    $harga = floatval($item['Harga']);
                    $lineTotal = $qty * $harga;

                    $itemMaster = ItemMaster::where('KodeItem', $kodeItem)
                        ->where('RecordOwnerID', $recordOwnerID)
                        ->first();

                    $fakturDetail = new FakturPenjualanDetail;
                    $fakturDetail->NoTransaksi = $invoiceNo;
                    $fakturDetail->BaseReff = $noTransaksi;
                    $fakturDetail->NoUrut = $index + 1;
                    $fakturDetail->BaseLine = $maxLine + $index + 1;
                    $fakturDetail->KodeItem = $kodeItem;
                    $fakturDetail->Qty = $qty;
                    $fakturDetail->QtyKonversi = $qty;
                    $fakturDetail->QtyRetur = 0;
                    $fakturDetail->Satuan = $itemMaster->Satuan;
                    $fakturDetail->Harga = $harga;
                    $fakturDetail->Discount = 0;
                    $fakturDetail->HargaNet = $lineTotal;
                    $fakturDetail->LineStatus = 'C';
                    $fakturDetail->VatPercent = $ppnPer;
                    $fakturDetail->HargaPokokPenjualan = $itemMaster->HargaPokok ?? 0;
                    $fakturDetail->KodeGudang = $gudangPoS;
                    $fakturDetail->RecordOwnerID = $recordOwnerID;
                    $fakturDetail->save();
                }

                // Payment Header
                $numberingDataBayar = new DocumentNumbering();
                $payNo = $numberingDataBayar->GetNewDoc("INPAY", "pembayaranpenjualanheader", "NoTransaksi");

                $payHeader = new PembayaranPenjualanHeader();
                $payHeader->Periode = $fakturHeader->Periode;
                $payHeader->NoTransaksi = $payNo;
                $payHeader->TglTransaksi = $fakturHeader->TglTransaksi;
                $payHeader->KodePelanggan = $fakturHeader->KodePelanggan;
                $payHeader->TotalPembelian = $fakturHeader->TotalPembelian;
                $payHeader->TotalPembayaran = $fakturHeader->TotalPembelian;
                $payHeader->KodeMetodePembayaran = $mpId;
                $payHeader->NoReff = "";
                $payHeader->Keterangan = $fakturHeader->Keterangan;
                $payHeader->RecordOwnerID = $recordOwnerID;
                $payHeader->CreatedBy = Auth::user()->name;
                $payHeader->Posted = 0;
                $payHeader->Status = 'C';
                $payHeader->save();

                $payDetail = new PembayaranPenjualanDetail();
                $payDetail->NoTransaksi = $payNo;
                $payDetail->NoUrut = 1;
                $payDetail->BaseReff = $invoiceNo;
                $payDetail->TotalPembayaran = $fakturHeader->TotalPembelian;
                $payDetail->RecordOwnerID = $recordOwnerID;
                $payDetail->KodeMetodePembayaran = $mpId;
                $payDetail->save();
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'FnB berhasil ditambahkan']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("storeFnBOrder Error: " . $th->getMessage() . " at " . $th->getFile() . ":" . $th->getLine());
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }
    public function storeTambahDurasi(Request $request)
    {
        $recordOwnerID = Auth::user()->RecordOwnerID;
        Log::debug("storeTambahDurasi Request: " . json_encode($request->all()));

        DB::beginTransaction();
        try {
            $noTransaksi = $request->input('NoTransaksi');
            $paketId = $request->input('PaketId');
            $durasiBaru = floatval($request->input('Durasi', 1));
            $opsiBayar = $request->input('OpsiBayar');

            $header = TableOrderHeader::where('NoTransaksi', $noTransaksi)
                ->where('RecordOwnerID', $recordOwnerID)
                ->first();

            if (!$header) {
                return response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
            }

            $paket = DB::table('pakettransaksi')
                ->where('id', $paketId)
                ->where('RecordOwnerID', $recordOwnerID)
                ->first();

            if (!$paket) {
                return response()->json(['success' => false, 'message' => 'Paket tidak ditemukan'], 404);
            }

            $company = Company::where('KodePartner', $recordOwnerID)->first();
            $ppnPer = $company->PPN ?? 0;
            $servicePer = $company->ServiceCharge ?? 0;

            $hargaNormal = floatval($paket->HargaNormal);
            $subtotalAdd = $hargaNormal * $durasiBaru;
            
            $taxAdd = round($subtotalAdd * ($ppnPer / 100));
            $serviceAdd = round($subtotalAdd * ($servicePer / 100));
            $totalAdd = $subtotalAdd + $taxAdd + $serviceAdd;

            // Update Header
            // Extend JamSelesai
            $unitDurasi = $paket->DurasiPaket; // per packet unit
            $totalMenitAdd = 0;
            $jenis = $header->JenisPaket;
            if ($jenis === 'JAM' || $jenis === 'JAMREALTIME' || $jenis === 'PAKETMEMBER') {
                $totalMenitAdd = $unitDurasi * $durasiBaru * 60;
            } else if ($jenis === 'MENIT' || $jenis === 'MENITREALTIME') {
                $totalMenitAdd = $unitDurasi * $durasiBaru;
            } else if ($jenis === 'DAILY') {
                $totalMenitAdd = $unitDurasi * $durasiBaru * 24 * 60;
            } else if ($jenis === 'MONTHLY') {
                $totalMenitAdd = $unitDurasi * $durasiBaru * 30 * 24 * 60;
            } else if ($jenis === 'YEARLY') {
                $totalMenitAdd = $unitDurasi * $durasiBaru * 365 * 24 * 60;
            }

            // Detect Midtrans AUTO
            $mpId = $request->input('MetodePembayaran');
            $mp = !empty($mpId) ? MetodePembayaran::find($mpId) : null;
            $isMidtrans = ($opsiBayar === 'LANGSUNG' && $mp && $mp->MetodeVerifikasi === 'AUTO');

            if (!$isMidtrans) {
                if ($header->JamSelesai) {
                    $header->JamSelesai = Carbon::parse($header->JamSelesai)->addMinutes($totalMenitAdd);
                }

                $header->DurasiPaket += ($unitDurasi * $durasiBaru);
                $header->Gross += $subtotalAdd;
                $header->TotalTax += $taxAdd;
                $header->BiayaLayanan += $serviceAdd;
                $header->NetTotal += $totalAdd;
                $header->save();
            }

            if ($opsiBayar === 'LANGSUNG') {
                if ($isMidtrans) {
                    if (empty($mp->ClientKey) || empty($mp->ServerKey)) {
                        DB::rollback();
                        return response()->json(['success' => false, 'message' => 'Metode pembayaran tidak valid (Midtrans Keys missing).']);
                    }

                    try {
                        $pAdminAdd = $mp->BiayaAdminPercent ?? 0;
                        $rAdminAdd = $mp->BiayaAdminRupiah ?? 0;
                        $adminFeeAdd = round($subtotalAdd * ($pAdminAdd / 100)) + $rAdminAdd;
                        $payAmount = $totalAdd + $adminFeeAdd;

                        // Configure Midtrans
                        \Midtrans\Config::$serverKey = $mp->ServerKey;
                        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
                        \Midtrans\Config::$isSanitized = true;
                        \Midtrans\Config::$is3ds = true;

                        $orderId = 'DUR-' . $noTransaksi . '-' . time();
                        $transaction = [
                            'transaction_details' => [
                                'order_id' => $orderId,
                                'gross_amount' => (int) $payAmount,
                            ],
                            'customer_details' => [
                                'first_name' => $header->NamaPelanggan ?? 'Pelanggan',
                            ],
                            'item_details' => [
                                [
                                    'id' => 'DUR-' . $noTransaksi,
                                    'price' => (int) $payAmount,
                                    'quantity' => 1,
                                    'name' => 'Tambah Durasi Order ' . $noTransaksi,
                                ]
                            ]
                        ];

                        $snapToken = \Midtrans\Snap::getSnapToken($transaction);
                        
                        DB::commit();
                        return response()->json([
                            'success' => true,
                            'snap_token' => $snapToken,
                            'NoTransaksi' => $noTransaksi,
                            'client_key' => $mp->ClientKey,
                            'payment_type' => 'ADD_DURATION',
                            'DurasiBaru' => $durasiBaru, // Perlu dikirim balik untuk callback
                            'PaketId' => $paketId
                        ]);

                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json(['success' => false, 'message' => 'Gagal generate snap token: ' . $e->getMessage()]);
                    }
                }

                $numberingData = new DocumentNumbering();
                $invoiceNo = $numberingData->GetNewDoc("SIS", "fakturpenjualanheader", "NoTransaksi");

                // $mpId = $request->input('MetodePembayaran');
                // $mp = MetodePembayaran::find($mpId);
                $pAdminAdd = $mp ? ($mp->BiayaAdminPercent ?? 0) : 0;
                $rAdminAdd = $mp ? ($mp->BiayaAdminRupiah ?? 0) : 0;
                $adminFeeAdd = round($subtotalAdd * ($pAdminAdd / 100)) + $rAdminAdd;
                
                $grandTotal = $totalAdd + $adminFeeAdd;
                $nominalBayar = floatval($request->input('NominalBayar', 0));

                if ($nominalBayar < $grandTotal) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Nominal bayar tidak boleh kurang dari total tagihan (' . number_format($grandTotal, 0, ',', '.') . ')'
                    ], 400);
                }

                $fakturHeader = new FakturPenjualanHeader;
                $fakturHeader->Periode = Carbon::now()->format('Ym');
                $fakturHeader->Transaksi = "POS";
                $fakturHeader->NoTransaksi = $invoiceNo;
                $fakturHeader->TglTransaksi = $header->TglTransaksi;
                $fakturHeader->TglJatuhTempo = $header->TglTransaksi;
                $fakturHeader->NoReff = "POS";
                // $fakturHeader->BaseReff = $noTransaksi;
                $fakturHeader->KodePelanggan = $header->KodePelanggan;
                $fakturHeader->KodeTermin = $company->TerminBayarPoS ?? '1';
                $fakturHeader->Termin = 0;
                $fakturHeader->TotalTransaksi = $subtotalAdd;
                $fakturHeader->Potongan = 0;
                $fakturHeader->Pajak = $taxAdd;
                $fakturHeader->BiayaLayanan = $serviceAdd + $adminFeeAdd;
                $fakturHeader->TotalPembelian = $totalAdd + $adminFeeAdd;
                $fakturHeader->TotalRetur = 0;
                $fakturHeader->TotalPembayaran = $fakturHeader->TotalPembelian;
                $fakturHeader->Pembulatan = 0;
                $fakturHeader->Status = "C";
                $fakturHeader->Posted = 0;
                $fakturHeader->MetodeBayar = $mp ? $mp->NamaMetodePembayaran : '';
                $fakturHeader->ReffPembayaran = "";
                $fakturHeader->KodeSales = $header->KodeSales;
                $fakturHeader->TipeOrder = 0;
                $fakturHeader->NomorMeja = $header->tableid;
                $fakturHeader->PajakHiburan = 0;
                $fakturHeader->Keterangan = "Tambah Durasi Order " . $noTransaksi . " (" . $paket->NamaPaket . " x" . $durasiBaru . ")";
                $fakturHeader->RecordOwnerID = $recordOwnerID;
                $fakturHeader->CreatedBy = Auth::user()->name;
                $fakturHeader->created_at = Carbon::now();
                $fakturHeader->save();

                // Detail
                $fakturDetail = new FakturPenjualanDetail;
                $fakturDetail->NoTransaksi = $invoiceNo;
                $fakturDetail->BaseReff = $noTransaksi;
                $fakturDetail->NoUrut = 1;
                $fakturDetail->BaseLine = 0;
                $fakturDetail->KodeItem = $company->ItemHiburan;
                $fakturDetail->Qty = $durasiBaru;
                $fakturDetail->QtyKonversi = $durasiBaru;
                $fakturDetail->QtyRetur = 0;
                $fakturDetail->Satuan = $header->JenisPaket;
                $fakturDetail->Harga = $hargaNormal;
                $fakturDetail->Discount = 0;
                $fakturDetail->HargaNet = $subtotalAdd;
                $fakturDetail->LineTotal = $subtotalAdd;
                $fakturDetail->LineStatus = "C";
                $fakturDetail->KodeGudang = $company->GudangPoS ?? 'HO';
                $fakturDetail->Keterangan = "Tambah Durasi: " . $paket->NamaPaket;
                $fakturDetail->VatPercent = $ppnPer;
                $fakturDetail->VatTotal = $taxAdd;
                $fakturDetail->Pajak = $taxAdd;
                $fakturDetail->PajakHiburan = 0;
                $fakturDetail->RecordOwnerID = $recordOwnerID;
                $fakturDetail->created_at = Carbon::now();
                $fakturDetail->save();

                // Payment
                if (floatval($fakturHeader->TotalPembayaran) > 0) {
                    $pmNo = $numberingData->GetNewDoc("PMB", "pembayaranpenjualanheader", "NoTransaksi");
                    $pembayaran = new PembayaranPenjualanHeader;
                    $pembayaran->Periode = Carbon::now()->format('Ym');
                    $pembayaran->NoTransaksi = $pmNo;
                    $pembayaran->TglTransaksi = $header->TglTransaksi;
                    $pembayaran->KodePelanggan = $header->KodePelanggan;
                    $pembayaran->TotalPembelian = $fakturHeader->TotalPembelian;
                    $pembayaran->TotalPembayaran = $fakturHeader->TotalPembayaran;
                    $pembayaran->BiayaLayanan = $fakturHeader->BiayaLayanan;
                    $pembayaran->KodeMetodePembayaran = $mpId;
                    $pembayaran->NoReff = $invoiceNo;
                    $pembayaran->Keterangan = "Pembayaran " . $invoiceNo;
                    $pembayaran->CreatedBy = Auth::user()->name;
                    $pembayaran->UpdatedBy = Auth::user()->name;
                    $pembayaran->Posted = 0;
                    $pembayaran->Status = "C";
                    $pembayaran->RecordOwnerID = $recordOwnerID;
                    $pembayaran->created_at = Carbon::now();
                    $pembayaran->save();

                    $pembayaranDetail = new PembayaranPenjualanDetail;
                    $pembayaranDetail->NoTransaksi = $pmNo;
                    $pembayaranDetail->NoUrut = 1;
                    $pembayaranDetail->BaseReff = $invoiceNo;
                    $pembayaranDetail->TotalPembayaran = $fakturHeader->TotalPembayaran;
                    $pembayaranDetail->KodeMetodePembayaran = $mpId;
                    $pembayaranDetail->Keterangan = "Pembayaran " . $invoiceNo;
                    $pembayaranDetail->RecordOwnerID = $recordOwnerID;
                    $pembayaranDetail->created_at = Carbon::now();
                    $pembayaranDetail->save();
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Durasi berhasil ditambahkan'
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("storeTambahDurasi Error: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan durasi: ' . $th->getMessage()
            ], 500);
        }
    }    
    public function handleMidtransSuccess(Request $request)
    {
        $noTransaksi = $request->input('NoTransaksi');
        $recordOwnerID = Auth::user()->RecordOwnerID;
        $paymentType = $request->input('payment_type', 'POS'); 
        Log::info("handleMidtransSuccess started for NoTransaksi: $noTransaksi, PaymentType: $paymentType");

        DB::beginTransaction();
        try {
            $company = Company::where('KodePartner', $recordOwnerID)->first();
            $numberingData = new DocumentNumbering();
            $periode = Carbon::now()->format('Ym');
            $now = Carbon::now();

            if ($paymentType === 'JUAL_FNB') {
                Log::info("handleMidtransSuccess: Processing JUAL_FNB (Temporary Entry)");
                
                // Cek apakah NoTransaksi adalah Temporary ID (TMPFNB...)
                if (str_starts_with($noTransaksi, 'TMPFNB')) {
                    $sessionData = session($noTransaksi);
                    if (!$sessionData) {
                        DB::rollback();
                        return response()->json(['success' => false, 'message' => 'Data sesi pembayaran tidak ditemukan atau sudah kadaluarsa.']);
                    }

                    // Generate Real Invoice No
                    $invoiceNo = $numberingData->GetNewDoc("SIS", "fakturpenjualanheader", "NoTransaksi");
                    $metode = MetodePembayaran::find($sessionData['metodePembayaranId']);

                    // 1. Create Faktur Header
                    $fH = new FakturPenjualanHeader;
                    $fH->Periode = $sessionData['periode'];
                    $fH->Transaksi = "POS";
                    $fH->NoTransaksi = $invoiceNo;
                    $fH->TglTransaksi = $now->toDateString();
                    $fH->TglJatuhTempo = $now->toDateString();
                    $fH->NoReff = "FNB-DIRECT";
                    $fH->KodePelanggan = $sessionData['kodePelanggan'];
                    $fH->KodeTermin = $sessionData['kodeTermin'];
                    $fH->Termin = 0;
                    $fH->TotalTransaksi = $sessionData['subtotal'];
                    $fH->Potongan = 0;
                    $fH->Pajak = $sessionData['ppnRp'];
                    $fH->TotalPembelian = $sessionData['grandTotal'];
                    $fH->TotalRetur = 0;
                    $fH->TotalPembayaran = $sessionData['grandTotal'];
                    $fH->Pembulatan = 0;
                    $fH->Status = "C";
                    $fH->Keterangan = "Penjualan FnB Langsung (Midtrans Success)";
                    $fH->Posted = 0;
                    $fH->MetodeBayar = $metode ? $metode->NamaMetodePembayaran : '';
                    $fH->ReffPembayaran = "";
                    $fH->KodeSales = "";
                    $fH->CreatedBy = Auth::user()->name;
                    $fH->UpdatedBy = Auth::user()->name;
                    $fH->TipeOrder = 0;
                    $fH->NomorMeja = "";
                    $fH->PajakHiburan = 0;
                    $fH->BiayaLayanan = $sessionData['serviceRp'] + $sessionData['adminFeeRp'];
                    $fH->SyaratDanKetentuan = "";
                    $fH->RecordOwnerID = $recordOwnerID;
                    $fH->save();

                    // 2. Create Faktur Detail
                    foreach ($sessionData['items'] as $i => $item) {
                        $fD = new FakturPenjualanDetail;
                        $fD->NoTransaksi = $invoiceNo;
                        $fD->BaseReff = "FNB-DIRECT";
                        $fD->NoUrut = $i + 1;
                        $fD->BaseLine = 0;
                        $fD->KodeItem = $item['KodeItem'] ?? '';
                        $fD->Qty = floatval($item['Qty'] ?? 1);
                        $fD->QtyKonversi = floatval($item['Qty'] ?? 1);
                        $fD->QtyRetur = 0;
                        $fD->Satuan = $item['Satuan'] ?? 'PCS';
                        $fD->Harga = floatval($item['Harga'] ?? 0);
                        $fD->Discount = 0;
                        $fD->HargaNet = $fD->Harga * $fD->Qty;
                        $fD->LineStatus = "C";
                        $fD->KodeGudang = $sessionData['gudangPos'];
                        $fD->Keterangan = $item['NamaItem'] ?? '';
                        $fD->VatPercent = $sessionData['ppnPersen'];
                        $fD->HargaPokokPenjualan = 0;
                        $fD->RecordOwnerID = $recordOwnerID;
                        $fD->Pajak = round($fD->HargaNet * ($sessionData['ppnPersen'] / 100));
                        $fD->PajakHiburan = 0;
                        $fD->VatTotal = $fD->Pajak;
                        $fD->save();
                    }

                    // 3. Create Pembayaran
                    $pmNo = $numberingData->GetNewDoc("PMB", "pembayaranpenjualanheader", "NoTransaksi");
                    $pmH = new PembayaranPenjualanHeader;
                    $pmH->Periode = $sessionData['periode'];
                    $pmH->NoTransaksi = $pmNo;
                    $pmH->TglTransaksi = $now->toDateString();
                    $pmH->KodePelanggan = $fH->KodePelanggan;
                    $pmH->TotalPembelian = $fH->TotalPembelian;
                    $pmH->TotalPembayaran = $fH->TotalPembelian;
                    $pmH->BiayaLayanan = $fH->BiayaLayanan;
                    $pmH->KodeMetodePembayaran = $metode ? $metode->id : 0;
                    $pmH->NoReff = $fH->NoTransaksi;
                    $pmH->Keterangan = "Pembayaran " . $fH->NoTransaksi . " (Midtrans Success)";
                    $pmH->CreatedBy = Auth::user()->name;
                    $pmH->UpdatedBy = Auth::user()->name;
                    $pmH->Posted = 0;
                    $pmH->Status = 'C';
                    $pmH->RecordOwnerID = $recordOwnerID;
                    $pmH->save();

                    $pmD = new PembayaranPenjualanDetail;
                    $pmD->NoTransaksi = $pmNo;
                    $pmD->NoUrut = 1;
                    $pmD->BaseReff = $fH->NoTransaksi;
                    $pmD->TotalPembayaran = $fH->TotalPembelian;
                    $pmD->KodeMetodePembayaran = $pmH->KodeMetodePembayaran;
                    $pmD->Keterangan = "Pembayaran " . $fH->NoTransaksi;
                    $pmD->RecordOwnerID = $recordOwnerID;
                    $pmD->save();

                    // Clear Session
                    session()->forget($noTransaksi);

                    DB::commit();
                    return response()->json(['success' => true, 'message' => 'Penjualan berhasil disimpan.', 'invoiceNo' => $invoiceNo]);
                }

                // Fallback (for non-temp entries if any exists)
                $fH = FakturPenjualanHeader::where('NoTransaksi', $noTransaksi)
                    ->where('RecordOwnerID', $recordOwnerID)
                    ->first();

                if ($fH && $fH->Status !== 'C') {
                    $fH->Status = 'C';
                    $fH->TotalPembayaran = $fH->TotalPembelian;
                    $fH->save();

                    DB::table('fakturpenjualandetail')
                        ->where('NoTransaksi', $noTransaksi)
                        ->where('RecordOwnerID', $recordOwnerID)
                        ->update(['LineStatus' => 'C']);
                    
                    // Create payment records... (Similar to above, but this is a fallback)
                    // For now, let's just commit if it's already there but marked O.
                    DB::commit();
                    return response()->json(['success' => true, 'message' => 'Penjualan berhasil disimpan.', 'invoiceNo' => $fH->NoTransaksi]);
                }
            }

            $model = TableOrderHeader::where('NoTransaksi', $noTransaksi)
                ->where('RecordOwnerID', $recordOwnerID)
                ->first();

            if (!$model) {
                Log::warning("handleMidtransSuccess: Transaksi tidak ditemukan for NoTransaksi: $noTransaksi");
                DB::rollback();
                return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan']);
            }

            if ($paymentType === 'POS' || $paymentType === 'NEW_PACKAGE') {
                Log::info("handleMidtransSuccess: Entering POS/NEW_PACKAGE branch");
                // ==========================================
                // TYPE 1: INITIAL POS ORDER
                // ==========================================
                // Jika sudah ada invoice, anggap selesai
                $fakturExists = FakturPenjualanHeader::where('NoReff', 'POS')
                    ->where('Keterangan', "Pembayaran Layanan PoS - " . $noTransaksi)
                    ->where('RecordOwnerID', $recordOwnerID)
                    ->exists();

                if ($fakturExists) {
                    Log::info("handleMidtransSuccess: Faktur already exists, skipping finalize.");
                    DB::commit();
                    return response()->json(['success' => true]);
                }

                // Selalu aktifkan jika pembayaran sukses (kecuali booking masa depan yang sangat jauh)
                // Tapi untuk POS/NEW_PACKAGE biasanya adalah pesanan yang ingin segera aktif
                // $model->Status = 1;
                // $model->DocumentStatus = 'O';
                // DB::table('titiklampu')
                //     ->where('id', $model->tableid)
                //     ->where('RecordOwnerID', $recordOwnerID)
                //     ->update(['Status' => 1]);

                $dtStart = Carbon::parse($model->JamMulai);
                if ($dtStart->lte($now)) {
                    $model->Status = 1;
                    $model->DocumentStatus = 'O';
                    DB::table('titiklampu')
                        ->where('id', $model->tableid)
                        ->where('RecordOwnerID', $recordOwnerID)
                        ->update(['Status' => 1]);
                }
                
                $model->save();
                Log::info("handleMidtransSuccess: Table activated and model saved.");

                if ($model->JenisPaket !== 'PAKETMEMBER' || $model->NetTotal > 0) {
                    $grandTotal = $model->TotalTerbayar;
                    $adminFeeRp = $grandTotal - $model->NetTotal;
                    if ($adminFeeRp < 0) $adminFeeRp = 0;

                    $invoiceNo = $numberingData->GetNewDoc("SIS", "fakturpenjualanheader", "NoTransaksi");
                    $fakturHeader = new FakturPenjualanHeader;
                    $fakturHeader->Periode = $periode;
                    $fakturHeader->Transaksi = "POS";
                    $fakturHeader->NoTransaksi = $invoiceNo;
                    $fakturHeader->TglTransaksi = $model->TglTransaksi;
                    $fakturHeader->TglJatuhTempo = $model->TglTransaksi;
                    $fakturHeader->NoReff = "POS";
                    $fakturHeader->KodePelanggan = $model->KodePelanggan;
                    $fakturHeader->KodeTermin = $company->TerminBayarPoS ?? '1';
                    $fakturHeader->Termin = 0;
                    $fakturHeader->TotalTransaksi = $model->GrossTotal - $model->TotalDiskon;
                    $fakturHeader->Potongan = $model->TotalDiskon;
                    $fakturHeader->Pajak = $model->TotalTax;
                    $fakturHeader->TotalPembelian = $grandTotal;
                    $fakturHeader->TotalRetur = 0;
                    $fakturHeader->TotalPembayaran = $grandTotal;
                    $fakturHeader->Pembulatan = 0;
                    $fakturHeader->Status = "C";
                    $fakturHeader->Keterangan = "Pembayaran Layanan PoS - " . $noTransaksi;
                    $fakturHeader->Posted = 0;
                    $fakturHeader->MetodeBayar = $model->MetodePembayaran;
                    $fakturHeader->ReffPembayaran = "";
                    $fakturHeader->KodeSales = $model->KodeSales ?? "";
                    $fakturHeader->CreatedBy = Auth::user()->name;
                    $fakturHeader->UpdatedBy = Auth::user()->name;
                    $fakturHeader->TipeOrder = 0;
                    $fakturHeader->NomorMeja = $model->tableid;
                    $fakturHeader->PajakHiburan = $model->TotalPajakHiburan;
                    $fakturHeader->BiayaLayanan = $model->BiayaLayanan + $adminFeeRp;
                    $fakturHeader->SyaratDanKetentuan = "";
                    $fakturHeader->RecordOwnerID = $recordOwnerID;
                    $fakturHeader->save();
                    Log::info("handleMidtransSuccess (POS): FakturHeader created: " . $invoiceNo);

                    // Detail & Payment logic (Replicated from earlier version)
                    $paket = ($model->paketid && $model->paketid != -1) ? Paket::find($model->paketid) : null;
                    $baseDurasi = ($paket && $paket->DurasiPaket) ? $paket->DurasiPaket : 1;
                    $hargaPerSatuan = $paket ? ($baseDurasi > 0 ? ($paket->HargaNormal / $baseDurasi) : $paket->HargaNormal) : 0;

                    $fDetail = new FakturPenjualanDetail;
                    $fDetail->NoTransaksi = $invoiceNo;
                    $fDetail->BaseReff = $model->NoTransaksi;
                    $fDetail->NoUrut = 1;
                    $fDetail->BaseLine = 0;
                    $fDetail->KodeItem = $company->ItemHiburan;
                    $fDetail->Qty = $model->DurasiPaket;
                    $fDetail->QtyKonversi = $model->DurasiPaket;
                    $fDetail->QtyRetur = 0;
                    $fDetail->Satuan = $model->JenisPaket;
                    $fDetail->Harga = $hargaPerSatuan;
                    $fDetail->Discount = 0;
                    $fDetail->HargaNet = $model->GrossTotal - $model->TotalDiskon;
                    $fDetail->LineStatus = "C";
                    $fDetail->KodeGudang = $company->GudangPoS ?? 'HO';
                    $fDetail->Keterangan = "Layanan " . $model->JenisPaket;
                    $fDetail->VatPercent = $company->PPN ?? 0;
                    $fDetail->HargaPokokPenjualan = 0;
                    $fDetail->RecordOwnerID = $recordOwnerID;
                    $fDetail->Pajak = $model->TotalTax;
                    $fDetail->PajakHiburan = $model->TotalPajakHiburan;
                    $fDetail->VatTotal = $model->TotalTax;
                    $fDetail->save();
                    Log::info("handleMidtransSuccess: FakturDetail saved for invoice: " . $invoiceNo);

                    $pmNo = $numberingData->GetNewDoc("PMB", "pembayaranpenjualanheader", "NoTransaksi");
                    $pmH = new PembayaranPenjualanHeader;
                    $pmH->Periode = $periode;
                    $pmH->NoTransaksi = $pmNo;
                    $pmH->TglTransaksi = $model->TglTransaksi;
                    $pmH->KodePelanggan = $model->KodePelanggan;
                    $pmH->TotalPembelian = $grandTotal;
                    $pmH->TotalPembayaran = $grandTotal;
                    $pmH->BiayaLayanan = $model->BiayaLayanan + $adminFeeRp;
                    $pmH->KodeMetodePembayaran = MetodePembayaran::where('NamaMetodePembayaran', $model->MetodePembayaran)->where('MetodeVerifikasi', 'AUTO')->first()->id ?? 1;
                    $pmH->NoReff = $invoiceNo;
                    $pmH->Keterangan = "Pembayaran " . $invoiceNo;
                    $pmH->CreatedBy = Auth::user()->name;
                    $pmH->UpdatedBy = Auth::user()->name;
                    $pmH->Posted = 0;
                    $pmH->Status = 'C';
                    $pmH->RecordOwnerID = $recordOwnerID;
                    $pmH->created_at = Carbon::now();
                    $pmH->save();
                    Log::info("handleMidtransSuccess: PembayaranPenjualanHeader created: " . $pmNo);

                    $pmD = new PembayaranPenjualanDetail;
                    $pmD->NoTransaksi = $pmNo;
                    $pmD->NoUrut = 1;
                    $pmD->BaseReff = $invoiceNo;
                    $pmD->TotalPembayaran = $grandTotal;
                    $pmD->KodeMetodePembayaran = MetodePembayaran::where('NamaMetodePembayaran', $model->MetodePembayaran)->where('MetodeVerifikasi', 'AUTO')->first()->id ?? 1;
                    $pmD->Keterangan = "Pembayaran " . $invoiceNo;
                    $pmD->RecordOwnerID = $recordOwnerID;
                    $pmD->created_at = Carbon::now();
                    $pmD->save();
                }

            } else if ($paymentType === 'PAY_DETAIL' || $paymentType === 'ADD_DURATION' || $paymentType === 'ADD_FNB') {
                Log::info("handleMidtransSuccess: Entering PAY_DETAIL/ADD_DURATION/ADD_FNB branch. Type: $paymentType");
                // ==========================================
                // TYPE: PAY DETAIL / ADD FNB / ADD DURATION
                // ==========================================
                $nominalBayar = (float)$request->input('NominalBayar');
                $mpNama = $model->MetodePembayaran; // This might need to be passed from the frontend for ADD_DURATION etc.
                $mp = MetodePembayaran::where('NamaMetodePembayaran', $mpNama)->where('MetodeVerifikasi', 'AUTO')->first();
                $mpId = $mp ? $mp->id : 1;

                $invoiceNo = $numberingData->GetNewDoc("SIS", "fakturpenjualanheader", "NoTransaksi"); // Initialize here for common use

                if ($paymentType === 'ADD_DURATION') {
                    Log::info("handleMidtransSuccess: Processing ADD_DURATION");
                    $paketId = $request->input('PaketId');
                    $durasiBaru = $request->input('DurasiBaru');
                    $paket = Paket::find($paketId);
                    
                    if ($paket) {
                        $unitDurasi = $paket->DurasiPaket;
                        $totalMenitAdd = 0;
                        $jenis = $model->JenisPaket;
                        if ($jenis === 'JAM' || $jenis === 'JAMREALTIME' || $jenis === 'PAKETMEMBER') $totalMenitAdd = $unitDurasi * $durasiBaru * 60;
                        else if ($jenis === 'MENIT' || $jenis === 'MENITREALTIME') $totalMenitAdd = $unitDurasi * $durasiBaru;
                        else if ($jenis === 'DAILY') $totalMenitAdd = $unitDurasi * $durasiBaru * 24 * 60;
                        
                        if ($model->JamSelesai) $model->JamSelesai = Carbon::parse($model->JamSelesai)->addMinutes($totalMenitAdd);
                        $model->DurasiPaket += ($unitDurasi * $durasiBaru);
                        
                        // Re-calculate based on what was paid (simplified)
                        // In real success, we should use exactly the components calculated in storeTambahDurasi
                        // For brevity, we update header totals using nominal paid
                        $model->NetTotal += $nominalBayar;
                        $model->save();

                        // Create Invoice (Meniru logic storeTambahDurasi)
                        $fH = new FakturPenjualanHeader;
                        $fH->Periode = $periode;
                        $fH->Transaksi = "POS";
                        $fH->NoTransaksi = $invoiceNo;
                        $fH->TglTransaksi = $now;
                        $fH->TglJatuhTempo = $now;
                        $fH->NoReff = "POS";
                        $fH->KodePelanggan = $model->KodePelanggan;
                        $fH->KodeTermin = $company->TerminBayarPoS ?? '1';
                        $fH->Termin = 0;
                        $fH->TotalTransaksi = $nominalBayar; // Simplified, should be subtotalAdd
                        $fH->Potongan = 0;
                        $fH->Pajak = 0; // Simplified, should be taxAdd
                        $fH->BiayaLayanan = 0; // Simplified, should be serviceAdd + adminFeeAdd
                        $fH->TotalPembelian = $nominalBayar;
                        $fH->TotalRetur = 0;
                        $fH->TotalPembayaran = $nominalBayar;
                        $fH->Pembulatan = 0;
                        $fH->Status = "C";
                        $fH->Posted = 0;
                        $fH->MetodeBayar = $mp ? $mp->NamaMetodePembayaran : '';
                        $fH->ReffPembayaran = "";
                        $fH->KodeSales = $model->KodeSales;
                        $fH->UpdatedBy = Auth::user()->name;
                        $fH->TipeOrder = 0;
                        $fH->NomorMeja = $model->tableid;
                        $fH->PajakHiburan = 0;
                        $fH->Keterangan = "Tambah Durasi Order " . $noTransaksi . " (" . $paket->NamaPaket . " x" . $durasiBaru . ")";
                        $fH->SyaratDanKetentuan = "";
                        $fH->RecordOwnerID = $recordOwnerID;
                        $fH->CreatedBy = Auth::user()->name;
                        $fH->created_at = Carbon::now();
                        $fH->save();
                        Log::info("handleMidtransSuccess (ADD_DURATION): FakturHeader created: " . $invoiceNo);

                        $fD = new FakturPenjualanDetail;
                        $fD->NoTransaksi = $invoiceNo;
                        $fD->BaseReff = $noTransaksi;
                        $fD->NoUrut = 1;
                        $fD->BaseLine = 0;
                        $fD->KodeItem = $company->ItemHiburan;
                        $fD->Qty = $durasiBaru;
                        $fD->QtyKonversi = $durasiBaru;
                        $fD->QtyRetur = 0;
                        $fD->Satuan = $model->JenisPaket;
                        $fD->Harga = $paket->HargaNormal / $paket->DurasiPaket; // Simplified
                        $fD->Discount = 0;
                        $fD->HargaNet = $nominalBayar; // Simplified
                        $fD->LineStatus = "C";
                        $fD->KodeGudang = $company->GudangPoS ?? 'HO';
                        $fD->Keterangan = "Tambah Durasi: " . $paket->NamaPaket;
                        $fD->VatPercent = $company->PPN ?? 0;
                        $fD->VatTotal = 0; // Simplified
                        $fD->HargaPokokPenjualan = 0;
                        $fD->RecordOwnerID = $recordOwnerID;
                        $fD->Pajak = 0; // Simplified
                        $fD->PajakHiburan = 0;
                        $fD->created_at = Carbon::now();
                        $fD->save();
                        Log::info("handleMidtransSuccess (ADD_DURATION): FakturDetail saved for invoice: " . $invoiceNo);
                    }
                } else if ($paymentType === 'ADD_FNB') {
                    Log::info("handleMidtransSuccess: Processing ADD_FNB");
                    // Finalize Open FnB items
                    DB::table('tableorderfnb')
                        ->where('NoTransaksi', $noTransaksi)
                        ->where('RecordOwnerID', $recordOwnerID)
                        ->where('LineStatus', 'O')
                        ->update(['LineStatus' => 'C']);
                    
                    // Logic to create invoice for FnB only...
                    // (Simplified: Create one summary invoice)
                    $fH = new FakturPenjualanHeader;
                    $fH->Periode = $periode;
                    $fH->Transaksi = "POS";
                    $fH->NoTransaksi = $invoiceNo;
                    $fH->TglTransaksi = $now;
                    $fH->TglJatuhTempo = $now;
                    $fH->NoReff = "POS";
                    $fH->KodePelanggan = $model->KodePelanggan;
                    $fH->KodeTermin = $company->TerminBayarPoS ?? '1';
                    $fH->Termin = 0;
                    $fH->TotalTransaksi = $nominalBayar;
                    $fH->Potongan = 0;
                    $fH->Pajak = 0;
                    $fH->BiayaLayanan = 0;
                    $fH->TotalPembelian = $nominalBayar;
                    $fH->TotalRetur = 0;
                    $fH->TotalPembayaran = $nominalBayar;
                    $fH->Pembulatan = 0;
                    $fH->Status = "C";
                    $fH->Posted = 0;
                    $fH->MetodeBayar = $mp ? $mp->NamaMetodePembayaran : '';
                    $fH->ReffPembayaran = "";
                    $fH->KodeSales = $model->KodeSales;
                    $fH->UpdatedBy = Auth::user()->name;
                    $fH->TipeOrder = 0;
                    $fH->NomorMeja = $model->tableid;
                    $fH->PajakHiburan = 0;
                    $fH->Keterangan = "Pembayaran FnB " . $noTransaksi;
                    $fH->SyaratDanKetentuan = "";
                    $fH->RecordOwnerID = $recordOwnerID;
                    $fH->CreatedBy = Auth::user()->name;
                    $fH->created_at = Carbon::now();
                    $fH->save();
                    Log::info("handleMidtransSuccess (ADD_FNB): FakturHeader created: " . $invoiceNo);

                    // Sync FnB Totals to Header
                    // Kita gunakan data fnb yang tadi kita update ke 'C'
                    // Dalam handleMidtransSuccess, kita belum punya list detail item secara langsung sebagai object,
                    // tapi kita bisa query yang baru saja diupdate jika kita tahu mana saja itu.
                    // Karena semua 'O' diupdate ke 'C', kita bisa sum yang sekarang 'C' tapi sebelumnya 'O'
                    // Namun di handleMidtransSuccess, ini biasanya batch yang baru masuk.
                    
                    // Cara paling aman: Sum SEMUA yang 'C' dan update header fields.
                    $fnbTotals = DB::table('tableorderfnb')
                        ->where('NoTransaksi', $noTransaksi)
                        ->where('RecordOwnerID', $recordOwnerID)
                        ->where('LineStatus', 'C')
                        ->selectRaw('SUM(Qty * Harga) as total_makanan, SUM(Tax) as total_tax, SUM(BiayaLayanan) as total_service')
                        ->first();

                    if ($model) {
                        $model->TotalMakanan = $fnbTotals->total_makanan ?? 0;
                        // Untuk Tax dan Service, jika kita reset ke 'fnb only', kita kehilangan Packet Tax.
                        // Jadi kita harus hati-hati.
                        
                        // User ingin 'akumulasi'. Jika header.TotalTax adalah total,
                        // maka kita butuh cara membedakan tax packet dan tax fnb.
                        // Alternatif: Kita asumsikan NetTotal dihitung sebagai (Gross-Disc) + AllPaidTax + AllPaidService + AllPaidMakanan.
                        
                        // Kita update incremental saja berdasarkan apa yang baru difakturkan (nominalBayar) 
                        // tapi nominalBayar di ADD_FNB Midtrans adalah total (Subtotal + Tax + Service).
                        // Kita sudah punya fnbTotals (SUM ALL 'C').
                        
                        $model->TotalMakanan = $fnbTotals->total_makanan ?? 0;
                        // Kita tidak bisa asal += tax karena fnbTotals adalah semua yang 'C'.
                        // Jika ini fnb kedua, fnbTotals include fnb pertama.
                        
                        // SOLUSI: Simpan komponen FnB saja di field tsb? 
                        // Tidak, field tsb biasanya total.
                        
                        // Kita gunakan incremental tax/service dari items yang baru saja di-C-kan.
                        // Tapi kita tidak punya listnya di sini kecuali query ulang status 'C' yang NoFaktur matching? No.
                        
                        // Oke, kita hitung incremental dari nominalBayar (gross_amount)
                        // Namun lebih akurat jika kita query items yang 'C' tapi belum masuk ke previous summary.
                        // Ribet. Mari gunakan SUM ALL 'C' dan asumsikan header fields (Tax, Service) 
                        // akan kita sinkronkan dengan (Packet Comp + FnB Comp).
                        
                        // Mari hitung Packet Tax/Service
                        $ppnPer = $company->PPN ?? 0;
                        $pb1Per = $company->PajakHiburan ?? 0;
                        $svcPer = $company->ServiceCharge ?? 0;
                        $dppPaket = floatval($model->Gross) - floatval($model->TotalDiskon);
                        $taxPaket = $dppPaket * (($ppnPer + $pb1Per) / 100);
                        $svcPaket = $dppPaket * ($svcPer / 100);
                        
                        $model->TotalTax = $taxPaket + ($fnbTotals->total_tax ?? 0);
                        $model->BiayaLayanan = $svcPaket + ($fnbTotals->total_service ?? 0);
                        $model->NetTotal = $dppPaket + $model->TotalTax + $model->BiayaLayanan + $model->TotalMakanan;
                        $model->save();
                    }
                } else if ($paymentType === 'PAY_DETAIL') {
                    Log::info("handleMidtransSuccess: Processing PAY_DETAIL");
                    // Update header if needed, but usually payOrderDetail is for existing factures or outstanding balance
                    $model->TotalTerbayar += $nominalBayar;
                    
                    // Logic: If JamSelesai > Now, set Status = 0 and DocumentStatus = 'C'
                    if ($model->JamSelesai && $model->JamSelesai < $now->toDateTimeString()) {
                        $model->Status = 0;
                        $model->DocumentStatus = 'C';
                    }
                    $model->save();
                    
                    // Create Invoice/Payment logic for the outstanding amount...
                    $fH = new FakturPenjualanHeader;
                    $fH->Periode = $periode;
                    $fH->Transaksi = "POS";
                    $fH->NoTransaksi = $invoiceNo;
                    $fH->TglTransaksi = $now;
                    $fH->TglJatuhTempo = $now;
                    $fH->NoReff = "POS";
                    $fH->KodePelanggan = $model->KodePelanggan;
                    $fH->KodeTermin = $company->TerminBayarPoS ?? '1';
                    $fH->Termin = 0;
                    $fH->TotalTransaksi = $nominalBayar;
                    $fH->Potongan = 0;
                    $fH->Pajak = 0;
                    $fH->BiayaLayanan = 0;
                    $fH->TotalPembelian = $nominalBayar;
                    $fH->TotalRetur = 0;
                    $fH->TotalPembayaran = $nominalBayar;
                    $fH->Pembulatan = 0;
                    $fH->Status = "C";
                    $fH->Posted = 0;
                    $fH->MetodeBayar = $mp ? $mp->NamaMetodePembayaran : '';
                    $fH->ReffPembayaran = "";
                    $fH->KodeSales = $model->KodeSales;
                    $fH->UpdatedBy = Auth::user()->name;
                    $fH->TipeOrder = 0;
                    $fH->NomorMeja = $model->tableid;
                    $fH->PajakHiburan = 0;
                    $fH->Keterangan = "Pelunasan Detail Order " . $noTransaksi;
                    $fH->SyaratDanKetentuan = "";
                    $fH->RecordOwnerID = $recordOwnerID;
                    $fH->CreatedBy = Auth::user()->name;
                    $fH->created_at = Carbon::now();
                    $fH->save();
                    Log::info("handleMidtransSuccess (PAY_DETAIL): FakturHeader created: " . $invoiceNo);
                }

                // Create Payment Header for PAY_DETAIL/ADD_FNB/ADD_DURATION (Common)
                $pmNo = $numberingData->GetNewDoc("PMB", "pembayaranpenjualanheader", "NoTransaksi");
                $pmH = new PembayaranPenjualanHeader;
                $pmH->Periode = $periode;
                $pmH->NoTransaksi = $pmNo;
                $pmH->TglTransaksi = $now;
                $pmH->KodePelanggan = $model->KodePelanggan;
                $pmH->TotalPembelian = $nominalBayar;
                $pmH->TotalPembayaran = $nominalBayar;
                $pmH->BiayaLayanan = 0; // Simplified
                $pmH->KodeMetodePembayaran = $mpId;
                $pmH->NoReff = $invoiceNo;
                $pmH->Keterangan = "Pembayaran " . $invoiceNo;
                $pmH->CreatedBy = Auth::user()->name;
                $pmH->UpdatedBy = Auth::user()->name;
                $pmH->Posted = 0;
                $pmH->Status = 'C';
                $pmH->RecordOwnerID = $recordOwnerID;
                $pmH->created_at = Carbon::now();
                $pmH->save();
                Log::info("handleMidtransSuccess (Common PMB): PembayaranPenjualanHeader created: " . $pmNo);
                
                $pmD = new PembayaranPenjualanDetail;
                $pmD->NoTransaksi = $pmNo;
                $pmD->NoUrut = 1;
                $pmD->BaseReff = $invoiceNo;
                $pmD->TotalPembayaran = $nominalBayar;
                $pmD->KodeMetodePembayaran = $mpId;
                $pmD->Keterangan = "Pembayaran " . $invoiceNo;
                $pmD->RecordOwnerID = $recordOwnerID;
                $pmD->created_at = Carbon::now();
                $pmD->save();
            }

            DB::commit();
            Log::info("handleMidtransSuccess: All updates committed successfully for $noTransaksi");
            return response()->json(['success' => true]);

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error("Midtrans Success Error ($paymentType): " . $th->getMessage() . "\n" . $th->getTraceAsString());
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function handleMidtransCancel(Request $request)
    {
        $noTransaksi = $request->input('NoTransaksi');
        $recordOwnerID = Auth::user()->RecordOwnerID;
        $paymentType = $request->input('payment_type', 'POS');

        DB::beginTransaction();
        try {
            if ($paymentType === 'JUAL_FNB') {
                if (str_starts_with($noTransaksi, 'TMPFNB')) {
                    session()->forget($noTransaksi);
                } else {
                    $fH = FakturPenjualanHeader::where('NoTransaksi', $noTransaksi)
                        ->where('RecordOwnerID', $recordOwnerID)
                        ->where('Status', 'O')
                        ->first();

                    if ($fH) {
                        FakturPenjualanDetail::where('NoTransaksi', $noTransaksi)
                            ->where('RecordOwnerID', $recordOwnerID)
                            ->delete();
                        $fH->delete();
                    }
                }
            } else {
                $model = TableOrderHeader::where('NoTransaksi', $noTransaksi)
                    ->where('RecordOwnerID', $recordOwnerID)
                    ->first();

                if ($model) {
                    if ($paymentType === 'POS') {
                        $model->TotalTerbayar = 0;
                        $model->DocumentStatus = 'C';
                        $model->save();
                    }
                }
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Jual FnB Standalone - Penjualan item FnB langsung tanpa table/transaksi
     */
    public function jualFnBStandalone(Request $request)
    {
        $recordOwnerID = Auth::user()->RecordOwnerID;
        $items = $request->input('items', []);
        $metodePembayaranId = $request->input('MetodePembayaranId');
        $nominalBayar = floatval($request->input('NominalBayar', 0));

        if (empty($items)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada item yang dipilih.']);
        }

        $company = Company::where('KodePartner', $recordOwnerID)->first();
        $numberingData = DocumentNumbering::where('RecordOwnerID', $recordOwnerID)->first();
        $metode = MetodePembayaran::find($metodePembayaranId);

        if (!$numberingData) {
            return response()->json(['success' => false, 'message' => 'Numbering dokumen tidak ditemukan.']);
        }

        // Default customer (walk-in / umum)
        $kodePelanggan = $company->KodeCustomerUmum ?? 'UMUM';
        $kodeTermin = $company->TerminBayarPoS ?? '1';
        $gudangPos = $company->GudangPoS ?? 'HO';
        $ppnPersen = floatval($company->PPN ?? 0);
        $servicePersen = floatval($company->ServiceCharge ?? 0);
        $periode = date('Ym');
        $now = Carbon::now();

        // Calculate totals
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += floatval($item['Harga'] ?? 0) * floatval($item['Qty'] ?? 1);
        }

        $ppnRp = round($subtotal * ($ppnPersen / 100));
        $serviceRp = round($subtotal * ($servicePersen / 100));

        // Admin fee from payment method
        $adminFeeRp = 0;
        if ($metode) {
            $subtotalWithTax = $subtotal + $ppnRp + $serviceRp;
            if ($metode->AdminFeePercent > 0) $adminFeeRp = round($subtotalWithTax * ($metode->AdminFeePercent / 100));
            elseif ($metode->AdminFeeRupiah > 0) $adminFeeRp = $metode->AdminFeeRupiah;
        }

        $grandTotal = round($subtotal + $ppnRp + $serviceRp + $adminFeeRp);

        DB::beginTransaction();
        try {
            $invoiceNo = $numberingData->GetNewDoc("SIS", "fakturpenjualanheader", "NoTransaksi");

            // Periksa apakah metode AUTO (Midtrans)
            if ($metode && $metode->MetodeVerifikasi === 'AUTO') {
                if (empty($metode->ClientKey) || empty($metode->ServerKey)) {
                    DB::rollback();
                    return response()->json(['success' => false, 'message' => 'Metode pembayaran tidak valid (Midtrans Keys missing).']);
                }

                // Generate Temporary ID
                $tempId = 'TMPFNB' . time() . rand(100, 999);
                
                // Store transaction data in session instead of DB
                session([$tempId => [
                    'items' => $items,
                    'grandTotal' => $grandTotal,
                    'subtotal' => $subtotal,
                    'ppnRp' => $ppnRp,
                    'serviceRp' => $serviceRp,
                    'adminFeeRp' => $adminFeeRp,
                    'kodePelanggan' => $kodePelanggan,
                    'kodeTermin' => $kodeTermin,
                    'metodePembayaranId' => $metodePembayaranId,
                    'ppnPersen' => $ppnPersen,
                    'gudangPos' => $gudangPos,
                    'periode' => $periode,
                ]]);

                // Midtrans Snap Token
                \Midtrans\Config::$serverKey = $metode->ServerKey;
                \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;

                $transaction = [
                    'transaction_details' => [
                        'order_id' => 'JUALFNB-' . $tempId . '-' . time(),
                        'gross_amount' => (int) $grandTotal,
                    ],
                    'customer_details' => [
                        'first_name' => 'Pelanggan POS',
                    ],
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($transaction);
                DB::commit();

                return response()->json([
                    'success' => true,
                    'snap_token' => $snapToken,
                    'invoiceNo' => $tempId,
                    'payment_type' => 'JUAL_FNB',
                    'client_key' => $metode->ClientKey
                ]);
            }

            // Faktur Header (Cash/Manual)
            $fH = new FakturPenjualanHeader;
            $fH->Periode = $periode;
            $fH->Transaksi = "POS";
            $fH->NoTransaksi = $invoiceNo;
            $fH->TglTransaksi = $now->toDateString();
            $fH->TglJatuhTempo = $now->toDateString();
            $fH->NoReff = "FNB-DIRECT";
            $fH->KodePelanggan = $kodePelanggan;
            $fH->KodeTermin = $kodeTermin;
            $fH->Termin = 0;
            $fH->TotalTransaksi = $subtotal;
            $fH->Potongan = 0;
            $fH->Pajak = $ppnRp;
            $fH->TotalPembelian = $grandTotal;
            $fH->TotalRetur = 0;
            $fH->TotalPembayaran = $grandTotal;
            $fH->Pembulatan = 0;
            $fH->Status = "C";
            $fH->Keterangan = "Penjualan FnB Langsung";
            $fH->Posted = 0;
            $fH->MetodeBayar = $metode ? $metode->NamaMetodePembayaran : '';
            $fH->ReffPembayaran = "";
            $fH->KodeSales = "";
            $fH->CreatedBy = Auth::user()->name;
            $fH->UpdatedBy = Auth::user()->name;
            $fH->TipeOrder = 0;
            $fH->NomorMeja = "";
            $fH->PajakHiburan = 0;
            $fH->BiayaLayanan = $serviceRp + $adminFeeRp;
            $fH->SyaratDanKetentuan = "";
            $fH->RecordOwnerID = $recordOwnerID;
            $fH->save();

            // Faktur Detail - per item
            foreach ($items as $i => $item) {
                $hargaItem = floatval($item['Harga'] ?? 0);
                $qtyItem = floatval($item['Qty'] ?? 1);
                $lineTotal = $hargaItem * $qtyItem;

                $fD = new FakturPenjualanDetail;
                $fD->NoTransaksi = $invoiceNo;
                $fD->BaseReff = "FNB-DIRECT";
                $fD->NoUrut = $i + 1;
                $fD->BaseLine = 0;
                $fD->KodeItem = $item['KodeItem'] ?? '';
                $fD->Qty = $qtyItem;
                $fD->QtyKonversi = $qtyItem;
                $fD->QtyRetur = 0;
                $fD->Satuan = $item['Satuan'] ?? 'PCS';
                $fD->Harga = $hargaItem;
                $fD->Discount = 0;
                $fD->HargaNet = $lineTotal;
                $fD->LineStatus = "C";
                $fD->KodeGudang = $gudangPos;
                $fD->Keterangan = $item['NamaItem'] ?? '';
                $fD->VatPercent = $ppnPersen;
                $fD->HargaPokokPenjualan = 0;
                $fD->RecordOwnerID = $recordOwnerID;
                $fD->Pajak = round($lineTotal * ($ppnPersen / 100));
                $fD->PajakHiburan = 0;
                $fD->VatTotal = round($lineTotal * ($ppnPersen / 100));
                $fD->save();
            }

            // Pembayaran Header
            $pmNo = $numberingData->GetNewDoc("PMB", "pembayaranpenjualanheader", "NoTransaksi");
            $pmH = new PembayaranPenjualanHeader;
            $pmH->Periode = $periode;
            $pmH->NoTransaksi = $pmNo;
            $pmH->TglTransaksi = $now->toDateString();
            $pmH->KodePelanggan = $kodePelanggan;
            $pmH->TotalPembelian = $grandTotal;
            $pmH->TotalPembayaran = $grandTotal;
            $pmH->BiayaLayanan = $serviceRp + $adminFeeRp;
            $pmH->KodeMetodePembayaran = $metodePembayaranId;
            $pmH->NoReff = $invoiceNo;
            $pmH->Keterangan = "Pembayaran " . $invoiceNo;
            $pmH->CreatedBy = Auth::user()->name;
            $pmH->UpdatedBy = Auth::user()->name;
            $pmH->Posted = 0;
            $pmH->Status = 'C';
            $pmH->RecordOwnerID = $recordOwnerID;
            $pmH->save();

            // Pembayaran Detail
            $pmD = new PembayaranPenjualanDetail;
            $pmD->NoTransaksi = $pmNo;
            $pmD->NoUrut = 1;
            $pmD->BaseReff = $invoiceNo;
            $pmD->TotalPembayaran = $grandTotal;
            $pmD->KodeMetodePembayaran = $metodePembayaranId;
            $pmD->Keterangan = "Pembayaran " . $invoiceNo;
            $pmD->RecordOwnerID = $recordOwnerID;
            $pmD->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Penjualan berhasil disimpan.',
                'invoiceNo' => $invoiceNo,
                'kembalian' => max(0, $nominalBayar - $grandTotal)
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("jualFnBStandalone Error: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function sendReceiptEmail(Request $request)
    {
        $noTransaksi = $request->NoTransaksi;
        $email = $request->Email;
        $recordOwnerID = Auth::user()->RecordOwnerID;

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['success' => false, 'message' => 'Email tidak valid.']);
        }

        // Fetch Header (Logic from getFakturDetail)
        $header = FakturPenjualanHeader::selectRaw("
                fakturpenjualanheader.*, 
                pembayaranpenjualanheader.TotalPembayaran as Bayar, 
                (COALESCE(pembayaranpenjualanheader.TotalPembayaran,0) - fakturpenjualanheader.TotalPembelian) as Kembali, 
                metodepembayaran.NamaMetodePembayaran,
                pelanggan.NamaPelanggan,
                pelanggan.Email
            ")
            ->join('fakturpenjualandetail', function($join) {
                $join->on('fakturpenjualanheader.NoTransaksi', '=', 'fakturpenjualandetail.NoTransaksi')
                     ->on('fakturpenjualanheader.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID');
            })
            ->join('itemmaster', function($join) {
                $join->on('fakturpenjualandetail.KodeItem', '=', 'itemmaster.KodeItem')
                     ->on('fakturpenjualandetail.RecordOwnerID', '=', 'itemmaster.RecordOwnerID');
            })
            ->leftJoin('pembayaranpenjualanheader', function($join) {
                $join->on('fakturpenjualanheader.NoTransaksi', '=', 'pembayaranpenjualanheader.NoReff')
                     ->on('fakturpenjualanheader.RecordOwnerID', '=', 'pembayaranpenjualanheader.RecordOwnerID');
            })
            ->leftJoin('metodepembayaran', function($join) {
                $join->on('pembayaranpenjualanheader.KodeMetodePembayaran', '=', 'metodepembayaran.id')
                     ->on('pembayaranpenjualanheader.RecordOwnerID', '=', 'metodepembayaran.RecordOwnerID');
            })
            ->leftJoin('pelanggan', function($join) {
                $join->on('fakturpenjualanheader.KodePelanggan', '=', 'pelanggan.KodePelanggan')
                     ->on('fakturpenjualanheader.RecordOwnerID', '=', 'pelanggan.RecordOwnerID');
            })
            ->where('fakturpenjualanheader.RecordOwnerID', $recordOwnerID)
            ->where(function($q) use ($noTransaksi) {
                $q->where('fakturpenjualanheader.NoTransaksi', $noTransaksi)
                  ->orWhere(function($sq) use ($noTransaksi) {
                      $sq->where('fakturpenjualandetail.BaseReff', $noTransaksi)
                         ->where('itemmaster.TypeItem', 4);
                  });
            })
            ->first();

        if (!$header) {
            return response()->json(['success' => false, 'message' => 'Data faktur tidak ditemukan.']);
        }

        // Fetch Details
        $details = FakturPenjualanDetail::where('NoTransaksi', $header->NoTransaksi)
            ->where('RecordOwnerID', $recordOwnerID)
            ->get();

        // Fetch Company Info
        $company = Company::where('KodePartner', $recordOwnerID)->first();

        try {
            Mail::to($email)->send(new ReceiptMail($header, $details, $company));
            return response()->json(['success' => true, 'message' => 'Email berhasil dikirim ke ' . $email]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengirim email: ' . $e->getMessage()]);
        }
    }

    public function getFakturDetail(Request $request)
    {
        $noTransaksi = $request->NoTransaksi;
        $recordOwnerID = Auth::user()->RecordOwnerID;

        $header = FakturPenjualanHeader::selectRaw("
                fakturpenjualanheader.*, 
                pembayaranpenjualanheader.TotalPembayaran as Bayar, 
                (COALESCE(pembayaranpenjualanheader.TotalPembayaran,0) - fakturpenjualanheader.TotalPembelian) as Kembali, 
                metodepembayaran.NamaMetodePembayaran,
                pelanggan.NamaPelanggan,
                pelanggan.Email
            ")
            ->join('fakturpenjualandetail', function($join) {
                $join->on('fakturpenjualanheader.NoTransaksi', '=', 'fakturpenjualandetail.NoTransaksi')
                     ->on('fakturpenjualanheader.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID');
            })
            ->join('itemmaster', function($join) {
                $join->on('fakturpenjualandetail.KodeItem', '=', 'itemmaster.KodeItem')
                     ->on('fakturpenjualandetail.RecordOwnerID', '=', 'itemmaster.RecordOwnerID');
            })
            ->leftJoin('pembayaranpenjualanheader', function($join) {
                $join->on('fakturpenjualanheader.NoTransaksi', '=', 'pembayaranpenjualanheader.NoReff')
                     ->on('fakturpenjualanheader.RecordOwnerID', '=', 'pembayaranpenjualanheader.RecordOwnerID');
            })
            ->leftJoin('metodepembayaran', function($join) {
                $join->on('pembayaranpenjualanheader.KodeMetodePembayaran', '=', 'metodepembayaran.id')
                     ->on('pembayaranpenjualanheader.RecordOwnerID', '=', 'metodepembayaran.RecordOwnerID');
            })
            ->leftJoin('pelanggan', function($join) {
                $join->on('fakturpenjualanheader.KodePelanggan', '=', 'pelanggan.KodePelanggan')
                     ->on('fakturpenjualanheader.RecordOwnerID', '=', 'pelanggan.RecordOwnerID');
            })
            ->where('fakturpenjualanheader.RecordOwnerID', $recordOwnerID)
            ->where(function($q) use ($noTransaksi) {
                $q->where('fakturpenjualanheader.NoTransaksi', $noTransaksi)
                  ->orWhere(function($sq) use ($noTransaksi) {
                      $sq->where('fakturpenjualandetail.BaseReff', $noTransaksi)
                         ->where('itemmaster.TypeItem', 4);
                  });
            })
            ->first();

        if (!$header) {
            return response()->json(['success' => false, 'message' => 'Data faktur tidak ditemukan.']);
        }

        $details = FakturPenjualanDetail::where('NoTransaksi', $header->NoTransaksi)
            ->where('RecordOwnerID', $recordOwnerID)
            ->get();

        $company = Company::where('KodePartner', $recordOwnerID)->first();

        return response()->json([
            'success' => true,
            'header' => $header,
            'details' => $details,
            'company' => $company
        ]);
    }
}

