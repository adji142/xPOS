<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Company;
use App\Models\Pelanggan;
use App\Models\ItemMaster;
use App\Models\Diskon;
use App\Models\MetodePembayaran;
use App\Models\Sales;
use App\Models\GrupPelanggan;
use App\Models\Provinsi;
use App\Models\Printer;
use App\Models\TipeOrderResto;
use App\Models\KelompokMeja;
use App\Models\Meja;
use App\Models\MenuRestoHeader;
use App\Models\MenuRestoDetail;
use App\Models\MenuRestoVariant;
use App\Models\VariantMenuHeader;
use App\Models\VariantMenuDetail;
use App\Models\JenisItem;
// require_once(app_path('Libraries/phpserial/src/PhpSerial.php'));
class PoSController extends Controller
{
    public function View(Request $request)
    {
        $sql = "pelanggan.*, CONCAT(COALESCE(NoTlp1,''),CASE WHEN COALESCE(NoTlp2,'') != '' THEN ' / ' ELSE '' END , COALESCE(NoTlp2,'')) NoTlpConcat ";
        $pelanggan = Pelanggan::selectRaw($sql)
                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('Status','=',1)
                    ->get();
        $sales = Sales::Where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('Status','=',1)
                    ->get();
        $company = Company::Where('KodePartner','=',Auth::user()->RecordOwnerID)->get();

        $itemServices = ItemMaster::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->where('Active','=','Y')
                            ->where('TypeItem','=',4)->get();
        $metodepembayaran = MetodePembayaran::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $gruppelanggan = GrupPelanggan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        $provinsi = Provinsi::all();

        $printer = Printer::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('DeviceAddress','=', $company[0]['NamaPosPrinter'])->first();


        if ($printer == null) {
            $printer = "[]";
        }
        // var_dump($company[0]["JenisUsaha"]);
        switch ($company[0]["JenisUsaha"]) {
            case 'Retail':
                return view("Transaksi.Penjualan.PoS.NormalPoS",[
                    'pelanggan' => $pelanggan,
                    'company' => $company,
                    'itemServices' =>$itemServices,
                    'metodepembayaran' => $metodepembayaran,
                    'sales' => $sales,
                    'gruppelanggan' => $gruppelanggan,
                    'provinsi' => $provinsi,
                    'printer' => $printer
                ]);
                break;
            case 'FnB':
                // alert()->error('Error','Fitur PoS untuk Bisnis FnB Belum Tersedia');
                // return redirect()->back();
                $kelompokmeja = KelompokMeja::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
                $meja = Meja::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
                $tipeorder = TipeOrderResto::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
                $jenisitem = JenisItem::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

                $sql = "itemmaster.KodeItem, itemmaster.NamaItem, menuheader.HargaPokokStandar, menuheader.HargaJual, 
                        menuheader.Gambar";
                $itemmenu = ItemMaster::selectRaw($sql)
                            ->Join('menuheader', function ($value){
                                $value->on('menuheader.KodeItemHasil','=','itemmaster.KodeItem')
                                ->on('menuheader.RecordOwnerID','=','itemmaster.RecordOwnerID');
                            })
                            ->where('Active','Y')
                            ->get();

                return view("Transaksi.Penjualan.PoS.FnBPoS",[
                    'pelanggan' => $pelanggan,
                    'company' => $company,
                    'itemServices' =>$itemServices,
                    'metodepembayaran' => $metodepembayaran,
                    'sales' => $sales,
                    'gruppelanggan' => $gruppelanggan,
                    'provinsi' => $provinsi,
                    'printer' => $printer,
                    'itemmenu' => $itemmenu,
                    'kelompokmeja' => $kelompokmeja,
                    'meja' => $meja,
                    'tipeorder' => $tipeorder,
                    'jenisitem' => $jenisitem
                ]);
                break;
            case 'Services':
                alert()->error('Error','Fitur PoS untuk Bisnis Services Belum Tersedia');
                return redirect()->back();
                break;
            default:
                alert()->error('Error','Jenis Usaha belum ada');
                break;
        }
    }

    public function GetDiscount(Request $request)
    {
        $data = array('success'=>false, 'message'=>'', 'data'=>array(), 'Diskon' => 0, 'TipeDiskon'=>'');

        $KodeItem = $request->input('KodeItem');
        $Qty = $request->input('Qty');
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $odiskon = Diskon::where('RecordOwnerID','=', $RecordOwnerID)
                    ->where('KodeItem','=', $KodeItem)->get();

        $diskon = 0;
        $diskonType = '';
        // var_dump($diskon);
        if ($odiskon) {
            foreach ($odiskon as $key) {

                if ($Qty >= $key['Minimal']) {
                    $diskon = $key['Diskon'];
                    $diskonType = $key['TipeDiskon'];
                    $data['data'] = $key;
                    // break;
                }
            }

            $data['Diskon']=$diskon;
            $data['TipeDiskon']=$diskonType;
        }

        return response()->json($data);
    }
    public function FunctionName(Request $request)
    {
    	// Initialize the class
        $serial = new \PhpSerial();

        // Specify the serial port to use (e.g., /dev/rfcomm0 for Linux or COM3 for Windows)
        $serial->deviceSet("/dev/rfcomm0"); // Update this to match your system's configuration

        // Set the serial port parameters
        $serial->confBaudRate(9600); // Adjust baud rate as needed
        $serial->confParity("none");
        $serial->confCharacterLength(8);
        $serial->confStopBits(1);
        $serial->confFlowControl("none");

        // Open the serial port
        $serial->deviceOpen();

        // Send data to the printer
        $data = "Hello, Bluetooth Printer!\n";
        $serial->sendMessage($data);

        // Close the serial port
        $serial->deviceClose();

        return response()->json(['message' => 'Printed successfully']);
    }
}
