<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\GrupPelanggan;
use App\Models\Pelanggan;
use App\Models\Provinsi;
use App\Exports\PelangganExport;
use App\Models\DocumentNumbering;

class PelangganController extends Controller
{
	public function ReadDemografi(Request $request)
	{
		$data = array('success' => true, 'message'=>'', 'data' => array());

		$Table = $request->input('Table');
		$Field = $request->input('Field');
		$Value = $request->input('Value');

		$demografi = DB::select("SELECT * FROM ".$Table." WHERE ".$Field." = '".$Value."'");

		$data['data'] = $demografi;
		return response()->json($data);
	}
    public function View(Request $request)
    {
    	$field = ['KodePelanggan','NamaPelanggan'];
        $keyword = $request->input('keyword');

        $sql = "pelanggan.*, dem_provinsi.prov_name, dem_kota.city_name, dem_kecamatan.dis_name, dem_kelurahan.subdis_name, gruppelanggan.NamaGrup, CASE WHEN pelanggan.status = 1 THEN 'ACTIVE' ELSE 'INACTIVE' END StatusRecord";

        $pelanggan = Pelanggan::selectRaw($sql)
        				->leftJoin('dem_provinsi','pelanggan.ProvID','=','dem_provinsi.prov_id')
        				->leftJoin('dem_kota','pelanggan.KotaID','=','dem_kota.city_id')
        				->leftJoin('dem_kecamatan','pelanggan.KecID','=','dem_kecamatan.dis_id')
        				->leftJoin('dem_kelurahan','pelanggan.KelID','=','dem_kelurahan.subdis_id')
        				->leftJoin('gruppelanggan', function ($value){
        					$value->on('pelanggan.KodeGrupPelanggan','=','gruppelanggan.KodeGrup')
        					->on('pelanggan.RecordOwnerID','=','gruppelanggan.RecordOwnerID');
        				})
        				->where(function ($query) use($keyword, $field) {
		                    for ($i = 0; $i < count($field); $i++){
		                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
		                    }      
		                })->where('pelanggan.RecordOwnerID','=',Auth::user()->RecordOwnerID);

        // $pelanggan = $pelanggan->paginate(4);

        $title = 'Delete Pelanggan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.BussinessPartner.Pelanggan",[
            'pelanggan' => $pelanggan->get(), 
        ]);
    }

    public function ReadPelangganJson(Request $request)
    {
        $data = array('success'=>false, 'message'=>'', 'data'=>array());

        $KodePelanggan = $request->input('KodePelanggan');
        $GrupPelanggan = $request->input('GrupPelanggan');
        $Search        = $request->input('Search');

        $NoHP          = $request->input('NoTlp1');
        $Email         = $request->input('Email');

        $RecordOwnerID = "";

        if(!empty($request->input('RecordOwnerID'))){
            $RecordOwnerID = $request->input('RecordOwnerID');
        }
        else{
            $RecordOwnerID =    Auth::user()->RecordOwnerID;
        }

        $sql = "pelanggan.*, gruppelanggan.DiskonPersen";
        $pelanggan = Pelanggan::selectRaw($sql)
                        ->leftJoin('gruppelanggan', function ($value){
                            $value->on('pelanggan.KodeGrupPelanggan','=','gruppelanggan.KodeGrup')
                            ->on('pelanggan.RecordOwnerID','=','gruppelanggan.RecordOwnerID');
                        })
                        ->where('pelanggan.RecordOwnerID','=',$RecordOwnerID);

        if ($KodePelanggan != "") {
            $pelanggan->where('pelanggan.KodePelanggan','=',$KodePelanggan);
        }

        if ($GrupPelanggan != "") {
            $pelanggan->where('pelanggan.KodeGrupPelanggan','=',$GrupPelanggan);
        }
        if(!empty($NoHP) ){
            $pelanggan->where('pelanggan.NoTlp1','=',$NoHP);
        }

        if(!empty($Email) ){
            $pelanggan->where('pelanggan.Email','=',$Email);
        }

        if (!empty($Search)) {
            $pelanggan->whereRaw("CONCAT(COALESCE(pelanggan.KodePelanggan,''), ' ' , coalesce(pelanggan.NamaPelanggan,''), ' ', COALESCE(pelanggan.PelangganID,''),' ', COALESCE(pelanggan.Email,''),' ', COALESCE(pelanggan.NoTlp1,'')) LIKE ?", ['%'.$Search.'%']);
        }

        $data['success'] = true;
        $data['data'] = $pelanggan->get();

        return response()->json($data);
    }

    public function Form($KodePelanggan = null)
    {
    	$pelanggan = Pelanggan::where('KodePelanggan','=',$KodePelanggan)->get();
    	$gruppelanggan = GrupPelanggan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
    	$provinsi = Provinsi::all();
        
        return view("master.BussinessPartner.Pelanggan-Input",[
            'pelanggan' => $pelanggan,
            'gruppelanggan' => $gruppelanggan,
            'provinsi' => $provinsi
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaPelanggan'=>'required',
                'KodeGrupPelanggan'=>'required',
            ]);

            $numberingData = new DocumentNumbering();
            $KodePelanggan = $numberingData->GetNewDoc("PLG","pelanggan","KodePelanggan");

            $model = new Pelanggan;
            $model->KodePelanggan = $KodePelanggan;
			$model->NamaPelanggan = $request->input('NamaPelanggan');
			$model->KodeGrupPelanggan = $request->input('KodeGrupPelanggan');
			$model->LimitPiutang = $request->input('LimitPiutang');
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
            $model->PelangganID = $request->input('PelangganID');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;
            $model->AllowedDay = $request->input('AllowedDay');
            $model->ValidUntil = $request->input('ValidUntil');

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Pelanggan Berhasil disimpan.');
                return redirect('pelanggan');
                
            }else{
                throw new \Exception('Penambahan Data Gagal');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function storeJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => 0);
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaPelanggan'=>'required',
                'KodeGrupPelanggan'=>'required',
            ]);

            $numberingData = new DocumentNumbering();
            $KodePelanggan = $numberingData->GetNewDoc("PLG","pelanggan","KodePelanggan");

            $model = new Pelanggan;
            $model->KodePelanggan = $KodePelanggan;
            $model->NamaPelanggan = $request->input('NamaPelanggan');
            $model->KodeGrupPelanggan = $request->input('KodeGrupPelanggan');
            $model->LimitPiutang = $request->input('LimitPiutang');
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
            $model->PelangganID = $request->input('PelangganID');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;
            $model->AllowedDay = $request->input('AllowedDay');
            $model->ValidUntil = $request->input('ValidUntil');

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                $data['message'] = 'Data Pelanggan Berhasil disimpan.';
                $data['LastTRX'] = $KodePelanggan;
                
            }else{
                $data['success'] = false;
                $data['message'] = 'Penambahan Data Gagal';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            $data['success'] = false;
            $data['message'] = 'Penambahan Data Gagal : '.$e->getMessage();
        }
        return response()->json($data);
    }

    public function edit(Request $request)
    {
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodePelanggan'=>'required',
                'NamaPelanggan'=>'required',
                'KodeGrupPelanggan'=>'required',
            ]);

            $model = Pelanggan::where('KodePelanggan','=',$request->input('KodePelanggan'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('pelanggan')
                			->where('KodePelanggan','=', $request->input('KodePelanggan'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
									'NamaPelanggan' => $request->input('NamaPelanggan'),
									'KodeGrupPelanggan' => $request->input('KodeGrupPelanggan'),
									'LimitPiutang' => $request->input('LimitPiutang'),
									'ProvID' => $request->input('ProvID'),
									'KotaID' => $request->input('KotaID'),
									'KelID' => $request->input('KelID'),
									'KecID' => $request->input('KecID'),
									'Email' => $request->input('Email'),
									'NoTlp1' => $request->input('NoTlp1'),
									'NoTlp2' => $request->input('NoTlp2'),
									'Alamat' => $request->input('Alamat'),
									'Keterangan' => $request->input('Keterangan'),
                                    'Status' => $request->input('Status'),
                                    'PelangganID' => $request->input('PelangganID'),
                                    'AllowedDay' => $request->input('AllowedDay'),
                                    'ValidUntil' => $request->input('ValidUntil')
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Pelanggan berhasil disimpan.');
                    return redirect('pelanggan');
                }else{
                    throw new \Exception('Edit Pelanggan Gagal');
                }
            } else{
                throw new \Exception('Grup Pelanggan not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function deletedata(Request $request)
    {
        $pelanggan = DB::table('pelanggan')
                ->where('KodePelanggan','=', $request->id)
                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                ->delete();

        if ($pelanggan) {
        	alert()->success('Success','Delete Pelanggan berhasil.');
        }
        else{
        	alert()->error('Error','Delete Pelanggan Gagal.');
        }
        return redirect('pelanggan');
    }
    public function Export()
    {
        return Excel::download(new PelangganExport(), 'Daftar Pelanggan.xlsx');
    }
}
