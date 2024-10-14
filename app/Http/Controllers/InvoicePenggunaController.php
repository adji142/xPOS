<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Company;
use App\Models\InvoicePenggunaHeader;
use App\Models\InvoicePenggunaDetail;
use App\Models\PembayaranLangganan;

use Midtrans\Config;
use Midtrans\Snap;
class InvoicePenggunaController extends Controller
{
    public function View(Request $request){
        $datatagihan = InvoicePenggunaHeader::where('TotalBayar','<', 'TotalTagihan')->get();
        return view("Admin.InvoicePelanggan",[
            'datatagihan' => $datatagihan
        ]);
    }
    public function Form($NoTransaksi = null){

    }

    function GetHeader(Request $request) {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');

        $tagihan = InvoicePenggunaHeader::selectRaw("tagihanpenggunaheader.*, subscriptionheader.NamaSubscription, company.NamaPartner ")
                    ->leftJoin('subscriptionheader', 'subscriptionheader.NoTransaksi', 'tagihanpenggunaheader.KodePaketLangganan')
                    ->leftJoin('company', 'company.KodePartner', 'tagihanpenggunaheader.KodePelanggan')
                    ->whereBetween('tagihanpenggunaheader.TglTransaksi', [$TglAwal, $TglAkhir])
                    ->get();
        $data['data'] = $tagihan;
        return response()->json($data);
    }

