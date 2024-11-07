<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\DocumentNumbering;
use App\Models\DocumentType;
use App\Models\JournalHeader;
use App\Models\JournalDetail;
use App\Models\Rekening;

use App\Models\KasKeluarHeader;
use App\Models\KasKeluarDetail;

class KasKeluarController extends Controller
{
    public function View(Request $request)
    {
    	$keyword = $request->input('keyword');
        $title = 'Batalkan Transaksi Kas Keluar !';
        $text = "Apakah anda yakin untuk membatalkan Transaksi ini ?";
        confirmDelete($title, $text);

	    return view("Transaksi.Accounting.KasKeluar");
    }

    public function ViewHeader(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
    	$TglAwal = $request->input('TglAwal');
	   	$TglAkhir = $request->input('TglAkhir');

        $sql = "kaskeluarheader.*, rekeningakutansi.NamaRekening  ";

        $model = KasKeluarHeader::selectRaw($sql)
                    ->leftJoin('rekeningakutansi', function ($value){
                        $value->on('rekeningakutansi.KodeRekening','=','kaskeluarheader.KodeAkun')
                        ->on('rekeningakutansi.RecordOwnerID','=','kaskeluarheader.RecordOwnerID');
                    })
                    ->whereBetween('kaskeluarheader.TglTransaksi', [$TglAwal, $TglAkhir])
                    ->where('kaskeluarheader.StatusDocument','<>', 'D');

        $model->orderBy('kaskeluarheader.TglTransaksi');
        $model->orderBy('kaskeluarheader.NoTransaksi');

        $data['data']= $model->get();
        return response()->json($data);
    }

    public function ViewDetail(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
        $NoTransaksi = $request->input('NoTransaksi');

        $sql = "kaskeluardetail.*, rekeningakutansi.NamaRekening ";
        $model = KasKeluarDetail::selectRaw($sql)
                    ->leftJoin('rekeningakutansi', function ($value){
                        $value->on('rekeningakutansi.Koderekening','=','kaskeluardetail.KodeAkun')
                        ->on('rekeningakutansi.RecordOwnerID','=','kaskeluardetail.RecordOwnerID');
                    })
                    ->where('kaskeluardetail.NoTransaksi', $NoTransaksi)
                    ->orderBy('kaskeluardetail.LineNumber');

        $data['data']= $model->get();
        return response()->json($data);
    }

