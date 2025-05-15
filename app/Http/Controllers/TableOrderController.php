<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\TableOrderHeader;
use App\Models\TableOrderFnB;
use App\Models\TitikLampu;
use App\Models\Paket;
use App\Models\Company;
use App\Models\Sales;
use App\Models\Pelanggan;
use App\Models\DocumentNumbering;
use App\Models\MetodePembayaran;
use App\Models\ItemMaster;

class TableOrderController extends Controller
{
    public function View(Request $request)
    {
        $paket = Paket::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

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
                            COALESCE(bookingtableonline.Keterangan,'') AS BookingPaymentReffNumber
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
                        ->where('titiklampu.RecordOwnerID', '=', Auth::user()->RecordOwnerID)->get();
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
        ]);
    }

    public function store(Request $request) {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $this->validate($request, [
            'JenisPaket'=>'required',
            'paketid'=>'required',
            'tableid'=>'required',
            'KodeSales'=>'required',
            'DurasiPaket'=>'required'
        ]);

        try {
            $currentDate = Carbon::now();
			$Year = $currentDate->format('Y');
			$Month = $currentDate->format('m');

			$numberingData = new DocumentNumbering();
	        $NoTransaksi = $numberingData->GetNewDoc("TRDR","tableorderheader","NoTransaksi");


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
            $model->JamMulai = Carbon::now();
            if ($request->input('JenisPaket') != 'MENIT') {
                $model->JamSelesai = $currentDate->addHours($request->input('DurasiPaket'));
                // var_dump($currentDate->addHours($request->input('DurasiPaket')));
            }
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

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
            $model = TableOrderHeader::where('NoTransaksi','=',$request->input('txtNoTransaksi_CheckOut'))
                        ->where('RecordOwnerID','=', Auth::user()->RecordOwnerID);

            if ($model) {
                $update = DB::table('tableorderheader')
                            ->where('NoTransaksi','=', $request->input('txtNoTransaksi_CheckOut'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'Status' => '-1',
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
                                    'Status' => '2'
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
                        $data['message'] = "Menyimpan Data " . dt["NamaItem"] . " Gagal dilakukan";
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
}
