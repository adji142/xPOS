<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Http\Controllers\Controller;

use App\Models\Company;
class CustDisplayController extends Controller
{
    public function View(Request $request)
    {
        $company = Company::Where('KodePartner','=',Auth::user()->RecordOwnerID)->first();
	    return view("Transaksi.Penjualan.PoS.CustDisplay",[
            'company' => $company,
        ]);
    }
}
