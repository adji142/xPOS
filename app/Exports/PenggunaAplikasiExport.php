<?php

namespace App\Exports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use DB;
use Log;

class PenggunaAplikasiExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        $subquery = DB::table('tagihanpenggunaheader')
                        ->selectRaw("NoTransaksi,KodePelanggan, MAX(created_at) created")
                        ->groupBy('NoTransaksi','KodePelanggan');

        return Company::selectRaw("company.KodePartner,company.NamaPartner,company.AlamatTagihan, company.NoTlp,
            company.NoHP,company.NamaPIC,company.StartSubs,company.EndSubs, company.ExtraDays,company.JenisUsaha,
            subscriptionheader.NamaSubscription, DATE_ADD(company.EndSubs, INTERVAL company.ExtraDays DAY) JatuhTempo, 
            case when NOW() BETWEEN DATE_ADD(company.EndSubs,INTERVAL -10 DAY) AND company.EndSubs OR NOW() > company.EndSubs THEN 'Bill' ELSE '' END Subscription,
            CASE WHEN tagihanpenggunaheader.TotalBayar = 0 THEN 'Belum Bayar-warning' ELSE 
                case when NOW() BETWEEN DATE_ADD(company.EndSubs,INTERVAL -10 DAY) AND company.EndSubs THEN 'Akan Jatuh Tempo-warning' ELSE 
                    CASE WHEN NOW() > company.EndSubs THEN 'Expired-danger' ELSE 
                        CASE WHEN tagihanpenggunaheader.TotalBayar > 0 AND company.EndSubs > NOW() THEN 'Aktif-success' ELSE 
                            CASE WHEN company.EndSubs > NOW() THEN 'Aktif-success' ELSE 
                                CASE WHEN company.StartSubs is null THEN 'Perlu Aktivasi-danger' ELSE '' END
                            END
                        END
                    END
                END
            END StatusSubscription ")
        ->leftJoin('subscriptionheader','company.KodePaketLangganan','subscriptionheader.NoTransaksi')
        ->leftJoinSub($subquery, 'inv', function ($join) {
            // Bind the placeholder value during the join
            $join->on('company.KodePartner', '=', 'inv.KodePelanggan');
        })
        ->leftJoin('tagihanpenggunaheader', 'tagihanpenggunaheader.NoTransaksi','inv.NoTransaksi')
        ->orderBy('company.KodePartner');
    }

    public function headings(): array
    {
        return [
            'KodePartner',
            'NamaPartner',
            'AlamatTagihan',
            'NoTlp',
            'NoHP',
            'NamaPIC',
            'StartSubs',
            'EndSubs',
            'ExtraDays',
            'JenisUsaha',
            'NamaSubscription',
            'JatuhTempo',
            'Subscription',
            'StatusSubscription',
        ];
    }
}
