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
                        ->where('titiklampu.RecordOwnerID', '=', Auth::user()->RecordOwnerID)
                        ->where(DB::raw("COALESCE(fakturpenjualanheader.NoReff,'POS')"), 'POS')
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
            'oKodeSales' => Auth::user()->KodeSales
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
                        ->where('titiklampu.RecordOwnerID', '=', Auth::user()->RecordOwnerID)
                        ->where(DB::raw("COALESCE(fakturpenjualanheader.NoReff,'POS')"), 'POS')
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
            'oKodeSales' => Auth::user()->KodeSales
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
            $model->TglTransaksi = Carbon::now();
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
            // If not provided (Flexible, or Menit), use NOW.
            if ($request->has('JamMulai') && $request->input('JamMulai') != "") {
                $tgl = $request->input('TglBooking') ?? Carbon::now()->format('Y-m-d');
                $jam = $request->input('JamMulai');
                $model->JamMulai = Carbon::parse($tgl . ' ' . $jam);
            } else {
                $model->JamMulai = Carbon::now();
            }

            if ($request->input('JenisPaket') == 'JAM' || $request->input('JenisPaket') == 'PAKETMEMBER') {
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
            }

            // Future Booking Logic
            // If JamMulai > NOW, force Status to 0 (Booking/Scheduled)
            $now = Carbon::now();
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
            $model = TableOrderHeader::selectRaw("tableorderheader.NoTransaksi,  COALESCE(SUM(tableorderfnb.LineTotal),0) AS totalFNB, COALESCE(SUM(fakturpenjualanheader.TotalPembelian),0) AS TotalCostTable")
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
            if($totalTransaksi > $request->input('TotalPembayaran') || $totalTransaksi == 0 ){
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
                                    'Status' => 0 ,
                                    'JamSelesai' => DB::raw("CASE WHEN '" . $request->input('txtJenisPaket_CheckOut') . "' = 'MENIT' THEN NOW() ELSE JamSelesai END")
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
            }
            else{
                $data['message'] = "Pilih Item terlebih dahulu";
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
                $toleranceTime = $currentDateTime->copy()->subMinutes(30);
                $isPast = $slotDateTime->lt($toleranceTime);
                
                // Check if slot is booked
                // Modify to check overlap:
                // Existing Booking Start < Slot End AND Existing Booking End > Slot Start
                // Also filter by tableid if provided
                $tableId = $request->input('tableid');
                
                $isBooked = false;
                if ($tableId) {
                    $isBooked = TableOrderHeader::whereDate('TglTransaksi', $date)
                        ->whereTime('JamMulai', '<', $slotEnd)
                        ->whereTime('JamSelesai', '>', $slotStart)
                        ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->whereIn('DocumentStatus', ['O', 'D'])
                        ->where('tableid', $tableId)
                        ->exists();

                    if (!$isBooked) {
                         $isBooked = BookingOnline::whereDate('TglBooking', $date)
                            ->whereTime('JamMulai', '<', $slotEnd)
                            ->whereTime('JamSelesai', '>', $slotStart)
                            ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                            ->where('StatusTransaksi', '=', 0) // Confirmed Status 0 is likely active/booked for BookingOnline
                            ->where('mejaID', $tableId)
                            ->exists();
                    }
                }
                
                $slots[] = [
                    'start' => $slotStart,
                    'end' => $slotEnd,
                    'label' => $slotStart . ' - ' . $slotEnd,
                    'available' => !$isPast && !$isBooked,
                    'isPast' => $isPast,
                    'isBooked' => $isBooked
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

        $field = ['tableorderheader.NoTransaksi', 'titiklampu.NamaTitikLampu', 'tableorderheader.JenisPaket'];

        $data = DB::table('tableorderheader')
            ->select('tableorderheader.NoTransaksi', 'tableorderheader.TglTransaksi', 'tableorderheader.JenisPaket', 'tableorderheader.DurasiPaket as Durasi', 'tableorderheader.Status', 'titiklampu.NamaTitikLampu as NamaTable')
            ->join('titiklampu', function($join) {
                $join->on('tableorderheader.tableid', '=', 'titiklampu.id')
                     ->on('tableorderheader.RecordOwnerID', '=', 'titiklampu.RecordOwnerID');
            })
            ->where('tableorderheader.RecordOwnerID', Auth::user()->RecordOwnerID)
            ->whereBetween('tableorderheader.TglTransaksi', [$tglAwal . ' 00:00:00', $tglAkhir . ' 23:59:59']);

        if ($keyword) {
            $data->where(function ($query) use ($keyword, $field) {
                for ($i = 0; $i < count($field); $i++) {
                    $query->orwhere($field[$i], 'like', '%' . $keyword . '%');
                }
            });
        }

        $data->orderBy('tableorderheader.TglTransaksi', 'desc');

        return view("Admin.DaftarTableOrder", [
            'data' => $data->get(),
            'tglAwal' => $tglAwal,
            'tglAkhir' => $tglAkhir,
        ]);
    }

    public function ResetController(Request $request)
    {
        try {
            $NoTransaksi = $request->input('NoTransaksi');
            
            $update = DB::table('tableorderheader')
                ->where('NoTransaksi', $NoTransaksi)
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->update([
                    'Status' => 0,
                    'DocumentStatus' => 'C'
                ]);

            if ($update) {
                alert()->success('Success', 'Controller berhasil direset.');
            } else {
                alert()->error('Error', 'Gagal mereset controller atau data tidak ditemukan.');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            alert()->error('Error', 'Terjadi kesalahan sistem.');
        }

        return redirect()->back();
    }
}
