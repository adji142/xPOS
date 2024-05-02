<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

use App\Models\Company;

class CompanyController extends Controller
{
    public function View(Request $request)
    {
    	// Test Printer



    	// exec("print /d:USB001: D:\testprinting.txt");
        $company = Company::Where('KodePartner','=',Auth::user()->RecordOwnerID)->get();

        $title = 'Delete Data Perusahaan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("setting.CompanySetting",[
            'company' => $company
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
									'icon' => empty($request->input('icon')) ? "" : $request->input('icon'),
									'NPWP' => empty($request->input('NPWP')) ? "" : $request->input('NPWP'),
									'TglPKP' => empty($request->input('TglPKP')) ? "1999-01-01" : $request->input('TglPKP'),
									'PPN' => empty($request->input('PPN')) ? 0 : $request->input('PPN'),
									'isHargaJualIncludePPN' => empty($request->input('isHargaJualIncludePPN')) ? 0 : $request->input('isHargaJualIncludePPN'),
									'NamaPosPrinter' => empty($request->input('NamaPosPrinter')) ? "" : $request->input('NamaPosPrinter'),
									'FooterNota' => empty($request->input('FooterNota')) ? "" : $request->input('FooterNota'),
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Perusahaan berhasil disimpan.');
                    return redirect('companysetting');
                }else{
                    throw new \Exception('Edit Perusahaan Gagal');
                }
            } else{
                throw new \Exception('Perusahaan not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
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
