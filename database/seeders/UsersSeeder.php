<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array(
            'name' => 'AIS System',
            'email' => 'aissystemsolo@gmail.com',
            'password' => Hash::make('ais123AIS'), // Hash the password
            'RecordOwnerID' => 'CL0001',
            'BranchID'=>''
        );
        DB::table('users')->insert($array);
    }
}
