<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

use App\Models\Company;
use App\Models\TitikLampu;
use App\Models\MasterController;
use App\Models\KelompokLampu;
use App\Models\JenisItem;
use App\Models\ItemMaster;
use App\Models\MetodePembayaran;
use App\Models\FakturPenjualanHeader;
use App\Models\FakturPenjualanDetail;
use App\Models\PembayaranPenjualanHeader;
use App\Models\PembayaranPenjualanDetail;
use App\Models\DocumentNumbering;
use App\Models\TableOrderFnB;
use App\Models\TableOrderHeader;
use App\Models\Paket;
use App\Models\Rekening;
use App\Models\AutoPosting;
use App\Models\SettingAccount;
use App\Models\Pelanggan;

use Midtrans\Config;
use Midtrans\Snap;

class TitikLampuController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['NamaTitikLampu'];
        $keyword = $request->input('keyword');
        $ControllerID = $request->input('ControllerID');

        $titiklampu = TitikLampu::selectRaw("titiklampu.*,mastercontroller.NamaController, tkelompoklampu.NamaKelompok")
                ->join('mastercontroller', function ($value)  {
                    $value->on('titiklampu.ControllerID','=','mastercontroller.id')
                    ->on('titiklampu.RecordOwnerID','=','mastercontroller.RecordOwnerID');
                })
                ->leftjoin('tkelompoklampu', function ($value)  {
                    $value->on('titiklampu.KelompokLampu','=','tkelompoklampu.KodeKelompok')
                    ->on('titiklampu.RecordOwnerID','=','tkelompoklampu.RecordOwnerID');
                })
                ->Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('titiklampu.RecordOwnerID','=',Auth::user()->RecordOwnerID)
                ->selectRaw("(SELECT COUNT(*) FROM tableorderheader WHERE tableorderheader.tableid = titiklampu.id AND tableorderheader.Status = 1 AND tableorderheader.RecordOwnerID = titiklampu.RecordOwnerID) as active_order_count");
        
                if ($ControllerID > 0) {
                    $titiklampu->where('titiklampu.ControllerID', $ControllerID);
                }
        $title = 'Delete Titik Lampu !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("controller.titiklampu",[
            'titiklampu' => $titiklampu->get()
        ]);
    }

    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jenisitem = TitikLampu::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $data['data']= $jenisitem;
        return response()->json($data);
    }

    public function Form($id = null)
    {
        $controller = MasterController::selectRaw("mastercontroller.*, serial_numbers.MaximalNode")
                ->leftJoin('serial_numbers', function ($value){
                    $value->on('serial_numbers.SerialNumber','=','mastercontroller.SN')
                    ->on('serial_numbers.KodePartner','=','mastercontroller.RecordOwnerID');
                })
                ->where('mastercontroller.RecordOwnerID','=',Auth::user()->RecordOwnerID)
                ->get();
    	$titiklampu = TitikLampu::where('id','=',$id)->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        $kelompoklampu = KelompokLampu::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        return view("controller.titiklampu-Input",[
            'titiklampu' => $titiklampu,
            'controller' => $controller,
            'kelompoklampu' => $kelompoklampu
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaTitikLampu'=>'required',
                'DigitalInput'=>'required',
                'ControllerID' =>'required',
            ]);

            // Validation regarding Serial Number and Maximal Node
            $ControllerID = $request->input('ControllerID');

            if ($ControllerID) {
                // Get SN from MasterController
                $masterController = DB::table('mastercontroller')
                                    ->where('id', $ControllerID)
                                    ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                                    ->first();

                if ($masterController) {
                    $sn = $masterController->SN;

                    // Get MaximalNode from serial_numbers
                    $serialNumberData = DB::table('serial_numbers')
                                        ->where('SerialNumber', $sn)
                                        ->where('KodePartner', Auth::user()->RecordOwnerID)
                                        ->first();

                   if ($serialNumberData) {
                        $maxNode = $serialNumberData->MaximalNode;

                        // Count existing TitikLampu
                        $currentCount = DB::table('titiklampu')
                                        ->where('ControllerID', $ControllerID)
                                        ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                                        ->count();
                        
                        if ($currentCount >= $maxNode) {
                            throw new \Exception('Jumlah Titik Lampu melebihi batas maksimal ('.$maxNode.') untuk controller ini.');
                        }
                   }
                }
            }

            $model = new TitikLampu;
            $model->NamaTitikLampu = $request->input('NamaTitikLampu');
            $model->DigitalInput = $request->input('DigitalInput');
            $model->ControllerID = $request->input('ControllerID');
            $model->KelompokLampu = $request->input('KelompokLampu');
            $model->Deskripsi = $request->input('Deskripsi');
            $model->Gambar = $request->input('image_base64');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Titik Lampu Berhasil disimpan.');
                return redirect('titiklampu');
                
            }else{
                throw new \Exception('Penambahan Data Titik Lampu Gagal');
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
                'NamaTitikLampu'=>'required',
                'DigitalInput'=>'required',
                'ControllerID' =>'required',
            ]);

            $model = TitikLampu::where('id','=',$request->input('id'))->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

            if ($model) {
                \App\Services\DBLogger::update('titiklampu', ['id' => $request->input('id')], [
                    'NamaTitikLampu'    => $request->input('NamaTitikLampu'),
                    'DigitalInput'      => $request->input('DigitalInput'),
                    'ControllerID'      => $request->input('ControllerID'),
                    'KelompokLampu'     => $request->input('KelompokLampu'),
                    'Deskripsi'         => $request->input('Deskripsi'),
                    'Gambar'            => $request->input('image_base64')
                ]);

                alert()->success('Success','Data Titik Lampu berhasil disimpan.');
                return redirect('titiklampu');

            } else{
                throw new \Exception('Titik Lampu not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function storeJson(Request $request)
    {
        Log::debug($request->all());
        try {

            // Validation regarding Serial Number and Maximal Node
            $ControllerID = $request->input('ControllerID');

            if ($ControllerID) {
                // Get SN from MasterController
                $masterController = DB::table('mastercontroller')
                                    ->where('id', $ControllerID)
                                    ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                                    ->first();

                if ($masterController) {
                    $sn = $masterController->SN;

                    // Get MaximalNode from serial_numbers
                    $serialNumberData = DB::table('serial_numbers')
                                        ->where('SerialNumber', $sn)
                                        ->where('KodePartner', Auth::user()->RecordOwnerID)
                                        ->first();

                   if ($serialNumberData) {
                        $maxNode = $serialNumberData->MaximalNode;

                        // Count existing TitikLampu
                        $currentCount = DB::table('titiklampu')
                                        ->where('ControllerID', $ControllerID)
                                        ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                                        ->count();
                        
                        if ($currentCount >= $maxNode) {
                            throw new \Exception('Jumlah Titik Lampu melebihi batas maksimal ('.$maxNode.') untuk controller ini.');
                        }
                   }
                }
            }

            $model = new TitikLampu;
            $model->NamaTitikLampu = $request->input('NamaTitikLampu');
            $model->DigitalInput = $request->input('DigitalInput');
            $model->ControllerID = $request->input('ControllerID');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;
            $model->KelompokLampu = $request->input('KelompokLampu');
            $model->Deskripsi = $request->input('Deskripsi');
            $model->Gambar = $request->input('image_base64');

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                
            }else{
                $data['message'] = 'Penambahan Data Titik Lampu Gagal';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function editJson(Request $request)
    {
        Log::debug($request->all());
        try {

            $model = TitikLampu::where('id','=',$request->input('id'))->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                \App\Services\DBLogger::update('titiklampu', ['id' => $request->input('id')], [
                    'NamaTitikLampu'    => $request->input('NamaTitikLampu'),
                    'DigitalInput'      => $request->input('DigitalInput'),
                    'ControllerID'      => $request->input('ControllerID'),
                    'KelompokLampu'     => $request->input('KelompokLampu'),
                    'Deskripsi'         => $request->input('Deskripsi'),
                    'Gambar'            => $request->input('image_base64')
                ]);

                $data['success'] = true;

            } else{
                $data['message'] = 'Titik Lampu Not found.';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function deletedata(Request $request)
    {
    	try {
    		$meja = DB::table('titiklampu')
	                ->where('id','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($meja) {
	        	alert()->success('Success','Delete Titik Lampu berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Titik Lampu Gagal.');
	        }
	        return redirect('titiklampu');
    	} catch (\Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }

    public function getMeja()
    {
        $data = TitikLampu::select('id', 'NamaTitikLampu', 'BisaDipesan')
    ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
    ->get();

        return response()->json($data);
    }

    public function updateStatusMeja(Request $request)
    {
       
        $update = DB::table('titiklampu')
        ->where('id','=', $request->input('id'))
        ->update(
            [
                'BisaDipesan'=>$request->input('BisaDipesan'),
            ]
        );

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Status meja berhasil diperbarui!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Edit Titik Lampu Gagal'], 400);
        }

    }

    public function powerOff($id)
    {
        try {
            $table = TitikLampu::where('id', $id)
                        ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->first();

            if ($table) {
                $table->Status = 0;
                $table->save();
                alert()->success('Success', 'Lampu berhasil dimatikan.');
            } else {
                alert()->error('Error', 'Titik Lampu tidak ditemukan.');
            }
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Power Off Error: ' . $e->getMessage());
            alert()->error('Error', 'Gagal mematikan lampu: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function emenu($id, $roid)
    {
        // Decode parameters
        try {
            $decodedId = base64_decode($id);
            $decodedRoid = base64_decode($roid);
        } catch (\Exception $e) {
            abort(404);
        }

        // Validate TitikLampu exists
        $titikLampu = TitikLampu::where('id', $decodedId)
                        ->where('RecordOwnerID', $decodedRoid)
                        ->first();

        if (!$titikLampu) {
            abort(404, 'Table not found');
        }

        // Fetch Company Data
        $company = Company::where('KodePartner', $decodedRoid)->first();

        // Fetch Categories (JenisItem)
        $categories = JenisItem::where('RecordOwnerID', $decodedRoid)
                        ->where('TampilkanEMenu', 1)
                        ->get();

        // Fetch Items (ItemMaster)
        $items = ItemMaster::where('RecordOwnerID', $decodedRoid)
                    ->where('TampilkanEMenu', 1)
                    ->get();
        
        $menus = [];
        foreach ($items as $item) {
            // Find category name
            $catName = 'Uncategorized';
            $cat = $categories->where('KodeJenis', $item->KodeJenisItem)->first();
            if ($cat) {
                 $catName = $cat->NamaJenis;
            }

            // Image Logic
            $imageSrc = "https://i.pinimg.com/474x/8c/c0/30/8cc030fe28355bb3c6dc38fdbd449bc9.jpg";
            if (!empty($item->Gambar)) {
                $imageSrc = "data:image/jpeg;base64," . base64_encode($item->Gambar);
            }

            $menus[] = [
                'id' => $item->KodeItem,
                'name' => $item->NamaItem,
                'price' => $item->HargaJual,
                'image' => $imageSrc,
                'category' => $catName,
                'description' => $item->NamaItem 
            ];
        }

        // Fetch Payment Methods
        $paymentMethods = DB::table('metodepembayaran')
                            ->where('RecordOwnerID', $decodedRoid)
                            ->get();

        // Payment Logic Handling
        $currentDate = Carbon::now();
        $activeSession = DB::table('tableorderheader')
            ->where('tableid', $decodedId)
            ->where('RecordOwnerID', $decodedRoid)
            ->where('JamMulai', '<=', $currentDate)
            ->where(function ($query) use ($currentDate) {
                $query->where('JamSelesai', '>=', $currentDate)
                      ->orWhereNull('JamSelesai');
            })
            ->where('Status', 1)
            ->where('DocumentStatus', 'O')
            ->first();

        $canUseQRIS = true;
        $canUseCash = true;

        if ($activeSession) {
            $NoTransaksi = $activeSession->NoTransaksi;
            
            // Link tableorderheader -> fakturpenjualandetail -> fakturpenjualanheader
            $faktur = DB::table('fakturpenjualanheader')
                        ->join('fakturpenjualandetail', 'fakturpenjualanheader.NoTransaksi', '=', 'fakturpenjualandetail.NoTransaksi')
                        ->where('fakturpenjualandetail.BaseReff', $NoTransaksi)
                        ->where('fakturpenjualanheader.RecordOwnerID', $decodedRoid)
                        ->select(
                            DB::raw('SUM(TotalPembelian) as SumTotalPembelian'),
                            DB::raw('SUM(TotalPembayaran) as SumTotalPembayaran')
                        )
                        ->first();

            if ($faktur && ($faktur->SumTotalPembelian > 0 || $faktur->SumTotalPembayaran > 0)) {
                if ($faktur->SumTotalPembelian == $faktur->SumTotalPembayaran) {
                    // Fully paid -> Only QRIS enabled
                    $canUseCash = false;
                } else {
                    // Unpaid or mismatch -> Only Cash enabled
                    $canUseQRIS = false;
                }
            } else {
                // No invoices yet, but table is active -> Only Cash enabled (typical for start of session)
                $canUseQRIS = false;
            }
        }
        
        $midtransclientkey = "";
        if ($company->MidtransClientKey != null) {
            $midtransclientkey = $company->MidtransClientKey;
        }

        // Fetch Jenis Langganan (Package Types) from Company
        $jenisLangganan = [];
        if ($company && $company->JenisLangganan) {
            $allJenis = json_decode($company->JenisLangganan, true);
            // Only allow specific package types for E-Menu
            $allowed = ['MENITREALTIME', 'JAMREALTIME', 'PAYPERUSE'];
            $jenisLangganan = array_filter($allJenis, function($item) use ($allowed) {
                return in_array($item['Kode'], $allowed);
            });
        }

        // Fetch Available Packages
        $paket = DB::table('pakettransaksi')
                    ->where('RecordOwnerID', $decodedRoid)
                    ->get();
        
        // dd($canUseCash, $canUseQRIS, $activeSession);
        $canUseQRIS = true;
        $canUseCash = true;
        return view('emenu.order', [
            'titikLampu' => $titikLampu,
            'menus' => $menus,
            'company' => $company,
            'roid' => $decodedRoid,
            'paymentMethods' => $paymentMethods,
            'midtransclientkey' => $midtransclientkey,
            'canUseQRIS' => $canUseQRIS,
            'canUseCash' => $canUseCash,
            'jenisLangganan' => $jenisLangganan,
            'paket' => $paket,
            'isTableActive' => $activeSession ? true : false
        ]);
    }

    public function generateQRCode()
    {
        $titiklampu = TitikLampu::selectRaw("titiklampu.*,mastercontroller.NamaController")
                        ->join('mastercontroller', function ($value)  {
                            $value->on('titiklampu.ControllerID','=','mastercontroller.id')
                            ->on('titiklampu.RecordOwnerID','=','mastercontroller.RecordOwnerID');
                        })->where('titiklampu.RecordOwnerID', Auth::user()->RecordOwnerID)->get();

        return view('controller.titiklampu-qrcode', [
            'titiklampu' => $titiklampu
        ]);
    }

    public function downloadPDFQRCode()
    {
        $titiklampu = TitikLampu::selectRaw("titiklampu.*,mastercontroller.NamaController")
                        ->join('mastercontroller', function ($value)  {
                            $value->on('titiklampu.ControllerID','=','mastercontroller.id')
                            ->on('titiklampu.RecordOwnerID','=','mastercontroller.RecordOwnerID');
                        })
                        ->where('titiklampu.RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('controller.titiklampu-pdf', [
            'titiklampu' => $titiklampu,
        ]);

        return $pdf->download('titiklampu-qrcode.pdf');
    }

    public function storeOrder(Request $request)
    {
        Log::debug('EMenu storeOrder: Start', ['request' => $request->all()]);
        $data = ['success' => false, 'message' => ''];
        DB::beginTransaction();

        try {
            $cart = $request->input('cart');
            $roid = $request->input('roid');
            $tableId = $request->input('table_id');
            $paymentMethod = $request->input('payment_method');
            $total = $request->input('total');

            if (empty($roid)) {
                throw new \Exception('RecordOwnerID (roid) is missing');
            }

            if (empty($cart)) {
                throw new \Exception('Cart is empty');
            }

            Log::debug('EMenu storeOrder: Validation Passed', ['roid' => $roid, 'table_id' => $tableId]);

            $currentDate = Carbon::now();

            // 1. Validation: Check active session in tableorderheader
            $activeSession = DB::table('tableorderheader')
                ->where('tableid', $tableId)
                ->where('RecordOwnerID', $roid)
                ->where('JamMulai', '<=', $currentDate)
                ->where(function ($query) use ($currentDate) {
                    $query->where('JamSelesai', '>=', $currentDate)
                          ->orWhereNull('JamSelesai');
                })
                ->where('Status', 1)
                ->where('DocumentStatus', 'O')
                ->first();

            Log::debug('EMenu storeOrder: Active Session Result', ['active' => !empty($activeSession)]);

            $NoTransaksi = "";
            if ($activeSession) {
                $NoTransaksi = $activeSession->NoTransaksi;
            } else {
                // Check if booking data provided (activation)
                if ($request->has('paketid') && $request->input('paketid') != "") {
                    Log::debug('EMenu storeOrder: Activating Table', ['paketid' => $request->input('paketid'), 'JenisPaket' => $request->input('JenisPaket')]);
                    $numberingData = new DocumentNumbering();
                    $NoTransaksi = $numberingData->GetNewDocMobile("POS","tableorderheader","NoTransaksi", $roid);
                    Log::debug('EMenu storeOrder: New NoTransaksi Generated', ['NoTransaksi' => $NoTransaksi]);
                    
                    $paket = Paket::find($request->input('paketid'));
                    if (!$paket) throw new \Exception('Paket tidak valid');

                    $company = DB::table('company')->where('KodePartner', $roid)->first();
                    $duration = $request->input('bookingDuration', 1);
                    if ($request->input('JenisPaket') != 'JAMREALTIME') {
                        $duration = 0;
                    }

                    $basePrice = $paket->HargaNormal * $duration;
                    $ppnPercent = $company->PPN ?? 0;
                    $pajakHiburanPercent = $company->PajakHiburan ?? 0;
                    
                    $ppnAmt = ($ppnPercent / 100) * $basePrice;
                    $pajakHiburanAmt = ($pajakHiburanPercent / 100) * $basePrice;
                    $totalMeja = $basePrice + $ppnAmt + $pajakHiburanAmt;

                    $kodePelanggan = $request->input('KodePelanggan');
                    if (empty($kodePelanggan) && !empty($request->input('NoTlp1')) && !empty($request->input('NamaPelanggan'))) {
                        $pelangganExist = DB::table('pelanggan')
                                            ->where('NoTlp1', $request->input('NoTlp1'))
                                            ->where('RecordOwnerID', $roid)
                                            ->first();
                        
                        if ($pelangganExist) {
                            $kodePelanggan = $pelangganExist->KodePelanggan;
                        } else {
                            $numberingPelanggan = new DocumentNumbering();
                            $kodePelanggan = $numberingPelanggan->GetNewDocMobile("PLG","pelanggan","KodePelanggan", $roid);
                            
                            DB::table('pelanggan')->insert([
                                'KodePelanggan' => $kodePelanggan,
                                'NamaPelanggan' => $request->input('NamaPelanggan'),
                                'KodeGrupPelanggan' => '',
                                'NoTlp1' => $request->input('NoTlp1'),
                                'isPaidMembership' => 0,
                                'MaxPlay' => 0,
                                'MemberPrice' => 0,
                                'maxTimePerPlay' => 0,
                                'RecordOwnerID' => $roid
                            ]);
                        }
                    }

                    $model = new TableOrderHeader;
                    $model->NoTransaksi = $NoTransaksi;
                    $model->TglTransaksi = $currentDate;
                    $model->TglPencatatan = $currentDate;
                    // $model->TglBooking = $currentDate->format('Y-m-d');
                    $model->RecordOwnerID = $roid;
                    $model->JenisPaket = $request->input('JenisPaket');
                    $model->paketid = $request->input('paketid');
                    $model->tableid = $tableId;
                    $model->Status = 1;
                    $model->DocumentStatus = 'O';
                    $model->KodePelanggan = $kodePelanggan ?? 'CASH';
                    // $model->CreatedBy = 'EMENU';
                    $model->JamMulai = $currentDate;
                    
                    if ($model->JenisPaket == 'JAM' || $model->JenisPaket == 'PAKETMEMBER' || $model->JenisPaket == 'JAMREALTIME') {
                         $model->JamSelesai = $model->JamMulai->copy()->addHours($duration)->subMinute();
                    } 
                    // elseif ($model->JenisPaket == 'MENIT') {
                    //      $model->JamSelesai = $model->JamMulai->copy()->addMinutes($duration)->subMinute();
                    // } else {
                    //      $model->JamSelesai = $model->JamMulai->copy()->endOfDay();
                    // }
                    $model->DurasiPaket = $duration;
                    // $model->HargaSewa = $basePrice;
                    $model->TaxTotal = 0;
                    $model->GrossTotal = 0;
                    $model->DiscTotal = 0;
                    $model->NetTotal = 0;

                    $model->KodeSales = "";
                    $model->save();

                    // Update Table Status to 1 (Active)
                    DB::table('titiklampu')
                        ->where('id', $tableId)
                        ->where('RecordOwnerID', $roid)
                        ->update(['status' => 1]);
                    
                } else {
                    throw new \Exception('Meja tidak aktif. Silakan pilih paket aktivasi terlebih dahulu.');
                }
            }

            $subtotalCart = 0;
            Log::debug('EMenu storeOrder: Processing Cart Items', ['cart_count' => count($cart)]);
            foreach ($cart as $id => $item) {
                $subtotalCart += $item['qty'] * $item['price'];
            }

            $serviceFeeTotal = $request->input('service_fee', 0);

            // 2. Data Mapping & Saving to tableorderfnb
            $lastLine = DB::table('tableorderfnb')
                ->where('NoTransaksi', $NoTransaksi)
                ->where('RecordOwnerID', $roid)
                ->max('LineNumber');
            
            $lineNumber = ($lastLine !== null) ? $lastLine + 1 : 0;

            Log::debug('EMenu storeOrder: Saving to tableorderfnb', ['NoTransaksi' => $NoTransaksi, 'StartLineNumber' => $lineNumber]);

            foreach ($cart as $id => $item) {
                $itemMaster = DB::table('itemmaster')->where('RecordOwnerID', $roid)->where('KodeItem', $id)->first();
                
                $itemSubtotal = $item['qty'] * $item['price'];
                $itemServiceFee = 0;
                if ($subtotalCart > 0) {
                    $itemServiceFee = ($itemSubtotal / $subtotalCart) * $serviceFeeTotal;
                }

                $modelDetail = new \App\Models\TableOrderFnB();
                $modelDetail->NoTransaksi = $NoTransaksi;
                $modelDetail->LineNumber = $lineNumber++;
                $modelDetail->KodeItem = $id;
                $modelDetail->Qty = $item['qty'];
                $modelDetail->Harga = $item['price'];
                $modelDetail->Tax = 0;
                $modelDetail->Discount = 0;
                $modelDetail->BiayaLayanan = $itemServiceFee; // Link the service fee here
                $modelDetail->LineTotal = $itemSubtotal;
                $modelDetail->RecordOwnerID = $roid;
                $modelDetail->LineStatus = 'O'; // Added LineStatus = 'O'
                $modelDetail->save();
                Log::debug('EMenu storeOrder: Saved item', ['id' => $id, 'qty' => $item['qty'], 'price' => $item['price']]);
            }

            DB::commit();
            $data['success'] = true;
            $data['message'] = 'Order placed successfully!';
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('EMenu storeOrder Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }

    public function createPaymentEMenu(Request $request)
    {
        $jsonData = $request->json()->all();

        $MetodeBayar = $jsonData['MetodeBayar'];
        $TotalPembelian = $jsonData['TotalPembelian'];
        $roid = $jsonData['roid'] ?? (Auth::check() ? Auth::user()->RecordOwnerID : null);

        if (!$roid) {
             return response()->json(['error' => "Record Owner ID tidak ditemukan"]);
        }

        $GetSetting = MetodePembayaran::where('RecordOwnerID', $roid)
                        ->where('id', $MetodeBayar)
                        ->first();
        
        if($GetSetting){
            Config::$serverKey = $GetSetting->ServerKey;
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            $transaction_details = [
                'order_id' => 'EM-' . uniqid(),
                'gross_amount' => floatval($TotalPembelian),
            ];

            $transaction = [
                'transaction_details' => $transaction_details,
                'payment_type' => 'qris',
                'qris' => []
            ];

            try {
                $snapToken = Snap::getSnapToken($transaction);
                return response()->json(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        } else {
            return response()->json(['error' => "Metode Pembayaran Tidak Valid"]);
        }
    }

    public function storeOrderEMenuQRIS(Request $request) 
    {
        $data = ['success' => false, 'message' => ''];
        DB::beginTransaction();

        try {
            $jsonData = $request->json()->all();
            $cart = $jsonData['cart'];
            $roid = $jsonData['roid'] ?? null;
            $tableId = $jsonData['table_id'];
            $paymentMethodId = $jsonData['payment_method'];
            $total = $jsonData['total'];
            $serviceFeeTotal = $jsonData['service_fee'] ?? 0;
            $reffPembayaran = $jsonData['reff_pembayaran'];

            if (empty($roid)) {
                throw new \Exception('RecordOwnerID (roid) is missing');
            }

            if (empty($cart)) {
                throw new \Exception('Cart is empty');
            }

            $currentDate = Carbon::now();
            $oCompany = Company::where('KodePartner', '=', $roid)->first();
            if (!$oCompany) {
                throw new \Exception('Company configuration not found');
            }

            $subtotalCart = 0;
            $tableRentalPrice = 0;
            $tablePPN = 0;
            $tablePajakHiburan = 0;
            $duration = 0;

            // 1. Find active session
            $activeSession = DB::table('tableorderheader')
                ->where('tableid', $tableId)
                ->where('RecordOwnerID', $roid)
                ->where('JamMulai', '<=', $currentDate)
                ->where(function ($query) use ($currentDate) {
                    $query->where('JamSelesai', '>=', $currentDate)
                          ->orWhereNull('JamSelesai');
                })
                ->where('Status', 1)
                ->where('DocumentStatus', 'O')
                ->first();

            $NoTransaksiTableOrder = "";
            if ($activeSession) {
                $NoTransaksiTableOrder = $activeSession->NoTransaksi;
            } else {
                // Check if booking data provided (activation)
                if (isset($jsonData['paketid']) && $jsonData['paketid'] != "") {
                    $numberingData = new DocumentNumbering();
                    $NoTransaksiTableOrder = $numberingData->GetNewDocMobile("POS","tableorderheader","NoTransaksi", $roid);
                    
                    $paket = Paket::find($jsonData['paketid']);
                    if (!$paket) throw new \Exception('Paket tidak valid');

                    $company = DB::table('company')->where('KodePartner', $roid)->first();
                    $duration = $jsonData['bookingDuration'] ?? 1;
                    if (($jsonData['JenisPaket'] ?? '') != 'JAMREALTIME') {
                        $duration = 0;
                    }

                    $basePrice = $paket->HargaNormal * $duration;
                    $ppnPercent = $company->PPN ?? 0;
                    $pajakHiburanPercent = $company->PajakHiburan ?? 0;
                    
                    $ppnAmt = ($ppnPercent / 100) * $basePrice;
                    $pajakHiburanAmt = ($pajakHiburanPercent / 100) * $basePrice;
                    $totalMeja = $basePrice + $ppnAmt + $pajakHiburanAmt;

                    $kodePelanggan = $jsonData['KodePelanggan'] ?? null;
                    if (empty($kodePelanggan) && !empty($jsonData['NoTlp1']) && !empty($jsonData['NamaPelanggan'])) {
                        $pelangganExist = DB::table('pelanggan')
                                            ->where('NoTlp1', $jsonData['NoTlp1'])
                                            ->where('RecordOwnerID', $roid)
                                            ->first();
                        
                        if ($pelangganExist) {
                            $kodePelanggan = $pelangganExist->KodePelanggan;
                        } else {
                            $numberingPelanggan = new DocumentNumbering();
                            $kodePelanggan = $numberingPelanggan->GetNewDocMobile("PLG","pelanggan","KodePelanggan", $roid);
                            
                            DB::table('pelanggan')->insert([
                                'KodePelanggan' => $kodePelanggan,
                                'NamaPelanggan' => $jsonData['NamaPelanggan'],
                                'KodeGrupPelanggan' => '',
                                'NoTlp1' => $jsonData['NoTlp1'],
                                'isPaidMembership' => 0,
                                'MaxPlay' => 0,
                                'MemberPrice' => 0,
                                'maxTimePerPlay' => 0,
                                'RecordOwnerID' => $roid
                            ]);
                        }
                    }

                    $model = new TableOrderHeader;
                    $model->NoTransaksi = $NoTransaksiTableOrder;
                    $model->TglTransaksi = $currentDate;
                    $model->TglPencatatan = $currentDate;
                    // $model->TglBooking = $currentDate->format('Y-m-d');
                    $model->RecordOwnerID = $roid;
                    $model->JenisPaket = $jsonData['JenisPaket'] ?? '';
                    $model->paketid = $jsonData['paketid'];
                    $model->tableid = $tableId;
                    $model->Status = 1;
                    $model->DocumentStatus = 'O';
                    $model->KodePelanggan = $kodePelanggan ?? 'CASH';
                    // $model->CreatedBy = 'EMENU';
                    $model->JamMulai = $currentDate;
                    
                    if ($model->JenisPaket == 'JAM' || $model->JenisPaket == 'PAKETMEMBER' || $model->JenisPaket == 'JAMREALTIME') {
                         $model->JamSelesai = $model->JamMulai->copy()->addHours($duration)->subMinute();
                    } 
                    // elseif ($model->JenisPaket == 'MENIT') {
                    //      $model->JamSelesai = $model->JamMulai->copy()->addMinutes($duration)->subMinute();
                    // } else {
                    //      $model->JamSelesai = $model->JamMulai->copy()->endOfDay();
                    // }
                    $model->DurasiPaket = $duration;
                    // $model->HargaSewa = $basePrice;
                    $model->TaxTotal = 0;
                    $model->GrossTotal = 0;
                    $model->DiscTotal = 0;
                    $model->NetTotal = 0;

                    $model->KodeSales = "";
                    $model->save();

                    // Store for invoice header
                    $tableRentalPrice = $basePrice;
                    $tablePPN = $ppnAmt;
                    $tablePajakHiburan = $pajakHiburanAmt;

                    // Update Table Status to 1 (Active)
                    DB::table('titiklampu')
                        ->where('id', $tableId)
                        ->where('RecordOwnerID', $roid)
                        ->update(['status' => 1]);
                } else {
                    throw new \Exception('Meja tidak aktif. Silakan pilih paket aktivasi terlebih dahulu.');
                }
            }

            // 2. Save items to tableorderfnb with status 'C'
            $lastLine = DB::table('tableorderfnb')
                ->where('NoTransaksi', $NoTransaksiTableOrder)
                ->where('RecordOwnerID', $roid)
                ->max('LineNumber');
            
            $lineNumber = ($lastLine !== null) ? $lastLine + 1 : 0;

            $subtotalCart = 0;
            foreach ($cart as $id => $item) {
                $subtotalCart += $item['qty'] * $item['price'];
            }

            foreach ($cart as $id => $item) {
                $itemSubtotal = $item['qty'] * $item['price'];
                $itemServiceFee = 0;
                if ($subtotalCart > 0) {
                    $itemServiceFee = ($itemSubtotal / $subtotalCart) * $serviceFeeTotal;
                }

                $modelDetail = new TableOrderFnB();
                $modelDetail->NoTransaksi = $NoTransaksiTableOrder;
                $modelDetail->LineNumber = $lineNumber++;
                $modelDetail->KodeItem = $id;
                $modelDetail->Qty = $item['qty'];
                $modelDetail->Harga = $item['price'];
                $modelDetail->Tax = 0;
                $modelDetail->Discount = 0;
                $modelDetail->BiayaLayanan = $itemServiceFee;
                $modelDetail->LineTotal = $itemSubtotal;
                $modelDetail->RecordOwnerID = $roid;
                $modelDetail->LineStatus = 'C'; 
                $modelDetail->save();
            }

            // 3. Create Invoices
            $numberingData = new DocumentNumbering();
            
            // --- F&B Invoice ---
            $NoTransaksiFakturFB = $numberingData->GetNewDocMobile("OINV", "fakturpenjualanheader", "NoTransaksi", $roid);
            $fakturHeaderFB = new FakturPenjualanHeader();
            $fakturHeaderFB->Periode = $currentDate->format('Ym');
            $fakturHeaderFB->Transaksi= 'POS';
            $fakturHeaderFB->NoTransaksi = $NoTransaksiFakturFB;
            $fakturHeaderFB->TglTransaksi = $currentDate;
            $fakturHeaderFB->TglJatuhTempo = $currentDate;
            $fakturHeaderFB->NoReff = 'EMENU-QRIS';
            $fakturHeaderFB->KodeSales = $activeSession->KodeSales ?? '';
            $fakturHeaderFB->KodePelanggan = $activeSession->KodePelanggan ?? 'CASH';
            $fakturHeaderFB->KodeTermin = $oCompany->TerminBayarPoS ?? '1';
            $fakturHeaderFB->Termin = 0;
            $fakturHeaderFB->TotalTransaksi = $subtotalCart;
            $fakturHeaderFB->Potongan = 0;
            $fakturHeaderFB->Pajak = 0;
            $fakturHeaderFB->PajakHiburan = 0;
            $fakturHeaderFB->BiayaLayanan = $serviceFeeTotal;
            $fakturHeaderFB->Pembulatan = 0;
            $fakturHeaderFB->TotalPembelian = $subtotalCart + $serviceFeeTotal;
            $fakturHeaderFB->TotalRetur = 0;
            $fakturHeaderFB->TotalPembayaran = $subtotalCart + $serviceFeeTotal;
            $fakturHeaderFB->RecordOwnerID = $roid;
            $fakturHeaderFB->Status = 'C'; 
            $fakturHeaderFB->CreatedBy = 'EMENU';
            $fakturHeaderFB->UpdatedBy = '';
            $fakturHeaderFB->Posted = 0;
            $fakturHeaderFB->save();

            // F&B Invoice Details
            $noUrutFakturFB = 0;
            foreach ($cart as $id => $item) {
                $itemMaster = ItemMaster::where('RecordOwnerID', $roid)->where('KodeItem', $id)->first();
                $fakturDetail = new FakturPenjualanDetail();
                $fakturDetail->NoTransaksi = $NoTransaksiFakturFB;
                $fakturDetail->NoUrut = $noUrutFakturFB++;
                $fakturDetail->BaseReff = $NoTransaksiTableOrder;
                $fakturDetail->BaseLine = -1;
                $fakturDetail->KodeItem = $id;
                $fakturDetail->Qty = $item['qty'];
                $fakturDetail->QtyKonversi = $item['qty'];
                $fakturDetail->Satuan = $itemMaster->Satuan ?? 'PCS';
                $fakturDetail->Harga = $item['price'];
                $fakturDetail->Discount = 0;
                $fakturDetail->HargaNet = $item['qty'] * $item['price'];
                $fakturDetail->LineStatus = 'O';
                $fakturDetail->KodeGudang = $oCompany->GudangPoS ?? 'HO';
                $fakturDetail->RecordOwnerID = $roid;
                $fakturDetail->save();
            }

            // --- Rental Invoice ---
            $NoTransaksiFakturRental = "";
            if ($tableRentalPrice > 0) {
                $NoTransaksiFakturRental = $numberingData->GetNewDoc("OINV", "fakturpenjualanheader", "NoTransaksi");
                $fakturHeaderRental = new FakturPenjualanHeader();
                $fakturHeaderRental->Periode = $currentDate->format('Ym');
                $fakturHeaderRental->Transaksi= 'POS';
                $fakturHeaderRental->NoTransaksi = $NoTransaksiFakturRental;
                $fakturHeaderRental->TglTransaksi = $currentDate;
                $fakturHeaderRental->TglJatuhTempo = $currentDate;
                $fakturHeaderRental->NoReff = 'POS';
                $fakturHeaderRental->KodeSales = $activeSession->KodeSales ?? '';
                $fakturHeaderRental->KodePelanggan = $activeSession->KodePelanggan ?? 'CASH';
                $fakturHeaderRental->KodeTermin = $oCompany->TerminBayarPoS ?? '1';
                $fakturHeaderRental->Termin = 0;
                $fakturHeaderRental->TotalTransaksi = $tableRentalPrice;
                $fakturHeaderRental->Potongan = 0;
                $fakturHeaderRental->Pajak = $tablePPN;
                $fakturHeaderRental->PajakHiburan = $tablePajakHiburan;
                $fakturHeaderRental->BiayaLayanan = 0;
                $fakturHeaderRental->Pembulatan = 0;
                $totalRental = $tableRentalPrice + $tablePPN + $tablePajakHiburan;
                $fakturHeaderRental->TotalPembelian = $totalRental;
                $fakturHeaderRental->TotalRetur = 0;
                $fakturHeaderRental->TotalPembayaran = $totalRental;
                $fakturHeaderRental->RecordOwnerID = $roid;
                $fakturHeaderRental->Status = 'C'; 
                $fakturHeaderRental->CreatedBy = 'EMENU';
                $fakturHeaderRental->UpdatedBy = '';
                $fakturHeaderRental->Posted = 0;
                $fakturHeaderRental->save();

                // Rental Invoice Detail
                $fakturDetailRental = new FakturPenjualanDetail();
                $fakturDetailRental->NoTransaksi = $NoTransaksiFakturRental;
                $fakturDetailRental->NoUrut = 0;
                $fakturDetailRental->BaseReff = $NoTransaksiTableOrder;
                $fakturDetailRental->BaseLine = -1;
                $fakturDetailRental->KodeItem = $oCompany->ItemHiburan;
                $fakturDetailRental->Qty = $duration;
                $fakturDetailRental->QtyKonversi = $duration;
                $fakturDetailRental->Satuan = 'JAM';
                $fakturDetailRental->Harga = $tableRentalPrice / max(1, $duration);
                $fakturDetailRental->Discount = 0;
                $fakturDetailRental->HargaNet = $tableRentalPrice;
                $fakturDetailRental->LineStatus = 'O';
                $fakturDetailRental->KodeGudang = $oCompany->GudangPoS ?? 'HO';
                $fakturDetailRental->RecordOwnerID = $roid;
                $fakturDetailRental->save();
            }

            // 5. Create PembayaranPenjualan (Payment)
            $NoTransaksiPembayaran = $numberingData->GetNewDoc("INPAY", "pembayaranpenjualanheader", "NoTransaksi");
            
            $paymentHeader = new PembayaranPenjualanHeader();
            $paymentHeader->Periode = $currentDate->format('Ym');
            $paymentHeader->NoTransaksi = $NoTransaksiPembayaran;
            $paymentHeader->TglTransaksi = $currentDate;
            $paymentHeader->KodePelanggan = $fakturHeaderFB->KodePelanggan;
            $paymentHeader->TotalPembelian = $total;
            $paymentHeader->TotalPembayaran = $total;
            $paymentHeader->BiayaLayanan = $serviceFeeTotal;
            $paymentHeader->KodeMetodePembayaran = $paymentMethodId;
            $paymentHeader->NoReff = $reffPembayaran;
            $paymentHeader->RecordOwnerID = $roid;
            $paymentHeader->Status = 'C';
            $paymentHeader->CreatedBy = 'EMENU';
            $paymentHeader->UpdatedBy = '';
            $paymentHeader->Posted = 0;
            $paymentHeader->save();

            // Link F&B Invoice to Payment
            $paymentDetailFB = new PembayaranPenjualanDetail();
            $paymentDetailFB->NoTransaksi = $NoTransaksiPembayaran;
            $paymentDetailFB->NoUrut = 0;
            $paymentDetailFB->BaseReff = $NoTransaksiFakturFB;
            $paymentDetailFB->TotalPembayaran = $subtotalCart + $serviceFeeTotal;
            $paymentDetailFB->KodeMetodePembayaran = $paymentMethodId;
            $paymentDetailFB->RecordOwnerID = $roid;
            $paymentDetailFB->save();

            // Link Rental Invoice to Payment if existing
            if ($NoTransaksiFakturRental != "") {
                $paymentDetailRental = new PembayaranPenjualanDetail();
                $paymentDetailRental->NoTransaksi = $NoTransaksiPembayaran;
                $paymentDetailRental->NoUrut = 1;
                $paymentDetailRental->BaseReff = $NoTransaksiFakturRental;
                $paymentDetailRental->TotalPembayaran = $tableRentalPrice + $tablePPN + $tablePajakHiburan;
                $paymentDetailRental->KodeMetodePembayaran = $paymentMethodId;
                $paymentDetailRental->RecordOwnerID = $roid;
                $paymentDetailRental->save();
            }

            DB::commit();
            $data['success'] = true;
            $data['message'] = 'Order and payment processed successfully!';
            $data['NoTransaksi'] = "";
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('EMenu QRIS Error: ' . $e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }

    public function downloadZipQR()
    {
        try {
            $titiklampu = TitikLampu::where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();

            if ($titiklampu->isEmpty()) {
                alert()->error('Error', 'Tidak ada data Titik Lampu untuk di download.');
                return redirect()->back();
            }

            $zipFileName = 'QR_Codes_' . Auth::user()->RecordOwnerID . '_' . date('YmdHis') . '.zip';
            $zipPath = storage_path('app/' . $zipFileName);

            $zip = new ZipArchive;
            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                foreach ($titiklampu as $v) {
                    $url = url('/emenu/' . base64_encode($v->id) . '/' . base64_encode($v->RecordOwnerID));
                    $qrCode = QrCode::size(500)->format('svg')->generate($url);
                    
                    // Clean filename to avoid issues
                    $fileName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $v->NamaTitikLampu) . '.svg';
                    $zip->addFromString($fileName, $qrCode);
                }
                $zip->close();
            } else {
                throw new \Exception('Gagal membuat file ZIP.');
            }

            return response()->download($zipPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            Log::error('Download QR ZIP Error: ' . $e->getMessage());
            alert()->error('Error', 'Gagal mendownload QR: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
