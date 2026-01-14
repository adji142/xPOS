<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\GrupPelanggan;
use App\Models\Pelanggan;
use App\Models\Provinsi;
use App\Exports\PelangganExport;
use App\Models\DocumentNumbering;

class PelangganController extends Controller
{
	public function ReadDemografi(Request $request)
	{
		$data = array('success' => true, 'message'=>'', 'data' => array());

		$Table = $request->input('Table');
		$Field = $request->input('Field');
		$Value = $request->input('Value');

		$demografi = DB::select("SELECT * FROM ".$Table." WHERE ".$Field." = '".$Value."'");

		$data['data'] = $demografi;
		return response()->json($data);
	}
    public function View(Request $request)
    {
    	$field = ['KodePelanggan','NamaPelanggan'];
        $keyword = $request->input('keyword');

        $sql = "pelanggan.*, dem_provinsi.prov_name, dem_kota.city_name, dem_kecamatan.dis_name, dem_kelurahan.subdis_name, gruppelanggan.NamaGrup, CASE WHEN pelanggan.status = 1 THEN 'ACTIVE' ELSE 'INACTIVE' END StatusRecord";

        $pelanggan = Pelanggan::selectRaw($sql)
        				->leftJoin('dem_provinsi','pelanggan.ProvID','=','dem_provinsi.prov_id')
        				->leftJoin('dem_kota','pelanggan.KotaID','=','dem_kota.city_id')
        				->leftJoin('dem_kecamatan','pelanggan.KecID','=','dem_kecamatan.dis_id')
        				->leftJoin('dem_kelurahan','pelanggan.KelID','=','dem_kelurahan.subdis_id')
        				->leftJoin('gruppelanggan', function ($value){
        					$value->on('pelanggan.KodeGrupPelanggan','=','gruppelanggan.KodeGrup')
        					->on('pelanggan.RecordOwnerID','=','gruppelanggan.RecordOwnerID');
        				})
        				->where(function ($query) use($keyword, $field) {
		                    for ($i = 0; $i < count($field); $i++){
		                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
		                    }      
		                })->where('pelanggan.RecordOwnerID','=',Auth::user()->RecordOwnerID);

        // $pelanggan = $pelanggan->paginate(4);

        $title = 'Delete Pelanggan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        
        $metodepembayaran = \App\Models\MetodePembayaran::where('RecordOwnerID', Auth::user()->RecordOwnerID)->where('MetodeVerifikasi','AUTO')->first();
        $company = \App\Models\Company::where('KodePartner', Auth::user()->RecordOwnerID)->first();

        
        $midtransclientkey = $company ? $metodepembayaran->ClientKey : '';
        
        return view("master.BussinessPartner.Pelanggan",[
            'pelanggan' => $pelanggan->get(),
            'metodepembayaran' => $metodepembayaran,
            'midtransclientkey' => $midtransclientkey,
            'company' => $company,
        ]);
    }

    public function ReadPelangganJson(Request $request)
    {
        $data = array('success'=>false, 'message'=>'', 'data'=>array());

        $KodePelanggan = $request->input('KodePelanggan');
        $GrupPelanggan = $request->input('GrupPelanggan');
        $Search        = $request->input('Search');

        $NoHP          = $request->input('NoTlp1');
        $Email         = $request->input('Email');

        $RecordOwnerID = "";

        if(!empty($request->input('RecordOwnerID'))){
            $RecordOwnerID = $request->input('RecordOwnerID');
        }
        else{
            $RecordOwnerID =    Auth::user()->RecordOwnerID;
        }

        $sql = "pelanggan.*, gruppelanggan.DiskonPersen";
        $pelanggan = Pelanggan::selectRaw($sql)
                        ->leftJoin('gruppelanggan', function ($value){
                            $value->on('pelanggan.KodeGrupPelanggan','=','gruppelanggan.KodeGrup')
                            ->on('pelanggan.RecordOwnerID','=','gruppelanggan.RecordOwnerID');
                        })
                        ->where('pelanggan.RecordOwnerID','=',$RecordOwnerID);

        if ($KodePelanggan != "") {
            $pelanggan->where('pelanggan.KodePelanggan','=',$KodePelanggan);
        }

        if ($GrupPelanggan != "") {
            $pelanggan->where('pelanggan.KodeGrupPelanggan','=',$GrupPelanggan);
        }
        if(!empty($NoHP) ){
            $pelanggan->where('pelanggan.NoTlp1','=',$NoHP);
        }

        if(!empty($Email) ){
            $pelanggan->where('pelanggan.Email','=',$Email);
        }

        if (!empty($Search)) {
            $pelanggan->whereRaw("CONCAT(COALESCE(pelanggan.KodePelanggan,''), ' ' , coalesce(pelanggan.NamaPelanggan,''), ' ', COALESCE(pelanggan.PelangganID,''),' ', COALESCE(pelanggan.Email,''),' ', COALESCE(pelanggan.NoTlp1,'')) LIKE ?", ['%'.$Search.'%']);
        }

        $data['success'] = true;
        $data['data'] = $pelanggan->get();

        return response()->json($data);
    }

