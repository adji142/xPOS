<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
class DemografiController extends Controller
{
    public function GetProvinsi() {
        // dd("Masuk");
        $provinsi = Provinsi::all();
        
        return response()->json($provinsi);
    }
    function GetKota($ProvID) {
        $kota = Kota::where('prov_id',$ProvID)->get();
        return response()->json($provinsi);
    }
    function GetKecamatan($kota_id) {
        $kecamatan = Kecamatan::where('kota_id', $kota_id)->get();
        return response()->json($kecamatan);
    }
    function GetKelurahan($kec_id) {
        $kelurahan = Kelurahan::where('kec_id', $kec_id)->get(); 
        return response()->json($kelurahan);
    }
}
