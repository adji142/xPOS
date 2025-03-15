<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\TitikLampu;
use App\Models\Paket;
use App\Models\BookingOnline;
use App\Models\Pelanggan;
use App\Models\DocumentNumbering;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PelangganExport;
use App\Models\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\KonfirmasiPembayaranMail;
use App\Mail\SendMail;

use Midtrans\Config;
use Midtrans\Snap;

class BookingOnlineController extends Controller
{
    public function getData()
{
    $company = Company::where('KodePartner','=',Auth::user()->RecordOwnerID)->get();
    $titikLampu = TitikLampu::where('BisaDipesan', 1)
    ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
    ->get();
    $gallery = Company::select('ImageGallery1', 'ImageGallery2', 'ImageGallery3','ImageGallery4','ImageGallery5','ImageGallery6','ImageGallery7','ImageGallery8','ImageGallery9','ImageGallery10','ImageGallery11','ImageGallery12')
    ->where('KodePartner', Auth::user()->RecordOwnerID)
    ->get();
    $paketTransaksi = Paket::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
    $user= User::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

    //dd($company);

    //dd($paketTransaksi);


    return view('Transaksi.Penjualan.PoS.BookingOnline', compact('company', 'titikLampu','gallery','paketTransaksi','user'));
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


function SimpanPembayaranJson(Request $request) {
    $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

    $jsonData = $request->json()->all();
    //dd($jsonData);
    DB::beginTransaction(); // Mulai transaksi
    try {
        $NoTransaksi = "";
        $prefix = date('ymd'); // Format YYMMDD
        $lastNoTrx = BookingOnline::where(DB::raw('LEFT(NoTransaksi,6)'),'=',$prefix)->count() + 1;
        $NoTransaksi = $prefix . str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);
        
        // Cek apakah email sudah ada di tabel pelanggan
        $existingPelanggan = Pelanggan::where('Email', $jsonData['Email'])->first();

        if ($existingPelanggan) {
            $KodePelanggan = $existingPelanggan->KodePelanggan;
        } else {
            $numberingData = new DocumentNumbering();
            $KodePelanggan = $numberingData->GetNewDoc("PLG", "pelanggan", "KodePelanggan");
        }


        $model = new BookingOnline();
        $model->NoTransaksi = $NoTransaksi;
        $model->TglBooking = $jsonData['TglBooking'];
        $model->JamMulai = $jsonData['JamMulai'];
        $model->JamSelesai = $jsonData['JamSelesai'];
        $model->mejaID = $jsonData['mejaID'];
        $model->paketid = $jsonData['paketid'];
        $model->KodeSales = $jsonData['KodeSales'];
        $model->KodePelanggan =  $KodePelanggan;
        $model->StatusTransaksi = $jsonData['StatusTransaksi'];
        $model->Keterangan = $jsonData['Keterangan'];
        $model->ExtraRequest = $jsonData['ExtraRequest'];
        $model->TotalTransaksi = $jsonData['TotalTransaksi'];
        $model->TotalTax = $jsonData['TotalTax'];
        $model->TotalDiskon = $jsonData['TotalDiskon'];
        $model->TotalLainLain = $jsonData['TotalLainLain'];
        $model->NetTotal = $jsonData['NetTotal'];
        $model->RecordOwnerID = Auth::user()->RecordOwnerID;

        if (!$model->save()) {
            throw new \Exception('Penambahan Data Pembayaran Gagal');
        }

         // Jika pelanggan baru, tambahkan ke tabel pelanggan
         if (!$existingPelanggan) {
            $pelanggan = new Pelanggan();
            $pelanggan->KodePelanggan = $KodePelanggan;
            $pelanggan->NamaPelanggan = $jsonData['NamaPelanggan'];
            $pelanggan->KodeGrupPelanggan = "1001";
            $pelanggan->Email = $jsonData['Email'];
            $pelanggan->NoTlp1 = $jsonData['NoTlp1'];
            $pelanggan->Status = 1;
            $pelanggan->RecordOwnerID = Auth::user()->RecordOwnerID;

            if (!$pelanggan->save()) {
                throw new \Exception('Penambahan Data Pelanggan Gagal');
            }
        }


        // Jika semuanya berhasil, commit transaksi
        DB::commit();

         // Send Email
         $booking = [
            'Email' => $jsonData['Email'],
            'NoTransaksi' => $NoTransaksi,
            'TglBooking' => $jsonData['TglBooking'],
            'JamMulai' => $jsonData['JamMulai'],
            'JamSelesai' => $jsonData['JamSelesai']
        ];

  
       
$emailPelanggan = Pelanggan::where('KodePelanggan', $KodePelanggan)->first();
//dd($data);

if ($emailPelanggan) {
  
    Mail::to($emailPelanggan->Email)->send(new KonfirmasiPembayaranMail($booking));
}

        $data['success'] = true;
        $data['message'] = 'Data berhasil disimpan';
        //return response()->json($data);

    } catch (\Exception $e) {
        DB::rollBack(); 
        $data['success'] = false;
        $data['message'] = $e->getMessage();
        
    }
    return response()->json($data);
}

public function getBookingsByDate(Request $request) {
    $tanggal = $request->input('tanggal');
    $idMeja = $request->input('idMeja'); 

       $bookings = BookingOnline::whereDate('TglBooking', $tanggal)
        ->where('mejaID', $idMeja)
        ->select('JamMulai', 'JamSelesai')
        ->get();

    return response()->json($bookings);
}

}