    public function Form($NoTransaksi = null)
	{
    	$kaskeluarheader = KasKeluarHeader::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->where('NoTransaksi', $NoTransaksi)
                            ->get();
                            
        $sql = "kaskeluardetail.*, rekeningakutansi.NamaRekening ";

        $kaskeluardetail = KasKeluarDetail::selectRaw($sql)
                    ->leftJoin('rekeningakutansi', function ($value){
                        $value->on('rekeningakutansi.Koderekening','=','kaskeluardetail.KodeAkun')
                        ->on('rekeningakutansi.RecordOwnerID','=','kaskeluardetail.RecordOwnerID');
                    })
                    ->where('kaskeluardetail.NoTransaksi', $NoTransaksi)
                    ->orderBy('kaskeluardetail.LineNumber')
                    ->get();
        $rekening = Rekening::selectRaw("rekeningakutansi.*")
                        ->leftJoin('kelompokrekening', function ($value){
                            $value->on('kelompokrekening.id','=','rekeningakutansi.KodeKelompok')
                            ->on('kelompokrekening.RecordOwnerID','=','rekeningakutansi.RecordOwnerID');
                        })
                    ->where('rekeningakutansi.RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('rekeningakutansi.Jenis',2)
                    ->where('kelompokrekening.Posisi', 1)
                    ->where('kelompokrekening.NeracaLR', 1)
                    ->get();

        $rekeningDetail = Rekening::selectRaw("rekeningakutansi.*")
                        ->leftJoin('kelompokrekening', function ($value){
                            $value->on('kelompokrekening.id','=','rekeningakutansi.KodeKelompok')
                            ->on('kelompokrekening.RecordOwnerID','=','rekeningakutansi.RecordOwnerID');
                        })
                    ->where('rekeningakutansi.RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('rekeningakutansi.Jenis',2)
                    ->get();

	    return view("Transaksi.Accounting.KasKeluar-Input",[
	        'kaskeluarheader' => $kaskeluarheader,
	        'kaskeluardetail' => $kaskeluardetail,
	        'rekening' => $rekening,
            'rekeningDetail' => $rekeningDetail
	    ]);
	}

    function store(Request $request) {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");
        $errorCount = 0;
        $errorMessage = "";

        try {
            DB::beginTransaction();

            $currentDate = Carbon::now();
			$Year = $currentDate->format('Y');
			$Month = $currentDate->format('m');
            $numberingData = new DocumentNumbering();

            $NoTransaksi = $numberingData->GetNewDoc("KOUT","kaskeluarheader","NoTransaksi");
            $header = new KasKeluarHeader();

            $header->NoTransaksi = $NoTransaksi;
            $header->TglTransaksi = $request->input('TglTransaksi');
            $header->TglPencatatan = $currentDate->format('Y-m-d H:i:s');
            $header->KodeAkun = $request->input('KodeAkun');
            $header->StatusDocument = $request->input('StatusDocument');
            $header->Keterangan = $request->input('Keterangan');
            $header->TotalTransaksi = $request->input('TotalTransaksi');
            $header->RecordOwnerID = Auth::user()->RecordOwnerID;
            $saveHeader = $header->save();

            $DetailParameter = $request->input('DetailParameter');

            if ($DetailParameter) {
                $index = 0;
                foreach ($DetailParameter as $dt) {
                    if ($dt["TotalTransaksi"] == 0) {
                        goto skip;
                    }

                    $detail = new KasKeluarDetail();
                    $detail->NoTransaksi = $NoTransaksi;
                    $detail->LineNumber = $index;
                    $detail->KodeAkun = $dt['KodeAkun'];
                    $detail->Keterangan = $dt['Keterangan'];
                    $detail->TotalTransaksi = $dt['TotalTransaksi'];
                    $detail->RecordOwnerID = Auth::user()->RecordOwnerID;

                    $detail->save();
    
                    if (!$detail) {
                        $errorMessage = "Menyimpan Kas Keluar Detail Row Number " . ($index +1) . " Gagal dilakukan";
                        $errorCount +=1;
                        goto jump;
                    }
                    $index +=1;
                    skip:
                }
            }
            else{
                $errorMessage = "Data Detail Harus diisi";
                $errorCount +=1;
                goto jump;
            }
jump:
            if ($errorCount > 0) {
                DB::rollback();
                // alert()->error('Error',$errorMessage);
                $data['success'] = false;
                $data['message'] = $errorMessage;
                // $data['success'] = false;
                // return redirect()->back();
            }
            else{
                DB::commit();
                $data['success'] = true;
                $data['message'] = "";
                // alert()->success('Success','Data Kas Keluar Berhasil disimpan.');
                // return redirect('kaskeluar');
            }
        } catch (\Exception $e) {
            // alert()->error('Error',$e->getMessage());
            // return redirect()->back();
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    function edit(Request $request) {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");
        $errorCount = 0;
        $errorMessage = "";

        try {
            DB::beginTransaction();

            $update = DB::table('kaskeluarheader')
                        ->where('NoTransaksi','=', $request->input('NoTransaksi'))
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->update(
                            [
                                'TglTransaksi' => $request->input('TglTransaksi'),
                                'KodeAkun' => $request->input('KodeAkun'),
                                'Keterangan' => $request->input('Keterangan'),
                                'TotalTransaksi' => $request->input('TotalTransaksi')
                            ]
                        );

            $DetailParameter = $request->input('DetailParameter');

            if ($DetailParameter) {
                $delete = DB::table('kaskeluardetail')
		                ->where('NoTransaksi','=', $request->input('NoTransaksi'))
		                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
		                ->delete();
                $index = 0;
                // var_dump($DetailParameter);
                foreach ($DetailParameter as $dt) {
                    if ($dt["TotalTransaksi"] == "0") {
                        // var_dump($dt["TotalTransaksi"]. " / ". $dt['KodeAkun']);
                        goto skip;
                    }

                    $detail = new KasKeluarDetail();
                    $detail->NoTransaksi = $request->input('NoTransaksi');
                    $detail->LineNumber = $index;
                    $detail->KodeAkun = $dt['KodeAkun'];
                    $detail->Keterangan = $dt['Keterangan'];
                    $detail->TotalTransaksi = $dt['TotalTransaksi'];
                    $detail->RecordOwnerID = Auth::user()->RecordOwnerID;

                    $detail->save();
    
                    if (!$detail) {
                        $data['success'] = false;
                        $data['message'] = "Menyimpan Kas Keluar Detail Row Number " . ($index +1) . " Gagal dilakukan";
                        $errorCount +=1;
                        goto jump;
                    }
                    $index +=1;
                    skip:
                }
            }
            else{
                $data['success'] = false;
                $data['message'] = "Data Detail Harus diisi";
                $errorCount +=1;
                goto jump;
            }
jump:
            if ($errorCount > 0) {
                DB::rollback();
                $data['success'] = false;
                $data['message'] = $errorMessage;
            }
            else{
                DB::commit();
                $data['success'] = true;
                $data['message'] = "";
            }
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    function deletedata(Request $request) {
        $errorCount = 0;
        $errorMessage = "";

        try {
            $update = DB::table('kaskeluarheader')
                        ->where('NoTransaksi','=', $request->id)
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->update(
                            [
                                'StatusDocument' => 'D',
                            ]
                        );
            if ($update) {
                alert()->success('Success','Data Kas Keluar Berhasil dihapus.');
            }
        } catch (\Exception $e) {
            alert()->error('Error',$e->getMessage());
        }
        return redirect('kaskeluar');
    }


}
