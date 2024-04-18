<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array(
            'userid' => 1,
            'roleid' => 1,
            'RecordOwnerID' => 'CL0001'
        );
        DB::table('userrole')->insert($array);
    }
}
