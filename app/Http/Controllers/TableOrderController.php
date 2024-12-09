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
                            tableorderheader.JamSelesai
                        ")
                        ->leftJoin('tableorderheader', function ($value)  {
                            $value->on('titiklampu.id','=','tableorderheader.tableid')
                            ->on('titiklampu.RecordOwnerID','=','tableorderheader.RecordOwnerID')
                            ->on(DB::raw("DATE_FORMAT(COALESCE(tableorderheader.JamSelesai, now()), '%Y-%m-%d %H:%i')"),'>=',DB::raw("DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i')"));
                        })
                        ->leftJoin('pakettransaksi', function ($value)  {
                            $value->on('tableorderheader.paketid','=','pakettransaksi.id')
                            ->on('tableorderheader.RecordOwnerID','=','pakettransaksi.RecordOwnerID');
                        })
                        ->leftJoin('sales', function ($value)  {
                            $value->on('tableorderheader.KodeSales','=','sales.KodeSales')
                            ->on('tableorderheader.RecordOwnerID','=','sales.RecordOwnerID');
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
        return view("Transaksi.Penjualan.PoS.Billing",[
            'paket' => $paket, 
            'titiklampu' => $titiklampu,
            'titiklampuoption' => $titiklampuoption,
            'company' => $company,
            'sales' => $sales,
            'pelanggan' => $pelanggan
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
            $model->TglTransaksi = $currentDate;
            $model->TglPencatatan = $currentDate;
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
            $model->JamMulai = $currentDate;
            if ($request->input('JenisPaket') != 'MENIT') {
                $model->JamSelesai = $currentDate->addHours($request->input('DurasiPaket'));
            }
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

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
}
