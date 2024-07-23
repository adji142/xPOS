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

use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

use App\Models\Company;
use App\Models\Printer;
use App\Models\Gudang;
use App\Models\Termin;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ItemMasterImport;
use App\Imports\HargaJualImport;
use App\Imports\PelangganImport;
use App\Imports\SupplierImport;

use App\Exceptions\CustomImportException;
use Throwable;

class CompanyController extends Controller
{
    public function View(Request $request)
    {
    	// Test Printer

    	// exec("print /d:USB001: D:\testprinting.txt");
        $clientOS = $request->input('client_os');
        if ($clientOS == "Windows") {
            

            $printers = shell_exec('wmic printer get name');
            $printerList = explode("\n", $printers);
            $printerList = array_filter(array_map('trim', $printerList));
            array_shift($printerList);

            foreach ($printerList as $printername) {
                $exist = Printer::where('DeviceName','=',$printername)
                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

                if (count($exist) > 0) {
                    goto skip;
                }
                // echo $printer . "<br>";
                $model = new Printer;
                $model->NamaPrinter = $printername;
                $model->PrinterInterface = 'USB';
                $model->DeviceName = $printername;
                $model->DeviceAddress = $printername;
                $model->PrinterToken = '-';
                $model->Used = 0;
                $model->RecordOwnerID = Auth::user()->RecordOwnerID;

                $save = $model->save();
                skip:
            }
            // var_dump($printerList);
            // echo $printerList[0];
        
        }

        $company = Company::Where('KodePartner','=',Auth::user()->RecordOwnerID)
                    ->leftJoin('subscriptionheader', 'company.KodePaketLangganan', 'subscriptionheader.NoTransaksi')
                    ->get();
        $printer = Printer::Where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        $gudang = Gudang::Where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        $temin = Termin::Where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $title = 'Delete Data Perusahaan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("setting.CompanySetting",[
            'company' => $company,
            'printer' => $printer,
            'gudang' => $gudang,
            'temin' => $temin,
            'clientOS' => $clientOS
        ]);
    }
    public function edit(Request $request){
    	Log::debug($request->all());
        try {

            $model = Company::where('KodePartner','=',Auth::user()->RecordOwnerID);

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('company')
                            ->where('KodePartner','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
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
                                    'JenisUsaha' => empty($request->input('JenisUsaha')) ? "" : $request->input('JenisUsaha'),
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
                                    'ShowLinkInReciept' => 0
                				]
                			);

                $clientOS = $request->input('client_os');

                if ($clientOS == "Windows") {
                    $printername = empty($request->input('NamaPosPrinter')) ? "" : $request->input('NamaPosPrinter');
                    $command = 'wmic printer where name="' .$printername. '" call setdefaultprinter';
                    $output = shell_exec($command);
                }
                alert()->success('Success','Data Perusahaan berhasil disimpan.');
                return redirect('companysetting');
            } else{
                throw new \Exception('Perusahaan not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
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
}
