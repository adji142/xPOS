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
use App\Models\PembayaranPenjualanHeader;
use App\Models\PembayaranPenjualanDetail;
use App\Models\OrderPembelianHeader;
use App\Models\OrderPembelianDetail;
use App\Models\FakturPembelianHeader;
use App\Models\FakturPembelianDetail;
use App\Models\PembayaranHeader;
use App\Models\PembayaranDetail;
use App\Models\ReturPembelianHeader;
use App\Models\ReturPembelianDetail;
use App\Models\PenerimaanKonsinyasiHeader;
use App\Models\PenerimaanKonsinyasiDetail;
use App\Models\ReturKonsinyasiHeader;
use App\Models\ReturKonsinyasiDetail;

class DocumentOutputController extends Controller
{
    protected function getSlipData($TipeTransaksi, $NomorTransaksi, $RecordOwnerID){
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
                return OrderPenjualanHeader::selectRaw($sql)
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

                return DeliveryNoteHeader::selectRaw($sql)
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

                return FakturPenjualanHeader::selectRaw($sql)
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
            case "pembayaranpenjualan":
                $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP, company.NoTlp,
                    pembayaranpenjualanheader.NoTransaksi, pembayaranpenjualanheader.TglTransaksi, pembayaranpenjualanheader.TglTransaksi TglJatuhTempo,
                    pelanggan.NamaPelanggan, pelanggan.Alamat, CONCAT('Pembayaran Faktur : ', pembayaranpenjualandetail.BaseReff) NamaItem, 
                    '' Satuan, 1 Qty, 0 Harga,  pembayaranpenjualandetail.TotalPembayaran HargaNet, 0 Discount, 
                    0 VatPercent, pembayaranpenjualanheader.TotalPembayaran AS SubTotal, 0 AS Diskon,
                    0 Pajak, pembayaranpenjualanheader.TotalPembayaran AS Total, company.icon, pelanggan.Email, pelanggan.NoTlp1,
                    'Pembayaran Penjualan' title, CONCAT(pembayaranpenjualanheader.Keterangan, '<br>', 'Dibayar dengan : ', metodepembayaran.NamaMetodePembayaran), '' SyaratDanKetentuan";

                return PembayaranPenjualanHeader::selectRaw($sql)
                    ->leftJoin('pembayaranpenjualandetail', function ($join) {
                        $join->on('pembayaranpenjualanheader.NoTransaksi', '=', 'pembayaranpenjualandetail.NoTransaksi')
                            ->on('pembayaranpenjualanheader.RecordOwnerID', '=', 'pembayaranpenjualandetail.RecordOwnerID');
                    })
                    ->leftJoin('pelanggan', function ($join) {
                        $join->on('pembayaranpenjualanheader.KodePelanggan', '=', 'pelanggan.KodePelanggan')
                            ->on('pembayaranpenjualanheader.RecordOwnerID', '=', 'pelanggan.RecordOwnerID');
                    })
                    ->leftJoin('metodepembayaran', function ($join) {
                        $join->on('pembayaranpenjualanheader.KodeMetodePembayaran', '=', 'metodepembayaran.id')
                            ->on('pembayaranpenjualanheader.RecordOwnerID', '=', 'metodepembayaran.RecordOwnerID');
                    })
                    ->leftJoin('company', 'company.KodePartner', '=', 'pembayaranpenjualanheader.RecordOwnerID')
                    ->where('pembayaranpenjualanheader.RecordOwnerID', $RecordOwnerID)
                    ->where('pembayaranpenjualanheader.NoTransaksi', $NomorTransaksi)
                    ->get();
                break;
            case "orderpembelian":
                $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP, company.NoTlp,
                        orderpembelianheader.NoTransaksi, orderpembelianheader.TglTransaksi, orderpembelianheader.TglJatuhTempo,
                        supplier.NamaSupplier AS NamaPelanggan, supplier.Alamat, itemmaster.NamaItem, 
                        orderpembeliandetail.Satuan, orderpembeliandetail.Qty, orderpembeliandetail.Harga, 
                        orderpembeliandetail.HargaNet, orderpembeliandetail.Discount, orderpembeliandetail.VatPercent,
                        orderpembelianheader.TotalTransaksi AS SubTotal, orderpembelianheader.Potongan AS Diskon,
                        orderpembelianheader.Pajak, orderpembelianheader.TotalPembelian AS Total, 
                        company.icon, supplier.Email, supplier.NoTlp1,
                        'Order Pembelian' title, orderpembelianheader.Keterangan, '' AS SyaratDanKetentuan";

                return OrderPembelianHeader::selectRaw($sql)
                    ->leftJoin('orderpembeliandetail', function ($join) {
                        $join->on('orderpembelianheader.NoTransaksi', '=', 'orderpembeliandetail.NoTransaksi')
                            ->on('orderpembelianheader.RecordOwnerID', '=', 'orderpembeliandetail.RecordOwnerID');
                    })
                    ->leftJoin('supplier', function ($join) {
                        $join->on('orderpembelianheader.KodeSupplier', '=', 'supplier.KodeSupplier')
                            ->on('orderpembelianheader.RecordOwnerID', '=', 'supplier.RecordOwnerID');
                    })
                    ->leftJoin('itemmaster', function ($join) {
                        $join->on('orderpembeliandetail.KodeItem', '=', 'itemmaster.KodeItem')
                            ->on('orderpembeliandetail.RecordOwnerID', '=', 'itemmaster.RecordOwnerID');
                    })
                    ->leftJoin('satuan', function ($join) {
                        $join->on('orderpembeliandetail.Satuan', '=', 'satuan.KodeSatuan')
                            ->on('orderpembeliandetail.RecordOwnerID', '=', 'satuan.RecordOwnerID');
                    })
                    ->leftJoin('company', 'company.KodePartner', '=', 'orderpembelianheader.RecordOwnerID')
                    ->where('orderpembelianheader.RecordOwnerID', $RecordOwnerID)
                    ->where('orderpembelianheader.NoTransaksi', $NomorTransaksi)
                    ->get();

            case "fakturpembelian":
                $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP, company.NoTlp,
                        fakturpembelianheader.NoTransaksi, fakturpembelianheader.TglTransaksi, fakturpembelianheader.TglJatuhTempo,
                        supplier.NamaSupplier AS NamaPelanggan, supplier.Alamat, itemmaster.NamaItem,
                        fakturpembeliandetail.Satuan, fakturpembeliandetail.Qty, fakturpembeliandetail.Harga,
                        fakturpembeliandetail.HargaNet, fakturpembeliandetail.Discount, fakturpembeliandetail.VatPercent,
                        fakturpembelianheader.TotalTransaksi AS SubTotal, fakturpembelianheader.Potongan AS Diskon,
                        fakturpembelianheader.Pajak, fakturpembelianheader.TotalPembelian AS Total,
                        company.icon, supplier.Email, supplier.NoTlp1,
                        'Faktur Pembelian' title, fakturpembelianheader.Keterangan, '' AS SyaratDanKetentuan";

                return FakturPembelianHeader::selectRaw($sql)
                    ->leftJoin('fakturpembeliandetail', function ($join) {
                        $join->on('fakturpembelianheader.NoTransaksi', '=', 'fakturpembeliandetail.NoTransaksi')
                            ->on('fakturpembelianheader.RecordOwnerID', '=', 'fakturpembeliandetail.RecordOwnerID');
                    })
                    ->leftJoin('supplier', function ($join) {
                        $join->on('fakturpembelianheader.KodeSupplier', '=', 'supplier.KodeSupplier')
                            ->on('fakturpembelianheader.RecordOwnerID', '=', 'supplier.RecordOwnerID');
                    })
                    ->leftJoin('itemmaster', function ($join) {
                        $join->on('fakturpembeliandetail.KodeItem', '=', 'itemmaster.KodeItem')
                            ->on('fakturpembeliandetail.RecordOwnerID', '=', 'itemmaster.RecordOwnerID');
                    })
                    ->leftJoin('satuan', function ($join) {
                        $join->on('fakturpembeliandetail.Satuan', '=', 'satuan.KodeSatuan')
                            ->on('fakturpembeliandetail.RecordOwnerID', '=', 'satuan.RecordOwnerID');
                    })
                    ->leftJoin('company', 'company.KodePartner', '=', 'fakturpembelianheader.RecordOwnerID')
                    ->where('fakturpembelianheader.RecordOwnerID', $RecordOwnerID)
                    ->where('fakturpembelianheader.NoTransaksi', $NomorTransaksi)
                    ->get();
                break;
            case "pembayaranpembelian" :
                $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP, company.NoTlp,
                    pembayaranheader.NoTransaksi, pembayaranheader.TglTransaksi, pembayaranheader.TglTransaksi TglJatuhTempo,
                    supplier.NamaSupplier AS NamaPelanggan, supplier.Alamat, 
                    CONCAT('Pembayaran Faktur : ', pembayarandetail.BaseReff) NamaItem, 
                    '' Satuan, 1 Qty, 0 Harga, pembayarandetail.TotalPembayaran HargaNet, 0 Discount, 
                    0 VatPercent, pembayaranheader.TotalPembayaran AS SubTotal, 0 AS Diskon,
                    0 Pajak, pembayaranheader.TotalPembayaran AS Total, company.icon, supplier.Email, supplier.NoTlp1,
                    'Pembayaran Pembelian' title, 
                    CONCAT(pembayaranheader.Keterangan, '<br>', 'Dibayar dengan : ', metodepembayaran.NamaMetodePembayaran), '' SyaratDanKetentuan";

            return PembayaranHeader::selectRaw($sql)
                ->leftJoin('pembayarandetail', function ($join) {
                    $join->on('pembayaranheader.NoTransaksi', '=', 'pembayarandetail.NoTransaksi')
                        ->on('pembayaranheader.RecordOwnerID', '=', 'pembayarandetail.RecordOwnerID');
                })
                ->leftJoin('supplier', function ($join) {
                    $join->on('pembayaranheader.KodeSupplier', '=', 'supplier.KodeSupplier')
                        ->on('pembayaranheader.RecordOwnerID', '=', 'supplier.RecordOwnerID');
                })
                ->leftJoin('metodepembayaran', function ($join) {
                    $join->on('pembayaranheader.KodeMetodePembayaran', '=', 'metodepembayaran.id')
                        ->on('pembayaranheader.RecordOwnerID', '=', 'metodepembayaran.RecordOwnerID');
                })
                ->leftJoin('company', 'company.KodePartner', '=', 'pembayaranheader.RecordOwnerID')
                ->where('pembayaranheader.RecordOwnerID', $RecordOwnerID)
                ->where('pembayaranheader.NoTransaksi', $NomorTransaksi)
                ->get();
                break;
            case "returpembelian":
                $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP, company.NoTlp,
                    returpembelianheader.NoTransaksi, returpembelianheader.TglTransaksi, returpembelianheader.TglTransaksi TglJatuhTempo,
                    supplier.NamaSupplier AS NamaPelanggan, supplier.Alamat,
                    itemmaster.NamaItem, returpembeliandetail.Satuan, returpembeliandetail.Qty,
                    returpembeliandetail.Harga, returpembeliandetail.HargaNet, 0 Discount,
                    returpembeliandetail.VatPercent, returpembelianheader.TotalTransaksi AS SubTotal,
                    returpembelianheader.Potongan AS Diskon, returpembelianheader.Pajak,
                    returpembelianheader.TotalPembelian AS Total, company.icon, supplier.Email, supplier.NoTlp1,
                    'Retur Pembelian' title, returpembelianheader.Keterangan, '' SyaratDanKetentuan";

            return ReturPembelianHeader::selectRaw($sql)
                ->leftJoin('returpembeliandetail', function ($join) {
                    $join->on('returpembelianheader.NoTransaksi', '=', 'returpembeliandetail.NoTransaksi')
                        ->on('returpembelianheader.RecordOwnerID', '=', 'returpembeliandetail.RecordOwnerID');
                })
                ->leftJoin('supplier', function ($join) {
                    $join->on('returpembelianheader.KodeSupplier', '=', 'supplier.KodeSupplier')
                        ->on('returpembelianheader.RecordOwnerID', '=', 'supplier.RecordOwnerID');
                })
                ->leftJoin('itemmaster', function ($join) {
                    $join->on('returpembeliandetail.KodeItem', '=', 'itemmaster.KodeItem')
                        ->on('returpembeliandetail.RecordOwnerID', '=', 'itemmaster.RecordOwnerID');
                })
                ->leftJoin('satuan', function ($join) {
                    $join->on('returpembeliandetail.Satuan', '=', 'satuan.KodeSatuan')
                        ->on('returpembeliandetail.RecordOwnerID', '=', 'satuan.RecordOwnerID');
                })
                ->leftJoin('company', 'company.KodePartner', '=', 'returpembelianheader.RecordOwnerID')
                ->where('returpembelianheader.RecordOwnerID', $RecordOwnerID)
                ->where('returpembelianheader.NoTransaksi', $NomorTransaksi)
                ->get();
                break;
            case "penerimaankons":
                $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP, company.NoTlp,
                    penerimaankonsinyasiheader.NoTransaksi, penerimaankonsinyasiheader.TglTransaksi, penerimaankonsinyasiheader.TglJatuhTempo,
                    supplier.NamaSupplier AS NamaPelanggan, supplier.Alamat,
                    itemmaster.NamaItem, penerimaankonsinyasidetail.Satuan, penerimaankonsinyasidetail.Qty,
                    penerimaankonsinyasidetail.Harga, penerimaankonsinyasidetail.HargaNet, penerimaankonsinyasidetail.Discount,
                    penerimaankonsinyasidetail.VatPercent, penerimaankonsinyasiheader.TotalTransaksi AS SubTotal,
                    penerimaankonsinyasiheader.Potongan AS Diskon, penerimaankonsinyasiheader.Pajak,
                    penerimaankonsinyasiheader.TotalPembelian AS Total, company.icon, supplier.Email, supplier.NoTlp1,
                    'Penerimaan Konsinyasi' title, penerimaankonsinyasiheader.Keterangan, '' SyaratDanKetentuan";

            return PenerimaanKonsinyasiHeader::selectRaw($sql)
                ->leftJoin('penerimaankonsinyasidetail', function ($join) {
                    $join->on('penerimaankonsinyasiheader.NoTransaksi', '=', 'penerimaankonsinyasidetail.NoTransaksi')
                        ->on('penerimaankonsinyasiheader.RecordOwnerID', '=', 'penerimaankonsinyasidetail.RecordOwnerID');
                })
                ->leftJoin('supplier', function ($join) {
                    $join->on('penerimaankonsinyasiheader.KodeSupplier', '=', 'supplier.KodeSupplier')
                        ->on('penerimaankonsinyasiheader.RecordOwnerID', '=', 'supplier.RecordOwnerID');
                })
                ->leftJoin('itemmaster', function ($join) {
                    $join->on('penerimaankonsinyasidetail.KodeItem', '=', 'itemmaster.KodeItem')
                        ->on('penerimaankonsinyasidetail.RecordOwnerID', '=', 'itemmaster.RecordOwnerID');
                })
                ->leftJoin('satuan', function ($join) {
                    $join->on('penerimaankonsinyasidetail.Satuan', '=', 'satuan.KodeSatuan')
                        ->on('penerimaankonsinyasidetail.RecordOwnerID', '=', 'satuan.RecordOwnerID');
                })
                ->leftJoin('company', 'company.KodePartner', '=', 'penerimaankonsinyasiheader.RecordOwnerID')
                ->where('penerimaankonsinyasiheader.RecordOwnerID', $RecordOwnerID)
                ->where('penerimaankonsinyasiheader.NoTransaksi', $NomorTransaksi)
                ->get();

                break;
            case "returkonsinyasi":
                $sql = "company.NamaPartner, company.AlamatTagihan, company.NPWP, company.NoTlp,
                        returkonsinyasiheader.NoTransaksi, returkonsinyasiheader.TglTransaksi, returkonsinyasiheader.TglTransaksi AS TglJatuhTempo,
                        supplier.NamaSupplier AS NamaPelanggan, supplier.Alamat,
                        itemmaster.NamaItem, returkonsinyasidetail.Satuan, returkonsinyasidetail.Qty,
                        returkonsinyasidetail.Harga, returkonsinyasidetail.HargaNet, 0 AS Discount,
                        returkonsinyasidetail.VatPercent, returkonsinyasiheader.TotalTransaksi AS SubTotal,
                        0 AS Diskon, 0 AS Pajak, returkonsinyasiheader.TotalTransaksi AS Total,
                        company.icon, supplier.Email, supplier.NoTlp1,
                        'Retur Konsinyasi' AS title, returkonsinyasiheader.Keterangan, '' AS SyaratDanKetentuan";

                return ReturKonsinyasiHeader::selectRaw($sql)
                    ->leftJoin('returkonsinyasidetail', function ($join) {
                        $join->on('returkonsinyasiheader.NoTransaksi', '=', 'returkonsinyasidetail.NoTransaksi')
                            ->on('returkonsinyasiheader.RecordOwnerID', '=', 'returkonsinyasidetail.RecordOwnerID');
                    })
                    ->leftJoin('supplier', function ($join) {
                        $join->on('returkonsinyasiheader.KodeSupplier', '=', 'supplier.KodeSupplier')
                            ->on('returkonsinyasiheader.RecordOwnerID', '=', 'supplier.RecordOwnerID');
                    })
                    ->leftJoin('itemmaster', function ($join) {
                        $join->on('returkonsinyasidetail.KodeItem', '=', 'itemmaster.KodeItem')
                            ->on('returkonsinyasidetail.RecordOwnerID', '=', 'itemmaster.RecordOwnerID');
                    })
                    ->leftJoin('satuan', function ($join) {
                        $join->on('returkonsinyasidetail.Satuan', '=', 'satuan.KodeSatuan')
                            ->on('returkonsinyasidetail.RecordOwnerID', '=', 'satuan.RecordOwnerID');
                    })
                    ->leftJoin('company', 'company.KodePartner', '=', 'returkonsinyasiheader.RecordOwnerID')
                    ->where('returkonsinyasiheader.RecordOwnerID', $RecordOwnerID)
                    ->where('returkonsinyasiheader.NoTransaksi', $NomorTransaksi)
                    ->get();
                break;
            default:
                return response()->json(['error' => 'Invalid transaction type'], 400);
        }
    }
    public function index(Request $request)
    {
        $RecordOwnerID = Auth()->user()->RecordOwnerID;
        $NomorTransaksi = $request->query('NomorTransaksi');
        $TipeTransaksi = $request->query('TipeTransaksi');

        $oCompany = Company::where('KodePartner', $RecordOwnerID)->first();

        $data = $this->getSlipData($TipeTransaksi, $NomorTransaksi, $RecordOwnerID);

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

        try {
            $data = $this->getSlipData($TipeTransaksi, $NomorTransaksi, $RecordOwnerID);


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

        try {
            $data = $this->getSlipData($TipeTransaksi, $NomorTransaksi, $RecordOwnerID);


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

            $pdf = PDF::loadView('Transaksi.Penjualan.slip.'.$oCompany->DefaultSlip, $oParamEmail);

            $timestamp = now()->timestamp; 

            $fileName = $TipeTransaksi . "_" . $RecordOwnerID . "_" . $NomorTransaksi.'_'.$timestamp . ".pdf";
            $pdfPath = storage_path('app/public/invoices/' . $fileName);
            $pdf->save($pdfPath);

            $encodedFileName = base64_encode($TipeTransaksi . "_" . $RecordOwnerID . "_" . $NomorTransaksi.'_'.$timestamp);
            $pdfUrl = route('download-pdf', ['file' => $encodedFileName]);

            // // Render Blade dan encode HTML sebelum ke DomPDF
            // $html = view('Transaksi.Penjualan.slip.' . $oCompany->DefaultSlip, $oParamEmail)->render();
            // $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

            // $pdf = PDF::loadHTML($html);

            // $fileName = $TipeTransaksi . "_" . $RecordOwnerID . "_" . $NomorTransaksi . ".pdf";
            // $pdfPath = storage_path('app/public/invoices/' . $fileName);

            // // Pastikan folder ada
            // if (!file_exists(dirname($pdfPath))) {
            //     mkdir(dirname($pdfPath), 0755, true);
            // }

            // $pdf->save($pdfPath);

            // // Link publik
            // $encodedFileName = base64_encode($TipeTransaksi . "_" . $RecordOwnerID . "_" . $NomorTransaksi);
            // $pdfUrl = route('download-pdf', ['file' => $encodedFileName]);


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
