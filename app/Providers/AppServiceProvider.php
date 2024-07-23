<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use View;

// Models
use App\Models\Company;
use App\Models\User;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\roles;
use App\Models\UserRole;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view)
        {
            // $navbars = Navbar::orderBy('ordering')->get();
            
            if (Auth::check()) {

                $oMenu = array();

                $oObject = UserRole::selectRaw("permission.*")
                            ->Join("permissionrole", function ($value)
                            {
                                $value->on("userrole.roleid","=","permissionrole.roleid")
                                        ->on("userrole.RecordOwnerID",'=', "permissionrole.RecordOwnerID");
                            })
                            ->Join("permission","permission.id","=","permissionrole.permissionid")
                            ->Join("users",function($value){
                                $value->on("userrole.userid","=","users.id")
                                        ->on("userrole.RecordOwnerID","=","users.RecordOwnerID");
                            })
                            ->leftJoin('company','permissionrole.RecordOwnerID', 'company.KodePartner')
                            ->Join('subscriptiondetail', function ($value){
                                $value->on('permission.id','=','subscriptiondetail.PermissionID')
                                ->on('subscriptiondetail.NoTransaksi','=','company.KodePaketLangganan');
                            })
                            ->where("users.email","=",Auth::user()->email)
                            ->where("users.RecordOwnerID","=",Auth::user()->RecordOwnerID)
                            // ->where("permission.MenuInduk","=","0")
                            ->where("permission.Status","=","1")
                            ->where("permission.Level","=","1")
                            ->orderBy("permission.Order","asc")
                            ->get();

                foreach ($oObject as $item) {
                    $temp = array();

                    $temp['PermissionName'] = $item->PermissionName;
                    $temp['Link'] = $item->Link;
                    $temp['Icon'] = $item->Icon;
                    $temp['ParentType'] = $item->SubMenu;

                    // Level 2
                    $dt2 = UserRole::selectRaw("permission.*")
                            ->Join("permissionrole", function ($value)
                            {
                                $value->on("userrole.roleid","=","permissionrole.roleid")
                                        ->on("userrole.RecordOwnerID",'=', "permissionrole.RecordOwnerID");
                            })
                            ->Join("permission","permission.id","=","permissionrole.permissionid")
                            ->Join("users",function($value){
                                $value->on("userrole.userid","=","users.id")
                                        ->on("userrole.RecordOwnerID","=","users.RecordOwnerID");
                            })
                            ->leftJoin('company','permissionrole.RecordOwnerID', 'company.KodePartner')
                            ->Join('subscriptiondetail', function ($value){
                                $value->on('permission.id','=','subscriptiondetail.PermissionID')
                                ->on('subscriptiondetail.NoTransaksi','=','company.KodePaketLangganan');
                            })
                            ->where("users.email","=",Auth::user()->email)
                            ->where("users.RecordOwnerID","=",Auth::user()->RecordOwnerID)
                            // ->where("permission.MenuInduk","=","0")
                            ->where("permission.Status","=","1")
                            ->where("permission.Level","=","2")
                            ->where("permission.MenuInduk","=",$item->id)
                            ->orderBy("permission.Order","asc")
                            ->get();

                    $array2 = array();
                    foreach ($dt2 as $key2) {
                        $temp2 = array();
                        $temp2['PermissionName'] = $key2->PermissionName;
                        $temp2['Link'] = $key2->Link;
                        $temp2['Icon'] = $key2->Icon;
                        $temp2['ParentType'] = $key2->SubMenu;


                        // Level 3

                        $dt3 = UserRole::selectRaw("permission.*")
                                ->Join("permissionrole", function ($value)
                                {
                                    $value->on("userrole.roleid","=","permissionrole.roleid")
                                            ->on("userrole.RecordOwnerID",'=', "permissionrole.RecordOwnerID");
                                })
                                ->Join("permission","permission.id","=","permissionrole.permissionid")
                                ->Join("users",function($value){
                                    $value->on("userrole.userid","=","users.id")
                                            ->on("userrole.RecordOwnerID","=","users.RecordOwnerID");
                                })
                                ->leftJoin('company','permissionrole.RecordOwnerID', 'company.KodePartner')
                                ->Join('subscriptiondetail', function ($value){
                                    $value->on('permission.id','=','subscriptiondetail.PermissionID')
                                    ->on('subscriptiondetail.NoTransaksi','=','company.KodePaketLangganan');
                                })
                                ->where("users.email","=",Auth::user()->email)
                                ->where("users.RecordOwnerID","=",Auth::user()->RecordOwnerID)
                                // ->where("permission.MenuInduk","=","0")
                                ->where("permission.Status","=","1")
                                ->where("permission.Level","=","3")
                                ->where("permission.MenuInduk","=",$key2->id)
                                ->orderBy("permission.Order","asc")
                                ->get();

                        $array3 = array();
                        foreach ($dt3 as $key3) {
                            $temp3 = array();
                            $temp3['PermissionName'] = $key3->PermissionName;
                            $temp3['Link'] = $key3->Link;
                            $temp3['Icon'] = $key3->Icon;
                            $temp3['ParentType'] = $key3->SubMenu;

                            array_push($array3, $temp3);
                        }
                        
                        $temp2['submenu'] = $array3;

                        array_push($array2, $temp2);
                    }

                    $temp['submenu'] = $array2;


                    array_push($oMenu, $temp);
                }

                // var_dump($oMenu);

                $view->with('navbars', $oMenu);

                
            }
            else{
                // throw new \Exception('Partner tidak ditemukan, Silahkan Hubungi Operator');
                return redirect('/');
            }
        });
    }
}
