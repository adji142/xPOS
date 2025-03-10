<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use ZipArchive;


use App\Models\Meja;
use App\Models\KelompokMeja;
use App\Models\Company;
class MejaController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['meja.KodeMeja','meja.NamaMeja'];
        $keyword = $request->input('keyword');

        $meja = Meja::selectRaw("meja.*, kelompokmeja.NamaKelompokMeja")
                ->leftJoin('kelompokmeja', function ($value){
                    $value->on('kelompokmeja.KodeKelompokMeja','=','meja.KelompokMeja')
                    ->on('kelompokmeja.RecordOwnerID','=','meja.RecordOwnerID');
                })
                ->Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('meja.RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        // $meja = $meja->paginate(4);

        $oCompany = Company::selectRaw("*")
                        ->leftJoin('subscriptionheader','subscriptionheader.NoTransaksi','company.KodePaketLangganan')
                        ->where('company.KodePartner', Auth::user()->RecordOwnerID)
                        ->first();
        $title = 'Delete Meja !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("Resto.Meja",[
            'meja' => $meja, 
            'AllowPesananMeja' => $oCompany->AllowPesananMeja
        ]);
    }

    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jenisitem = Meja::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $data['data']= $jenisitem;
        return response()->json($data);
    }

    public function Form($KodeMeja = null)
    {
    	$meja = Meja::where('KodeMeja','=',$KodeMeja)->get();
        $kelompokmeja = KelompokMeja::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        
        return view("Resto.Meja-Input",[
            'meja' => $meja,
            'kelompokmeja' => $kelompokmeja
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeMeja'=>'required',
                'NamaMeja'=>'required',
                'KelompokMeja'=> 'required'
            ]);

            $model = new Meja;
            $model->KodeMeja = $request->input('KodeMeja');
            $model->NamaMeja = $request->input('NamaMeja');
            $model->KelompokMeja = $request->input('KelompokMeja');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Meja Berhasil disimpan.');
                return redirect('meja');
                
            }else{
                throw new \Exception('Penambahan Data Meja Gagal');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeMeja'=>'required',
                'NamaMeja'=>'required',
                'KelompokMeja'=> 'required'
            ]);

            $model = Meja::where('KodeMeja','=',$request->input('KodeMeja'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('meja')
                			->where('KodeMeja','=', $request->input('KodeMeja'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'NamaMeja'=>$request->input('NamaMeja'),
                                    'KelompokMeja'=>$request->input('KelompokMeja'),
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Meja berhasil disimpan.');
                    return redirect('meja');
                }else{
                    throw new \Exception('Edit Meja Gagal');
                }
            } else{
                throw new \Exception('Meja not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function storeJson(Request $request)
    {
        Log::debug($request->all());
        try {

            $model = new Meja;
            $model->KodeMeja = $request->input('KodeMeja');
            $model->NamaMeja = $request->input('NamaMeja');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                
            }else{
                $data['message'] = 'Penambahan Data Meja Gagal';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function editJson(Request $request)
    {
        Log::debug($request->all());
        try {

            $model = Meja::where('KodeMeja','=',$request->input('KodeMeja'));

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('meja')
                            ->where('KodeMeja','=', $request->input('KodeMeja'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'NamaMeja'=>$request->input('NamaMeja'),
                                ]
                            );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message'] = 'Edit Meja Gagal';
                }
            } else{
                $data['message'] = 'Meja not found.';
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function deletedata(Request $request)
    {
    	try {
    		$meja = DB::table('meja')
	                ->where('KodeMeja','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($meja) {
	        	alert()->success('Success','Delete Meja berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Meja Gagal.');
	        }
	        return redirect('meja');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }

    public function ExportQRCode(Request $request){
        // $url ="http://192.168.1.66:8056/digimenu?ObjectString="; // development
        // $url = $apiUrl = env('WEB_MENU_BASE_URL', $DEVurl); // production
        $url = "http://dspos.digimenu.dstechsmart.com/?ObjectString=";
        $directoryPath = public_path('images/qrcode/'.Auth::user()->RecordOwnerID);
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
            // return response()->json(['message' => 'Directory created successfully!']);
        }

        $meja = Meja::selectRaw("meja.*, kelompokmeja.NamaKelompokMeja")
                ->leftJoin('kelompokmeja', function ($value){
                    $value->on('kelompokmeja.KodeKelompokMeja','=','meja.KelompokMeja')
                    ->on('kelompokmeja.RecordOwnerID','=','meja.RecordOwnerID');
                })->where('meja.RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        $oCompany = Company::where('KodePartner',Auth::user()->RecordOwnerID)->first();

        foreach ($meja as $key) {
            $oData = array(
                "RecordOwnerID" => Auth::user()->RecordOwnerID,
                "PartnerName" => $oCompany->NamaPartner,
                "KodeMeja" => $key->KodeMeja,
                "NamaMeja" => $key->NamaMeja,
                "DeviceID" => "-",
                "IPAddress" => "-"
            );
            $jsonData = json_encode($oData);
            $base64Data = base64_encode($jsonData);
            // echo $base64Data."<br>";
            $imageUrl = 'https://quickchart.io/qr?text='.$url.$base64Data;
            $imageContent = file_get_contents($imageUrl);
            $fileName = 'qrcode_' . Auth::user()->RecordOwnerID.'_'. $key->NamaMeja . '.jpg';
            $path = public_path('images/qrcode/' .Auth::user()->RecordOwnerID.'/'. $fileName);
            file_put_contents($path, $imageContent);
            // $qrCode = QrCode::size(300)->generate('http://192.168.1.66:8000');
        }

        $zipFileName = 'qrcodes_' . Auth::user()->RecordOwnerID . '.zip';
        $zipFilePath = $directoryPath . '/' . $zipFileName;
        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // Add all files from the directory to the zip
            foreach (glob($directoryPath . '/*') as $file) {
                $zip->addFile($file, basename($file)); // Add file to zip
            }
            $zip->close(); // Close the zip file
        }
        // return response()->json(['message' => 'Image downloaded successfully', 'filename' => 'test']);
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
        
        // return response()->view('Resto/Meja-QR', ['qrCode' => $qrCode]);
        // var_dump($qrCode);
        // return response()->json(['message' => $qrCode]);
        // $url = "http://localhost:8056/digimenu/";
        
        
    }
}
