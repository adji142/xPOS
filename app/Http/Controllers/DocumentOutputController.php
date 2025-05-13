<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

use App\Models\Company;
use App\Models\OrderPenjualanHeader;
use App\Models\OrderPenjualanDetail;
use App\Models\DeliveryNoteHeader;
use App\Models\DeliveryNoteDetail;
use App\Models\FakturPenjualanHeader;
use App\Models\FakturPenjualanDetail;
use App\Mail\InvoiceMail;

class DocumentOutputController extends Controller
{
    public function index(Request $request)
    {
        $RecordOwnerID = Auth()->user()->RecordOwnerID;
        $NomorTransaksi = $request->query('NomorTransaksi');
        $TipeTransaksi = $request->query('TipeTransaksi');

        $oCompany = Company::where('KodePartner', $RecordOwnerID)->first();

        $data = null;

        switch ($TipeTransaksi) {
            case 'OrderPenjualan':
                $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP,company.NoTlp, orderpenjualanheader.NoTransaksi,
                        orderpenjualanheader.TglTransaksi, orderpenjualanheader.TglJatuhTempo, pelanggan.NamaPelanggan,
                        pelanggan.Alamat, itemmaster.NamaItem, orderpenjualandetail.Satuan, orderpenjualandetail.Qty,
                        orderpenjualandetail.Harga,orderpenjualandetail.HargaNet ,orderpenjualandetail.Discount, orderpenjualandetail.VatPercent, 
                        orderpenjualanheader.TotalTransaksi AS SubTotal, orderpenjualanheader.Potongan AS Diskon,
                        orderpenjualanheader.Pajak, orderpenjualanheader.TotalPenjualan AS Total, company.icon, pelanggan.Email, pelanggan.NoTlp1,
                        'Order Penjualan' title, orderpenjualanheader.Keterangan, orderpenjualanheader.SyaratDanKetentuan
                        ";
                $data = OrderPenjualanHeader::selectRaw($sql)
                            ->leftJoin('orderpenjualandetail', function ($value){
                                $value->on('orderpenjualanheader.NoTransaksi','=','orderpenjualandetail.NoTransaksi')
                                ->on('orderpenjualanheader.RecordOwnerID','=','orderpenjualandetail.RecordOwnerID');
                            })
                            ->leftJoin('pelanggan', function ($value){
                                $value->on('orderpenjualanheader.KodePelanggan','=','pelanggan.KodePelanggan')
                                ->on('orderpenjualanheader.RecordOwnerID','=','pelanggan.RecordOwnerID');
                            })
                            ->leftJoin('itemmaster', function ($value){
                                $value->on('orderpenjualandetail.KodeItem','=','itemmaster.KodeItem')
                                ->on('orderpenjualandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
                            })
                            ->leftJoin('satuan', function ($value){
                                $value->on('orderpenjualandetail.Satuan','=','satuan.KodeSatuan')
                                ->on('orderpenjualandetail.RecordOwnerID','=','satuan.RecordOwnerID');
                            })
                            ->leftJoin('company', 'company.KodePartner', '=', 'orderpenjualanheader.RecordOwnerID')
                            ->where('orderpenjualanheader.RecordOwnerID', $RecordOwnerID)
                            ->where('orderpenjualanheader.NoTransaksi', $NomorTransaksi)
                            ->get();
                break;
            case 'deliverynote':
                $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP, company.NoTlp,
                    deliverynoteheader.NoTransaksi, deliverynoteheader.TglTransaksi, deliverynoteheader.TglJatuhTempo,
                    pelanggan.NamaPelanggan, pelanggan.Alamat, itemmaster.NamaItem, deliverynotedetail.Satuan,
                    deliverynotedetail.Qty, deliverynotedetail.Harga, deliverynotedetail.HargaNet,
                    deliverynotedetail.Discount, deliverynotedetail.VatPercent,
                    deliverynoteheader.TotalTransaksi AS SubTotal, deliverynoteheader.Potongan AS Diskon,
                    deliverynoteheader.Pajak, deliverynoteheader.TotalPembelian AS Total,
                    company.icon, pelanggan.Email, pelanggan.NoTlp1,
                    'Delivery Note' title, deliverynoteheader.Keterangan, deliverynoteheader.SyaratDanKetentuan";

                $data = DeliveryNoteHeader::selectRaw($sql)
                    ->leftJoin('deliverynotedetail', function ($join) {
                        $join->on('deliverynoteheader.NoTransaksi', '=', 'deliverynotedetail.NoTransaksi')
                            ->on('deliverynoteheader.RecordOwnerID', '=', 'deliverynotedetail.RecordOwnerID');
                    })
                    ->leftJoin('pelanggan', function ($join) {
                        $join->on('deliverynoteheader.KodePelanggan', '=', 'pelanggan.KodePelanggan')
                            ->on('deliverynoteheader.RecordOwnerID', '=', 'pelanggan.RecordOwnerID');
                    })
                    ->leftJoin('itemmaster', function ($join) {
                        $join->on('deliverynotedetail.KodeItem', '=', 'itemmaster.KodeItem')
                            ->on('deliverynotedetail.RecordOwnerID', '=', 'itemmaster.RecordOwnerID');
                    })
                    ->leftJoin('satuan', function ($join) {
                        $join->on('deliverynotedetail.Satuan', '=', 'satuan.KodeSatuan')
                            ->on('deliverynotedetail.RecordOwnerID', '=', 'satuan.RecordOwnerID');
                    })
                    ->leftJoin('company', 'company.KodePartner', '=', 'deliverynoteheader.RecordOwnerID')
                    ->where('deliverynoteheader.RecordOwnerID', $RecordOwnerID)
                    ->where('deliverynoteheader.NoTransaksi', $NomorTransaksi)
                    ->get();

                break;
            case 'fakturpenjualan' :
                $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP, company.NoTlp,
                    fakturpenjualanheader.NoTransaksi, fakturpenjualanheader.TglTransaksi, fakturpenjualanheader.TglJatuhTempo,
                    pelanggan.NamaPelanggan, pelanggan.Alamat, itemmaster.NamaItem, fakturpenjualandetail.Satuan,
                    fakturpenjualandetail.Qty, fakturpenjualandetail.Harga, fakturpenjualandetail.HargaNet,
                    fakturpenjualandetail.Discount, fakturpenjualandetail.VatPercent,
                    fakturpenjualanheader.TotalTransaksi AS SubTotal, fakturpenjualanheader.Potongan AS Diskon,
                    fakturpenjualanheader.Pajak, fakturpenjualanheader.TotalPembelian AS Total,
                    company.icon, pelanggan.Email, pelanggan.NoTlp1,
                    'Faktur Penjualan' title, fakturpenjualanheader.Keterangan, fakturpenjualanheader.SyaratDanKetentuan";

                $data = FakturPenjualanHeader::selectRaw($sql)
                    ->leftJoin('fakturpenjualandetail', function ($join) {
                        $join->on('fakturpenjualanheader.NoTransaksi', '=', 'fakturpenjualandetail.NoTransaksi')
                            ->on('fakturpenjualanheader.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID');
                    })
                    ->leftJoin('pelanggan', function ($join) {
                        $join->on('fakturpenjualanheader.KodePelanggan', '=', 'pelanggan.KodePelanggan')
                            ->on('fakturpenjualanheader.RecordOwnerID', '=', 'pelanggan.RecordOwnerID');
                    })
                    ->leftJoin('itemmaster', function ($join) {
                        $join->on('fakturpenjualandetail.KodeItem', '=', 'itemmaster.KodeItem')
                            ->on('fakturpenjualandetail.RecordOwnerID', '=', 'itemmaster.RecordOwnerID');
                    })
                    ->leftJoin('satuan', function ($join) {
                        $join->on('fakturpenjualandetail.Satuan', '=', 'satuan.KodeSatuan')
                            ->on('fakturpenjualandetail.RecordOwnerID', '=', 'satuan.RecordOwnerID');
                    })
                    ->leftJoin('company', 'company.KodePartner', '=', 'fakturpenjualanheader.RecordOwnerID')
                    ->where('fakturpenjualanheader.RecordOwnerID', $RecordOwnerID)
                    ->where('fakturpenjualanheader.NoTransaksi', $NomorTransaksi)
                    ->get();
                break;
            default:
                return response()->json(['error' => 'Invalid transaction type'], 400);
        }

        return view('Transaksi.Penjualan.slip.'.$oCompany->DefaultSlip,[
            'data' => $data,
            'TipeTransaksi' => $TipeTransaksi,
            'NomorTransaksi' => $NomorTransaksi,
        ]);
    }

    public function SendEmail(Request $request){
        $data = array();
        $data['success'] = false;
        $data['message'] = '';
        $data['data'] = array();

        $RecordOwnerID = Auth()->user()->RecordOwnerID;
        $NomorTransaksi = $request->input('NomorTransaksi');
        $TipeTransaksi = $request->input('TipeTransaksi');

        $oCompany = Company::where('KodePartner', $RecordOwnerID)->first();

        $data = null;

        try {
            switch ($TipeTransaksi) {
                case 'OrderPenjualan':
                    $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP,company.NoTlp, orderpenjualanheader.NoTransaksi,
                            orderpenjualanheader.TglTransaksi, orderpenjualanheader.TglJatuhTempo, pelanggan.NamaPelanggan,
                            pelanggan.Alamat, itemmaster.NamaItem, orderpenjualandetail.Satuan, orderpenjualandetail.Qty,
                            orderpenjualandetail.Harga,orderpenjualandetail.HargaNet, orderpenjualandetail.Discount, orderpenjualandetail.VatPercent,
                            orderpenjualanheader.TotalTransaksi AS SubTotal, orderpenjualanheader.Potongan AS Diskon,
                            orderpenjualanheader.Pajak, orderpenjualanheader.TotalPembelian AS Total, company.icon, pelanggan.Email, pelanggan.NoTlp1,
                            'Order Penjualan' title, orderpenjualanheader.Keterangan, orderpenjualanheader.SyaratDanKetentuan
                            ";
                    $data = OrderPenjualanHeader::selectRaw($sql)
                                ->leftJoin('orderpenjualandetail', function ($value){
                                    $value->on('orderpenjualanheader.NoTransaksi','=','orderpenjualandetail.NoTransaksi')
                                    ->on('orderpenjualanheader.RecordOwnerID','=','orderpenjualandetail.RecordOwnerID');
                                })
                                ->leftJoin('pelanggan', function ($value){
                                    $value->on('orderpenjualanheader.KodePelanggan','=','pelanggan.KodePelanggan')
                                    ->on('orderpenjualanheader.RecordOwnerID','=','pelanggan.RecordOwnerID');
                                })
                                ->leftJoin('itemmaster', function ($value){
                                    $value->on('orderpenjualandetail.KodeItem','=','itemmaster.KodeItem')
                                    ->on('orderpenjualandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
                                })
                                ->leftJoin('satuan', function ($value){
                                    $value->on('orderpenjualandetail.Satuan','=','satuan.KodeSatuan')
                                    ->on('orderpenjualandetail.RecordOwnerID','=','satuan.RecordOwnerID');
                                })
                                ->leftJoin('company', 'company.KodePartner', '=', 'orderpenjualanheader.RecordOwnerID')
                                ->where('orderpenjualanheader.RecordOwnerID', $RecordOwnerID)
                                ->where('orderpenjualanheader.NoTransaksi', $NomorTransaksi)
                                ->get();
                    break;
                case 'deliverynote':
                    $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP, company.NoTlp,
                        deliverynoteheader.NoTransaksi, deliverynoteheader.TglTransaksi, deliverynoteheader.TglJatuhTempo,
                        pelanggan.NamaPelanggan, pelanggan.Alamat, itemmaster.NamaItem, deliverynotedetail.Satuan,
                        deliverynotedetail.Qty, deliverynotedetail.Harga, deliverynotedetail.HargaNet,
                        deliverynotedetail.Discount, deliverynotedetail.VatPercent,
                        deliverynoteheader.TotalTransaksi AS SubTotal, deliverynoteheader.Potongan AS Diskon,
                        deliverynoteheader.Pajak, deliverynoteheader.TotalPenjualan AS Total,
                        company.icon, pelanggan.Email, pelanggan.NoTlp1,
                        'Delivery Note' title, deliverynoteheader.Keterangan, deliverynoteheader.SyaratDanKetentuan";

                    $data = DeliveryNoteHeader::selectRaw($sql)
                        ->leftJoin('deliverynotedetail', function ($join) {
                            $join->on('deliverynoteheader.NoTransaksi', '=', 'deliverynotedetail.NoTransaksi')
                                ->on('deliverynoteheader.RecordOwnerID', '=', 'deliverynotedetail.RecordOwnerID');
                        })
                        ->leftJoin('pelanggan', function ($join) {
                            $join->on('deliverynoteheader.KodePelanggan', '=', 'pelanggan.KodePelanggan')
                                ->on('deliverynoteheader.RecordOwnerID', '=', 'pelanggan.RecordOwnerID');
                        })
                        ->leftJoin('itemmaster', function ($join) {
                            $join->on('deliverynotedetail.KodeItem', '=', 'itemmaster.KodeItem')
                                ->on('deliverynotedetail.RecordOwnerID', '=', 'itemmaster.RecordOwnerID');
                        })
                        ->leftJoin('satuan', function ($join) {
                            $join->on('deliverynotedetail.Satuan', '=', 'satuan.KodeSatuan')
                                ->on('deliverynotedetail.RecordOwnerID', '=', 'satuan.RecordOwnerID');
                        })
                        ->leftJoin('company', 'company.KodePartner', '=', 'deliverynoteheader.RecordOwnerID')
                        ->where('deliverynoteheader.RecordOwnerID', $RecordOwnerID)
                        ->where('deliverynoteheader.NoTransaksi', $NomorTransaksi)
                        ->get();
                    break;
                    case 'fakturpenjualan' :
                        $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP, company.NoTlp,
                            fakturpenjualanheader.NoTransaksi, fakturpenjualanheader.TglTransaksi, fakturpenjualanheader.TglJatuhTempo,
                            pelanggan.NamaPelanggan, pelanggan.Alamat, itemmaster.NamaItem, fakturpenjualandetail.Satuan,
                            fakturpenjualandetail.Qty, fakturpenjualandetail.Harga, fakturpenjualandetail.HargaNet,
                            fakturpenjualandetail.Discount, fakturpenjualandetail.VatPercent,
                            fakturpenjualanheader.TotalTransaksi AS SubTotal, fakturpenjualanheader.Potongan AS Diskon,
                            fakturpenjualanheader.Pajak, fakturpenjualanheader.TotalPembelian AS Total,
                            company.icon, pelanggan.Email, pelanggan.NoTlp1,
                            'Faktur Penjualan' title, fakturpenjualanheader.Keterangan, fakturpenjualanheader.SyaratDanKetentuan";

                        $data = FakturPenjualanHeader::selectRaw($sql)
                            ->leftJoin('fakturpenjualandetail', function ($join) {
                                $join->on('fakturpenjualanheader.NoTransaksi', '=', 'fakturpenjualandetail.NoTransaksi')
                                    ->on('fakturpenjualanheader.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID');
                            })
                            ->leftJoin('pelanggan', function ($join) {
                                $join->on('fakturpenjualanheader.KodePelanggan', '=', 'pelanggan.KodePelanggan')
                                    ->on('fakturpenjualanheader.RecordOwnerID', '=', 'pelanggan.RecordOwnerID');
                            })
                            ->leftJoin('itemmaster', function ($join) {
                                $join->on('fakturpenjualandetail.KodeItem', '=', 'itemmaster.KodeItem')
                                    ->on('fakturpenjualandetail.RecordOwnerID', '=', 'itemmaster.RecordOwnerID');
                            })
                            ->leftJoin('satuan', function ($join) {
                                $join->on('fakturpenjualandetail.Satuan', '=', 'satuan.KodeSatuan')
                                    ->on('fakturpenjualandetail.RecordOwnerID', '=', 'satuan.RecordOwnerID');
                            })
                            ->leftJoin('company', 'company.KodePartner', '=', 'fakturpenjualanheader.RecordOwnerID')
                            ->where('fakturpenjualanheader.RecordOwnerID', $RecordOwnerID)
                            ->where('fakturpenjualanheader.NoTransaksi', $NomorTransaksi)
                            ->get();
                        break;
                default:
                    return response()->json(['error' => 'Invalid transaction type'], 400);
            }


            if ($data->isEmpty()) {
                $data['success'] = false;
                $data['message'] = 'No data found';
                $data['data'] = [];
                return response()->json($data, 404);
            }

            if(isset($data[0]['Email']) && $data[0]['Email'] == null){
                $data['success'] = false;
                $data['message'] = 'Email not found';
                $data['data'] = [];
                return response()->json($data, 404);
            }

            $oParamEmail = [
                'data' => $data,
                'TipeTransaksi' => $TipeTransaksi,
                'NomorTransaksi' => $NomorTransaksi,
            ];

            $pdf = PDF::loadView('Transaksi.Penjualan.slip.'.$oCompany->DefaultSlip, $oParamEmail);
            $pdfContent = $pdf->output();

            Mail::to($data[0]["Email"])->send(new InvoiceMail($data, $pdfContent, $TipeTransaksi));
            $data['success'] = true;
            $data['message'] = 'Email sent successfully';
        } catch (\Throwable $th) {
            //throw $th;
            $data['success'] = false;
            $data['message'] = 'Failed to send email: '.$th->getMessage();
        }

        return response()->json($data);
    }

    public function SendWhatsApp(Request $request){
        $data = array();
        $data['success'] = false;
        $data['message'] = '';
        $data['data'] = array();

        $RecordOwnerID = Auth()->user()->RecordOwnerID;
        $NomorTransaksi = $request->input('NomorTransaksi');
        $TipeTransaksi = $request->input('TipeTransaksi');

        $oCompany = Company::where('KodePartner', $RecordOwnerID)->first();

        $data = null;

        try {
            switch ($TipeTransaksi) {
                case 'OrderPenjualan':
                    $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP,company.NoTlp, orderpenjualanheader.NoTransaksi,
                            orderpenjualanheader.TglTransaksi, orderpenjualanheader.TglJatuhTempo, pelanggan.NamaPelanggan,
                            pelanggan.Alamat, itemmaster.NamaItem, orderpenjualandetail.Satuan, orderpenjualandetail.Qty,
                            orderpenjualandetail.Harga,orderpenjualandetail.HargaNet, orderpenjualandetail.Discount, orderpenjualandetail.VatPercent,
                            orderpenjualanheader.TotalTransaksi AS SubTotal, orderpenjualanheader.Potongan AS Diskon,
                            orderpenjualanheader.Pajak, orderpenjualanheader.TotalPenjualan AS Total, company.icon, pelanggan.Email, pelanggan.NoTlp1,
                            'Order Penjualan' title, orderpenjualanheader.Keterangan, orderpenjualanheader.SyaratDanKetentuan
                            ";
                    $data = OrderPenjualanHeader::selectRaw($sql)
                                ->leftJoin('orderpenjualandetail', function ($value){
                                    $value->on('orderpenjualanheader.NoTransaksi','=','orderpenjualandetail.NoTransaksi')
                                    ->on('orderpenjualanheader.RecordOwnerID','=','orderpenjualandetail.RecordOwnerID');
                                })
                                ->leftJoin('pelanggan', function ($value){
                                    $value->on('orderpenjualanheader.KodePelanggan','=','pelanggan.KodePelanggan')
                                    ->on('orderpenjualanheader.RecordOwnerID','=','pelanggan.RecordOwnerID');
                                })
                                ->leftJoin('itemmaster', function ($value){
                                    $value->on('orderpenjualandetail.KodeItem','=','itemmaster.KodeItem')
                                    ->on('orderpenjualandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
                                })
                                ->leftJoin('satuan', function ($value){
                                    $value->on('orderpenjualandetail.Satuan','=','satuan.KodeSatuan')
                                    ->on('orderpenjualandetail.RecordOwnerID','=','satuan.RecordOwnerID');
                                })
                                ->leftJoin('company', 'company.KodePartner', '=', 'orderpenjualanheader.RecordOwnerID')
                                ->where('orderpenjualanheader.RecordOwnerID', $RecordOwnerID)
                                ->where('orderpenjualanheader.NoTransaksi', $NomorTransaksi)
                                ->get();
                    break;
                case 'deliverynote':
                    $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP, company.NoTlp,
                        deliverynoteheader.NoTransaksi, deliverynoteheader.TglTransaksi, deliverynoteheader.TglJatuhTempo,
                        pelanggan.NamaPelanggan, pelanggan.Alamat, itemmaster.NamaItem, deliverynotedetail.Satuan,
                        deliverynotedetail.Qty, deliverynotedetail.Harga, deliverynotedetail.HargaNet,
                        deliverynotedetail.Discount, deliverynotedetail.VatPercent,
                        deliverynoteheader.TotalTransaksi AS SubTotal, deliverynoteheader.Potongan AS Diskon,
                        deliverynoteheader.Pajak, deliverynoteheader.TotalPembelian AS Total,
                        company.icon, pelanggan.Email, pelanggan.NoTlp1,
                        'Delivery Note' title, deliverynoteheader.Keterangan, deliverynoteheader.SyaratDanKetentuan";

                    $data = DeliveryNoteHeader::selectRaw($sql)
                        ->leftJoin('deliverynotedetail', function ($join) {
                            $join->on('deliverynoteheader.NoTransaksi', '=', 'deliverynotedetail.NoTransaksi')
                                ->on('deliverynoteheader.RecordOwnerID', '=', 'deliverynotedetail.RecordOwnerID');
                        })
                        ->leftJoin('pelanggan', function ($join) {
                            $join->on('deliverynoteheader.KodePelanggan', '=', 'pelanggan.KodePelanggan')
                                ->on('deliverynoteheader.RecordOwnerID', '=', 'pelanggan.RecordOwnerID');
                        })
                        ->leftJoin('itemmaster', function ($join) {
                            $join->on('deliverynotedetail.KodeItem', '=', 'itemmaster.KodeItem')
                                ->on('deliverynotedetail.RecordOwnerID', '=', 'itemmaster.RecordOwnerID');
                        })
                        ->leftJoin('satuan', function ($join) {
                            $join->on('deliverynotedetail.Satuan', '=', 'satuan.KodeSatuan')
                                ->on('deliverynotedetail.RecordOwnerID', '=', 'satuan.RecordOwnerID');
                        })
                        ->leftJoin('company', 'company.KodePartner', '=', 'deliverynoteheader.RecordOwnerID')
                        ->where('deliverynoteheader.RecordOwnerID', $RecordOwnerID)
                        ->where('deliverynoteheader.NoTransaksi', $NomorTransaksi)
                        ->get();
                    break;
                    case 'fakturpenjualan' :
                        $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP, company.NoTlp,
                            fakturpenjualanheader.NoTransaksi, fakturpenjualanheader.TglTransaksi, fakturpenjualanheader.TglJatuhTempo,
                            pelanggan.NamaPelanggan, pelanggan.Alamat, itemmaster.NamaItem, fakturpenjualandetail.Satuan,
                            fakturpenjualandetail.Qty, fakturpenjualandetail.Harga, fakturpenjualandetail.HargaNet,
                            fakturpenjualandetail.Discount, fakturpenjualandetail.VatPercent,
                            fakturpenjualanheader.TotalTransaksi AS SubTotal, fakturpenjualanheader.Potongan AS Diskon,
                            fakturpenjualanheader.Pajak, fakturpenjualanheader.TotalPembelian AS Total,
                            company.icon, pelanggan.Email, pelanggan.NoTlp1,
                            'Faktur Penjualan' title, fakturpenjualanheader.Keterangan, fakturpenjualanheader.SyaratDanKetentuan";

                        $data = FakturPenjualanHeader::selectRaw($sql)
                            ->leftJoin('fakturpenjualandetail', function ($join) {
                                $join->on('fakturpenjualanheader.NoTransaksi', '=', 'fakturpenjualandetail.NoTransaksi')
                                    ->on('fakturpenjualanheader.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID');
                            })
                            ->leftJoin('pelanggan', function ($join) {
                                $join->on('fakturpenjualanheader.KodePelanggan', '=', 'pelanggan.KodePelanggan')
                                    ->on('fakturpenjualanheader.RecordOwnerID', '=', 'pelanggan.RecordOwnerID');
                            })
                            ->leftJoin('itemmaster', function ($join) {
                                $join->on('fakturpenjualandetail.KodeItem', '=', 'itemmaster.KodeItem')
                                    ->on('fakturpenjualandetail.RecordOwnerID', '=', 'itemmaster.RecordOwnerID');
                            })
                            ->leftJoin('satuan', function ($join) {
                                $join->on('fakturpenjualandetail.Satuan', '=', 'satuan.KodeSatuan')
                                    ->on('fakturpenjualandetail.RecordOwnerID', '=', 'satuan.RecordOwnerID');
                            })
                            ->leftJoin('company', 'company.KodePartner', '=', 'fakturpenjualanheader.RecordOwnerID')
                            ->where('fakturpenjualanheader.RecordOwnerID', $RecordOwnerID)
                            ->where('fakturpenjualanheader.NoTransaksi', $NomorTransaksi)
                            ->get();
                        break;
                default:
                    return response()->json(['error' => 'Invalid transaction type'], 400);
            }


            if ($data->isEmpty()) {
                $data['success'] = false;
                $data['message'] = 'No data found';
                $data['data'] = [];
                return response()->json($data, 404);
            }

            $data = $data->map(function ($item) {
                foreach ($item as $key => $value) {
                    $item[$key] = is_string($value) ? utf8_encode($value) : $value;
                }
                return $item;
            });

            if(isset($data[0]['NoTlp1']) && $data[0]['NoTlp1'] == null){
                $data['success'] = false;
                $data['message'] = 'Nomor WhatsApp not found';
                $data['data'] = [];
                return response()->json($data, 404);
            }

            $data = $data->map(function ($item) {
                foreach ($item as $key => $value) {
                    $item[$key] = is_string($value) ? utf8_encode($value) : $value;
                }
                return $item;
            });

            $oParamEmail = [
                'data' => $data,
                'TipeTransaksi' => $TipeTransaksi,
                'NomorTransaksi' => $NomorTransaksi,
            ];

            // $pdf = PDF::loadView('Transaksi.Penjualan.slip.'.$oCompany->DefaultSlip, $oParamEmail);

            // $fileName = $TipeTransaksi . "_" . $RecordOwnerID . "_" . $NomorTransaksi . ".pdf";
            // $pdfPath = storage_path('app/public/invoices/' . $fileName);
            // $pdf->save($pdfPath);

            // $encodedFileName = base64_encode($TipeTransaksi . "_" . $RecordOwnerID . "_" . $NomorTransaksi);
            // $pdfUrl = route('download-pdf', ['file' => $encodedFileName]);

            // Render Blade dan encode HTML sebelum ke DomPDF
            $html = view('Transaksi.Penjualan.slip.' . $oCompany->DefaultSlip, $viewData)->render();
            $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

            $pdf = PDF::loadHTML($html);

            $fileName = $TipeTransaksi . "_" . $RecordOwnerID . "_" . $NomorTransaksi . ".pdf";
            $pdfPath = storage_path('app/public/invoices/' . $fileName);

            // Pastikan folder ada
            if (!file_exists(dirname($pdfPath))) {
                mkdir(dirname($pdfPath), 0755, true);
            }

            $pdf->save($pdfPath);

            // Link publik
            $encodedFileName = base64_encode($TipeTransaksi . "_" . $RecordOwnerID . "_" . $NomorTransaksi);
            $pdfUrl = route('download-pdf', ['file' => $encodedFileName]);


            $whatsappMessage = "Halo Bapak/Ibu " . $data[0]['NamaPelanggan'] . ",\n\n";
            $whatsappMessage .= "Berikut saya kirimkan invoice Anda:\n\n";
            $whatsappMessage .= "Tipe Transaksi: " . $data[0]['title'] . "\n";
            $whatsappMessage .= "Nomor Transaksi: " . $data[0]['NoTransaksi'] . "\n";
            $whatsappMessage .= "Tanggal Transaksi: " . Carbon::parse($data[0]['TglTransaksi'])->format('d-m-Y') . "\n";
            $whatsappMessage .= "Tanggal Jatuh Tempo: " . Carbon::parse($data[0]['TglJatuhTempo'])->format('d-m-Y') . "\n";
            $whatsappMessage .= "Silakan klik link berikut untuk mengunduh invoice Anda:\n";
            $whatsappMessage .= $pdfUrl . "\n\n";
            $whatsappMessage .= "Terima kasih atas kerjasama Anda.\n\n";
            $whatsappMessage .= "Salam,\n";
            $whatsappMessage .= $oCompany->NamaPartner . "\n";

            // $response = json_decode($whatsappSend->getBody(), true);
            // $whatsappSend = 'https://api.whatsapp.com/send?phone=' . $data[0]['NoTlp1'] . '&text=' . urlencode($whatsappMessage);

            // return response()->view('redirect', ['url' => $whatsappSend]);

            $data['success'] = true;
            $data['message'] = '';
            $data['whatsappurl'] = 'https://api.whatsapp.com/send?phone=' . $data[0]['NoTlp1'] . '&text=' . urlencode($whatsappMessage);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('SendWhatsApp Error: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString()
            ]);
            $data['success'] = false;
            $data['message'] = 'Failed to send email: '.$th->getMessage();
        }

        return response()->json($data);
    }
    public function downloadPdf($file)
    {
        // Decode base64
        $decodedFileName = base64_decode($file);

        // Tentukan lokasi file PDF
        $pdfPath = storage_path('app/public/invoices/' . $decodedFileName . '.pdf');

        // Periksa apakah file ada
        if (file_exists($pdfPath)) {
            // Download file
            return response()->download($pdfPath);
        }

        return response()->json(['error' => 'File not found'], 404);
    }
}
