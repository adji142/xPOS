<?php

namespace App\Imports;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Pelanggan;
use App\Models\GrupPelanggan;
use App\Models\DocumentNumbering;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PelangganImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $gruppelanggan = GrupPelanggan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('KodeGrup', $row['kodegruppelanggan'])
                    ->first();
                    
        if (!$gruppelanggan) {
            session()->flash('error', 'Kode Grup Pelanggan ' . $row['namapelanggan'] . ' Tidak ada, Silahkan Masukan terlebih dahulu Melalui Master -> Business Partner-> Grup Pelanggan');
            return null;
        }

        $numberingData = new DocumentNumbering();
        $KodePelanggan = $numberingData->GetNewDoc("PLG","pelanggan","KodePelanggan");

        return new Pelanggan([
            'KodePelanggan' => $KodePelanggan,
            'NamaPelanggan'=>$row['namapelanggan'],
            'KodeGrupPelanggan'=>$row['kodegruppelanggan'],
            'LimitPiutang'=>$row['limitpiutang'],
            'Email'=>$row['email'],
            'NoTlp1'=>$row['notlp1'],
            'Alamat'=>$row['alamat'],
            'ProvID'=>-1,
            'KotaID'=>-1,
            'KelID'=>-1,
            'KecID'=>-1,
            'RecordOwnerID'=>Auth::user()->RecordOwnerID
        ]);
    }
}
