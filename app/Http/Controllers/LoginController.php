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
use App\Models\SubscriptionHeader;
use App\Models\SubscriptionDetail;
use App\Models\SubscriptionImage;
use App\Http\Controllers\InvoicePenggunaController;

use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
use App\Models\Roles;
use App\Models\PermissionRole;
use App\Models\UserRole;
use App\Models\Permission;

use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function __construct()
    {

    }
    public function login() {
        $subscriptionheader = SubscriptionHeader::all();
        return view("auth.login",[
            'subscriptionheader' => $subscriptionheader
        ]);
    }

    public function Register() {
        // dd("Masuk");
        $subscriptionheader = SubscriptionHeader::all();
        $provinsi = Provinsi::all();
        $kota = Kota::all();
        $kelurahan = Kelurahan::all();
        $kecamatan = Kecamatan::all();
        dd($kota);
        return view("auth.register",[
            'subscriptionheader' => $subscriptionheader,
            'provinsi' => $provinsi,
            'kota' => $kota,
            'kelurahan' => $kelurahan,
            'kecamatan' => $kecamatan 
        ]);
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
            // $oPartner = Company::where('EndSubs','<',$DueDate)
                            // ->where('KodePartner', $RecordOwnerID);

            // if ($oPartner->count() > 0 && $RecordOwnerID != "999999") {
            //     throw new \Exception('Langganan Telah Habis, Silahkan Melakukan Perpanjangan Langganan');
            //     goto jump;
            // }

            // $oValidation = $oPartner->first();
            // $oValidation = Company::where('KodePartner','=',$RecordOwnerID)->first();
            // var_dump($oPartner->first());

            if ($oPartner->isSuspended == 1) {
                throw new \Exception('Akun And Kena Suspend Dengan Alasan '.$oPartner->SuspendReason.'. Silahkan Hubungi Administrator');
                goto jump;
            }

            // Cek User Konfirmasi


            if ($user) {
                if ($user->active == 'N') {
                    throw new \Exception('User tidak aktif !');
                    goto jump;
                }
                if ($user->isConfirmed == 0) {
                    throw new \Exception('User Belum Konfirmasi Email !');
                    goto jump;
                }

                if (Auth::Attempt($data)) {
                    if ($RecordOwnerID == "999999") {
                        return redirect('dashboardadmin');
                    }
                    else{
                        if ($oPartner->isActive == 1) {
                            return redirect('dashboard');
                        }
                        else{
                            return redirect('companysetting#invoice');
                        }
                    }
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

    public function API_login(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'token' => "");

        try {
            $this->validate($request, [
                'email'=>'required',
                'password'=>'required',
            ]);

            $userdata = [
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
                $data['message'] = "Partner tidak ditemukan, Silahkan Hubungi Operator";
                // throw new \Exception('Partner tidak ditemukan, Silahkan Hubungi Operator');
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
                // throw new \Exception('Langganan Telah Habis, Silahkan Melakukan Perpanjangan Langganan');
                $data['message'] = "Langganan Telah Habis, Silahkan Melakukan Perpanjangan Langganan";
                goto jump;
            }

            if ($user) {
                if ($user->active == 'N') {
                    // throw new \Exception('User tidak aktif !');
                    $data['message'] = "User tidak aktif !";
                    goto jump;
                }

                if (Auth::Attempt($userdata)) {
                    // $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
                    $data['success'] = true;
                    $data['data'] = $user;
                    // $data['token'] = $token;
                    // return redirect('dashboard');
                } else{
                    $data['message'] = "Email atau Password Salah";
                    // throw new \Exception('Email atau Password Salah');
                }
            } else{
                $data['message'] = "Email tidak ditemukan";
                // throw new \Exception('Email tidak ditemukan');
            }

            jump:

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            // alert()->info('Info',$e->getMessage());
            // return redirect()->back();
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    function actionRegister(Request $request) {
        DB::beginTransaction();
        $errorCount = 0;
        $errorMessage = "";

        try {
            $KodePartner = "";
            $prefix = "CL";
            $lastNoTrx = Company::where(DB::raw('LEFT(KodePartner,2)'),'=',$prefix)->count()+1;
            $KodePartner = $prefix.str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);


            $model = new Company();
            $model->KodePartner = $KodePartner;
            $model->NamaPartner = $request->input('NamaPartner');
            $model->NamaPIC = $request->input('NamaPIC');
            $model->NIKPIC = "-";
            $model->NoHP = $request->input('NoHP');
            $model->NoTlp = $request->input('NoHP');
            $model->ProvID = $request->input('ProvID');
            $model->KotaID = $request->input('KotaID');
            $model->KecID = $request->input('KecID');
            $model->KelID = $request->input('KelID');
            $model->AlamatTagihan = $request->input('AlamatTagihan');
            $model->tempStore = $request->input('password');
            $model->JenisUsaha = $request->input('JenisUsaha');
            $model->KodePaketLangganan = $request->input('ProductSelected');
            // $model->ProductPrice = $request->input('ProductPrice');

            $save = $model->save();

            if (!$save) {
                $errorCount +=1;
                $errorMessage = "Gagal menyimpan data Partner";
            }

            // isi Kelompok Akses
            $saverole = Roles::insertGetId([
                'RoleName' => "SuperAdmin",
                'RecordOwnerID' => $KodePartner
            ]);

            $detailpermission = SubscriptionDetail::where('NoTransaksi',$request->input('ProductSelected'))->get();

            foreach ($detailpermission as $key) {
                $akses = new PermissionRole;
                $akses->roleid = $saverole;
                $akses->permissionid = $key->PermissionID;
                $akses->RecordOwnerID = $KodePartner;
                $aksessave = $akses->save();
            }

            // $akses = new PermissionRole;
            // $akses->roleid = $saverole;
            // $akses->permissionid = 1;
            // $akses->RecordOwnerID = $KodePartner;
            // $aksessave = $akses->save();

            // $akses = new PermissionRole;
            // $akses->roleid = $saverole;
            // $akses->permissionid = 60;
            // $akses->RecordOwnerID = $KodePartner;
            // $aksessave = $akses->save();

            // $akses = new PermissionRole;
            // $akses->roleid = $saverole;
            // $akses->permissionid = 61;
            // $akses->RecordOwnerID = $KodePartner;
            // $aksessave = $akses->save();

            // $akses = new PermissionRole;
            // $akses->roleid = $saverole;
            // $akses->permissionid = 63;
            // $akses->RecordOwnerID = $KodePartner;
            // $aksessave = $akses->save();
            // isi User

            // $KelompokAkses = $request->input('KelompokAkses');

            // uniqid()
            $KonfirmasiID = uniqid();
            $saveUser = User::insertGetId([
                'name' => $request->input('NamaPIC'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'Active' => 'N',
                'RecordOwnerID' => $KodePartner,
                'BranchID' => '',
                'isConfirmed' => 0,
                'KonfirmasiID' => $KonfirmasiID
            ]);

            if ($saveUser) {
            	if ($saverole != "") {
            		$model = new UserRole;
            		$model->userid = $saveUser;
            		$model->roleid = $saverole;
            		$model->RecordOwnerID = $KodePartner;

            		$saveUserRole = $model->save();
            		if (!$saveUserRole) {
            			throw new \Exception('Gagal Menyimpan Data Akses');
            			goto jump;
            		}
            	}
            }else{
                // throw new \Exception('Penambahan Data Gagal');
                $errorCount +=1;
                $errorMessage = "Gagal menyimpan data User";
                goto jump;
                // DB::rollback();
            }


            // Save Invoice
            $oSubs = SubscriptionHeader::where('NoTransaksi',$request->input('ProductSelected'))->first();
            $oDetail = array(
                'NoTransaksi' => '',
                'NoUrut' => -1,
                'Harga' => floatval($oSubs->Harga) - floatval($oSubs->Potongan),
                'Catatan' => "Langganan Perdana",
                'KodePelanggan' => $KodePartner,
            );
            $oObject = array(
                'NoTransaksi' => '',
                'TglTransaksi' => Carbon::now()->format('Y-m-d'),
                'TglJatuhTempo' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'KodePaketLangganan' => $request->input('ProductSelected'),
                'Catatan' => 'Langganan Perdana',
                'KodePelanggan' => $KodePartner,
                'TotalTagihan' => $oSubs->Harga - $oSubs->Potongan,
                'TotalBayar' => 0,
                'Status' => 'O',
                'StartSubs' => Carbon::now()->format('Y-m-d'),
                'EndSubs' => Carbon::now()->format('Y-m-d'),
                'Detail' => $oDetail
            );
            
            $oInv = new InvoicePenggunaController();
            $oSaveINV = $oInv->SaveInvoice($oObject);
            if (!$oSaveINV) {
                $errorCount +=1;
                $errorMessage = "Gagal Menimpan Tagihan ";
                goto jump;
            }

            // Send Email
            $data = [
                'title' => 'Email Konfirmasi',
                'message' => 'Terimakasih telah melakukan pendaftaran di DSTechSmart PoS, Silahkan melakukan konfirmasi Melalui link berikut untuk mulai menggunakan Aplikasi : '. url('/')."/konfirmasi/".$KonfirmasiID
            ];
        
            Mail::to($request->input('email'))->send(new SendMail($data,"Email Konfirmasi"));
        } catch (\Exception $e) {
            $errorCount +=1;
            $errorMessage = "Internal Error: ".$e->getMessage();
        }

        jump:
        if ($errorCount > 0) {
            DB::rollback();
            // throw new \Exception('Proses Gagal');
            alert()->success('Error','Proses Data Gagal '.$errorMessage);
            // var_dump($errorMessage);
        }
        else{
            DB::commit();
            alert()->success('Success','Data Langganan Berhasil disimpan, Silahkan Melakukan Konfirmasi Email dengan klik link yang dikirim di email, Periksa Inbox dan folder Spam / junk');
            return redirect('/');
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        Auth::logout();
        return redirect('/');
    }
    
    function Konfirmasi($id) {
        $ErrorMessage = "";
        $user = User::where('KonfirmasiID', $id)->first();

        if ($user) {
            if ($user->isConfirmed == 1) {
                $ErrorMessage = "User sudah dikonfirmasi, Link Expired";
                goto jump;
            }

            DB::table('users')
                ->where('email','=',$user->email)
                ->update(
                    [
                        'Active' => 'Y',
                        'isConfirmed' => 1,
                        'email_verified_at' => Carbon::now()
                    ]
                );
        }
        else{
            $ErrorMessage = "Link Expired";
            goto jump;
        }
        
        jump:
        if ($ErrorMessage <> "") {
            alert()->error('Error','Proses Data Gagal '.$ErrorMessage);
        }
        else{
            alert()->success('Success','Email Berhasil dikonfirmasi, silahkan login menggunakan email yang terdaftar');
            return redirect('/');
        }
    }
}
