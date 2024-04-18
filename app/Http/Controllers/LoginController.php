<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Company;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {

    }
    public function login() {
        return view("auth.login");
    }
    public function action_login(Request $request)
    {
        try {
            $this->validate($request, [
                'email'=>'required',
                'password'=>'required',
            ]);

            $data = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];

            // GetRecordOwnerID

            $RecordOwnerID = "";

            $user = User::where('email', '=', $request->input('email'))->first();
            if ($user) {
            	$RecordOwnerID = $user->RecordOwnerID;
            }

            // Validasi Kode Partner Exist
            $oPartner = Company::where('KodePartner','=',$RecordOwnerID)->first();

            if (!$oPartner) {
                throw new \Exception('Partner tidak ditemukan, Silahkan Hubungi Operator');
                goto jump;
            }

            // Validasi Active Subscription

            $NowDate = Carbon::now()->toDateString();
            $DueDate = Carbon::now()->subDays($oPartner->ExtraDays)->toDateString();

            // $oPartner = DB::tables('company')
            //                 ->whereDate('EndSubs','>',$DueDate)
            //                 ->get();
            $oPartner = Company::where('EndSubs','<',$DueDate);

            if ($oPartner->count() > 0) {
                throw new \Exception('Langganan Telah Habis, Silahkan Melakukan Perpanjangan Langganan');
                goto jump;
            }

            if ($user) {
                if ($user->active == 'N') {
                    throw new \Exception('User tidak aktif !');
                }

                if (Auth::Attempt($data)) {
                    return redirect('dashboard');
                } else{
                    throw new \Exception('Email atau Password Salah');
                }
            } else{
                throw new \Exception('Email tidak ditemukan');
            }

            jump:

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            alert()->info('Info',$e->getMessage());
            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