    function GetPerCompany(Request $request)  {
        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');
        $Status = $request->input('Status');

        $tagihan = InvoicePenggunaHeader::selectRaw("tagihanpenggunaheader.*, subscriptionheader.NamaSubscription, company.NamaPartner, case when tagihanpenggunaheader.TotalBayar > 0 THEN 'LUNAS' ELSE 'BELUM DIBAYAR' END StatusPembayaran ")
                    ->leftJoin('subscriptionheader', 'subscriptionheader.NoTransaksi', 'tagihanpenggunaheader.KodePaketLangganan')
                    ->leftJoin('company', 'company.KodePartner', 'tagihanpenggunaheader.KodePelanggan')
                    ->whereBetween('tagihanpenggunaheader.TglTransaksi', [$TglAwal, $TglAkhir])
                    ->where('KodePelangga n', Auth::user()->RecordOwnerID);
        if ($Status != "") {
            $tagihan->where('tagihanpenggunaheader.Status', $Status);
        }

        return response()->json($tagihan->get());
    }
    public function storeJson(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
        Log::debug($request->all());
        DB::beginTransaction();

        $errorCount = 0;
        $jsonData = $request->json()->all();

        try {
            $NoTransaksi = "";
            $prefix = "INV";
            $lastNoTrx = InvoicePenggunaHeader::where(DB::raw('LEFT(NoTransaksi,3)'),'=',$prefix)->count()+1;
            $NoTransaksi = $prefix.str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);

            $model = new InvoicePenggunaHeader;
            $model->NoTransaksi = $NoTransaksi;
            $model->TglTransaksi = $jsonData['TglTransaksi'];
            $model->TglJatuhTempo = $jsonData['TglJatuhTempo'];
            $model->KodePaketLangganan = $jsonData['KodePaketLangganan'];
            $model->Catatan = $jsonData['Catatan'];
            $model->KodePelanggan = $jsonData['KodePelanggan'];
            $model->TotalTagihan = $jsonData['TotalTagihan'];
            $model->TotalBayar = $jsonData['TotalBayar'];
            $model->Status = 'O';
            $model->StartSubs = $jsonData['StartSubs'];
            $model->EndSubs = $jsonData['EndSubs'];
            $save = $model->save();

            if (!$save) {
                $data['message'] = "Gagal Menyimpan Data Tagihan Pengguna";
                $errorCount += 1;
                goto jump;
            }

            if (count($jsonData['Detail']) == 0) {
                $data['message'] = "Data Detail Item Harus diisi";
                $errorCount += 1;
                goto jump;
            }

            $index = 0;
            foreach ($jsonData['Detail'] as $key) {
                $modelDetail = new InvoicePenggunaDetail;

                $modelDetail->NoTransaksi = $NoTransaksi;
                $modelDetail->NoUrut = $index;
                $modelDetail->Harga = $key['Harga'];
                $modelDetail->Catatan = $key['Catatan'];
                $modelDetail->KodePelanggan = $key['KodePelanggan'];

                $save = $modelDetail->save();

                if (!$save) {
                    $data['message'] = "Gagal Menyimpan Data Detail di Row ".$key->NoUrut;
                    $errorCount += 1;
                    goto jump;
                }

                $index += 1;
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

    public function SaveInvoice($jsonData){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
        // Log::debug($request->all());
        DB::beginTransaction();

        $errorCount = 0;
        // $jsonData = $request->json()->all();

        try {
            $NoTransaksi = "";
            $prefix = "INV";
            $lastNoTrx = InvoicePenggunaHeader::where(DB::raw('LEFT(NoTransaksi,3)'),'=',$prefix)->count()+1;
            $NoTransaksi = $prefix.str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);

            $model = new InvoicePenggunaHeader;
            $model->NoTransaksi = $NoTransaksi;
            $model->TglTransaksi = $jsonData['TglTransaksi'];
            $model->TglJatuhTempo = $jsonData['TglJatuhTempo'];
            $model->KodePaketLangganan = $jsonData['KodePaketLangganan'];
            $model->Catatan = $jsonData['Catatan'];
            $model->KodePelanggan = $jsonData['KodePelanggan'];
            $model->TotalTagihan = $jsonData['TotalTagihan'];
            $model->TotalBayar = $jsonData['TotalBayar'];
            $model->Status = 'O';
            $model->StartSubs = $jsonData['StartSubs'];
            $model->EndSubs = $jsonData['EndSubs'];
            $save = $model->save();

            if (!$save) {
                $data['message'] = "Gagal Menyimpan Data Tagihan Pengguna";
                $errorCount += 1;
                goto jump;
            }

            if (count($jsonData['Detail']) == 0) {
                $data['message'] = "Data Detail Item Harus diisi";
                $errorCount += 1;
                goto jump;
            }

            $index = 0;
            // var_dump($jsonData['Detail']["Harga"]);

            $modelDetail = new InvoicePenggunaDetail;

            $modelDetail->NoTransaksi = $NoTransaksi;
            $modelDetail->NoUrut = 0;
            $modelDetail->Harga = $jsonData['Detail']['Harga'];
            $modelDetail->Catatan = $jsonData['Detail']['Catatan'];
            $modelDetail->KodePelanggan = $jsonData['Detail']['KodePelanggan'];

            $save = $modelDetail->save();

            if (!$save) {
                $data['message'] = "Gagal Menyimpan Data Detail di Row 0";
                $errorCount += 1;
                goto jump;
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

    public function createMidTransTransaction(Request $request)
    {
		$jsonData = $request->json()->all();

		$TotalPembelian = $jsonData['TotalPembelian'];
		$oCompany = Company::where('KodePartner','=',Auth::user()->RecordOwnerID)->first();
		
		Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Data transaksi yang akan dikirimkan ke Midtrans
        $transaction_details = [
            'order_id' => uniqid(),
            'gross_amount' => floatval($TotalPembelian), // Jumlah total transaksi
        ];

        $customer_details = [
            'first_name' => $oCompany->NamaPartner,
        ];

        $transaction = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        ];

        try {
            $snapToken = Snap::getSnapToken($transaction);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    function SimpanPembayaran(Request $request) {
        Log::debug($request->all());
        try {
            $NoTransaksi = "";
            $prefix = "PMB";
            $lastNoTrx = PembayaranLangganan::where(DB::raw('LEFT(NoTransaksi,3)'),'=',$prefix)->count()+1;
            $NoTransaksi = $prefix.str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);

            $model = new PembayaranLangganan;
            
            $model->NoTransaksi = $NoTransaksi;
            $model->TglTransaksi = $request->input('TglTransaksi');
            $model->BaseReff = $request->input('BaseReff');
            $model->MetodePembayaran = $request->input('MetodePembayaran');
            $model->NoReff = $request->input('NoReff');
            $model->Keterangan = $request->input('Keterangan');
            $model->TotalBayar = $request->input('TotalBayar');

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Pembayaran Berhasil disimpan.');
                return redirect('tagihanpengguna');
                
            }else{
                throw new \Exception('Penambahan Data Pembayaran Gagal');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    function SimpanPembayaranJson(Request $request) {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jsonData = $request->json()->all();
        try {
            $NoTransaksi = "";
            $prefix = "PMB";
            $lastNoTrx = PembayaranLangganan::where(DB::raw('LEFT(NoTransaksi,3)'),'=',$prefix)->count()+1;
            $NoTransaksi = $prefix.str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);

            $model = new PembayaranLangganan;
            
            $model->NoTransaksi = $NoTransaksi;
            $model->TglTransaksi = Carbon::now()->format('Y-m-d');
            $model->BaseReff = $jsonData['BaseReff'];
            $model->MetodePembayaran = $jsonData['MetodePembayaran'];
            $model->NoReff = $jsonData['NoReff'];
            $model->Keterangan = $jsonData['Keterangan'];
            $model->TotalBayar = $jsonData['TotalBayar'];

            $save = $model->save();

            if ($save) {
                $data['success'] =true;
            }else{
                $data['success'] =false;
                $data['message'] = 'Penambahan Data Pembayaran Gagal';
            }
        } catch (\Exception $e) {
            $data['success'] =false;
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }
}
