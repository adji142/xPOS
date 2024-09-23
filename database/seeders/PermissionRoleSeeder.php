<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonArray = '[{"roleid": 1, "permissionid": 1, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 2, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 3, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 4, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 5, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 6, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 7, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 8, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 9, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 10, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 11, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 12, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 13, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 14, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 15, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 16, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 17, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 18, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 19, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 20, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 21, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 22, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 23, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 24, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 25, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 26, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 27, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 28, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 29, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 30, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 31, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 32, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 33, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 34, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 35, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 36, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 37, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 38, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 39, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 40, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 41, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 42, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 43, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 44, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 45, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 46, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 47, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 48, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 49, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 50, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 51, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 52, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 53, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 54, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 55, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 56, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 57, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 58, "RecordOwnerID": "CL0001"},{"roleid": 1, "permissionid": 59, "RecordOwnerID": "CL0001"}]';

    	$array = json_decode($jsonArray, true);
        DB::table('permissionrole')->insert($array);
    }
}
