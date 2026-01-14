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
                })->where('titiklampu.RecordOwnerID','=',Auth::user()->RecordOwnerID);
        
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
        $controller = MasterController::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
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
        
        $midtransclientkey = "";
        if ($company->MidtransClientKey != null) {
            $midtransclientkey = $company->MidtransClientKey;
        }

        return view('emenu.order', [
            'titikLampu' => $titikLampu,
            'menus' => $menus,
            'company' => $company,
            'roid' => $decodedRoid,
            'paymentMethods' => $paymentMethods,
            'midtransclientkey' => $midtransclientkey
        ]);
    }

    public function generateQRCode()
    {
        $titiklampu = TitikLampu::where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();

        return view('controller.titiklampu-qrcode', [
            'titiklampu' => $titiklampu
        ]);
    }

    public function storeOrder(Request $request)
    {
        $data = ['success' => false, 'message' => ''];
        DB::beginTransaction();

        try {
            $cart = $request->input('cart');
            $roid = $request->input('roid');
            $tableId = $request->input('table_id');
            $paymentMethod = $request->input('payment_method');
            $total = $request->input('total');

            if (empty($cart)) {
                throw new \Exception('Cart is empty');
            }

            $currentDate = Carbon::now();

            // 1. Validation: Check active session in tableorderheader
            $activeSession = DB::table('tableorderheader')
                ->where('tableid', $tableId)
                ->where('RecordOwnerID', $roid)
                ->whereDate('TglTransaksi', $currentDate->toDateString())
                ->where('Status', 1)
                ->where('DocumentStatus', 'O')
                ->first();

            if (!$activeSession) {
                throw new \Exception('Meja tidak aktif. Silakan hubungi Kasir atau Petugas Resto.');
            }

            $NoTransaksi = $activeSession->NoTransaksi;

            $subtotalCart = 0;
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
            }

            DB::commit();
            $data['success'] = true;
            $data['message'] = 'Order placed successfully!';
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('EMenu Error: ' . $e->getMessage());
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
            $roid = $jsonData['roid'];
            $tableId = $jsonData['table_id'];
            $paymentMethodId = $jsonData['payment_method'];
            $total = $jsonData['total'];
            $serviceFeeTotal = $jsonData['service_fee'] ?? 0;
            $reffPembayaran = $jsonData['reff_pembayaran'];

            if (empty($cart)) {
                throw new \Exception('Cart is empty');
            }

            $currentDate = Carbon::now();
            $oCompany = Company::where('KodePartner', '=', $roid)->first();
            if (!$oCompany) {
                throw new \Exception('Company configuration not found');
            }

            // 1. Find active session
            $activeSession = DB::table('tableorderheader')
                ->where('tableid', $tableId)
                ->where('RecordOwnerID', $roid)
                ->whereDate('TglTransaksi', $currentDate->toDateString())
                ->where('Status', 1)
                ->where('DocumentStatus', 'O')
                ->first();

            if (!$activeSession) {
                throw new \Exception('Meja tidak aktif. Silakan hubungi Kasir atau Petugas Resto.');
            }

            $NoTransaksiTableOrder = $activeSession->NoTransaksi;

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

            // 3. Create FakturPenjualan (Invoice)
            $numberingData = new DocumentNumbering();
            $NoTransaksiFaktur = $numberingData->GetNewDoc("OINV", "fakturpenjualanheader", "NoTransaksi");

            $fakturHeader = new FakturPenjualanHeader();
            $fakturHeader->Periode = $currentDate->format('Ym');
            $fakturHeader->Transaksi= 'POS';
            $fakturHeader->NoTransaksi = $NoTransaksiFaktur;
            $fakturHeader->TglTransaksi = $currentDate;
            $fakturHeader->TglJatuhTempo = $currentDate;
            $fakturHeader->NoReff = 'EMENU-QRIS';
            $fakturHeader->KodeSales = $activeSession->KodeSales ?? '';
            $fakturHeader->KodePelanggan = $activeSession->KodePelanggan ?? 'CASH';
            $fakturHeader->KodeTermin = $oCompany->TerminBayarPoS ?? '1';
            $fakturHeader->Termin = 0;
            $fakturHeader->TotalTransaksi = $subtotalCart;
            $fakturHeader->Potongan = 0;
            $fakturHeader->Pajak = 0;
            $fakturHeader->PajakHiburan = 0;
            $fakturHeader->BiayaLayanan = $serviceFeeTotal;
            $fakturHeader->Pembulatan = 0;
            $fakturHeader->TotalPembelian = $total;
            $fakturHeader->TotalRetur = 0;
            $fakturHeader->TotalPembayaran = $total;
            $fakturHeader->RecordOwnerID = $roid;
            $fakturHeader->Status = 'C'; 
            $fakturHeader->CreatedBy = 'EMENU';
            $fakturHeader->UpdatedBy = '';
            $fakturHeader->Posted = 0;
            $fakturHeader->save();

            // 4. Create FakturPenjualanDetail
            $noUrutFaktur = 0;
            foreach ($cart as $id => $item) {
                $itemMaster = ItemMaster::where('RecordOwnerID', $roid)->where('KodeItem', $id)->first();
                
                $fakturDetail = new FakturPenjualanDetail();
                $fakturDetail->NoTransaksi = $NoTransaksiFaktur;
                $fakturDetail->NoUrut = $noUrutFaktur++;
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

            // 5. Create PembayaranPenjualan (Payment)
            $NoTransaksiPembayaran = $numberingData->GetNewDoc("INPAY", "pembayaranpenjualanheader", "NoTransaksi");
            
            $paymentHeader = new PembayaranPenjualanHeader();
            $paymentHeader->Periode = $currentDate->format('Ym');
            $paymentHeader->NoTransaksi = $NoTransaksiPembayaran;
            $paymentHeader->TglTransaksi = $currentDate;
            $paymentHeader->KodePelanggan = $fakturHeader->KodePelanggan;
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

            $paymentDetail = new PembayaranPenjualanDetail();
            $paymentDetail->NoTransaksi = $NoTransaksiPembayaran;
            $paymentDetail->NoUrut = 0;
            $paymentDetail->BaseReff = $NoTransaksiFaktur;
            $paymentDetail->TotalPembayaran = $total;
            $paymentDetail->KodeMetodePembayaran = $paymentMethodId;
            $paymentDetail->RecordOwnerID = $roid;
            $paymentDetail->save();

            DB::commit();
            $data['success'] = true;
            $data['message'] = 'Order and payment processed successfully!';
            $data['NoTransaksi'] = $NoTransaksiFaktur;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('EMenu QRIS Error: ' . $e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }
}
