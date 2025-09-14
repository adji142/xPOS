<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\Roles;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Sales;

class UserController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeUser','NamaUser'];
        $keyword = $request->input('keyword');
        $KelompokAkses = $request->input('KelompokAkses');
        $StatusUser = $request->input('StatusUser');

        $sql = "users.id, users.name, users.email, CASE WHEN users.Active = 'Y' THEN 'Aktif' ELSE 'Tidak Aktif' END StatusUser, roles.RoleName";

        $users = User::selectRaw($sql)
				->leftJoin('userrole','users.id','=','userrole.userid')
				->leftJoin('roles','roles.id','=','userrole.roleid')
                ->where('users.RecordOwnerID','=',Auth::user()->RecordOwnerID);

        if ($KelompokAkses != "") {
        	$users->where('roles.id','=', $KelompokAkses);
        }

        if ($StatusUser != "") {
        	$users->where('users.Active','=', $StatusUser);
        }
        $users = $users->paginate(4);

        // KelompokAkses
        $roles = Roles::selectRaw("*")
        		->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $title = 'Delete User !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Auth.User",[
            'users' => $users, 
            'rolesdata' => $roles,
            'oldKelompokAkses' => $KelompokAkses,
            'oldStatusUser' => $StatusUser
        ]);
    }

    public function Form($id = null)
    {
    	$sql = "users.*, roles.id as KelompokAkses,roles.RoleName";
    	$users = User::selectRaw($sql)
			->leftJoin('userrole','users.id','=','userrole.userid')
			->leftJoin('roles','roles.id','=','userrole.roleid')
	        ->where('users.RecordOwnerID','=',Auth::user()->RecordOwnerID)
	        ->where('users.id','=', $id)->get();
        
        $roles = Roles::selectRaw("*")
        		->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        // KodeSales
        $salesdata = Sales::selectRaw("*")
        		->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        return view("master.Auth.User-Input",[
            'users' => $users,
            'rolesdata' => $roles,
            'salesdata' => $salesdata
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());

    	// DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
	            'name' => 'required|string|max:255',
	            'email' => 'required|email|unique:users,email',
	            'password' => 'required|string|min:8|confirmed',
	        ]);

	        // if ($validator->fails()) {
	        //     return redirect()->back()
	        //                 ->withErrors($validator)
	        //                 ->withInput();
	        // }
            
            $KelompokAkses = $request->input('KelompokAkses');


            $save = User::insertGetId([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'Active' => $request->input('Active'),
                'RecordOwnerID' => Auth::user()->RecordOwnerID,
                'BranchID' => '',
                'KodeSales' => $request->input('KodeSales')
            ]);

            if ($save) {
            	if ($KelompokAkses != "") {
            		$model = new UserRole;
            		$model->userid = $save;
            		$model->roleid = $KelompokAkses;
            		$model->RecordOwnerID = Auth::user()->RecordOwnerID;

            		$saveRole = $model->save();
            		if (!$saveRole) {
            			throw new \Exception('Gagal Menyimpan Data Akses');
            			goto jump;
            		}
            	}

                alert()->success('Success','Data User Berhasil disimpan.');
                return redirect('user');
                jump:
            }else{
                throw new \Exception('Penambahan Data Gagal');
                // DB::rollback();
            }

            
            // DB::commit();
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            // DB::rollback();
            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'name' => 'required|string|max:255',
	            'email' => 'required|email',
            ]);

            $model = User::where('id','=',$request->input('id'));
            $KelompokAkses = $request->input('KelompokAkses');

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');

                \App\Services\DBLogger::update('users', ['id' => $request->input('id'), 'RecordOwnerID' => Auth::user()->RecordOwnerID], [
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'Active' => $request->input('Active'),
                    'KodeSales' => $request->input('KodeSales')
                ]);

                if ($KelompokAkses != "") {

                    \App\Services\DBLogger::update('userrole', ['userid' => $request->input('id'), 'RecordOwnerID' => Auth::user()->RecordOwnerID], [
                        'roleid' => $KelompokAkses
                    ]);

            		// if (!$saveRole) {
            		// 	throw new \Exception('Gagal Menyimpan Data Akses');
            		// 	// DB::rollback();
            		// 	goto jump;
            		// }
            	}
                alert()->success('Success','Data User berhasil disimpan.');
                return redirect('user');
                jump:
            } else{
                throw new \Exception('Grup User not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function deletedata(Request $request)
    {
        $users = DB::table('users')
                ->where('KodeUser','=', $request->id)
                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                ->delete();

        if ($users) {
        	alert()->success('Success','Delete User berhasil.');
        }
        else{
        	alert()->error('Error','Delete User Gagal.');
        }
        return redirect('users');
    }
    public function Export()
    {
        return Excel::download(new UserExport(), 'Daftar User.xlsx');
    }
}
