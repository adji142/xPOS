<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\SubscriptionHeader;
use App\Models\SubscriptionDetail;
use App\Models\SubscriptionImage;

use App\Models\Roles;
use App\Models\PermissionRole;
use App\Models\UserRole;
use App\Models\Permission;

class SubscriptionController extends Controller
{
    public function View(Request $request){
        $subscriptionheader = SubscriptionHeader::all();
        return view("Admin.Subscription",[
            'subscriptionheader' => $subscriptionheader
        ]);
    }

    public function Form($NoTransaksi = null)
    {   
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $permission = Permission::all();
        $subscriptionheader = SubscriptionHeader::where('NoTransaksi', $NoTransaksi)->get();
        $subscriptiondetail = SubscriptionDetail::where('NoTransaksi', $NoTransaksi)->get();

        $oMenu = array();
        $data = "hai ini data";
        $permissionrole = Permission::selectRaw("permission.*,COALESCE(subscriptiondetail.PermissionID,'') roleid")
                        ->leftJoin('subscriptiondetail', function ($value) use($NoTransaksi){
                            $value->on('permission.id','=','subscriptiondetail.PermissionID')
                            ->on('subscriptiondetail.NoTransaksi','=',DB::raw("'".$NoTransaksi."'"));
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

            $dt2 = Permission::selectRaw("permission.*,COALESCE(subscriptiondetail.PermissionID,'') roleid")
                    ->leftJoin('subscriptiondetail', function ($value) use($NoTransaksi){
                        $value->on('permission.id','=','subscriptiondetail.PermissionID')
                        ->on('subscriptiondetail.NoTransaksi','=',DB::raw("'".$NoTransaksi."'"));
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

                $dt3 = Permission::selectRaw("permission.*,COALESCE(subscriptiondetail.PermissionID,'') roleid")
                    ->leftJoin('subscriptiondetail', function ($value) use($NoTransaksi){
                        $value->on('permission.id','=','subscriptiondetail.PermissionID')
                        ->on('subscriptiondetail.NoTransaksi','=',DB::raw("'".$NoTransaksi."'"));
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

        return view("Admin.Subscription-Input",[
            'permissionrole' => $oMenu,
            'permission' => $permission,
            'subscriptionheader' => $subscriptionheader,
            'subscriptiondetail' => $subscriptiondetail
        ]);
    }

    public function storeJson(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
	    Log::debug($request->all());
	    DB::beginTransaction();

	    $errorCount = 0;
	    $jsonData = $request->json()->all();

        try {
            $model = new SubscriptionHeader;

            $model->NoTransaksi = $jsonData['NoTransaksi'];
            $model->Tanggal = $jsonData['Tanggal'];
            $model->NamaSubscription = $jsonData['NamaSubscription'];
            $model->DeskripsiSubscription = $jsonData['DeskripsiSubscription'];
            $model->Harga = $jsonData['Harga'];
            $model->LamaSubsription = $jsonData['LamaSubsription'];
            $model->AllowAccounting = $jsonData['AllowAccounting'];
            $model->AllowPesananMeja = $jsonData['AllowPesananMeja'];
            $model->AllowPaymentGateway = $jsonData['AllowPaymentGateway'];
            $model->AllowKatalogOnline = $jsonData['AllowKatalogOnline'];

            $save = $model->save();

			if (!$save) {
           		$data['message'] = "Gagal Menyimpan Data Produk Berlangganan";
           		$errorCount += 1;
           		goto jump;
			}
            
            $NoUrut = 0;
            foreach ($jsonData['Detail'] as $key) {
                $modelDetail = new SubscriptionDetail;

                $modelDetail->NoTransaksi = $jsonData['NoTransaksi'];
                $modelDetail->NoUrut = $NoUrut;
                $modelDetail->PermissionID = $key['PermissionID'];

                $save = $modelDetail->save();
				if (!$save) {
					$data['message'] = "Gagal Menyimpan Data Detail di Row ".$NoUrut;
					$errorCount += 1;
					goto jump;
				}

                $NoUrut+=1;
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
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function editJson(Request $request){
        Log::debug($request->all());
		DB::beginTransaction();

		$errorCount = 0;
		$jsonData = $request->json()->all();

        try {
            $model = SubscriptionHeader::where('NoTransaksi','=',$jsonData['NoTransaksi']);

            if ($model) {
                $update = DB::table('subscriptionheader')
                           ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
                           ->update(
                               [
                                    'Tanggal' => $jsonData['Tanggal'],
									'NamaSubscription' => $jsonData['NamaSubscription'],
									'DeskripsiSubscription' => $jsonData['DeskripsiSubscription'],
									'Harga' => $jsonData['Harga'],
									'LamaSubsription' => $jsonData['LamaSubsription'],
									'AllowAccounting' => $jsonData['AllowAccounting'],
									'AllowPesananMeja' => $jsonData['AllowPesananMeja'],
									'AllowPaymentGateway' => $jsonData['AllowPaymentGateway'],
                               ]
                           );

                $delete = DB::table('subscriptiondetail')
                    ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
                    ->delete();
                
                $NoUrut = 0;
                foreach ($jsonData['Detail'] as $key) {
                    $modelDetail = new SubscriptionDetail;
    
                    $modelDetail->NoTransaksi = $jsonData['NoTransaksi'];
                    $modelDetail->NoUrut = $NoUrut;
                    $modelDetail->PermissionID = $key['PermissionID'];
    
                    $save = $modelDetail->save();
                    if (!$save) {
                        $data['message'] = "Gagal Menyimpan Data Detail di Row ".$NoUrut;
                        $errorCount += 1;
                        goto jump;
                    }
    
                    $NoUrut+=1;
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
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }
}
