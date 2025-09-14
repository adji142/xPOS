<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Sales;
use App\Models\Provinsi;
use App\Exports\SalesExport;

class SalesController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeSales','NamaSales'];
        $keyword = $request->input('keyword');

        $sql = "sales.*, dem_provinsi.prov_name, dem_kota.city_name, dem_kecamatan.dis_name, dem_kelurahan.subdis_name,CASE WHEN sales.status = 1 THEN 'ACTIVE' ELSE 'INACTIVE' END StatusRecord";

        $sales = Sales::selectRaw($sql)
        				->leftJoin('dem_provinsi','sales.ProvID','=','dem_provinsi.prov_id')
        				->leftJoin('dem_kota','sales.KotaID','=','dem_kota.city_id')
        				->leftJoin('dem_kecamatan','sales.KecID','=','dem_kecamatan.dis_id')
        				->leftJoin('dem_kelurahan','sales.KelID','=','dem_kelurahan.subdis_id')
        				->where(function ($query) use($keyword, $field) {
		                    for ($i = 0; $i < count($field); $i++){
		                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
		                    }      
		                })->where('sales.RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $sales = $sales->paginate(4);

        $title = 'Delete Sales !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.BussinessPartner.Sales",[
            'sales' => $sales, 
        ]);
    }

    public function Form($KodeSales = null)
    {
    	$sales = Sales::where('KodeSales','=',$KodeSales)->get();
    	$provinsi = Provinsi::all();
        
        return view("master.BussinessPartner.Sales-Input",[
            'sales' => $sales,
            'provinsi' => $provinsi
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaSales'=>'required',
                'NoTlp1'=>'required',
                'Email'=>'required',
            ]);

            $KodeSales = "";
            $prefix = "SL";
            $lastNoTrx = Sales::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
            ->where(DB::raw('LEFT(KodeSales,2)'),'=',$prefix)->count()+1;
            $KodeSales = $prefix.str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);

            $model = new Sales;
            $model->KodeSales = $KodeSales;
			$model->NamaSales = $request->input('NamaSales');
			$model->ProvID = $request->input('ProvID');
			$model->KotaID = $request->input('KotaID');
			$model->KelID = $request->input('KelID');
			$model->KecID = $request->input('KecID');
			$model->Email = $request->input('Email');
			$model->NoTlp1 = $request->input('NoTlp1');
			$model->NoTlp2 = $request->input('NoTlp2');
			$model->Alamat = $request->input('Alamat');
			$model->Keterangan = $request->input('Keterangan');
            $model->Status = $request->input('Status');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Sales Berhasil disimpan.');
                return redirect('sales');
                
            }else{
                throw new \Exception('Penambahan Data Gagal');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeSales'=>'required',
                'NamaSales'=>'required',
                'NoTlp1'=>'required',
                'Email'=>'required',
            ]);

            $model = Sales::where('KodeSales','=',$request->input('KodeSales'))->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

            if ($model) {
                \App\Services\DBLogger::update('sales', ['KodeSales' => $request->input('KodeSales'), 'RecordOwnerID' => Auth::user()->RecordOwnerID], [
                    'NamaSales' => $request->input('NamaSales'),
                    'ProvID' => $request->input('ProvID'),
                    'KotaID' => $request->input('KotaID'),
                    'KelID' => $request->input('KelID'),
                    'KecID' => $request->input('KecID'),
                    'Email' => $request->input('Email'),
                    'NoTlp1' => $request->input('NoTlp1'),
                    'NoTlp2' => $request->input('NoTlp2'),
                    'Alamat' => $request->input('Alamat'),
                    'Keterangan' => $request->input('Keterangan'),
                    'Status' => $request->input('Status')
                ]);

                alert()->success('Success','Data Sales berhasil disimpan.');
                return redirect('sales');

            } else{
                throw new \Exception('Sales not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function deletedata(Request $request)
    {
        $sales = DB::table('sales')
                ->where('KodeSales','=', $request->id)
                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                ->delete();

        if ($sales) {
        	alert()->success('Success','Delete Sales berhasil.');
        }
        else{
        	alert()->error('Error','Delete Sales Gagal.');
        }
        return redirect('sales');
    }
    public function Export()
    {
        return Excel::download(new SalesExport(), 'Daftar Sales.xlsx');
    }
}
