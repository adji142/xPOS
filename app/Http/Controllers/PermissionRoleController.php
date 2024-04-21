<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Role;
use App\Models\PermissionRole;

class PermissionPermissionRoleController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['id','NamaPermissionRole'];
        $keyword = $request->input('keyword');

        $sql = "*";

        $roles = Role::selectRaw($sql)
        		->where('permissionrole.RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $roles = $roles->paginate(4);

        $title = 'Delete PermissionRole !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Auth.PermissionRole",[
            'roles' => $roles, 
        ]);
    }

    public function Form($id = null)
    {
    	$permissionrole = PermissionRole::where('id','=',$id)->get();
        
        return view("master.Auth.PermissionRole-Input",[
            'permissionrole' => $permissionrole
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'RoleName'=>'required',
            ]);

            $model = new PermissionRole;
			$model->RoleName = $request->input('RoleName');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data PermissionRole Berhasil disimpan.');
                return redirect('permissionrole');
                
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
                'id'=>'required',
                'RoleName'=>'required',
            ]);

            $model = PermissionRole::where('id','=',$request->input('id'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('permissionrole')
                			->where('id','=', $request->input('id'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
									'RoleName' => $request->input('RoleName'),
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data PermissionRole berhasil disimpan.');
                    return redirect('permissionrole');
                }else{
                    throw new \Exception('Edit PermissionRole Gagal');
                }
            } else{
                throw new \Exception('Grup PermissionRole not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function deletedata(Request $request)
    {

    	$permissionrole = PermissionRole::where('roleid','=',$request->id)
    						->where('RecordOwnerID','=', Auth::user()->RecordOwnerID)->get();

    	if (count($permissionrole) > 0) {
    		alert()->error('Error','Delete Kelompok Akses Gagal, Kelompok Akses Sudah Dipakai di hak akses');
    		goto jump;
    	}

        $permissionrole = DB::table('permissionrole')
                ->where('id','=', $request->id)
                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                ->delete();

        if ($permissionrole) {
        	alert()->success('Success','Delete Kelompok Akses berhasil.');
        }
        else{
        	alert()->error('Error','Delete Kelompok Akses Gagal.');
        }

        jump:
        return redirect('permissionrole');
    }
    public function Export()
    {
        return Excel::download(new PermissionRoleExport(), 'Daftar PermissionRole.xlsx');
    }
}
