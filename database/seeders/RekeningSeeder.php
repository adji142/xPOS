<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Rekening;
use App\Models\KelompokRekening;

class RekeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected static $RecordOwnerID;
    public static function setParameter($RecordOwnerID)
    {
        self::$RecordOwnerID= $RecordOwnerID;
    }
    public function run()
    {
        $RecordOwnerID= self::$RecordOwnerID;
        $oKelompok = Rekening::selectRaw('DISTINCT KodeKelompok')
                        ->where('RecordOwnerID','=',DB::raw("'CL0001'"))->get();
        // var_dump(json_encode($oKelompok));
        foreach ($oKelompok as $key) {
            $kelompokRekening = KelompokRekening::where('id', $key['KodeKelompok'])
                                    ->first();
            // var_dump($kelompokRekening);
            $savekelompok = KelompokRekening::insertGetId([
                'NamaKelompok' => $kelompokRekening['NamaKelompok'],
                'Kelompok' => $kelompokRekening['Kelompok'],
                'Posisi' => $kelompokRekening['Posisi'],
                'FooterLaporan' => $kelompokRekening['FooterLaporan'],
                'NeracaLR' => $kelompokRekening['NeracaLR'],
                'RecordOwnerID' => $RecordOwnerID
            ]);

            $rekening = Rekening::where('RecordOwnerID', DB::raw("'CL0001'"))
                            ->where('KodeKelompok', $key['KodeKelompok'])
                            ->get();
            
            foreach ($rekening as $keyrekening) {
                $model = new Rekening;
                $model->KodeRekening = $keyrekening['KodeRekening'];
                $model->NamaRekening = $keyrekening['NamaRekening'];
                $model->KodeKelompok = $savekelompok;
                $model->Jenis = $keyrekening['Jenis'];
                $model->Level = $keyrekening['Level'];
                $model->KodeRekeningInduk = $keyrekening['RekeningInduk'];
                $model->SaldoValas = 0;
                $model->SaldoBase = 0;
                $model->RecordOwnerID = $RecordOwnerID;

                $save = $model->save();
            }
        }

    }
}
