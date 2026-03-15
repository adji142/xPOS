<?php

namespace App\Exports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use DB;

class LaporanPenggunaExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        $subquery = DB::table('tagihanpenggunaheader')
                        ->selectRaw("KodePelanggan,MAX(tagihanpenggunaheader.TotalBayar) TotalBayar, MAX(created_at) created")
                        ->groupBy('KodePelanggan');

        return Company::selectRaw("company.KodePartner, company.NamaPartner, company.NoTlp, company.NamaPIC, company.StartSubs, company.EndSubs, company.ExtraDays, company.JenisUsaha, subscriptionheader.NamaSubscription, 
                            CASE WHEN inv.TotalBayar = 0 THEN 'Belum Bayar' ELSE 
                                CASE WHEN NOW() BETWEEN DATE_ADD(company.EndSubs,INTERVAL -10 DAY) AND company.EndSubs THEN 'Akan Jatuh Tempo' ELSE 
                                    CASE WHEN NOW() > company.EndSubs THEN 'Expired' ELSE 
                                        CASE WHEN inv.TotalBayar > 0 AND company.EndSubs > NOW() THEN 'Aktif' ELSE 
                                            CASE WHEN company.EndSubs > NOW() THEN 'Aktif' ELSE 
                                                CASE WHEN company.StartSubs is null THEN 'Perlu Aktivasi' ELSE '' END
                                            END
                                        END
                                    END
                                END
                            END StatusSubscription")
                        ->leftJoin('subscriptionheader','company.KodePaketLangganan','subscriptionheader.NoTransaksi')
                        ->leftJoinSub($subquery, 'inv', function ($join) {
                            $join->on('company.KodePartner', '=', 'inv.KodePelanggan');
                        })
                        ->selectRaw("(SELECT u.email FROM users u 
                                      JOIN userrole ur ON u.id = ur.userid AND u.RecordOwnerID = ur.RecordOwnerID
                                      JOIN roles r ON ur.roleid = r.id AND ur.RecordOwnerID = r.RecordOwnerID
                                      WHERE ur.RecordOwnerID = company.KodePartner AND r.RoleName = 'SuperAdmin'
                                      ORDER BY u.created_at ASC LIMIT 1) as email")
                        ->selectRaw("(SELECT u.created_at FROM users u 
                                      JOIN userrole ur ON u.id = ur.userid AND u.RecordOwnerID = ur.RecordOwnerID
                                      JOIN roles r ON ur.roleid = r.id AND ur.RecordOwnerID = r.RecordOwnerID
                                      WHERE ur.RecordOwnerID = company.KodePartner AND r.RoleName = 'SuperAdmin'
                                      ORDER BY u.created_at ASC LIMIT 1) as oldest_superadmin_at")
                        ->where('company.isActive', '!=', '-1')
                        ->orderBy('oldest_superadmin_at', 'asc');
    }

    public function headings(): array
    {
        return [
            'KodePartner',
            'NamaPartner',
            'Status',
            'Email',
            'No. Tlp',
            'Nama PIC',
            'Mulai Berlangganan',
            'Expired Date',
            'Lama Berlangganan',
            'Jenis Usaha',
            'Paket Berlangganan',
        ];
    }

    public function map($company): array
    {
        $start = Carbon::parse($company->StartSubs);
        $end = Carbon::parse($company->EndSubs);
        $duration = $start->diffInDays($end) . " Hari";

        return [
            $company->KodePartner,
            $company->NamaPartner,
            $company->StatusSubscription,
            $company->email,
            $company->NoTlp,
            $company->NamaPIC,
            $company->StartSubs,
            $company->EndSubs,
            $duration,
            $company->JenisUsaha,
            $company->NamaSubscription,
        ];
    }
}
