<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\TableOrderHeader;

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
use App\Models\DiscountVoucher;
use App\Models\MetodePembayaran;

use Illuminate\Support\Facades\Mail;
use App\Mail\KonfirmasiPembayaranMail;
use App\Mail\SendMail;

use Midtrans\Config;
use Midtrans\Snap;

class BookingOnlineController extends Controller
{
    public function index($id)
    {

        $idE = base64_decode($id); // ⬅️ decode di sini
        $company = Company::where('KodePartner','=',$idE)->first();
        $titikLampu = TitikLampu::where('BisaDipesan', 1)
        ->where('RecordOwnerID', $idE)
        ->get();
        $gallery = Company::select('ImageGallery1', 'ImageGallery2', 'ImageGallery3','ImageGallery4','ImageGallery5','ImageGallery6','ImageGallery7','ImageGallery8','ImageGallery9','ImageGallery10','ImageGallery11','ImageGallery12')
        ->where('KodePartner', $idE)
        ->get();
        $paketTransaksi = Paket::where('RecordOwnerID','=',$idE)->get();
        $user= User::where('RecordOwnerID','=',$idE)->first();

        //dd($company);

        //dd($paketTransaksi);


        return view('Transaksi.Penjualan.PoS.BookingOnline', compact('company', 'titikLampu','gallery','paketTransaksi','user'));
    }

    public function getData()
{
    $company = Company::where('KodePartner','=',Auth::user()->RecordOwnerID)->first();
    $titikLampu = TitikLampu::where('BisaDipesan', 1)
    ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
    ->get();
    $gallery = Company::select('ImageGallery1', 'ImageGallery2', 'ImageGallery3','ImageGallery4','ImageGallery5','ImageGallery6','ImageGallery7','ImageGallery8','ImageGallery9','ImageGallery10','ImageGallery11','ImageGallery12')
    ->where('KodePartner', Auth::user()->RecordOwnerID)
    ->get();
    $paketTransaksi = Paket::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
    $user= User::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->first();

    //dd($company);

    //dd($paketTransaksi);


    return view('Transaksi.Penjualan.PoS.BookingOnline', compact('company', 'titikLampu','gallery','paketTransaksi','user'));
}

public function createMidTransTransaction(Request $request)
{
    $jsonData = $request->json()->all();

    $TotalPembelian = $jsonData['TotalPembelian'];
    $oCompany = Company::where('KodePartner','=',$jsonData['kodePartner'])->first();

    $midtransdata = MetodePembayaran::where('RecordOwnerID','=',$jsonData['kodePartner'])
                            ->where('MetodeVerifikasi','=','AUTO')->first();
    $midtransclientkey = "";
    $MetodePembayaranAutoID = -1;
    dd($midtransdata->ClientKey);
    if ($midtransdata) {
        $midtransclientkey = $midtransdata->ClientKey;
        $MetodePembayaranAutoID = $midtransdata->id;
    }

    if ($midtransclientkey == "") {
        return response()->json(['error' => 'Pembayaran Belum bisa dilakukan, Silahkan Hubungi Administrator']);
    }
    
    
    Config::$serverKey = $midtransclientkey;
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
        $model->RecordOwnerID = $jsonData['kodePartner'];

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
            $pelanggan->RecordOwnerID = $jsonData['kodePartner'];

            if (!$pelanggan->save()) {
                throw new \Exception('Penambahan Data Pelanggan Gagal');
            }
        }

