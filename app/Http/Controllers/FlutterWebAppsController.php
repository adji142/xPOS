<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OrderPenjualanHeader;
use App\Models\OrderPenjualanDetail;
use App\Models\FakturPenjualanHeader;
use App\Models\FakturPenjualanDetail;
use App\Models\FakturPenjualanVariant;
use App\Models\DeliveryNoteDetail;
use App\Models\DeliveryNoteHeader;
use App\Models\PembayaranPenjualanDetail;
use App\Models\PembayaranPenjualanHeader;
use App\Models\Pelanggan;
use App\Models\Termin;
use App\Models\ItemMaster;
use App\Models\Satuan;
use App\Models\MetodePembayaran;
use App\Models\DocumentNumbering;
use App\Models\Gudang;
use App\Models\AutoPosting;
use App\Models\SettingAccount;
use App\Models\Rekening;
use App\Models\Company;
use App\Models\Printer;
use App\Http\Controllers\PenghapusanBarangController;
use App\Http\Controllers\PengakuanBarangController;
use App\Models\MenuRestoHeader;
use App\Models\MenuRestoDetail;
use App\Models\MenuRestoVariant;
use App\Models\MenuRestoAddon;
use App\Models\Meja;
use App\Models\TipeOrderResto;
use App\Models\JenisItem;

class FlutterWebAppsController extends Controller
{
    public function InitProgram(Request $request){
        $data = array(
            'success' => false, 
            'message' => '', 
            'menu' => array(), 
            'variantmenu'=> array(),
            'addonmenu'=>array(),
            'company'=>array(),
            'meja'=>array(), 
            'kelompokmenu'=>array(), 
            'tipeorder'=>array()
        );

        $RecordOwnerID = $request->input('RecordOwnerID');
        $KodeMeja = $request->input('KodeMeja');
        $IPAddress = $request->input('IPAddress');
        $DeviceID = $request->input('DeviceID');

        // Company :
        $oCompany = Company::where('KodePartner',$RecordOwnerID)->get();
        $oMeja = Meja::where('KodeMeja', $KodeMeja);
        $otipeOrder = TipeOrderResto::where('RecordOwnerID','=',$RecordOwnerID)->get();
        $oKelompokMenu = JenisItem::where('RecordOwnerID','=',$RecordOwnerID)->get();


        $sql = "itemmaster.KodeItem, itemmaster.NamaItem, menuheader.HargaPokokStandar, menuheader.HargaJual, 
                        menuheader.Gambar";
        $itemmenu = ItemMaster::selectRaw($sql)
                    ->Join('menuheader', function ($value){
                        $value->on('menuheader.KodeItemHasil','=','itemmaster.KodeItem')
                        ->on('menuheader.RecordOwnerID','=','itemmaster.RecordOwnerID');
                    })
                    ->where('Active','Y')
                    ->get();
        
        $sql = "menuvarian.Father, variantdetail.variant_id AS VariantGrupID, variantheader.NamaGrup, 
        variantdetail.id AS VariantID, variantdetail.NamaVariant, variantheader.OpsiPilihan, variantdetail.ExtraPrice ";
        $variantData = MenuRestoVariant::selectRaw($sql)
                        ->join('variantdetail', function ($value)  {
                            $value->on('menuvarian.VariantGrupID','=','variantdetail.id')
                            ->on('menuvarian.RecordOwnerID','=','variantdetail.RecordOwnerID');
                        })
                        ->join('variantheader',function ($value) {
                            $value->on('variantheader.id','=','variantdetail.variant_id')
                            ->on('variantheader.RecordOwnerID','=','variantdetail.RecordOwnerID');
                        })
                        ->where('menuvarian.RecordOwnerID', $RecordOwnerID)
                        ->get();
        
        $menuaddon = MenuRestoAddon::selectRaw("addonmenudata.*, menuaddon.NamaAddon, menuaddon.HargaAddon")
                ->leftJoin('menuaddon', function ($value) {
                    $value->on('menuaddon.id','=','addonmenudata.AddonMenuID')
                    ->on('menuaddon.RecordOwnerID','=','addonmenudata.RecordOwnerID');
                })
                ->where('addonmenudata.RecordOwnerID', $RecordOwnerID)
                ->get();

        $data['success'] = true;
        $data['menu'] = $itemmenu;
        $data['variantmenu'] = $variantData;
        $data['addonmenu'] = $menuaddon;
        $data['company']= $oCompany;
        $data['meja'] = $oMeja;
        $data['kelompokmenu'] = $oKelompokMenu;
        $data['tipeorder'] = $otipeOrder;

        return response()->json($data);
    }

