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
}
