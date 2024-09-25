<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Services\FirebaseService;
use App\Models\Printer;
use App\Models\PrintingReciept;
use App\Models\GeneralModel;
use App\Models\FakturPenjualanHeader;
use App\Models\FakturPenjualanDetail;
use App\Models\Company;
class PrinterController extends Controller
{
	protected $firebaseService;
	protected $generalmodel;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
        $this->generalmodel = new GeneralModel();
    }

    public function Read(Request $request)
    {
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'token' => "");

    	$RecordOwnerID = $request->input('RecordOwnerID');
    	$DeviceAddress = $request->input('DeviceAddress');
    	try {
    		$printer = Printer::selectRaw('printer.*')
    					->where('printer.RecordOwnerID','=',$RecordOwnerID);

    		if ($DeviceAddress != "") {
    			$printer->where('printer.DeviceAddress','=', $DeviceAddress);
    		}

    		$data['success'] = true;
    		$data['data'] = $printer->get();


    	} catch (\Exception $e) {
    		$data['message'] = $e->getMessage();
    	}

    	return response()->json($data);
    }

    public function store(Request $request)
    {
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'token' => "");

    	try {
    		$this->validate($request, [
                'NamaPrinter'=>'required',
                'PrinterInterface'=>'required',
                'DeviceName'=>'required',
                'DeviceAddress'=>'required',
            ]);

    		$exist = Printer::where('DeviceAddress','=',$request->input('DeviceAddress'))
    				->where('RecordOwnerID','=',$request->input('RecordOwnerID'))->get();

    		if (count($exist) > 0) {
    			$data['success'] = false;
                $data['message'] = "Printer Sudah Ada";
                goto jump;
    		}

            $model = new Printer;
            $model->NamaPrinter = $request->input('NamaPrinter');
            $model->PrinterInterface = $request->input('PrinterInterface');
            $model->DeviceName = $request->input('DeviceName');
            $model->DeviceAddress = $request->input('DeviceAddress');
            $model->PrinterToken = $request->input('PrinterToken');
            $model->Used = 1;
            $model->RecordOwnerID = $request->input('RecordOwnerID');

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                $data['message'] = "Data Berhasil disimpan";
                
            }else{
                $data['message'] = "Data Gagal disimpan";
            }
    	} catch (\Exception $e) {
    		$data['message'] = $e->getMessage();
    	}