    public function Form($KodePelanggan = null)
    {
    	$pelanggan = Pelanggan::where('KodePelanggan','=',$KodePelanggan)->get();
    	$gruppelanggan = GrupPelanggan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
    	$provinsi = Provinsi::all();
        
        return view("master.BussinessPartner.Pelanggan-Input",[
            'pelanggan' => $pelanggan,
            'gruppelanggan' => $gruppelanggan,
            'provinsi' => $provinsi
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaPelanggan'=>'required',
                'KodeGrupPelanggan'=>'required',
            ]);

            $numberingData = new DocumentNumbering();
            $KodePelanggan = $numberingData->GetNewDoc("PLG","pelanggan","KodePelanggan");

            $model = new Pelanggan;
            $model->KodePelanggan = $KodePelanggan;
			$model->NamaPelanggan = $request->input('NamaPelanggan');
			$model->KodeGrupPelanggan = $request->input('KodeGrupPelanggan');
			$model->LimitPiutang = $request->input('LimitPiutang');
			$model->ProvID = $request->input('ProvID');
			$model->KotaID = $request->input('KotaID');
			$model->KelID = $request->input('KelID');
			$model->KecID = $request->input('KecID');
			$model->Email = $request->input('Email');
			$model->NoTlp1 = $request->input('NoTlp1');
			$model->NoTlp2 = $request->input('NoTlp2');
			$model->Alamat = $request->input('Alamat');
			$model->Keterangan = $request->input('Keterangan');
            $model->Status = $request->input('Status');
            $model->PelangganID = $request->input('PelangganID');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;
            $allowedDays = $request->input('AllowedDay');
            $model->AllowedDay = is_array($allowedDays) ? implode(',', $allowedDays) : '';
            // ValidUntil will be set only during activation/extension
            $model->isPaidMembership = $request->input('isPaidMembership', 0);
            $model->MaxPlay = $request->input('MaxPlay', 0);
            $model->Played = $request->input('Played', 0);
            $model->MemberPrice = $request->input('MemberPrice', 0);
            $model->maxTimePerPlay = $request->input('maxTimePerPlay', 0);
            $model->TglBerlanggananPaketBulanan = $request->input('TglBerlanggananPaketBulanan');

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Pelanggan Berhasil disimpan.');
                return redirect('pelanggan');
                
            }else{
                throw new \Exception('Penambahan Data Gagal');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function storeJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => 0);
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaPelanggan'=>'required',
                'KodeGrupPelanggan'=>'required',
            ]);

            $numberingData = new DocumentNumbering();
            $KodePelanggan = $numberingData->GetNewDoc("PLG","pelanggan","KodePelanggan");

            $model = new Pelanggan;
            $model->KodePelanggan = $KodePelanggan;
            $model->NamaPelanggan = $request->input('NamaPelanggan');
            $model->KodeGrupPelanggan = $request->input('KodeGrupPelanggan');
            $model->LimitPiutang = $request->input('LimitPiutang');
            $model->ProvID = $request->input('ProvID');
            $model->KotaID = $request->input('KotaID');
            $model->KelID = $request->input('KelID');
            $model->KecID = $request->input('KecID');
            $model->Email = $request->input('Email');
            $model->NoTlp1 = $request->input('NoTlp1');
            $model->NoTlp2 = $request->input('NoTlp2');
            $model->Alamat = $request->input('Alamat');
            $model->Keterangan = $request->input('Keterangan');
            $model->Status = $request->input('Status');
            $model->PelangganID = $request->input('PelangganID');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;
            $allowedDays = $request->input('AllowedDay');
            $model->AllowedDay = is_array($allowedDays) ? implode(',', $allowedDays) : '';
            // ValidUntil will be set only during activation/extension
            $model->isPaidMembership = $request->input('isPaidMembership', 0);
            $model->MaxPlay = $request->input('MaxPlay', 0);
            $model->Played = $request->input('Played', 0);
            $model->MemberPrice = $request->input('MemberPrice', 0);
            $model->maxTimePerPlay = $request->input('maxTimePerPlay', 0);
            $model->TglBerlanggananPaketBulanan = $request->input('TglBerlanggananPaketBulanan');

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                $data['message'] = 'Data Pelanggan Berhasil disimpan.';
                $data['LastTRX'] = $KodePelanggan;
                
            }else{
                $data['success'] = false;
                $data['message'] = 'Penambahan Data Gagal';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            $data['success'] = false;
            $data['message'] = 'Penambahan Data Gagal : '.$e->getMessage();
        }
        return response()->json($data);
    }

    public function edit(Request $request)
    {
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodePelanggan'=>'required',
                'NamaPelanggan'=>'required',
                'KodeGrupPelanggan'=>'required',
            ]);

            $model = Pelanggan::where('KodePelanggan','=',$request->input('KodePelanggan'))->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

            if ($model) {
                \App\Services\DBLogger::update('pelanggan', ['KodePelanggan' => $request->input('KodePelanggan'), 'RecordOwnerID' => Auth::user()->RecordOwnerID], [
                    'NamaPelanggan' => $request->input('NamaPelanggan'),
                    'KodeGrupPelanggan' => $request->input('KodeGrupPelanggan'),
                    'LimitPiutang' => $request->input('LimitPiutang'),
                    'ProvID' => $request->input('ProvID'),
                    'KotaID' => $request->input('KotaID'),
                    'KelID' => $request->input('KelID'),
                    'KecID' => $request->input('KecID'),
                    'Email' => $request->input('Email'),
                    'NoTlp1' => $request->input('NoTlp1'),
                    'NoTlp2' => $request->input('NoTlp2'),
                    'Alamat' => $request->input('Alamat'),
                    'Keterangan' => $request->input('Keterangan'),
                    'Status' => $request->input('Status'),
                    'PelangganID' => $request->input('PelangganID'),
                    'AllowedDay' => is_array($request->input('AllowedDay')) ? implode(',', $request->input('AllowedDay')) : '',
                    // ValidUntil will be set only during activation/extension
                    'isPaidMembership' => $request->input('isPaidMembership', 0),
                    'MaxPlay' => $request->input('MaxPlay', 0),
                    'Played' => $request->input('Played', 0),
                    'MemberPrice' => $request->input('MemberPrice', 0),
                    'maxTimePerPlay' => $request->input('maxTimePerPlay', 0),
                    'TglBerlanggananPaketBulanan' => $request->input('TglBerlanggananPaketBulanan')
                ]);

                alert()->success('Success','Data Pelanggan berhasil disimpan.');
                return redirect('pelanggan');

            } else{
                throw new \Exception('Pelanggan not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function editJson(Request $request)
    {
        $data = array('success' => false, 'message' => '');
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodePelanggan'=>'required',
                'NamaPelanggan'=>'required',
                'KodeGrupPelanggan'=>'required',
            ]);

            $model = Pelanggan::where('KodePelanggan','=',$request->input('KodePelanggan'))->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

            if ($model) {
                \App\Services\DBLogger::update('pelanggan', ['KodePelanggan' => $request->input('KodePelanggan'), 'RecordOwnerID' => Auth::user()->RecordOwnerID], [
                    'NamaPelanggan' => $request->input('NamaPelanggan'),
                    'KodeGrupPelanggan' => $request->input('KodeGrupPelanggan'),
                    'LimitPiutang' => $request->input('LimitPiutang'),
                    'ProvID' => $request->input('ProvID'),
                    'KotaID' => $request->input('KotaID'),
                    'KelID' => $request->input('KelID'),
                    'KecID' => $request->input('KecID'),
                    'Email' => $request->input('Email'),
                    'NoTlp1' => $request->input('NoTlp1'),
                    'NoTlp2' => $request->input('NoTlp2'),
                    'Alamat' => $request->input('Alamat'),
                    'Keterangan' => $request->input('Keterangan'),
                    'Status' => $request->input('Status'),
                    'PelangganID' => $request->input('PelangganID'),
                    'AllowedDay' => is_array($request->input('AllowedDay')) ? implode(',', $request->input('AllowedDay')) : '',
                    // ValidUntil will be set only during activation/extension
                    'isPaidMembership' => $request->input('isPaidMembership', 0),
                    'MaxPlay' => $request->input('MaxPlay', 0),
                    'Played' => $request->input('Played', 0),
                    'MemberPrice' => $request->input('MemberPrice', 0),
                    'maxTimePerPlay' => $request->input('maxTimePerPlay', 0),
                    'TglBerlanggananPaketBulanan' => $request->input('TglBerlanggananPaketBulanan')
                ]);

                $data['success'] = true;
            } else{
                $data['message'] = 'Pelanggan not found.';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function deletedata(Request $request)
    {
        $pelanggan = DB::table('pelanggan')
                ->where('KodePelanggan','=', $request->id)
                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                ->delete();

        if ($pelanggan) {
        	alert()->success('Success','Delete Pelanggan berhasil.');
        }
        else{
        	alert()->error('Error','Delete Pelanggan Gagal.');
        }
        return redirect('pelanggan');
    }
    public function Export()
    {
        return Excel::download(new PelangganExport(), 'Daftar Pelanggan.xlsx');
    }

    public function activateMember(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array());
        DB::beginTransaction();
        
        try {
            $kodeMember = $request->input('kode_member');
            $metodeId = $request->input('metode_pembayaran');
            
            // Get member data
            $pelanggan = Pelanggan::where('KodePelanggan', $kodeMember)
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->first();
            
            if (!$pelanggan) {
                $data['message'] = 'Member tidak ditemukan';
                return response()->json($data);
            }
            
            $currentDate = Carbon::now();
            $Year = $currentDate->format('Y');
            $Month = $currentDate->format('m');
            
            // Get company settings
            $oCompany = \App\Models\Company::where('KodePartner', Auth::user()->RecordOwnerID)->first();
            
            // Create Faktur
            $numberingData = new DocumentNumbering();
            $fakturNo = $numberingData->GetNewDoc("POS", "fakturpenjualanheader", "NoTransaksi");
            
            $fHeader = new \App\Models\FakturPenjualanHeader();
            $fHeader->Periode = $Year . $Month;
            $fHeader->NoTransaksi = $fakturNo;
            $fHeader->Transaksi = 'POS';
            $fHeader->TglTransaksi = $currentDate;
            $fHeader->TglJatuhTempo = $currentDate;
            $fHeader->NoReff = 'AKTIVASI-' . $kodeMember;
            $fHeader->KodePelanggan = $kodeMember;
            $fHeader->KodeTermin = "";
            $fHeader->Termin = 0;
            $fHeader->TotalTransaksi = $pelanggan->MemberPrice;
            $fHeader->Potongan = 0;
            $fHeader->Pajak = 0;
            $fHeader->TotalPembelian = $pelanggan->MemberPrice;
            $fHeader->TotalRetur = 0;
            $fHeader->TotalPembayaran = $pelanggan->MemberPrice;
            $fHeader->Pembulatan = 0;
            $fHeader->Status = 'C'; // Close/Lunas
            $fHeader->Keterangan = 'Aktivasi Member';
            $fHeader->MetodeBayar = $metodeId;
            $fHeader->ReffPembayaran = "AKTIVASI-" . $kodeMember;
            $fHeader->KodeSales = Auth::user()->KodeSales;
            $fHeader->Posted = 0;
            $fHeader->RecordOwnerID = Auth::user()->RecordOwnerID;
            $fHeader->CreatedBy = Auth::user()->name;
            $fHeader->UpdatedBy = "";
            $fHeader->save();
            
            // Create Faktur Detail
            $fDetail = new \App\Models\FakturPenjualanDetail();
            $fDetail->NoTransaksi = $fakturNo;
            $fDetail->NoUrut = 0;
            $fDetail->KodeItem = $oCompany->ItemHiburan;
            $fDetail->Qty = 1;
            $fDetail->QtyKonversi = 1;
            $fDetail->QtyRetur = 0;
            $fDetail->Satuan = 'PAKET';
            $fDetail->Harga = $pelanggan->MemberPrice;
            $fDetail->Discount = 0;
            $fDetail->BaseReff = '';
            $fDetail->BaseLine = -1;
            $fDetail->KodeGudang = $oCompany->GudangPoS;
            $fDetail->HargaNet = $pelanggan->MemberPrice;
            $fDetail->LineStatus = 'O';
            $fDetail->VatPercent = 0;
            $fDetail->HargaPokokPenjualan = 0;
            $fDetail->RecordOwnerID = Auth::user()->RecordOwnerID;
            $fDetail->save();
            
            // Create Payment
            $payNo = $numberingData->GetNewDoc("INPAY", "pembayaranpenjualanheader", "NoTransaksi");
            $pHeader = new \App\Models\PembayaranPenjualanHeader();
            $pHeader->Periode = $Year . $Month;
            $pHeader->NoTransaksi = $payNo;
            $pHeader->TglTransaksi = $currentDate;
            $pHeader->KodePelanggan = $kodeMember;
            $pHeader->TotalPembelian = $pelanggan->MemberPrice;
            $pHeader->TotalPembayaran = $pelanggan->MemberPrice;
            $pHeader->KodeMetodePembayaran = $metodeId;
            $pHeader->NoReff = "AKTIVASI-" . $kodeMember;
            $pHeader->Keterangan = 'Aktivasi Member';
            $pHeader->RecordOwnerID = Auth::user()->RecordOwnerID;
            $pHeader->CreatedBy = Auth::user()->name;
            $pHeader->UpdatedBy = "";
            $pHeader->Posted = 0;
            $pHeader->Status = 'C';
            $pHeader->save();
            
            $pDetail = new \App\Models\PembayaranPenjualanDetail();
            $pDetail->NoTransaksi = $payNo;
            $pDetail->NoUrut = 0;
            $pDetail->BaseReff = $fakturNo;
            $pDetail->TotalPembayaran = $pelanggan->MemberPrice;
            $pDetail->RecordOwnerID = Auth::user()->RecordOwnerID;
            $pDetail->KodeMetodePembayaran = $metodeId;
            $pDetail->Keterangan = 'Aktivasi Member';
            $pDetail->save();
            
            // Update member ValidUntil and reset Played
            $validUntil = $currentDate->copy()->addDays(30);
            DB::table('pelanggan')
                ->where('KodePelanggan', $kodeMember)
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->update([
                    'ValidUntil' => $validUntil,
                    'Played' => 0
                ]);
            
            DB::commit();
            $data['success'] = true;
            $data['message'] = 'Member berhasil diaktivasi';
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Member activation error: " . $e->getMessage());
            $data['message'] = 'Gagal mengaktivasi member: ' . $e->getMessage();
        }
        
        return response()->json($data);
    }

    public function extendMember(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array());
        DB::beginTransaction();
        
        try {
            $kodeMember = $request->input('kode_member');
            $validUntil = $request->input('valid_until');
            $metodeId = $request->input('metode_pembayaran');
            
            // Get member data
            $pelanggan = Pelanggan::where('KodePelanggan', $kodeMember)
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->first();
            
            if (!$pelanggan) {
                $data['message'] = 'Member tidak ditemukan';
                return response()->json($data);
            }
            
            $currentDate = Carbon::now();
            $Year = $currentDate->format('Y');
            $Month = $currentDate->format('m');
            
            // Get company settings
            $oCompany = \App\Models\Company::where('KodePartner', Auth::user()->RecordOwnerID)->first();
            
            // Create Faktur
            $numberingData = new DocumentNumbering();
            $fakturNo = $numberingData->GetNewDoc("POS", "fakturpenjualanheader", "NoTransaksi");
            
            $fHeader = new \App\Models\FakturPenjualanHeader();
            $fHeader->Periode = $Year . $Month;
            $fHeader->NoTransaksi = $fakturNo;
            $fHeader->Transaksi = 'POS';
            $fHeader->TglTransaksi = $currentDate;
            $fHeader->TglJatuhTempo = $currentDate;
            $fHeader->NoReff = 'PERPANJANG-' . $kodeMember;
            $fHeader->KodePelanggan = $kodeMember;
            $fHeader->KodeTermin = "";
            $fHeader->Termin = 0;
            $fHeader->TotalTransaksi = $pelanggan->MemberPrice;
            $fHeader->Potongan = 0;
            $fHeader->Pajak = 0;
            $fHeader->TotalPembelian = $pelanggan->MemberPrice;
            $fHeader->TotalRetur = 0;
            $fHeader->TotalPembayaran = $pelanggan->MemberPrice;
            $fHeader->Pembulatan = 0;
            $fHeader->Status = 'C'; // Close/Lunas
            $fHeader->Keterangan = 'Perpanjang Member';
            $fHeader->MetodeBayar = $metodeId;
            $fHeader->ReffPembayaran = "PERPANJANG-" . $kodeMember;
            $fHeader->KodeSales = Auth::user()->KodeSales;
            $fHeader->Posted = 0;
            $fHeader->RecordOwnerID = Auth::user()->RecordOwnerID;
            $fHeader->CreatedBy = Auth::user()->name;
            $fHeader->UpdatedBy = "";
            $fHeader->save();
            
            // Create Faktur Detail
            $fDetail = new \App\Models\FakturPenjualanDetail();
            $fDetail->NoTransaksi = $fakturNo;
            $fDetail->NoUrut = 0;
            $fDetail->KodeItem = $oCompany->ItemHiburan;
            $fDetail->Qty = 1;
            $fDetail->QtyKonversi = 1;
            $fDetail->QtyRetur = 0;
            $fDetail->Satuan = 'PAKET';
            $fDetail->Harga = $pelanggan->MemberPrice;
            $fDetail->Discount = 0;
            $fDetail->BaseReff = '';
            $fDetail->BaseLine = -1;
            $fDetail->KodeGudang = $oCompany->GudangPoS;
            $fDetail->HargaNet = $pelanggan->MemberPrice;
            $fDetail->LineStatus = 'O';
            $fDetail->VatPercent = 0;
            $fDetail->HargaPokokPenjualan = 0;
            $fDetail->RecordOwnerID = Auth::user()->RecordOwnerID;
            $fDetail->save();
            
            // Create Payment
            $payNo = $numberingData->GetNewDoc("INPAY", "pembayaranpenjualanheader", "NoTransaksi");
            $pHeader = new \App\Models\PembayaranPenjualanHeader();
            $pHeader->Periode = $Year . $Month;
            $pHeader->NoTransaksi = $payNo;
            $pHeader->TglTransaksi = $currentDate;
            $pHeader->KodePelanggan = $kodeMember;
            $pHeader->TotalPembelian = $pelanggan->MemberPrice;
            $pHeader->TotalPembayaran = $pelanggan->MemberPrice;
            $pHeader->KodeMetodePembayaran = $metodeId;
            $pHeader->NoReff = "PERPANJANG-" . $kodeMember;
            $pHeader->Keterangan = 'Perpanjang Member';
            $pHeader->RecordOwnerID = Auth::user()->RecordOwnerID;
            $pHeader->CreatedBy = Auth::user()->name;
            $pHeader->UpdatedBy = "";
            $pHeader->Posted = 0;
            $pHeader->Status = 'C';
            $pHeader->save();
            
            $pDetail = new \App\Models\PembayaranPenjualanDetail();
            $pDetail->NoTransaksi = $payNo;
            $pDetail->NoUrut = 0;
            $pDetail->BaseReff = $fakturNo;
            $pDetail->TotalPembayaran = $pelanggan->MemberPrice;
            $pDetail->RecordOwnerID = Auth::user()->RecordOwnerID;
            $pDetail->KodeMetodePembayaran = $metodeId;
            $pDetail->Keterangan = 'Perpanjang Member';
            $pDetail->save();
            
            // Update member ValidUntil and reset Played
            DB::table('pelanggan')
                ->where('KodePelanggan', $kodeMember)
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->update([
                    'ValidUntil' => $validUntil,
                    'Played' => 0
                ]);
            
            DB::commit();
            $data['success'] = true;
            $data['message'] = 'Member berhasil diperpanjang';
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Member extension error: " . $e->getMessage());
            $data['message'] = 'Gagal memperpanjang member: ' . $e->getMessage();
        }
        
        return response()->json($data);
    }

    public function paymentGateway(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'snap_token' => '');
        
        try {
            $kodeMember = $request->input('kode_member');
            $type = $request->input('type'); // 'aktivasi' or 'perpanjang'
            $metodeId = $request->input('metode_pembayaran');
            $validUntil = $request->input('valid_until', '');
            
            // Get member data
            $pelanggan = Pelanggan::where('KodePelanggan', $kodeMember)
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->first();
            
            if (!$pelanggan) {
                $data['message'] = 'Member tidak ditemukan';
                return response()->json($data);
            }
            
            // Get payment method
            $metode = \App\Models\MetodePembayaran::where('id', $metodeId)
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->first();
            
            if (!$metode || !$metode->ServerKey) {
                $data['message'] = 'Metode pembayaran tidak valid atau belum dikonfigurasi';
                return response()->json($data);
            }
            
            // Configure Midtrans
            \Midtrans\Config::$serverKey = $metode->ServerKey;
            \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;
            
            // Create unique order ID
            $orderId = 'MEMBER-' . strtoupper($type) . '-' . $kodeMember . '-' . time();
            
            // Create transaction details
            $transaction_details = [
                'order_id' => $orderId,
                'gross_amount' => floatval($pelanggan->MemberPrice),
            ];
            
            $customer_details = [
                'first_name' => $pelanggan->NamaPelanggan,
                'email' => $pelanggan->Email,
                'phone' => $pelanggan->NoTlp1,
            ];
            
            // Store transaction metadata
            $metadata = [
                'kode_member' => $kodeMember,
                'type' => $type,
                'valid_until' => $validUntil,
                'metode_id' => $metodeId,
                'user_id' => Auth::user()->id,
                'record_owner_id' => Auth::user()->RecordOwnerID,
            ];
            
            $transaction = [
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
                'custom_field1' => json_encode($metadata),
            ];
            
            $snapToken = \Midtrans\Snap::getSnapToken($transaction);
            
            $data['success'] = true;
            $data['snap_token'] = $snapToken;
            $data['order_id'] = $orderId;
            
        } catch (\Exception $e) {
            Log::error("Payment gateway error: " . $e->getMessage());
            $data['message'] = 'Gagal membuat transaksi: ' . $e->getMessage();
        }
        
        return response()->json($data);
    }

    public function paymentCallback(Request $request)
    {
        $data = array('success' => false, 'message' => '');
        DB::beginTransaction();
        
        try {
            $orderId = $request->input('order_id');
            $statusCode = $request->input('status_code');
            $transactionStatus = $request->input('transaction_status');
            $metadata = json_decode($request->input('metadata'), true);
            
            // Verify payment is successful
            if ($transactionStatus !== 'settlement' && $transactionStatus !== 'capture') {
                $data['message'] = 'Pembayaran belum selesai';
                return response()->json($data);
            }
            
            $kodeMember = $metadata['kode_member'];
            $type = $metadata['type'];
            $validUntil = $metadata['valid_until'];
            $metodeId = $metadata['metode_id'];
            
            // Get member data
            $pelanggan = Pelanggan::where('KodePelanggan', $kodeMember)
                ->where('RecordOwnerID', $metadata['record_owner_id'])
                ->first();
            
            if (!$pelanggan) {
                $data['message'] = 'Member tidak ditemukan';
                return response()->json($data);
            }
            
            $currentDate = Carbon::now();
            $Year = $currentDate->format('Y');
            $Month = $currentDate->format('m');
            
            // Get company settings
            $oCompany = \App\Models\Company::where('KodePartner', $metadata['record_owner_id'])->first();
            
            // Create Faktur
            $numberingData = new DocumentNumbering();
            $fakturNo = $numberingData->GetNewDoc("POS", "fakturpenjualanheader", "NoTransaksi");
            
            $fHeader = new \App\Models\FakturPenjualanHeader();
            $fHeader->Periode = $Year . $Month;
            $fHeader->NoTransaksi = $fakturNo;
            $fHeader->Transaksi = 'POS';
            $fHeader->TglTransaksi = $currentDate;
            $fHeader->TglJatuhTempo = $currentDate;
            $fHeader->NoReff = strtoupper($type) . '-' . $kodeMember;
            $fHeader->KodePelanggan = $kodeMember;
            $fHeader->KodeTermin = "";
            $fHeader->Termin = 0;
            $fHeader->TotalTransaksi = $pelanggan->MemberPrice;
            $fHeader->Potongan = 0;
            $fHeader->Pajak = 0;
            $fHeader->TotalPembelian = $pelanggan->MemberPrice;
            $fHeader->TotalRetur = 0;
            $fHeader->TotalPembayaran = $pelanggan->MemberPrice;
            $fHeader->Pembulatan = 0;
            $fHeader->Status = 'C';
            $fHeader->Keterangan = ucfirst($type) . ' Member via Payment Gateway';
            $fHeader->MetodeBayar = $metodeId;
            $fHeader->ReffPembayaran = $orderId;
            $fHeader->KodeSales = '';
            $fHeader->Posted = 0;
            $fHeader->RecordOwnerID = $metadata['record_owner_id'];
            $fHeader->CreatedBy = 'SYSTEM';
            $fHeader->UpdatedBy = "";
            $fHeader->save();
            
            // Create Faktur Detail
            $fDetail = new \App\Models\FakturPenjualanDetail();
            $fDetail->NoTransaksi = $fakturNo;
            $fDetail->NoUrut = 0;
            $fDetail->KodeItem = $oCompany->ItemHiburan;
            $fDetail->Qty = 1;
            $fDetail->QtyKonversi = 1;
            $fDetail->QtyRetur = 0;
            $fDetail->Satuan = 'PAKET';
            $fDetail->Harga = $pelanggan->MemberPrice;
            $fDetail->Discount = 0;
            $fDetail->BaseReff = '';
            $fDetail->BaseLine = -1;
            $fDetail->KodeGudang = $oCompany->GudangPoS;
            $fDetail->HargaNet = $pelanggan->MemberPrice;
            $fDetail->LineStatus = 'O';
            $fDetail->VatPercent = 0;
            $fDetail->HargaPokokPenjualan = 0;
            $fDetail->RecordOwnerID = $metadata['record_owner_id'];
            $fDetail->save();
            
            // Create Payment
            $payNo = $numberingData->GetNewDoc("INPAY", "pembayaranpenjualanheader", "NoTransaksi");
            $pHeader = new \App\Models\PembayaranPenjualanHeader();
            $pHeader->Periode = $Year . $Month;
            $pHeader->NoTransaksi = $payNo;
            $pHeader->TglTransaksi = $currentDate;
            $pHeader->KodePelanggan = $kodeMember;
            $pHeader->TotalPembelian = $pelanggan->MemberPrice;
            $pHeader->TotalPembayaran = $pelanggan->MemberPrice;
            $pHeader->KodeMetodePembayaran = $metodeId;
            $pHeader->NoReff = $orderId;
            $pHeader->Keterangan = ucfirst($type) . ' Member via Payment Gateway';
            $pHeader->RecordOwnerID = $metadata['record_owner_id'];
            $pHeader->CreatedBy = 'SYSTEM';
            $pHeader->UpdatedBy = "";
            $pHeader->Posted = 0;
            $pHeader->Status = 'C';
            $pHeader->save();
            
            $pDetail = new \App\Models\PembayaranPenjualanDetail();
            $pDetail->NoTransaksi = $payNo;
            $pDetail->NoUrut = 0;
            $pDetail->BaseReff = $fakturNo;
            $pDetail->TotalPembayaran = $pelanggan->MemberPrice;
            $pDetail->RecordOwnerID = $metadata['record_owner_id'];
            $pDetail->KodeMetodePembayaran = $metodeId;
            $pDetail->Keterangan = ucfirst($type) . ' Member via Payment Gateway';
            $pDetail->save();
            
            // Update member ValidUntil and reset Played
            if ($type === 'aktivasi') {
                $newValidUntil = $currentDate->copy()->addDays(30);
            } else {
                $newValidUntil = $validUntil;
            }
            
            DB::table('pelanggan')
                ->where('KodePelanggan', $kodeMember)
                ->where('RecordOwnerID', $metadata['record_owner_id'])
                ->update([
                    'ValidUntil' => $newValidUntil,
                    'Played' => 0
                ]);
            
            DB::commit();
            $data['success'] = true;
            $data['message'] = 'Pembayaran berhasil diproses';
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Payment callback error: " . $e->getMessage());
            $data['message'] = 'Gagal memproses pembayaran: ' . $e->getMessage();
        }
        
        return response()->json($data);
    }
}
