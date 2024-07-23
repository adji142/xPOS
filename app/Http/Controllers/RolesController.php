<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Roles;
use App\Models\PermissionRole;
use App\Models\UserRole;
use App\Models\Permission;

class RolesController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['id','NamaRoles'];
        $keyword = $request->input('keyword');

        $sql = "*";

        $roles = Roles::selectRaw($sql)
        		->where('roles.RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $roles = $roles->paginate(4);

        $title = 'Delete Roles !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Auth.Roles",[
            'roles' => $roles, 
        ]);
    }

    public function Form($id = null)
    {
    	$roles = Roles::where('id','=',$id)->get();
        $permission = Permission::all();
        
        // PermissionRoles
        $userrole = UserRole::where('userid','=', Auth::user()->id)
                    ->where('RecordOwnerID','=', Auth::user()->RecordOwnerID)->first();

        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $oMenu = array();
        $data = "hai ini data";
        $permissionrole = Permission::selectRaw("permission.*,COALESCE(permissionrole.roleid,'') roleid")
                        ->leftJoin('permissionrole', function ($value) use($id, $RecordOwnerID){
                            $value->on('permission.id','=','permissionrole.permissionid')
                            ->on('permissionrole.roleid','=',DB::raw("'".$id."'"))
                            ->on('permissionrole.RecordOwnerID','=',DB::raw("'".$RecordOwnerID."'"));
                        })
                        ->leftJoin('company','permissionrole.RecordOwnerID', 'company.KodePartner')
                        ->Join('subscriptiondetail', function ($value){
                            $value->on('permission.id','=','subscriptiondetail.PermissionID')
                            ->on('subscriptiondetail.NoTransaksi','=','company.KodePaketLangganan');
                        })
                        // ->where('permissionrole.roleid','=',$userrole->roleid)
                        // ->where('permissionrole.RecordOwnerID','=', Auth::user()->RecordOwnerID)
                        ->where("permission.Status","=","1")
                        ->where("permission.Level","=","1")->get();

        foreach ($permissionrole as $lv1) {
            $temp = array();

            $temp['MenuID'] = $lv1->id;
            $temp['PermissionName'] = $lv1->PermissionName;
            $temp['Link'] = $lv1->Link;
            $temp['Icon'] = $lv1->Icon;
            $temp['ParentType'] = $lv1->SubMenu;
            $temp['MenuInduk'] = $lv1->MenuInduk;
            $temp['Selected'] = $lv1->roleid;

            $dt2 = Permission::selectRaw("permission.*,COALESCE(permissionrole.roleid,'') roleid")
                    ->leftJoin('permissionrole', function ($value) use($id, $RecordOwnerID){
                        // var_dump($userrole);
                        $value->on('permission.id','=','permissionrole.permissionid')
                        ->on('permissionrole.roleid','=',DB::raw("'".$id."'"))
                        ->on('permissionrole.RecordOwnerID','=',DB::raw("'".$RecordOwnerID."'"));
                    })
                    ->leftJoin('company','permissionrole.RecordOwnerID', 'company.KodePartner')
                    ->Join('subscriptiondetail', function ($value){
                        $value->on('permission.id','=','subscriptiondetail.PermissionID')
                        ->on('subscriptiondetail.NoTransaksi','=','company.KodePaketLangganan');
                    })
                    // ->where('permissionrole.roleid','=',$userrole->roleid)
                    // ->where('permissionrole.RecordOwnerID','=', Auth::user()->RecordOwnerID)
                    ->where("permission.Status","=","1")
                    ->where("permission.Level","=","2")
                    ->where("permission.MenuInduk","=",$lv1->id)
                    ->get();
            $array2 = array();
            foreach ($dt2 as $lv2) {
                $temp2 = array();
                $temp2['MenuID'] = $lv2->id;
                $temp2['PermissionName'] = $lv2->PermissionName;
                $temp2['Link'] = $lv2->Link;
                $temp2['Icon'] = $lv2->Icon;
                $temp2['ParentType'] = $lv2->SubMenu;
                $temp2['MenuInduk'] = $lv2->MenuInduk;
                $temp2['Selected'] = $lv2->roleid;

                $dt3 = Permission::selectRaw("permission.*,COALESCE(permissionrole.roleid,'') roleid")
                    ->leftJoin('permissionrole', function ($value) use($id, $RecordOwnerID){
                        $value->on('permission.id','=','permissionrole.permissionid')
                        ->on('permissionrole.roleid','=',DB::raw("'".$id."'"))
                        ->on('permissionrole.RecordOwnerID','=',DB::raw("'".$RecordOwnerID."'"));
                    })
                    ->leftJoin('company','permissionrole.RecordOwnerID', 'company.KodePartner')
                    ->Join('subscriptiondetail', function ($value){
                        $value->on('permission.id','=','subscriptiondetail.PermissionID')
                        ->on('subscriptiondetail.NoTransaksi','=','company.KodePaketLangganan');
                    })
                    // ->where('permissionrole.roleid','=',$userrole->roleid)
                    // ->where('permissionrole.RecordOwnerID','=', Auth::user()->RecordOwnerID)
                    ->where("permission.Status","=","1")
                    ->where("permission.Level","=","3")
                    ->where("permission.MenuInduk","=",$lv2->id)
                    ->get();

                $array3 = array();
                foreach ($dt3 as $lv3) {
                    $temp3 = array();
                    $temp3['MenuID'] = $lv3->id;
                    $temp3['PermissionName'] = $lv3->PermissionName;
                    $temp3['Link'] = $lv3->Link;
                    $temp3['Icon'] = $lv3->Icon;
                    $temp3['ParentType'] = $lv3->SubMenu;
                    $temp3['MenuInduk'] = $lv2->id;
                    $temp3['Selected'] = $lv3->roleid;

                    array_push($array3, $temp3);
                }
                $temp2['submenu'] = $array3;
                array_push($array2, $temp2);
            }
            $temp['submenu'] = $array2;
            array_push($oMenu, $temp);

        }
        return view("master.Auth.Roles-Input",[
            'roles' => $roles,
            'permissionrole' => $oMenu,
            'permission' => $permission
        ]);
    }

    public function store(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jsonData = $request->json()->all();


        Log::debug($request->all());
        DB::beginTransaction();

        $errorCount = 0;

        try {

            $save = Roles::insertGetId([
                'RoleName' => $jsonData['RoleName'],
                'RecordOwnerID' => Auth::user()->RecordOwnerID
            ]);
            // $model = new Roles;
            // $model->RoleName = $jsonData['RoleName'];
            // $model->RecordOwnerID = Auth::user()->RecordOwnerID;
            // $save = $model->save();

            // var_dump($save);

            if ($save) {
                // alert()->success('Success','Data Roles Berhasil disimpan.');
                // return redirect('roles');
                for ($i=0; $i < count($jsonData['permissionrole']) ; $i++) {
                    $akses = new PermissionRole;
                    $akses->roleid = $save;
                    $akses->permissionid = $jsonData['permissionrole'][$i]['id'];
                    $akses->RecordOwnerID = Auth::user()->RecordOwnerID;

                    $aksessave = $akses->save();

                    if (!$aksessave) {
                        $data['message'] = "Gagal Simpan Data Akses";
                        $errorCount +=1;
                        goto jump;
                    }
                }
            }else{
                $errorCount += 1;
                $data['message'] = "Gagal Simpan Data Kelompok Akses";
                goto jump;
                // throw new \Exception('Penambahan Data Gagal');
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
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['success'] = false;
            $data['message'] = "Gagal Simpan Data ". $e->getMessage();
            // $errorCount += 1;
            // alert()->error('Error',$e->getMessage());
            // goto jump;
            // return redirect()->back();
        }

        return response()->json($data);
    }

    public function edit(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jsonData = $request->json()->all();


        Log::debug($request->all());
        DB::beginTransaction();

        $errorCount = 0;

        try {

            $update = DB::table('roles')
                    ->where('id','=', $jsonData['id'])
                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->update(
                        [
                            'RoleName' => $jsonData['RoleName']
                        ]
                    );

            $delete = DB::table('permissionrole')
            ->where('roleid','=', $jsonData['id'])
            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
            ->delete();

            // if(!$delete){
            //     $errorCount +=1;
            //     $data['message'] = "Gagal Delete Data Akses";   
            // }
            // alert()->success('Success','Data Roles Berhasil disimpan.');
            // return redirect('roles');
            for ($i=0; $i < count($jsonData['permissionrole']) ; $i++) {
                $akses = new PermissionRole;
                $akses->roleid = $jsonData['id'];
                $akses->permissionid = $jsonData['permissionrole'][$i]['id'];
                $akses->RecordOwnerID = Auth::user()->RecordOwnerID;

                $aksessave = $akses->save();

                if (!$aksessave) {
                    $data['message'] = "Gagal Simpan Data Akses";
                    $errorCount +=1;
                    goto jump;
                }
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
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['success'] = false;
            $data['message'] = "Gagal Simpan Data ". $e->getMessage();
            // $errorCount += 1;
            // alert()->error('Error',$e->getMessage());
            // goto jump;
            // return redirect()->back();
        }

        return response()->json($data);
    }

    public function deletedata(Request $request)
    {

    	$permissionrole = PermissionRole::where('roleid','=',$request->id)
    						->where('RecordOwnerID','=', Auth::user()->RecordOwnerID)->get();

    	if (count($permissionrole) > 0) {
    		alert()->error('Error','Delete Kelompok Akses Gagal, Kelompok Akses Sudah Dipakai di hak akses');
    		goto jump;
    	}

        $roles = DB::table('roles')
                ->where('id','=', $request->id)
                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                ->delete();

        if ($roles) {
        	alert()->success('Success','Delete Kelompok Akses berhasil.');
        }
        else{
        	alert()->error('Error','Delete Kelompok Akses Gagal.');
        }

        jump:
        return redirect('roles');
    }
    public function Export()
    {
        return Excel::download(new RolesExport(), 'Daftar Roles.xlsx');
    }
}
