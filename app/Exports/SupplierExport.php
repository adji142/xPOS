<?php
namespace App\Exports;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Supplier;
use App\Models\Provinsi;

class SupplierExport implements FromQuery, WithHeadings
{
    public function query()
    {
    	 $sql = "supplier.KodeSupplier, supplier.NamaSupplier,supplier.Email, supplier.NoTlp1, supplier.Alamat, dem_provinsi.prov_name, dem_kota.city_name, dem_kecamatan.dis_name, dem_kelurahan.subdis_name,CASE WHEN supplier.status = 1 THEN 'ACTIVE' ELSE 'INACTIVE' END StatusRecord";

        $supplier = Supplier::selectRaw($sql)
        				->leftJoin('dem_provinsi','supplier.ProvID','=','dem_provinsi.prov_id')
        				->leftJoin('dem_kota','supplier.KotaID','=','dem_kota.city_id')
        				->leftJoin('dem_kecamatan','supplier.KecID','=','dem_kecamatan.dis_id')
        				->leftJoin('dem_kelurahan','supplier.KelID','=','dem_kelurahan.subdis_id')
        				->where('supplier.RecordOwnerID','=',Auth::user()->RecordOwnerID)
        				->orderBy('supplier.KodeSupplier');
        return $supplier;
    }
    public function headings(): array
    {
        return [
            'KodeSupplier',
            'NamaSupplier',
            'Email',
            'NoTlp',
            'Alamat',
            'Provinsi',
            'Kota',
            'Kecamatan',
            'Kelurahan',
            'Status'
        ];
    }
}