<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\ItemMaster;
use App\Models\MenuRestoHeader;
use App\Models\MenuRestoDetail;
use App\Models\MenuRestoVariant;
use App\Models\MenuRestoAddon;

use App\Models\VariantMenuHeader;
use App\Models\VariantMenuDetail;
use App\Models\MenuAddon;

class MenuRestoAddonController extends Controller
{
    public function View(Request $request)
    {
        $sql ="menuheader.Gambar, menuheader.KodeItemHasil, itemmaster.NamaItem, jenisitem.NamaJenis, 
            menuheader.HargaJual, COUNT(menuvarian.Father) JumlahVariant
        ";
        $oMenuData = MenuRestoHeader::selectRaw($sql)
                        ->leftJoin('itemmaster', function ($value){
                            $value->on('menuheader.KodeItemHasil','=','itemmaster.KodeItem')
                            ->on('menuheader.RecordOwnerID','=','itemmaster.RecordOwnerID');
                        })
                        ->leftJoin('jenisitem', function ($value){
                            $value->on('jenisitem.KodeJenis','=','itemmaster.KodeJenisItem')
                            ->on('jenisitem.RecordOwnerID','=','itemmaster.RecordOwnerID');
                        })
                        ->leftJoin('menuvarian', function ($value){
                            $value->on('menuvarian.Father','=','menuheader.KodeItemHasil')
                            ->on('menuvarian.RecordOwnerID','=','menuheader.RecordOwnerID');
                        })
                        ->where('menuheader.RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->groupBy('menuheader.Gambar', 'menuheader.KodeItemHasil', 'itemmaster.NamaItem', 'jenisitem.NamaJenis', 
                        'menuheader.HargaJual')
                        ->get();
        $title = 'Delete Menu ini !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("Resto.menu",[
            'menudata'=>$oMenuData
        ]);
    }

    function ViewJson(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
        $KodeJenis = $request->input('KodeJenis');
        
        $sql = "itemmaster.KodeItem, itemmaster.NamaItem, menuheader.HargaPokokStandar, menuheader.HargaJual, 
                        menuheader.Gambar";
                $itemmenu = ItemMaster::selectRaw($sql)
                            ->Join('menuheader', function ($value){
                                $value->on('menuheader.KodeItemHasil','=','itemmaster.KodeItem')
                                ->on('menuheader.RecordOwnerID','=','itemmaster.RecordOwnerID');
                            })
                            ->where('Active','Y');
        if ($KodeJenis != "") {
            $itemmenu->where('itemmaster.KodeJenisItem', $KodeJenis);
        }

        $data['data']= $itemmenu->get();
        return response()->json($data);
    }

    public function Form($KodeItemHasil = null)
    {   
        $oItem = new ItemMaster();
    	$itemhasil = $oItem->GetItemData(Auth::user()->RecordOwnerID,'', '', '','1', 'Y', '',1)->get();
        $itembahan = $oItem->GetItemData(Auth::user()->RecordOwnerID,'', '', '','6', 'Y', '',1)->get();
        $variantheader = VariantMenuHeader::where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
        $variantdetail = VariantMenuDetail::where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
        $daftaraddon = MenuAddon::selectRaw("menuaddon.*")
                    ->where('menuaddon.RecordOwnerID', Auth::user()->RecordOwnerID)
                    ->get();

        $menuheader = MenuRestoHeader::where('RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->where('KodeItemHasil', $KodeItemHasil)
                        ->get();
        $menudetail = MenuRestoDetail::selectRaw("menudetail.*, itemmaster.NamaItem")
                        ->leftJoin('itemmaster', function ($value){
                            $value->on('menudetail.KodeItemRM','=','itemmaster.KodeItem')
                            ->on('menudetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
                        })
                        ->where('menudetail.RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->where('menudetail.Father', $KodeItemHasil)
                        ->get();
        $menuaddon = MenuRestoAddon::selectRaw("addonmenudata.*, menuaddon.NamaAddon, menuaddon.HargaAddon")
                        ->leftJoin('menuaddon', function ($value) {
                            $value->on('menuaddon.id','=','addonmenudata.AddonMenuID')
                            ->on('menuaddon.RecordOwnerID','=','addonmenudata.RecordOwnerID');
                        })
                        ->where('addonmenudata.RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->where('addonmenudata.Father', $KodeItemHasil)
                        ->get();
        $menuvariant = MenuRestoVariant::selectRaw("DISTINCT variantheader.* ")
                        ->leftJoin('variantdetail', function ($value){
                            $value->on('menuvarian.VariantGrupID','=','variantdetail.id')
                            ->on('menuvarian.RecordOwnerID','=','variantdetail.RecordOwnerID');
                        })
                        ->leftJoin('variantheader', function ($value){
                            $value->on('variantheader.id','=','variantdetail.variant_id')
                            ->on('variantheader.RecordOwnerID','=','variantdetail.RecordOwnerID');
                        })
                        ->where('menuvarian.RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->where('menuvarian.Father', $KodeItemHasil)
                        ->get();

        return view("Resto.menu-Input",[
            'menu' => array(),
            'menuheader' => $menuheader,
            'menudetail' => $menudetail,
            'menuvariant' => $menuvariant,
            'itemhasil' => $itemhasil,
            'itembahan' => $itembahan,
            'variantheader' => $variantheader,
            'variantdetail' => $variantdetail,
            'daftaraddon' => $daftaraddon,
            'menuaddon' => $menuaddon
        ]);
    }

    function store(Request $request) {
        $errorCount = 0;
        $errorMessage = "";

        try {
            DB::beginTransaction();

            $image_base64 = $request->input('image_base64');
            $KodeItemHasil = $request->input('KodeItemHasil');
            $HargaPokokStandar = $request->input('HargaPokokStandar');
            $HargaJual = $request->input('HargaJual');
            $DetailParameter = $request->input('DetailParameter');
            $DetailVariant = $request->input('DetailVariant');
            $DetailAddon = $request->input('DetailAddon');

            $exist = MenuRestoHeader::where('KodeItemHasil', $KodeItemHasil)
                        ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->get();
            if (count($exist) > 0) {
                $errorMessage = "Menu ".$KodeItemHasil." Sudah ada disistem";
                $errorCount +=1;
                goto jump;
            }

            $header = new MenuRestoHeader();
            $header->KodeItemHasil = $KodeItemHasil;
            $header->QtyHasil = 1;
            $header->Satuan = "";
            $header->Gambar = $image_base64;
            $header->HargaPokokStandar = 0;
            $header->HargaJual = $HargaJual;
            $header->RecordOwnerID = Auth::user()->RecordOwnerID;
            $saveHeader = $header->save();

            // if (count($DetailParameter) == 0) {
            //     $errorMessage = "Data Bahan Tidak boleh kosong";
            //     $errorCount +=1;
            //     goto jump;
            // }

            $HargaPokokStandar = 0;

            if ($DetailParameter) {
                foreach ($DetailParameter as $dt) {
                    if ($dt["Pemakaian"] == 0) {
                        $errorMessage = "Pemakaian Bahan Item ";
                        $errorCount +=1;
                        goto jump;
                    }
                    $oItemMaster = ItemMaster::where('KodeItem', $dt['KodeItem'])
                                    ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                                    ->first();
    
                    $detail = new MenuRestoDetail();
                    $detail->Father = $KodeItemHasil;
                    $detail->KodeItemRM = $dt['KodeItem'];
                    $detail->QtyBahan = $dt["Pemakaian"];
                    $detail->HargaPokok = $oItemMaster->HargaPokokPenjualan;
                    $detail->Satuan = $dt["Satuan"];
                    $detail->RecordOwnerID = Auth::user()->RecordOwnerID;
                    $detail->save();
    
                    if (!$detail) {
                        $errorMessage = "Menyimpan data Bahan " . dt["NamaBahan"] . " Gagal dilakukan";
                        $errorCount +=1;
                        goto jump;
                    }
    
                    $HargaPokokStandar = $HargaPokokStandar + ($oItemMaster->HargaPokokPenjualan * $dt["Pemakaian"]);
                }
            }


            if ($DetailVariant) {
                foreach ($DetailVariant as $dt) {
                    $varian = new MenuRestoVariant();
                    $varian->Father = $KodeItemHasil;
                    $varian->VariantGrupID = $dt['variant_id'];
                    $varian->RecordOwnerID = Auth::user()->RecordOwnerID;
                    $varian->save();

                    if (!$varian) {
                        $errorMessage = "Menyimpan data Varian ".dt["NamaVariant"]." Gagal dilakukan";
                        $errorCount +=1;
                        goto jump;
                    }
                }
            }

            if ($DetailAddon) {
                foreach ($DetailAddon as $dt) {
                    $addon = new MenuRestoAddon();
                    $addon->Father = $KodeItemHasil;
                    $addon->AddonMenuID = $dt['AddonID'];
                    $addon->RecordOwnerID = Auth::user()->RecordOwnerID;
                    $addon->save();

                    if (!$addon) {
                        $errorMessage = "Menyimpan data Addon ".dt["NamaAddon"]." Gagal dilakukan";
                        $errorCount +=1;
                        goto jump;
                    }
                }
            }

            if ($HargaPokokStandar == 0) {
                // $errorMessage = "Harga Pokok Tidak Boleh Kosong, Silahkan cek masing masing harga pokok bahan baku";
                // $errorCount +=1;
                // goto jump;
                $oItemMaster = ItemMaster::where('KodeItem', $KodeItemHasil)
                                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                                ->first();

                                $update = DB::table('menuheader')
                                ->where('KodeItemHasil','=', $KodeItemHasil)
                                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                                ->update(
                                    [
                                        'HargaPokokStandar' => $oItemMaster->HargaPokokPenjualan,
                                    ]
                                );
            }
            else{
                $update = DB::table('menuheader')
                        ->where('KodeItemHasil','=', $KodeItemHasil)
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->update(
                            [
                                'HargaPokokStandar' => $oItemMaster->HargaPokokPenjualan,
                            ]
                        );
            }

            jump:
	        if ($errorCount > 0) {
		        DB::rollback();
                alert()->error('Error',$errorMessage);
		        // $data['success'] = false;
                return redirect()->back();
	        }
	        else{
		        DB::commit();
		        alert()->success('Success','Data Variant Berhasil disimpan.');
                return redirect('menu');
	        }
        } catch (\Exception $e) {
            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    function edit(Request $request) {
        $errorCount = 0;
        $errorMessage = "";

        try {
            DB::beginTransaction();

            $id = $request->input('id');
            $image_base64 = $request->input('image_base64');
            $KodeItemHasil = $request->input('KodeItemHasil');
            $HargaPokokStandar = $request->input('HargaPokokStandar');
            $HargaJual = $request->input('HargaJual');
            $DetailParameter = $request->input('DetailParameter');
            $DetailVariant = $request->input('DetailVariant');
            $DetailAddon = $request->input('DetailAddon');

            $oData = MenuRestoHeader::where('id', $id)
                        ->where('RecordOwnerID', Auth::user()->RecordOwnerID);

            if (!$oData) {
                $errorMessage = "Data Tidak Valid";
                $errorCount +=1;
                goto jump;
            }

            $update = DB::table('menuheader')
                        ->where('id','=', $id)
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->update(
                            [
                                'Gambar' => $image_base64,
                                'HargaPokokStandar' => $HargaPokokStandar,
                                'HargaJual' => $HargaJual,
                            ]
                        );

            
            // if (!$DetailParameter) {
            //     $errorMessage = "Data Bahan Menu tidak ada";
            //     $errorCount +=1;
            //     goto jump;
            // }

            $delete = DB::table('menudetail')
		                ->where('father','=', $KodeItemHasil)
		                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
		                ->delete();
            $HargaPokokStandar = 0;

            if ($DetailParameter) {
                foreach ($DetailParameter as $dt) {
                    if ($dt["Pemakaian"] == 0) {
                        $errorMessage = "Pemakaian Bahan Item ";
                        $errorCount +=1;
                        goto jump;
                    }
                    $oItemMaster = ItemMaster::where('KodeItem', $dt['KodeItem'])
                                    ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                                    ->first();
    
                    $detail = new MenuRestoDetail();
                    $detail->Father = $KodeItemHasil;
                    $detail->KodeItemRM = $dt['KodeItem'];
                    $detail->QtyBahan = $dt["Pemakaian"];
                    $detail->HargaPokok = $oItemMaster->HargaPokokPenjualan;
                    $detail->Satuan = $dt["Satuan"];
                    $detail->RecordOwnerID = Auth::user()->RecordOwnerID;
                    $detail->save();
    
                    if (!$detail) {
                        $errorMessage = "Menyimpan data Bahan " . dt["NamaBahan"] . " Gagal dilakukan";
                        $errorCount +=1;
                        goto jump;
                    }
    
                    $HargaPokokStandar = $HargaPokokStandar + ($oItemMaster->HargaPokokPenjualan * $dt["Pemakaian"]);
                }
            }

            if ($DetailVariant) {
                $delete = DB::table('menuvarian')
		                ->where('father','=', $KodeItemHasil)
		                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
		                ->delete();

                foreach ($DetailVariant as $dt) {
                    $varian = new MenuRestoVariant();
                    $varian->Father = $KodeItemHasil;
                    $varian->VariantGrupID = $dt['variant_id'];
                    $varian->RecordOwnerID = Auth::user()->RecordOwnerID;
                    $varian->save();

                    if (!$varian) {
                        $errorMessage = "Menyimpan data Varian ".dt["NamaVariant"]." Gagal dilakukan";
                        $errorCount +=1;
                        goto jump;
                    }
                }
            }

            if ($DetailAddon) {
                $delete = DB::table('addonmenudata')
		                ->where('father','=', $KodeItemHasil)
		                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
		                ->delete();

                foreach ($DetailAddon as $dt) {
                    $addon = new MenuRestoAddon();
                    $addon->Father = $KodeItemHasil;
                    $addon->AddonMenuID = $dt['AddonID'];
                    $addon->RecordOwnerID = Auth::user()->RecordOwnerID;
                    $addon->save();

                    if (!$addon) {
                        $errorMessage = "Menyimpan data Addon ".dt["NamaAddon"]." Gagal dilakukan";
                        $errorCount +=1;
                        goto jump;
                    }
                }
            }

            if ($HargaPokokStandar == 0) {
                $oItemMaster = ItemMaster::where('KodeItem', $KodeItemHasil)
                                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                                ->first();

                                $update = DB::table('menuheader')
                                ->where('KodeItemHasil','=', $KodeItemHasil)
                                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                                ->update(
                                    [
                                        'HargaPokokStandar' => $oItemMaster->HargaPokokPenjualan,
                                    ]
                                );
            }
            else{
                $update = DB::table('menuheader')
                        ->where('KodeItemHasil','=', $KodeItemHasil)
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->update(
                            [
                                'HargaPokokStandar' => $HargaPokokStandar,
                            ]
                        );
            }

            jump:
            if ($errorCount > 0) {
                DB::rollback();
                alert()->error('Error',$errorMessage);
                // $data['success'] = false;
                return redirect()->back();
            }
            else{
                DB::commit();
                alert()->success('Success','Data Menu Berhasil disimpan.');
                return redirect('menu');
            }
        } catch (\Exception $e) {
            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    function deletedata(Request $request) {
        $errorCount = 0;
        $errorMessage = "";

        try {
            DB::beginTransaction();

            $oHeader = MenuRestoHeader::where('KodeItemHasil', $request->KodeItemHasil)
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->get();
            $oDetail = MenuRestoDetail::where('Father', $request->KodeItemHasil)
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->get();
            $oVariant = MenuRestoVariant::where('Father', $request->KodeItemHasil)
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->get();
            $oAddon = MenuRestoAddon::where('Father', $request->KodeItemHasil)
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->get();

            if (count($oVariant) > 0) {
                $variant = DB::table('menuvarian')
                        ->where('Father','=', $request->KodeItemHasil)
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->delete();
                if (!$variant) {
                    $errorCount +=1;
                    $errorMessage = "Hapus Data Variant Menu Gagal";
                    goto jump;
                }
            }

            if (count($oAddon) > 0) {
                $variant = DB::table('addonmenudata')
                        ->where('Father','=', $request->KodeItemHasil)
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->delete();
                if (!$variant) {
                    $errorCount +=1;
                    $errorMessage = "Hapus Data Addon Menu Gagal";
                    goto jump;
                }
            }

            if (count($oDetail) > 0) {
                $detail = DB::table('menudetail')
                        ->where('Father','=', $request->KodeItemHasil)
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->delete();

                if (!$detail) {
                    $errorCount +=1;
                    $errorMessage = "Hapus Data Bahan Menu Gagal";
                    goto jump;
                }
            }

            if (count($oHeader) > 0) {
                $header = DB::table('menuheader')
                        ->where('KodeItemHasil','=', $request->KodeItemHasil)
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->delete();
                if (!$header) {
                    $errorCount +=1;
                    $errorMessage = "Hapus Data Menu Gagal";
                    goto jump;
                }
            }
            else{
                $errorCount +=1;
                $errorMessage = "Data Menu Tidak Valid";
                goto jump;
            }

            jump:
	        if ($errorCount > 0) {
		        DB::rollback();
                alert()->error('Error',$errorMessage);
		        // $data['success'] = false;
                return redirect()->back();
	        }
	        else{
		        DB::commit();
		        alert()->success('Success','Data Menu Berhasil dihapus.');
                return redirect('menu');
	        }
        } catch (\Exception $e) {
            alert()->error('Error',$e->getMessage());
        }
    }
}
