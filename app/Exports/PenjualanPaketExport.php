<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\InvoicePenggunaHeader;
use DB;

class PenjualanPaketExport implements FromQuery, WithHeadings
{
    protected $TglAwal;
    protected $TglAkhir;

    public function __construct($TglAwal, $TglAkhir)
    {
        $this->TglAwal = $TglAwal;
        $this->TglAkhir = $TglAkhir;
    }

    public function query()
    {
        return InvoicePenggunaHeader::selectRaw("tagihanpenggunaheader.NoTransaksi, tagihanpenggunaheader.TglTransaksi, 
            tagihanpenggunaheader.TglJatuhTempo, tagihanpenggunaheader.KodePelanggan, company.NamaPartner, 
            subscriptionheader.NamaSubscription, tagihanpenggunaheader.TotalTagihan, tagihanpenggunaheader.TotalBayar, 
            pembayarantagihan.TglTransaksi AS TglBayar")
            ->leftJoin('subscriptionheader', 'subscriptionheader.NoTransaksi', 'tagihanpenggunaheader.KodePaketLangganan')
            ->leftJoin('company', 'company.KodePartner', 'tagihanpenggunaheader.KodePelanggan')
            ->leftJoin('pembayarantagihan', 'pembayarantagihan.BaseReff','tagihanpenggunaheader.NoTransaksi')
            ->whereBetween('tagihanpenggunaheader.TglTransaksi', [$this->TglAwal, $this->TglAkhir])
            ->where('tagihanpenggunaheader.Status','<>', 'D')
            ->orderBy('tagihanpenggunaheader.TglTransaksi');
    }

    public function headings(): array
    {
        return [
            'NoTransaksi',
            'TglTransaksi',
            'TglJatuhTempo',
            'KodePartner',
            'NamaPartner',
            'NamaSubscription',
            'TotalTagihan',
            'TotalBayar',
            'TglBayar'
        ];
    }
}
