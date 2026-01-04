<?php
/**
 * create Import from excel with Maatwebsite with input file and button only using jquery and laravel, the table column is KodeItem, NamaItem, Merk. Merk column have a relation in Merk Table, before inserting, please check Merk value, if Merk Column not Exist in Merk Table, give me notification with message, Merk is not exist in Merk Table

 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Illuminate\Support\Facades\Artisan;

use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

use App\Models\Company;
use App\Models\Printer;
use App\Models\Gudang;
use App\Models\Termin;
use App\Models\SubscriptionHeader;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ItemMasterImport;
use App\Imports\HargaJualImport;
use App\Imports\PelangganImport;
use App\Imports\SupplierImport;

use App\Exceptions\CustomImportException;
use Throwable;


use Database\Seeders\DocumentNumberingSeeder;
use Database\Seeders\SettingAccountSeeder;
use Database\Seeders\RekeningSeeder;
use Database\Seeders\KelompokRekeningSeeder;
use Database\Seeders\GudangSeeder;
use Database\Seeders\SatuanSeeder;
use App\Exports\PenggunaAplikasiExport;
use App\Models\ItemMaster;
use App\Models\InvoicePenggunaHeader;
use App\Models\InvoicePenggunaDetail;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\UserRole;
use App\Models\User;

use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\InvoicePenggunaController;

class CompanyController extends Controller
{

    function AdminPelanggan(Request $request) {
        // if(Auth::user()->RecordOwnerID != '999999'){
        //     auth()->user()->tokens()->delete();
        //     Auth::logout();
        //     return redirect('/');
        // }
        
        $Status = $request->input('Status');

        $subquery = DB::table('tagihanpenggunaheader')
                        ->selectRaw("KodePelanggan,MAX(tagihanpenggunaheader.TotalBayar) TotalBayar, MAX(created_at) created")
                        ->groupBy('KodePelanggan');

        $oCompany = Company::selectRaw("company.*, subscriptionheader.NamaSubscription, DATE_ADD(company.EndSubs, INTERVAL company.ExtraDays DAY) JatuhTempo, 
                            case when NOW() BETWEEN DATE_ADD(company.EndSubs,INTERVAL -10 DAY) AND company.EndSubs OR NOW() > company.EndSubs THEN 'Bill' ELSE '' END Subscription,
                            CASE WHEN inv.TotalBayar = 0 THEN 'Belum Bayar-warning' ELSE 
                                case when NOW() BETWEEN DATE_ADD(company.EndSubs,INTERVAL -10 DAY) AND company.EndSubs THEN 'Akan Jatuh Tempo-warning' ELSE 
                                    CASE WHEN NOW() > company.EndSubs THEN 'Expired-danger' ELSE 
                                        CASE WHEN inv.TotalBayar > 0 AND company.EndSubs > NOW() THEN 'Aktif-success' ELSE 
                                            CASE WHEN company.EndSubs > NOW() THEN 'Aktif-success' ELSE 
                                                CASE WHEN company.StartSubs is null THEN 'Perlu Aktivasi-danger' ELSE '' END
                                            END
                                        END
                                    END
                                END
                            END StatusSubscription, users.email ")
                        ->leftJoin('subscriptionheader','company.KodePaketLangganan','subscriptionheader.NoTransaksi')
                        ->leftJoinSub($subquery, 'inv', function ($join) {
                            // Bind the placeholder value during the join
                            $join->on('company.KodePartner', '=', 'inv.KodePelanggan');
                        })
                        ->join('userrole', 'company.KodePartner', '=', 'userrole.RecordOwnerID')
                        ->join('roles', function($join) {
                            $join->on('userrole.roleid', '=', 'roles.id')
                                ->on('userrole.RecordOwnerID', '=', 'roles.RecordOwnerID');
                        })
                        ->join('users', function($join) {
                            $join->on('userrole.userid', '=', 'users.id')
                                ->on('userrole.RecordOwnerID', '=', 'users.RecordOwnerID');
                        })
                        ->where('company.isActive', '!=', '-1')
                        // ->leftJoin('tagihanpenggunaheader', 'tagihanpenggunaheader.NoTransaksi','inv.NoTransaksi')
                        ->get();
        $subs = SubscriptionHeader::all();

        return view("Admin.Pengguna",[
            'oCompany' => $oCompany,
            'subs' => $subs,
        ]);
    }
    public function View(Request $request)
    {
        $clientOS = "";

        $company = Company::Where('KodePartner','=',Auth::user()->RecordOwnerID)
                        ->leftJoin('subscriptionheader', 'company.KodePaketLangganan', 'subscriptionheader.NoTransaksi')
                        ->get();
        $printer = Printer::Where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        $gudang = Gudang::Where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        $temin = Termin::Where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        $itemjasa = ItemMaster::where('TypeItem','=','4')
                        ->where('RecordOwnerID', '=', Auth::user()->RecordOwnerID)
                        ->get();

        $userdata = UserRole::selectRaw("users.*")
                ->leftJoin('users', function ($value){
                    $value->on('userrole.userid','=','users.id')
                    ->on('userrole.RecordOwnerID','=','users.RecordOwnerID');
                })
                ->leftJoin('roles', function ($value){
                    $value->on('roles.id','=','userrole.roleid')
                    ->on('roles.RecordOwnerID','=','userrole.RecordOwnerID');
                })
                ->where('roles.RoleName', 'SuperAdmin')
                ->where('userrole.RecordOwnerID', Auth::user()->RecordOwnerID)
                ->first();
        $encodedRecordOwnerID = base64_encode(Auth::user()->RecordOwnerID);
        $BookingURLString = url('booking/').'/'.$encodedRecordOwnerID;
        $QueueURLString = url('queue/').'/'.$encodedRecordOwnerID;
        $title = 'Delete Data Perusahaan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        // dd($company);
        return view("setting.CompanySetting",[
            'company' => $company,
            'printer' => $printer,
            'gudang' => $gudang,
            'temin' => $temin,
            'clientOS' => $clientOS,
            'itemjasa' => $itemjasa,
            'BookingURLString' => $BookingURLString,
            'userdata' => $userdata,
            'QueueURLString' => $QueueURLString
        ]);
    }
    public function edit(Request $request){
    	Log::debug($request->all());
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
        try {

            $model = Company::where('KodePartner','=',Auth::user()->RecordOwnerID);

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
            
                \App\Services\DBLogger::update('company', ['KodePartner' => Auth::user()->RecordOwnerID], [
                    // 'NamaGudang'=>$request->input('NamaGudang'),
                    'NamaPartner' => empty($request->input('NamaPartner')) ? "" : $request->input('NamaPartner'),
                    'AlamatTagihan' => empty($request->input('AlamatTagihan')) ? "" : $request->input('AlamatTagihan'),
                    'NoTlp' => empty($request->input('NoTlp')) ? "" : $request->input('NoTlp'),
                    'NoHP' => empty($request->input('NoHP')) ? "" : $request->input('NoHP'),
                    'NIKPIC' => empty($request->input('NIKPIC')) ? "" : $request->input('NIKPIC'),
                    'NamaPIC' => empty($request->input('NamaPIC')) ? "" : $request->input('NamaPIC'),
                    'tempStore' => empty($request->input('tempStore')) ? "" : $request->input('tempStore'),
                    'icon' => empty($request->input('image_base64')) ? "" : $request->input('image_base64'),
                    'NPWP' => empty($request->input('NPWP')) ? "" : $request->input('NPWP'),
                    'TglPKP' => empty($request->input('TglPKP')) ? "1999-01-01" : $request->input('TglPKP'),
                    'PPN' => empty($request->input('PPN')) ? 0 : $request->input('PPN'),
                    'isHargaJualIncludePPN' => empty($request->input('isHargaJualIncludePPN')) ? 0 : $request->input('isHargaJualIncludePPN'),
                    'isPostingAkutansi' => empty($request->input('isPostingAkutansi')) ? 0 : $request->input('isPostingAkutansi'),
                    'NamaPosPrinter' => empty($request->input('NamaPosPrinter')) ? "" : $request->input('NamaPosPrinter'),
                    'FooterNota' => empty($request->input('FooterNota')) ? "" : $request->input('FooterNota'),
                    'LebarKertas' => empty($request->input('LebarKertas')) ? "" : $request->input('LebarKertas'),
                    // 'JenisUsaha' => empty($request->input('JenisUsaha')) ? "" : $request->input('JenisUsaha'),
                    'GudangPoS' => empty($request->input('GudangPoS')) ? "" : $request->input('GudangPoS'),
                    'TerminBayarPoS' => empty($request->input('TerminBayarPoS')) ? "" : $request->input('TerminBayarPoS'),
                    'AllowNegativeInventory' => empty($request->input('AllowNegativeInventory')) ? "" : $request->input('AllowNegativeInventory'),
                    'DefaultSlip' => empty($request->input('DefaultSlip')) ? "" : $request->input('DefaultSlip'),
                    'Banner1' => empty($request->input('Banner1Base64')) ? "" : $request->input('Banner1Base64'),
                    'Banner2' => empty($request->input('Banner2Base64')) ? "" : $request->input('Banner2Base64'),
                    'Banner3' => empty($request->input('Banner3Base64')) ? "" : $request->input('Banner3Base64'),
                    'BannerHeader1' => empty($request->input('BannerHeader1')) ? "" : $request->input('BannerHeader1'),
                    'BannerHeader2' => empty($request->input('BannerHeader2')) ? "" : $request->input('BannerHeader2'),
                    'BannerHeader3' => empty($request->input('BannerHeader3')) ? "" : $request->input('BannerHeader3'),
                    'BannerText1' => empty($request->input('BannerText1')) ? "" : $request->input('BannerText1'),
                    'BannerText2' => empty($request->input('BannerText2')) ? "" : $request->input('BannerText2'),
                    'BannerText3' => empty($request->input('BannerText3')) ? "" : $request->input('BannerText3'),
                    'ShowLinkInReciept' => 0,
                    'ImageCustDisplay1' => empty($request->input('ImageCustDisplay1Base64')) ? "" : $request->input('ImageCustDisplay1Base64'),
                    'ImageCustDisplay2' => empty($request->input('ImageCustDisplay2Base64')) ? "" : $request->input('ImageCustDisplay2Base64'),
                    'ImageCustDisplay3' => empty($request->input('ImageCustDisplay3Base64')) ? "" : $request->input('ImageCustDisplay3Base64'),
                    'ImageCustDisplay4' => empty($request->input('ImageCustDisplay4Base64')) ? "" : $request->input('ImageCustDisplay4Base64'),
                    'PromoDsiplay' => empty($request->input('PromoDsiplay')) ? "" : $request->input('PromoDsiplay'),
                    'RunningText' => empty($request->input('RunningText')) ? "" : $request->input('RunningText'),
                    'PajakHiburan' => empty($request->input('PajakHiburan')) ? "0" : $request->input('PajakHiburan'),
                    'WarningTimer' => empty($request->input('WarningTimer')) ? "0" : $request->input('WarningTimer'),
                    'ItemHiburan' => empty($request->input('ItemHiburan')) ? "" : $request->input('ItemHiburan'),
                    'BannerBooking' => empty($request->input('BannerBookingBase64')) ? "" : $request->input('BannerBookingBase64'),
                    'HeadlineBanner' => empty($request->input('HeadlineBanner')) ? "" : $request->input('HeadlineBanner'),
                    'SubHeadlineBanner' => empty($request->input('SubHeadlineBanner')) ? "" : $request->input('SubHeadlineBanner'),
                    'JamAwalBooking' => empty($request->input('JamAwalBooking')) ? "" : $request->input('JamAwalBooking'),
                    'JamAkhirBooking' => empty($request->input('JamAkhirBooking')) ? "" : $request->input('JamAkhirBooking'),
                    'TermAndCondition' => empty($request->input('TermAndCondition')) ? "" : $request->input('TermAndCondition'),
                    'AboutUs' => empty($request->input('AboutUs')) ? "" : $request->input('AboutUs'),
                    'ImageGallery1' => empty($request->input('ImageGallery1Base64')) ? "" : $request->input('ImageGallery1Base64'),
                    'ImageGallery2' => empty($request->input('ImageGallery2Base64')) ? "" : $request->input('ImageGallery2Base64'),
                    'ImageGallery3' => empty($request->input('ImageGallery3Base64')) ? "" : $request->input('ImageGallery3Base64'),
                    'ImageGallery4' => empty($request->input('ImageGallery4Base64')) ? "" : $request->input('ImageGallery4Base64'),
                    'ImageGallery5' => empty($request->input('ImageGallery5Base64')) ? "" : $request->input('ImageGallery5Base64'),
                    'ImageGallery6' => empty($request->input('ImageGallery6Base64')) ? "" : $request->input('ImageGallery6Base64'),
                    'ImageGallery7' => empty($request->input('ImageGallery7Base64')) ? "" : $request->input('ImageGallery7Base64'),
                    'ImageGallery8' => empty($request->input('ImageGallery8Base64')) ? "" : $request->input('ImageGallery8Base64'),
                    'ImageGallery9' => empty($request->input('ImageGallery9Base64')) ? "" : $request->input('ImageGallery9Base64'),
                    'ImageGallery10' => empty($request->input('ImageGallery10Base64')) ? "" : $request->input('ImageGallery10Base64'),
                    'ImageGallery11' => empty($request->input('ImageGallery11Base64')) ? "" : $request->input('ImageGallery11Base64'),
                    'ImageGallery12' => empty($request->input('ImageGallery12Base64')) ? "" : $request->input('ImageGallery12Base64'),
                    'VideoCustomerDisplay1' => empty($request->input('VideoCustomerDisplay1')) ? "" : $request->input('VideoCustomerDisplay1'),
                    'VideoCustomerDisplay2' => empty($request->input('VideoCustomerDisplay2')) ? "" : $request->input('VideoCustomerDisplay2'),
                    'VideoCustomerDisplay3' => empty($request->input('VideoCustomerDisplay3')) ? "" : $request->input('VideoCustomerDisplay3'),
                    'VideoCustomerDisplay4' => empty($request->input('VideoCustomerDisplay4')) ? "" : $request->input('VideoCustomerDisplay4'),
                    'VideoCustomerDisplay5' => empty($request->input('VideoCustomerDisplay5')) ? "" : $request->input('VideoCustomerDisplay5'),
                    'TermAndConditionBookingOnline' => $request->input('TermAndConditionBookingOnline'),
                    'Email' => $request->input('Email'),
                    'DefaultLandingPageColor' => $request->input('DefaultLandingPageColor'),
                    'DefaultLandingPages' => $request->input('DefaultLandingPages'),
                    'TypeBackgraund' => $request->input('TypeBackgraund'),
                    'Backgraund' => empty($request->input('BackgraundBase64')) ? $request->input('Backgraund') : $request->input('BackgraundBase64'),
                    'RunningTextSelfServices' => empty($request->input('RunningTextSelfServices')) ? $request->input('RunningTextSelfServices') : $request->input('RunningTextSelfServices'),
                    'QueueDesignSetting' => empty($request->input('QueueDesignSetting')) ? "QueueManagement" : $request->input('QueueDesignSetting')
                ]);
            
                
                $data['success'] = true;
                $data['message'] = 'Data Perusahaan berhasil disimpan.';
            } else{
                // throw new \Exception('Perusahaan not found.');
                $data['success'] = false;
                $data['message'] = 'Perusahaan not found.';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['success'] = false;
            $data['message'] = $e->getMessage();
            // alert()->error('Error',$e->getMessage());
            // return redirect()->back();

        }

        return response()->json($data);
    }

    public function UpdateSuspend(Request $request){
    	Log::debug($request->all());
        try {

            $model = Company::where('KodePartner','=',$request->input('KodePartner'));

            if ($model) {
                if ($request->input('isSuspended') == 1) {
                    $update = DB::table('company')
                            ->where('KodePartner','=',$request->input('KodePartner'))
                			->update(
                				[
                					// 'NamaGudang'=>$request->input('NamaGudang'),
                					'isSuspended' => empty($request->input('isSuspended')) ? "" : $request->input('isSuspended'),
									'SuspendReason' => empty($request->input('SuspendReason')) ? "" : $request->input('SuspendReason')
                				]
                			);
                }
                elseif ($request->input('isSuspended') == 2) {
                    $update = DB::table('company')
                            ->where('KodePartner','=',$request->input('KodePartner'))
                			->update(
                				[
									'EndSubs' => $request->input('EndSubs'),
                                    'StartSubs' => $request->input('StartSubs'),
                                    'ExtraDays' => 1
                				]
                			);
                    
                            $RecordOwnerID = $request->input('KodePartner');
                            DocumentNumberingSeeder::setParameter($RecordOwnerID);
                            Artisan::call('db:seed', ['--class' => 'DocumentNumberingSeeder']);
                            // return response()->json(['message' => 'Database seeded successfully']);

                            // Gudang
                            GudangSeeder::setParameter($RecordOwnerID);
                            Artisan::call('db:seed', ['--class' => 'GudangSeeder']);
                            // return response()->json(['message' => 'Database seeded successfully']);

                            // Kelompok Rekening
                            // KelompokRekeningSeeder::setParameter($RecordOwnerID);
                            // Artisan::call('db:seed', ['--class' => 'KelompokRekeningSeeder']);

                            // Rekening Akutansi
                            RekeningSeeder::setParameter($RecordOwnerID);
                            Artisan::call('db:seed', ['--class' => 'RekeningSeeder']);

                            // Setting Account
                            SettingAccountSeeder::setParameter($RecordOwnerID);
                            Artisan::call('db:seed', ['--class' => 'SettingAccountSeeder']);

                            // Satuan
                            SatuanSeeder::setParameter($RecordOwnerID);
                            Artisan::call('db:seed', ['--class' => 'SatuanSeeder']);

                            // Generate Permission

                }
                else{
                    $update = DB::table('company')
                            ->where('KodePartner','=',$request->input('KodePartner'))
                			->update(
                				[
                					// 'NamaGudang'=>$request->input('NamaGudang'),
                					'isSuspended' => $request->input('isSuspended'),
									'EndSubs' => $request->input('EndSubs')
                				]
                			);
                }
                alert()->success('Success','Data Perusahaan berhasil disimpan.');
                return redirect('penggunaaplikasi');
            } else{
                throw new \Exception('Perusahaan not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }
    

    public function UpdatePaket(Request $request){
    	Log::debug($request->all());
        try {

            $model = Company::where('KodePartner','=',$request->input('KodePartner'));

            if ($model) {
                $update = DB::table('company')
                        ->where('KodePartner','=',$request->input('KodePartner'))
                        ->update(
                            [
                                // 'NamaGudang'=>$request->input('NamaGudang'),
                                'JenisUsaha' => empty($request->input('JenisUsaha')) ? "" : $request->input('JenisUsaha'),
                                'KodePaketLangganan' => empty($request->input('PaketAplikasi')) ? "" : $request->input('PaketAplikasi'),
                                'StartSubs' => empty($request->input('StartSubs')) ? "" : $request->input('StartSubs'),
                                'EndSubs' => empty($request->input('EndSubs')) ? "" : $request->input('EndSubs'),
                            ]
                        );
                alert()->success('Success','Data Perusahaan berhasil disimpan.');
                return redirect('penggunaaplikasi');
            } else{
                throw new \Exception('Perusahaan not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function DeletePengguna(Request $request){
    	Log::debug($request->all());
        $data = array('success' => false, 'data' => array(), 'message' => '');
        try {

            $model = Company::where('KodePartner','=',$request->input('KodePartner'));

            if ($model) {
                $update = DB::table('company')
                        ->where('KodePartner','=',$request->input('KodePartner'))
                        ->update(
                            [
                                // 'NamaGudang'=>$request->input('NamaGudang'),
                                'isActive' => -1
                            ]
                        );
                $data['success'] = true;
            } else{
                $data['success'] = false;
                $data['message'] = 'Perusahaan not found.';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }

    public function GenerateInitialData(Request $request){
        // $request->input['RecordOwnerID']
        $RecordOwnerID = 'CL0005';
        DocumentNumberingSeeder::setParameter($RecordOwnerID);
        Artisan::call('db:seed', ['--class' => 'DocumentNumberingSeeder']);
        // return response()->json(['message' => 'Database seeded successfully']);

        // Gudang
        GudangSeeder::setParameter($RecordOwnerID);
        Artisan::call('db:seed', ['--class' => 'GudangSeeder']);
        // return response()->json(['message' => 'Database seeded successfully']);

        // Kelompok Rekening
        // KelompokRekeningSeeder::setParameter($RecordOwnerID);
        // Artisan::call('db:seed', ['--class' => 'KelompokRekeningSeeder']);

        // Rekening Akutansi
        RekeningSeeder::setParameter($RecordOwnerID);
        Artisan::call('db:seed', ['--class' => 'RekeningSeeder']);

        // Setting Account
        SettingAccountSeeder::setParameter($RecordOwnerID);
        Artisan::call('db:seed', ['--class' => 'SettingAccountSeeder']);

        // Satuan
        SatuanSeeder::setParameter($RecordOwnerID);
        Artisan::call('db:seed', ['--class' => 'SatuanSeeder']);
    }

    function ImportItemMaster(Request $request) {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        Excel::import(new ItemMasterImport, $request->file('BulkItemMaster'));

        if (session()->has('error')) {
            $data['success'] = false;
            $data['message'] = session('error');
            // return response()->json(['error' => session('error')], 400);
        }
        else{
            $data['success'] = true;
        }
        
        return response()->json($data);
    }
    function ImportHargaJual(Request $request) {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        Excel::import(new HargaJualImport, $request->file('BulkHargaJual'));

        if (session()->has('error')) {
            $data['success'] = false;
            $data['message'] = session('error');
            // return response()->json(['error' => session('error')], 400);
        }
        else{
            $data['success'] = true;
        }
        
        return response()->json($data);
    }

    function ImportPelanggan(Request $request) {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        Excel::import(new PelangganImport, $request->file('BulkPelanggan'));

        if (session()->has('error')) {
            $data['success'] = false;
            $data['message'] = session('error');
            // return response()->json(['error' => session('error')], 400);
        }
        else{
            $data['success'] = true;
        }
        
        return response()->json($data);
    }

    function ImportSupplier(Request $request) {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        Excel::import(new SupplierImport, $request->file('BulkSupplier'));

        if (session()->has('error')) {
            $data['success'] = false;
            $data['message'] = session('error');
            // return response()->json(['error' => session('error')], 400);
        }
        else{
            $data['success'] = true;
        }
        
        return response()->json($data);
    }

    public function TestPrint()
    {
    	// Set params
        $mid = '123123456';
        $store_name = 'YOURMART';
        $store_address = 'Mart Address';
        $store_phone = '1234567890';
        $store_email = 'yourmart@email.com';
        $store_website = 'yourmart.com';
        $tax_percentage = 10;
        $transaction_id = 'TX123ABC456';

        // Set items
        $items = [
            [
                'name' => 'French Fries (tera)',
                'qty' => 2,
                'price' => 65000,
            ],
            [
                'name' => 'Roasted Milk Tea (large)',
                'qty' => 1,
                'price' => 24000,
            ],
            [
                'name' => 'Honey Lime (large)',
                'qty' => 3,
                'price' => 10000,
            ],
            [
                'name' => 'Jasmine Tea (grande)',
                'qty' => 3,
                'price' => 8000,
            ],
        ];

        // Init printer
        $printer = new ReceiptPrinter;
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );

        // Set store info
        $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

        // Add items
        foreach ($items as $item) {
            $printer->addItem(
                $item['name'],
                $item['qty'],
                $item['price']
            );
        }
        // Set tax
        $printer->setTax($tax_percentage);

        // Calculate total
        $printer->calculateSubTotal();
        $printer->calculateGrandTotal();

        // Set transaction ID
        $printer->setTransactionID($transaction_id);

        // Set qr code
        $printer->setQRcode([
            'tid' => $transaction_id,
        ]);

        // Print receipt
        $printer->printReceipt();
    }

    public function Export()
    {
        return Excel::download(new PenggunaAplikasiExport(), 'Daftar Pengguna Aplikasi.xlsx');
    }

    public function CheckSubscriptionStatus()
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $oTemp = [];

        $company = Company::selectRaw("users.email, roles.RoleName ,company.*")
                        ->leftJoin('users', function ($value){
                            $value->on('users.RecordOwnerID','=','company.KodePartner');
                        })
                        ->leftJoin('userrole', function ($value){
                            $value->on('userrole.userid','=','users.id')
                            ->on('userrole.RecordOwnerID','=','users.RecordOwnerID');
                        })
                        ->leftJoin('roles', function ($value){
                            $value->on('roles.id','=','userrole.roleid')
                            ->on('roles.RecordOwnerID','=','userrole.RecordOwnerID');
                        })
                        ->where('roles.RoleName','=','SuperAdmin')
                        ->where('company.isActive','=',1)
                        ->get();

        if(count($company) > 0){
            foreach ($company as $key => $value) {
                $currentDate = Carbon::now();
                $endSubs = Carbon::parse($value->EndSubs)->addDays($value->ExtraDays);

                $isCreateNewInvoice = true;

                $oInvPengguna = InvoicePenggunaHeader::selectRaw('(TotalTagihan - TotalBayar) As Outstanding ')
                                    ->where('KodePelanggan', $value->KodePartner)
                                    ->orderBy('TglTransaksi', 'desc')
                                    ->orderBy('created_at', 'desc')
                                    ->first();
                if (!$oInvPengguna) {
                    $isCreateNewInvoice = true;
                } else {
                    $isCreateNewInvoice = $oInvPengguna->Outstanding <= 0;
                }
                
                if ($currentDate->greaterThan($endSubs)) {
                    // return response()->json(['status' => 'expired']);
                    DB::table('company')
                        ->where('KodePartner', $value->KodePartner)
                        ->update(['SuspendReason' => 'Expired', 'isActive' => 0]);
                    
                    
                    // Save Invoice
                    if($isCreateNewInvoice){
                        $oSubs = SubscriptionHeader::where('NoTransaksi',$value->KodePaketLangganan)->first();
                        $oDetail = array(
                            'NoTransaksi' => '',
                            'NoUrut' => -1,
                            'Harga' => floatval($oSubs->Harga) - floatval($oSubs->Potongan),
                            'Catatan' => "Langganan Perdana",
                            'KodePelanggan' => $value->KodePartner,
                        );
                        $oObject = array(
                            'NoTransaksi' => '',
                            'TglTransaksi' => Carbon::now()->format('Y-m-d'),
                            'TglJatuhTempo' => Carbon::now()->addDays(7)->format('Y-m-d'),
                            'KodePaketLangganan' => $value->KodePaketLangganan,
                            'Catatan' => 'Langganan DS Tech Smart Pos Bulan ' . Carbon::now()->format('F Y'),
                            'KodePelanggan' => $value->KodePartner,
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
                            $otemp['success'] = false;
                            $data['message'] = 'Failed to save invoice';
                        } else {
                            $data['success'] = true;
                            $data['message'] = 'Invoice saved successfully';
                        }
                    }

                    $oEmailData = [
                        'title' => 'Email Pengingat',
                        'message' => 'Langganan anda sudah expired, silahkan melakukan pembayaran untuk mengaktifkan kembali langganan anda.',
                    ];
                
                    Mail::to($value->email)->send(new SendMail($oEmailData,"Email Pengingat"));

                    $data['success'] = true;
                    $data['message'] = 'Subscription '. $value->KodePartner .' Atas Nama '. $value->NamaPartner .' expired';

                    $oTemp[] = $data;
                } elseif ($currentDate->greaterThanOrEqualTo($endSubs->subDays(10))) {
                    // return response()->json(['status' => 'warning']);
                    // Send Email
                    // Save Invoice

                    if($isCreateNewInvoice){
                        $oSubs = SubscriptionHeader::where('NoTransaksi',$value->KodePaketLangganan)->first();
                        $oDetail = array(
                            'NoTransaksi' => '',
                            'NoUrut' => -1,
                            'Harga' => floatval($oSubs->Harga) - floatval($oSubs->Potongan),
                            'Catatan' => "Langganan Perdana",
                            'KodePelanggan' => $value->KodePartner,
                        );
                        $oObject = array(
                            'NoTransaksi' => '',
                            'TglTransaksi' => Carbon::now()->format('Y-m-d'),
                            'TglJatuhTempo' => Carbon::now()->addDays(7)->format('Y-m-d'),
                            'KodePaketLangganan' => $value->KodePaketLangganan,
                            'Catatan' => 'Langganan DS Tech Smart Pos Bulan ' . Carbon::now()->format('F Y'),
                            'KodePelanggan' => $value->KodePartner,
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
                            $data['success'] = false;
                            $data['message'] = 'Failed to save invoice';
                        } else {
                            $data['success'] = true;
                            $data['message'] = 'Invoice saved successfully';
                        }
                    }

                    $oEmailData = [
                        'title' => 'Email Konfirmasi',
                        'message' => 'Terimakasih telah melakukan pendaftaran di DSTechSmart PoS, Silahkan melakukan pengecekan pada langganan anda. dan segera melakukan pembayaran sebelum jatuh tempo.',
                    ];
                
                    Mail::to($value->email)->send(new SendMail($oEmailData,"Email Konfirmasi"));

                    $data['success'] = true;
                    $data['message'] = 'Subscription '. $value->KodePartner .' Atas Nama '. $value->NamaPartner .' warning';
                    $oTemp[] = $data;
                } else {
                    $data['success'] = true;
                    $data['message'] = 'Subscription '. $value->KodePartner .' Atas Nama '. $value->NamaPartner .' active';
                    $oTemp[] = $data;
                }
            }
        } else {
            $data['success'] = false;
            $data['message'] = 'Company not found';
            // return response()->json($data);
            $oTemp[] = $data;
        }
        return response()->json($oTemp);
    }

    public function getCompanyDetails(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        try {
           $oData = Company::where('KodePartner', Auth::user()->RecordOwnerID)->first();
           $data['success'] = true;
           $data['data'] = $oData;
        } catch (\Throwable $th) {
            $data['success'] = false;
            $data['message'] = $th->getMessage();
        }
        return response()->json($data);
        
    }

    public function updateSlip(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
        $FieldName = $request->input('FieldName');
        $FieldValue = $request->input('FieldValue');

        try {
            DB::statement("UPDATE company SET ". $FieldName ." = '". $FieldValue ."' WHERE KodePartner = '". Auth::user()->RecordOwnerID. "'");
            $data['success'] = true;
        } catch (\Throwable $th) {
            $data['success'] = false;
            $data['message'] = $th->getMessage();
        }

        return response()->json($data);
    }
}
