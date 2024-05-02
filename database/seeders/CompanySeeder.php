<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company')->insert([
            'KodePartner' => 'CL0001',
            'NamaPartner' => 'AIS System',
            'AlamatTagihan' => '',
            'NoTlp' => '',
            'NoHP'=>'',
            'NIKPIC'=>'',
            'NamaPIC'=>'',
            'icon'=>'',
            'StartSubs'=>'2021-01-01',
            'EndSubs'=>'2222-01-01',
            'ExtraDays'=>1,
            'tempStore'=>'',
            'NPWP' => '',
            'TglPKP' => '1999-01-01',
            'PPN' => 0,
            'isHargaJualIncludePPN' => 1,
            'NamaPosPrinter' => '',
            'FooterNota' => ''
        ]);
    }
}
