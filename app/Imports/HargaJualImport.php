<?php

namespace App\Imports;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\HargaJual;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HargaJualImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // var_dump($row);
        return new HargaJual([
            'KodeItem'=>$row["kodeitem"],
            'HargaJual'=>$row["hargajual"],
            'TipeMarkUp'=>-1,
            'RecordOwnerID'=>Auth::user()->RecordOwnerID
        ]);
    }
}