jump:
    	return response()->json($data);
    }

    public function edit(Request $request)
    {
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'token' => "");

    	try {
    		$this->validate($request, [
                'NamaPrinter'=>'required',
                'PrinterInterface'=>'required',
                'DeviceName'=>'required',
                'DeviceAddress'=>'required',
            ]);

            $model = Printer::where('id','=',$request->input('id'));

            if ($model) {
            	$update = DB::table('printer')
                			->where('id','=', $request->input('id'))
                            ->where('RecordOwnerID','=',$request->input('RecordOwnerID'))
                			->update(
                				[
                					'NamaPrinter'=>$request->input('NamaPrinter'),
                                    'PrinterInterface' => $request->input('PrinterInterface'),
                                    'DeviceName' => $request->input('DeviceName'),
                                    'DeviceAddress' => $request->input('DeviceAddress'),
                                    'PrinterToken' => $request->input('PrinterToken')
                				]
                			);

	            if ($update) {
	                $data['success'] = true;
	                $data['message'] = "Data Berhasil disimpan";
	            }else{
	                $data['message'] = "Data Gagal disimpan";
	            }
            }
            else{
            	$data['message'] = "Data Printer Tidak ditemukan";
            }
    	} catch (\Exception $e) {
    		$data['message'] = $e->getMessage();
    	}
    	return response()->json($data);
    }

    public function delete(Request $request)
    {
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'token' => "");

    	try {
    		$model = DB::table('printer')
	                ->where('id','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($model) {
	        	$data['success'] = true;
	            $data['message'] = "Data Berhasil dihapus";
	        }
	        else{
	        	$data['message'] = "Data gagal dihapus";
	        }
    	} catch (\Exception $e) {
    		$data['message'] = $e->getMessage();
    	}
    	return response()->json($data);
    }

    public function PrintRecieptUSB(Request $request){
        return view("setting.test48usb");
    }
    public function PrintRecieptTest(Request $request)
    {
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'token' => "");

    	$NoTransaksi = $this->generalmodel->generateRandomText();

    	// Get Printer Acceess
    	$printer = Printer::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
    				->where('Used','=', 1)->first();
    	// var_dump($printer);
    	if ($printer) {
    		$detailRecpt = array();

    		// Test
    		$temp = array(
    			'Item' => 'NISSIN 109G',
    			'Qty' => "10",
    			'Harga' => "2500",
                'Diskon' => "0",
    			'Total' => "25,000"
    		);
    		array_push($detailRecpt, $temp);

    		$temp = array(
    			'Item' => 'IDM GULA PSR PRM 1KG',
    			'Qty' => "25",
    			'Harga' => "5500",
                'Diskon' => "-150",
    			'Total' => "137,500"
    		);
    		array_push($detailRecpt, $temp);

    		$RecieptData = array(
    			'NoTRX' => $NoTransaksi,
    			'CompanyName' => 'AIS SYSTEM',
    			'CompanyAddress' => 'SOLO UTARA SURAKARTA JAWA TENGAH PINGGIR KOTA SELATAN',
    			'Logo' => 'http://localhost/xpos/images/misc/logo.png',
    			'TglTransaksi' => '2024-05-27 10:46',
    			'Kasir' =>'AJI',
    			'SubTotal' => "162,500",
    			'Diskon' => "3,750",
    			'PPN' =>0,
    			'GrandTotal' => "158,750",
    			'TotalBayar' => "158,750",
    			'Kembalian' => "0",
    			'MetodeBayar' => 'BCA-DEBIT',
    			'NoReff' => '-',
    			'FooterNote' => 'PEMBELIAN GRATIS JIKA TIDAK DIBERIKAN STRUK',
    			'PrintedDate' =>'2024-05-27 10:46',
                'PrinterWidth' => 48,
    			'Detail' => $detailRecpt
    		);

    		// Get Detail Transaction

    		// End DetailTrasaction
    		$model = new Printer();
	        $oParam = array(
	        	'title' => 'Test Printing',
	        	'body' => 'Test Print',
	        	'token' => $printer->PrinterToken,
	        	'data' => array(
	        		'DeviceAddress' => $printer->DeviceAddress,
                    'RecieptType' => 'PrintTest',
	        		'RecieptData' => json_encode($RecieptData)
	        	)
	        );
	        // $response = $this->firebaseService->sendNotification($title, $body, $token);
	        $response = $model->SendNotif($oParam,$this->firebaseService);

	        // Save RecieptData
	        $rcp = new PrintingReciept;
            $rcp->BaseReff = $NoTransaksi;
            $rcp->PrintingData = json_encode($RecieptData);
            $rcp->PrintCount = 1;
            $rcp->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $rcp->save();

            if ($save) {
            	$data['success'] = true;
            	$data['data']= $RecieptData;
            	$data['firebaseresult'] = $response;
            }

            return response()->json($data);
    	}
    }

    public function PrintRecieptRetail(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'token' => "");

        $NoTransaksi = $request->input('NoTransaksi');

        $company = Company::where('KodePartner','=',Auth::user()->RecordOwnerID)->first();

        if ($company) {
            if ($company->NamaPosPrinter == '') {
                $data['Printer Belum ditentukan, Silahkan melakukan setting di menu Master -> Pengaturan Toko -> Perusahaan'];
                goto jump;
            }

            if ($company->LebarKertas =='') {
                $data['Lebar Kertas Belum ditentukan, Silahkan melakukan setting di menu Master -> Pengaturan Toko -> Perusahaan'];
                goto jump;
            }

            // Good To go
            $printer = Printer::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('DeviceAddress','=', $company->NamaPosPrinter)->first();


            $sql = "fakturpenjualanheader.*, fakturpenjualandetail.*, COALESCE(itemmaster.NamaItem,'') NamaItem, COALESCE(metodepembayaran.NamaMetodePembayaran,'') NamaMetodePembayaran ";
            $trx = FakturPenjualanHeader::selectRaw($sql)
                    ->leftJoin('fakturpenjualandetail', function ($value){
                        $value->on('fakturpenjualandetail.NoTransaksi','=','fakturpenjualanheader.NoTransaksi')
                        ->on('fakturpenjualandetail.RecordOwnerID','=','fakturpenjualanheader.RecordOwnerID');
                    })
                    ->leftJoin('itemmaster', function ($value){
                        $value->on('fakturpenjualandetail.KodeItem','=','itemmaster.KodeItem')
                        ->on('fakturpenjualandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
                    })
                    ->leftJoin('metodepembayaran', function ($value){
                        $value->on('fakturpenjualanheader.MetodeBayar','=','metodepembayaran.id')
                        ->on('fakturpenjualanheader.RecordOwnerID','=','metodepembayaran.RecordOwnerID');
                    })
                    ->where('fakturpenjualanheader.RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('fakturpenjualanheader.NoTransaksi','=',$NoTransaksi)->get();


            $detailRecpt = array();

            $RecieptData = array(
                'NoTRX' => $NoTransaksi,
                'CompanyName' => $company->NamaPartner,
                'CompanyAddress' => $company->AlamatTagihan,
                'Logo' => '',
                'PPN' =>0,
                'NoReff' => '-',
                'FooterNote' => $company->FooterNota,
                'PrinterWidth' => intval($company->LebarKertas),
            );

            foreach ($trx as $key) {
                $temp = array(
                    'Item' => $key->NamaItem,
                    'Qty' => $key->Qty,
                    'Harga' => $key->Harga,
                    'Diskon' => $key->Discount * -1,
                    'Total' => number_format($key->HargaNet,0)
                );

                array_push($detailRecpt, $temp);


                $RecieptData['TglTransaksi'] = $key->TglTransaksi;
                $RecieptData['Kasir'] = $key->CreatedBy;
                $RecieptData['SubTotal'] = number_format($key->TotalTransaksi,0);
                $RecieptData['Diskon'] = number_format($key->Potongan,0);
                $RecieptData['GrandTotal'] = number_format($key->TotalPembelian,0);
                $RecieptData['TotalBayar'] = number_format($key->TotalPembayaran,0);
                $RecieptData['Kembalian'] = number_format(($key->TotalPembayaran - $key->TotalPembelian),0);
                $RecieptData['MetodeBayar'] = $key->NamaMetodePembayaran;
                $RecieptData['PrintedDate'] = date('Y-m-d H:i:s', strtotime($key->created_at));

            }
            
            $RecieptData['Detail'] = $detailRecpt;
            
            $model = new Printer();
            $oParam = array(
                'title' => 'Printing Reciept No ' .$NoTransaksi,
                'body' => 'Printing Reciept No ' .$NoTransaksi,
                'token' => $printer->PrinterToken,
                'data' => array(
                    'DeviceAddress' => $printer->DeviceAddress,
                    'RecieptType' => 'Retail',
                    'RecieptData' => json_encode($RecieptData)
                )
            );
            // $response = $this->firebaseService->sendNotification($title, $body, $token);
            $response = $model->SendNotif($oParam,$this->firebaseService);

            // Save RecieptData
            $rcp = new PrintingReciept;
            $rcp->BaseReff = $NoTransaksi;
            $rcp->PrintingData = json_encode($RecieptData);
            $rcp->PrintCount = 1;
            $rcp->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $rcp->save();

            if ($save) {
                $data['success'] = true;
                $data['data']= $RecieptData;
                $data['firebaseresult'] = $response;
            }
            
        }

        jump:
        return response()->json($data);
    }

    public function TestNotif(Request $request)
    {
    	try {
    		$title = $request->input('title');
	        $body = $request->input('body');
	        $token = $request->input('token');

	        $model = new Printer();
	        $oParam = array(
	        	'title' => $title,
	        	'body' => $body,
	        	'token' => $token,
	        	'data' => array(
	        		'title' =>'1234445',
	        		'body' => 'ssd'
	        	)
	        );
	        // $response = $this->firebaseService->sendNotification($title, $body, $token);
	        $response = $model->SendNotif($oParam,$this->firebaseService);

	        return response()->json($response);
    	} catch (\Exception $e) {
    		return response()->json(['message' => $e->getMessage()]);
    	}
    }
}
