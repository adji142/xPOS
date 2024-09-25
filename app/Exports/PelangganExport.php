<?php
namespace App\Exports;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\GrupPelanggan;
use App\Models\Pelanggan;
use App\Models\Provinsi;

class PelangganExport implements FromQuery, WithHeadings
{
    public function query()
    {
    	 $sql = "pelanggan.KodePelanggan, pelanggan.NamaPelanggan, gruppelanggan.NamaGrup,pelanggan.LimitPiutang, CASE WHEN pelanggan.status = 1 THEN 'ACTIVE' ELSE 'INACTIVE' END StatusRecord, pelanggan.Email, pelanggan.NoTlp1 ,dem_provinsi.prov_name, dem_kota.city_name, dem_kecamatan.dis_name, dem_kelurahan.subdis_name";
        return Pelanggan::selectRaw($sql)
				->leftJoin('dem_provinsi','pelanggan.ProvID','=','dem_provinsi.prov_id')
				->leftJoin('dem_kota','pelanggan.KotaID','=','dem_kota.city_id')
				->leftJoin('dem_kecamatan','pelanggan.KecID','=','dem_kecamatan.dis_id')
				->leftJoin('dem_kelurahan','pelanggan.KelID','=','dem_kelurahan.subdis_id')
				->leftJoin('gruppelanggan', function ($value){
					$value->on('pelanggan.KodeGrupPelanggan','=','gruppelanggan.KodeGrup')
					->on('pelanggan.RecordOwnerID','=','gruppelanggan.RecordOwnerID');
				})
				->where('pelanggan.RecordOwnerID','=',Auth::user()->RecordOwnerID)
				->orderBy('pelanggan.KodePelanggan');
    }
    public function headings(): array
    {
        return [
            'KodePelanggan',
            'NamaPelanggan',
            'NamaGrup',
            'LimitPiutang',
            'StatusRecord',
            'Email',
            'NoTlp1',
            'Provinsi',
            'Kota',
            'Kecamatan',
            'Kelurahan',
        ];
    }
}