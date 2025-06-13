<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Http\Controllers\Controller;

use App\Models\Company;
use App\Models\MetodePembayaran;

class CustDisplayController extends Controller
{
    public function View(Request $request)
    {
        $midtransdata = MetodePembayaran::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->where('MetodeVerifikasi','=','AUTO')->first();
        $midtransclientkey = "";
        $MetodePembayaranAutoID = -1;
        if ($midtransdata) {
            $midtransclientkey = $midtransdata->ClientKey;
            $MetodePembayaranAutoID = $midtransdata->id;
        }
        $company = Company::Where('KodePartner','=',Auth::user()->RecordOwnerID)->first();

        $oImageData = [];

        if (!empty($company->ImageCustDisplay1)) {
            $image = array('type' => 'image', 'url' => $company->ImageCustDisplay1);
            array_push($oImageData, $image);
        }

        if (!empty($company->ImageCustDisplay2)) {
            $image = array('type' => 'image', 'url' => $company->ImageCustDisplay2);
            array_push($oImageData, $image);
        }

        if (!empty($company->ImageCustDisplay3)) {
            $image = array('type' => 'image', 'url' => $company->ImageCustDisplay3);
            array_push($oImageData, $image);
        }

        if (!empty($company->ImageCustDisplay4)) {
            $image = array('type' => 'image', 'url' => $company->ImageCustDisplay4);
            array_push($oImageData, $image);
        }

        if (!empty($company->ImageCustDisplay5)) {
            $image = array('type' => 'image', 'url' => $company->ImageCustDisplay5);
            array_push($oImageData, $image);
        }

        if (!empty($company->VideoCustomerDisplay1)) {
            $url = "https://www.youtube.com/embed/".$company->VideoCustomerDisplay1."?autoplay=0&mute=1&enablejsapi=1";
            $image = array('type' => 'video', 'url' => $url);
            array_push($oImageData, $image);
        }

        if (!empty($company->VideoCustomerDisplay2)) {
            $url = "https://www.youtube.com/embed/".$company->VideoCustomerDisplay2."?autoplay=0&mute=1&enablejsapi=1";
            $image = array('type' => 'video', 'url' => $url);
            array_push($oImageData, $image);
        }

        if (!empty($company->VideoCustomerDisplay3)) {
            $url = "https://www.youtube.com/embed/".$company->VideoCustomerDisplay3."?autoplay=0&mute=1&enablejsapi=1";
            $image = array('type' => 'video', 'url' => $url);
            array_push($oImageData, $image);
        }

        if (!empty($company->VideoCustomerDisplay4)) {
            $url = "https://www.youtube.com/embed/".$company->VideoCustomerDisplay4."?autoplay=0&mute=1&enablejsapi=1";
            $image = array('type' => 'video', 'url' => $url);
            array_push($oImageData, $image);
        }

        if (!empty($company->VideoCustomerDisplay5)) {
            $url = "https://www.youtube.com/embed/".$company->VideoCustomerDisplay5."?autoplay=0&mute=1&enablejsapi=1";
            $image = array('type' => 'video', 'url' => $url);
            array_push($oImageData, $image);
        }

        // dd(json_encode($oImageData));

	    return view("Transaksi.Penjualan.PoS.CustDisplay",[
            'company' => $company,
            'midtransclientkey' => $midtransclientkey,
            'MetodePembayaranAutoID' => $MetodePembayaranAutoID,
            'oImageData' => $oImageData
        ]);
    }
}
