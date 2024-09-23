<?php

namespace App\Imports;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SupplierImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $KodeSupplier = "";
        $prefix = "SP";
        $lastNoTrx = Supplier::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
        ->where(DB::raw('LEFT(KodeSupplier,2)'),'=',$prefix)->count()+1;
        $KodeSupplier = $prefix.str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);

        return new Supplier([
            'KodeSupplier' => $KodeSupplier,
            'NamaSupplier'=>$row['namasupplier'],
            'Email'=>$row['email'],
            'NoTlp1'=>$row['notlp1'],
            'Alamat'=>$row['alamat'],
            'NPWP'=>$row['npwp'],
            'Bank'=>$row['bank'],
            'NoRekening'=>$row['norekening'],
            'PemilikRekening'=>$row['pemilikrekening'],
            'ProvID'=>-1,
            'KotaID'=>-1,
            'KelID'=>-1,
            'KecID'=>-1,
            'RecordOwnerID'=>Auth::user()->RecordOwnerID
        ]);
    }
}
