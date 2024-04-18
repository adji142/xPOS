<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Supplier;
use App\Models\Provinsi;
use App\Exports\SupplierExport;

class SupplierController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeSupplier','NamaSupplier'];
        $keyword = $request->input('keyword');

        $sql = "supplier.*, dem_provinsi.prov_name, dem_kota.city_name, dem_kecamatan.dis_name, dem_kelurahan.subdis_name,CASE WHEN supplier.status = 1 THEN 'ACTIVE' ELSE 'INACTIVE' END StatusRecord";

        $supplier = Supplier::selectRaw($sql)
        				->leftJoin('dem_provinsi','supplier.ProvID','=','dem_provinsi.prov_id')
        				->leftJoin('dem_kota','supplier.KotaID','=','dem_kota.city_id')
        				->leftJoin('dem_kecamatan','supplier.KecID','=','dem_kecamatan.dis_id')
        				->leftJoin('dem_kelurahan','supplier.KelID','=','dem_kelurahan.subdis_id')
        				->where(function ($query) use($keyword, $field) {
		                    for ($i = 0; $i < count($field); $i++){
		                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
		                    }      
		                })->where('supplier.RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $supplier = $supplier->paginate(4);

        $title = 'Delete Supplier !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.BussinessPartner.Supplier",[
            'supplier' => $supplier, 
        ]);
    }

    public function Form($KodeSupplier = null)
    {
    	$supplier = Supplier::where('KodeSupplier','=',$KodeSupplier)->get();
    	$provinsi = Provinsi::all();
        
        return view("master.BussinessPartner.Supplier-Input",[
            'supplier' => $supplier,
            'provinsi' => $provinsi
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaSupplier'=>'required',
                'NoTlp1'=>'required',
            ]);

            $KodeSupplier = "";
            $prefix = "SP";
            $lastNoTrx = Supplier::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
            ->where(DB::raw('LEFT(KodeSupplier,2)'),'=',$prefix)->count()+1;
            $KodeSupplier = $prefix.str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);

            $model = new Supplier;
            $model->KodeSupplier = $KodeSupplier;
			$model->NamaSupplier = $request->input('NamaSupplier');
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
                alert()->success('Success','Data Supplier Berhasil disimpan.');
                return redirect('supplier');
                
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
                'KodeSupplier'=>'required',
                'NamaSupplier'=>'required',
                'NoTlp1'=>'required',
            ]);

            $model = Supplier::where('KodeSupplier','=',$request->input('KodeSupplier'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('supplier')
                			->where('KodeSupplier','=', $request->input('KodeSupplier'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
									'NamaSupplier' => $request->input('NamaSupplier'),
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
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Supplier berhasil disimpan.');
                    return redirect('supplier');
                }else{
                    throw new \Exception('Edit Supplier Gagal');
                }
            } else{
                throw new \Exception('Grup Supplier not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function deletedata(Request $request)
    {
        $supplier = DB::table('supplier')
                ->where('KodeSupplier','=', $request->id)
                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                ->delete();

        if ($supplier) {
        	alert()->success('Success','Delete Supplier berhasil.');
        }
        else{
        	alert()->error('Error','Delete Supplier Gagal.');
        }
        return redirect('supplier');
    }
    public function Export()
    {
        return Excel::download(new SupplierExport(), 'Daftar Supplier.xlsx');
    }
}