         // Update kuota voucher jika ada
         if (isset($jsonData['VoucherCode'])) {
           
         $update = DB::table('discountvoucher')
         ->where('VoucherCode', '=', $request->input('VoucherCode'))
         ->update(['DiscountQuota' => 0]);
       
     if (!$update) {
         throw new \Exception('Gagal menggunakan voucher Diskon.');
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
  
    Mail::to($emailPelanggan->Email)->send(new KonfirmasiPembayaranMail($booking, $emailPelanggan));
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

public function getDiscountVoucher(Request $request)
{
    $voucherCode = $request->query('code');
    $kodePartner = $request->query('kodePartner');
    $voucher = DiscountVoucher::where('VoucherCode', $voucherCode)
    ->where('RecordOwnerID', $kodePartner)->first();

    if (!$voucher) {
        return response()->json(['success' => false, 'message' => 'Voucher tidak ditemukan'], 404);
    }

    return response()->json([
        'success' => true,
        'discountPercent' => $voucher->DiscountPercent,
        'maximalDiscount' => $voucher->MaximalDiscount,
        'discountQuota' => $voucher->DiscountQuota,
        'startDate' => $voucher->StartDate,
        'endDate' => $voucher->EndDate,
    ]);
}

public function View(Request $request)
{
    $listBooking = BookingOnline::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
    return view('Transaksi.Penjualan.PoS.ListBookingOnline', compact('listBooking'));
}

public function ViewGenerateVoucher(Request $request)
{
    $listBooking = BookingOnline::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();


    return view('Transaksi.Penjualan.PoS.GenerateVoucher', compact('listBooking'));
}

public function storeVoucher(Request $request)
{
    try{
    // Validasi input
    $request->validate([
        'discountPercent' => 'required|numeric|min:1|max:100',
        'maximalDiscount' => 'required|numeric|min:1000',
        'discountQuota' => 'required|integer|min:1',
        'expiryDate' => 'required|date|after:today',
    ]);

    // Generate kode voucher unik (6 karakter)
    //$voucherCode = strtoupper(Str::random(6));
    
    // Simpan data ke database
    $voucher = new DiscountVoucher();
    $voucher->VoucherCode = $request->voucherCode;
    $voucher->DiscountPercent = $request->discountPercent;
    $voucher->MaximalDiscount = $request->maximalDiscount;
    $voucher->DiscountQuota = $request->discountQuota;
    $voucher->DiscountDescription = $request->description;
    $voucher->StartDate = $request->startDate;
    $voucher->EndDate = $request->expiryDate;
    $voucher->RecordOwnerID = Auth::user()->RecordOwnerID;
    $voucher->save();

    $data['success'] = true;
    $data['message'] = 'Data berhasil disimpan';

} catch (\Exception $e) {
    $data['success'] = false;
    $data['message'] = $e->getMessage();
    
}

    return response()->json($data);

}

public function getListVoucher()
    {
        $vouchers = DiscountVoucher::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return response()->json($vouchers);
    }

    public function getBookings()
    {
        $query = BookingOnline::join('pelanggan', 'bookingtableonline.KodePelanggan', '=', 'pelanggan.KodePelanggan')
        ->join('titiklampu', 'bookingtableonline.mejaID', '=', 'titiklampu.id') 
        ->where('bookingtableonline.RecordOwnerID', Auth::user()->RecordOwnerID)
        ->orderBy('bookingtableonline.created_at', 'desc')
        ->select(
            'bookingtableonline.*', 
            'pelanggan.NamaPelanggan', 
            'pelanggan.Email', 
            'pelanggan.NoTlp1', 
            'titiklampu.NamaTitikLampu' ,
            DB::raw("CASE 
                    WHEN bookingtableonline.StatusTransaksi = 0 THEN 'WAITING' 
                    WHEN bookingtableonline.StatusTransaksi = 1 THEN 'CHECK IN' 
                    ELSE 'UNKNOWN' 
                 END AS StatusTransaksi")
        );
        

        //dd($query->toSql(), $query->getBindings());

        $bookings = $query->get();

        return response()->json($bookings);
    }

    public function getBookingDetail($noTransaksi)
{
    $booking = BookingOnline::join('pelanggan', 'bookingtableonline.KodePelanggan', '=', 'pelanggan.KodePelanggan')
        ->join('titiklampu', 'bookingtableonline.mejaID', '=', 'titiklampu.id')
        ->join('pakettransaksi', 'bookingtableonline.paketid', '=', 'pakettransaksi.id')
        ->where('bookingtableonline.NoTransaksi', $noTransaksi)
        ->select(
            'bookingtableonline.*', 
            'pelanggan.NamaPelanggan', 
            'pelanggan.Email', 
            'titiklampu.NamaTitikLampu',
            'pakettransaksi.JenisPaket',
            'pakettransaksi.DurasiPaket',
            DB::raw("CASE 
            WHEN bookingtableonline.StatusTransaksi = 0 THEN 'WAITING' 
            WHEN bookingtableonline.StatusTransaksi = 1 THEN 'CHECK IN' 
            ELSE 'UNKNOWN' 
         END AS StatusTransaksi")
        )
        ->first();

    if ($booking) {
        return response()->json($booking);
    } else {
        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }
}

public function getMejaByTransaksi($noTransaksi)
{
    $booking = BookingOnline::where('NoTransaksi', $noTransaksi)
    ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
    ->select('mejaID')
    ->first();
    

if (!$booking) {
    return response()->json(['error' => 'Data tidak ditemukan'], 404);
}

return response()->json($booking);

}


public function insertTableOrder(Request $request)
{
    $data = ['success' => false, 'message' => '', 'data' => [], 'Kembalian' => ""];

    $this->validate($request, [
        'JenisPaket' => 'required',
        'paketid' => 'required',
        'tableid' => 'required',
        'KodeSales' => 'required',
        'DurasiPaket' => 'required'
    ]);

    try {
        DB::beginTransaction(); // Mulai transaksi

        $currentDate = Carbon::now();
        $Year = $currentDate->format('Y');
        $Month = $currentDate->format('m');

        $tglBooking = $request->input('TglBooking'); // "2025-03-13 00:00:00"
        $jamMulai = $request->input('JamMulai'); // "10:00:00"

        $startDate = Carbon::parse($tglBooking)->format('Y-m-d') . ' ' . $jamMulai;

        // Insert ke tableorderheader
        $model = new TableOrderHeader();
        $model->NoTransaksi = $request->input('NoTransaksi');
        $model->TglTransaksi = $startDate;
        $model->TglPencatatan = Carbon::now();
        $model->JenisPaket = $request->input('JenisPaket');
        $model->paketid = $request->input('paketid');
        $model->tableid = $request->input('tableid');
        $model->KodeSales = $request->input('KodeSales');
        $model->DurasiPaket = $request->input('DurasiPaket');
        $model->Status = $request->input('Status');
        $model->KodePelanggan = $request->input('KodePelanggan');
        $model->TaxTotal = 0; // Default 0
        $model->GrossTotal = $request->input('GrossTotal');
        $model->DiscTotal = $request->input('DiscTotal');
        $model->NetTotal = $request->input('NetTotal');
        $model->JamMulai = $startDate;
        $model->JamSelesai = Carbon::parse($startDate)->addHours($request->input('DurasiPaket'));
        // if ($request->input('JenisPaket') != 'MENIT') {
        //     $model->JamSelesai = Carbon::parse($startDate)->addHours($request->input('DurasiPaket'));
        // }

        $model->RecordOwnerID = Auth::user()->RecordOwnerID;

        if (!$model->save()) {
            throw new \Exception('Gagal menyimpan data ke tableorderheader.');
        }

        // Update bookingtableonline
        $update = DB::table('bookingtableonline')
            ->where('NoTransaksi', '=', $request->input('NoTransaksi'))
            ->update(['StatusTransaksi' => 1]);

        if (!$update) {
            throw new \Exception('Gagal memperbarui bookingtableonline.');
        }

        DB::commit(); // Commit transaksi jika semuanya berhasil
        $data['success'] = true;
    } catch (\Throwable $th) {
        DB::rollBack(); // Rollback transaksi jika ada error
        $data['message'] = 'Internal error: ' . $th->getMessage();
    }

    return response()->json($data);
}



}