    function GetMenuByKelompok(Request $request) {
        $data = array(
            'success' => false, 
            'message' => '', 
            'data'=> array()
        );
        $KodeKelompok = $request->input('KodeKelompok');

        try {
            $sql = "itemmaster.KodeItem, itemmaster.NamaItem, menuheader.HargaPokokStandar, menuheader.HargaJual, 
                        menuheader.Gambar";
            $itemmenu = ItemMaster::selectRaw($sql)
                        ->Join('menuheader', function ($value){
                            $value->on('menuheader.KodeItemHasil','=','itemmaster.KodeItem')
                            ->on('menuheader.RecordOwnerID','=','itemmaster.RecordOwnerID');
                        })
                        ->where('Active','Y');
            if ($KodeKelompok != "") {
                $itemmenu->where('itemmaster.KodeJenisItem','=',$KodeKelompok);
            }
            $rs = $itemmenu->get();
            
            $data['success'] = true;
            $data['data'] = $rs;
        } catch (\Throwable $th) {
            $data['success'] = false;
            $data['message'] = $th->getMessage();
        }

        return response()->json($data);
    }

    function getVariantAddonData(Request $request) {
        $data = array(
            'success' => false, 
            'message' => '', 
            'variant'=> array(),
            'addon'=> array()
        );

        $KodeItem = $request->input('KodeItem');
        $RecordOwnerID = $request->input('RecordOwnerID');
        try {
            $sql = "menuvarian.Father, variantdetail.variant_id AS VariantGrupID, variantheader.NamaGrup, 
            variantdetail.id AS VariantID, variantdetail.NamaVariant, variantheader.OpsiPilihan, variantdetail.ExtraPrice ";
            $variantData = MenuRestoVariant::selectRaw($sql)
                            ->join('variantdetail', function ($value)  {
                                $value->on('menuvarian.VariantGrupID','=','variantdetail.id')
                                ->on('menuvarian.RecordOwnerID','=','variantdetail.RecordOwnerID');
                            })
                            ->join('variantheader',function ($value) {
                                $value->on('variantheader.id','=','variantdetail.variant_id')
                                ->on('variantheader.RecordOwnerID','=','variantdetail.RecordOwnerID');
                            })
                            ->where('menuvarian.RecordOwnerID', $RecordOwnerID);
            if ($KodeItem != "") {
                $variantData->where('menuvarian.Father', '=', $KodeItem);
            }
            
            $menuaddon = MenuRestoAddon::selectRaw("addonmenudata.*, menuaddon.NamaAddon, menuaddon.HargaAddon")
                    ->leftJoin('menuaddon', function ($value) {
                        $value->on('menuaddon.id','=','addonmenudata.AddonMenuID')
                        ->on('menuaddon.RecordOwnerID','=','addonmenudata.RecordOwnerID');
                    })
                    ->where('addonmenudata.RecordOwnerID', $RecordOwnerID);
            if ($KodeItem != "") {
                $menuaddon->where('addonmenudata.Father', '=', $KodeItem);
            }

            $data['success'] = true;
            $data['variant'] = $variantData->get();
            $data['addon'] = $menuaddon->get();
        } catch (\Throwable $th) {
            $data['success'] = false;
            $data['message'] = $th->getMessage();
        }

        return response()->json($data);
    }
}
