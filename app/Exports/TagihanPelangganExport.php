<?php

namespace App\Exports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use App\Models\InvoicePenggunaHeader;
use App\Models\InvoicePenggunaDetail;
use App\Models\PembayaranLangganan;

class TagihanPelangganExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
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
            tagihanpenggunaheader.TglJatuhTempo, subscriptionheader.NamaSubscription,tagihanpenggunaheader.TotalTagihan, 
            company.NamaPartner, pembayarantagihan.TglTransaksi AS TglBayar, pembayarantagihan.MetodePembayaran, 
            pembayarantagihan.NoReff ReffPembayaran, pembayarantagihan.Keterangan PaymentNote ")
            ->leftJoin('subscriptionheader', 'subscriptionheader.NoTransaksi', 'tagihanpenggunaheader.KodePaketLangganan')
            ->leftJoin('company', 'company.KodePartner', 'tagihanpenggunaheader.KodePelanggan')
            ->leftJoin('pembayarantagihan', 'pembayarantagihan.BaseReff','tagihanpenggunaheader.NoTransaksi')
            ->whereBetween('tagihanpenggunaheader.TglTransaksi', [$this->TglAwal, $this->TglAkhir])
            ->orderBy('tagihanpenggunaheader.TglTransaksi');
    }
    public function headings(): array
    {
        return [
            'NoTransaksi',
            'TglTransaksi',
            'TglJatuhTempo',
            'NamaSubscription',
            'TotalTagihan',
            'NamaPartner',
            'TglBayar',
            'MetodePembayaran',
            'ReffPembayaran',
            'PaymentNote'
        ];
    }
}
