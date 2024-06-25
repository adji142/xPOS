<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\SettingAccount;
use App\Models\Rekening;

class SettingAccountController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeSatuan','NamaSatuan'];
        $keyword = $request->input('keyword');

        $settingakun = SettingAccount::Where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        $account = Rekening::Where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
        			->Where('Jenis','=',2)->get();

        $title = 'Delete Grup Pelanggan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("setting.AcctSetting",[
            'settingakun' => $settingakun, 
            'account' => $account
        ]);
    }
    public function checkInput(Request $request, $Name)
	{
	    if ($request->filled($Name)) {
	        // Input is filled
	        return $request->input($Name);
	    } else {
	        // Input is empty or not present
	        return '';
	    }
	}
    public function edit(Request $request)
    {
        Log::debug($request->all());
        try {
        	// var_dump($this->checkInput($request, 'InvAcctPersediaan'));
            $model = SettingAccount::where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('settingaccount')
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'InvAcctHargaPokokPenjualan'=>$this->checkInput($request, 'InvAcctHargaPokokPenjualan'),
									'InvAcctPendapatanJual'=>$this->checkInput($request, 'InvAcctPendapatanJual'),
									'InvAcctPendapatanJasa'=>$this->checkInput($request, 'InvAcctPendapatanJasa'),
									'InvAcctPersediaan'=>$this->checkInput($request, 'InvAcctPersediaan'),
									'InvAcctPendapatanNonInventory'=>$this->checkInput($request, 'InvAcctPendapatanNonInventory'),
									'InvAcctPendapatanLainLain'=>$this->checkInput($request, 'InvAcctPendapatanLainLain'),
									'InvAcctPenyesuaiaanStockMasuk'=>$this->checkInput($request, 'InvAcctPenyesuaiaanStockMasuk'),
									'InvAcctPenyesuaiaanStockKeluar'=>$this->checkInput($request, 'InvAcctPenyesuaiaanStockKeluar'),
									'PbAcctPajakPembelian'=>$this->checkInput($request, 'PbAcctPajakPembelian'),
									'PbAcctPembayaranTunai'=>$this->checkInput($request, 'PbAcctPembayaranTunai'),
									'PbAcctPembayaranNonTunai'=>$this->checkInput($request, 'PbAcctPembayaranNonTunai'),
									'PbAcctHutang'=>$this->checkInput($request, 'PbAcctHutang'),
									'PbAcctUangMukaPembelian'=>$this->checkInput($request, 'PbAcctUangMukaPembelian'),
									'PjAcctPajakPenjualan'=>$this->checkInput($request, 'PjAcctPajakPenjualan'),
									'PjAcctPenjualanTunai'=>$this->checkInput($request, 'PjAcctPenjualanTunai'),
									'PjAcctPenjualanNonTunai'=>$this->checkInput($request, 'PjAcctPenjualanNonTunai'),
									'PjAcctPiutang'=>$this->checkInput($request, 'PjAcctPiutang'),
									'PjAcctUangMukaPenjualan'=>$this->checkInput($request, 'PjAcctUangMukaPenjualan'),
                                    'PjAcctGoodsInTransit'=>$this->checkInput($request, 'PjAcctGoodsInTransit'),
									'KnAcctHutangKonsinyasi'=>$this->checkInput($request, 'KnAcctHutangKonsinyasi'),
									'KnAcctPembayaranHutang'=>$this->checkInput($request, 'KnAcctPembayaranHutang'),
									'OthAcctModal'=>$this->checkInput($request, 'OthAcctModal'),
									'OthAcctPrive'=>$this->checkInput($request, 'OthAcctPrive'),
									'OthAcctLabaDitahan'=>$this->checkInput($request, 'OthAcctLabaDitahan'),
									'OthAcctLabaTahunBerjalan'=>$this->checkInput($request, 'OthAcctLabaTahunBerjalan')
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Setting Berhasil disimpan.');
                    return redirect('acctsetting');
                }else{
                    throw new \Exception('Edit Setting Gagal');
                }
            } else{
                throw new \Exception('Satuan not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }
}
