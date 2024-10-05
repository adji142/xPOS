<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

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


    public function TableServices(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => 0);
		DB::beginTransaction();

		$errorCount = 0;

		$jsonData = $request->json()->all();
		// var_dump($jsonData['KodePelanggan']);
		$oCompany = Company::where('KodePartner','=',$jsonData['RecordOwnerID'])->first();

		$oKembalian = 0;
		try {

			if ($jsonData['KodePelanggan'] == "") {
				$data['message'] = "Pelanggan Tidak boleh kosong";
				$errorCount +=1;
				goto jump;
			}
			
			$currentDate = Carbon::now();
			$Year = $currentDate->format('Y');
			$Month = $currentDate->format('m');

			$numberingData = new DocumentNumbering();
			$NoTransaksi = $numberingData->GetNewDocMobile("POS","fakturpenjualanheader","NoTransaksi", $jsonData['RecordOwnerID']);
			$HargaPokokPenjualan = 0;

	        $data['LastTRX'] = $NoTransaksi;
	        $model = new FakturPenjualanHeader;

	        $model->Periode = $Year.$Month;
	        $model->NoTransaksi= $NoTransaksi;
	        $model->Transaksi= 'POS';
	        $model->TglTransaksi = $jsonData['TglTransaksi'];
			$model->TglJatuhTempo = $jsonData['TglJatuhTempo'];
			$model->NoReff = $jsonData['NoReff'];
			$model->KodePelanggan = $jsonData['KodePelanggan'];
			$model->KodeTermin = empty($jsonData['KodeTermin']) ? "" : $jsonData['KodeTermin'];
			$model->Termin = $jsonData['Termin'];
			$model->TotalTransaksi = $jsonData['TotalTransaksi'];
			$model->Potongan = $jsonData['Potongan'];
			$model->Pajak = $jsonData['Pajak'];
			$model->TotalPembelian = $jsonData['TotalPembelian'];
			$model->TotalRetur = $jsonData['TotalRetur'];
			$model->TotalPembayaran = $jsonData['TotalPembayaran'];
			$model->Pembulatan = $jsonData['Pembulatan'];
			$model->Status = $jsonData['Status'];
			$model->Keterangan = $jsonData['Keterangan'];
			$model->MetodeBayar = $jsonData['MetodeBayar'];
			$model->ReffPembayaran = $jsonData['ReffPembayaran'];
			$model->KodeSales = $jsonData['KodeSales'];
			$model->Posted = 0;
			$model->TipeOrder = $jsonData['JenisOrder'];
			$model->NomorMeja = $jsonData['KodeMeja'];
			$model->CreatedBy = $jsonData['DeviceID'];
			$model->UpdatedBy = "";
            $model->RecordOwnerID = $jsonData['RecordOwnerID'];
   
			$save = $model->save();


			$oKembalian = floatval($jsonData['TotalPembayaran']) - floatval($jsonData['TotalPembelian']);
			$data['Kembalian'] = $oKembalian;
			foreach ($jsonData['Detail'] as $key) {
				if ($key['Qty'] == 0) {
					goto skip;
				}

				if ($oCompany) {
					if ($oCompany->AllowNegativeInventory == NULL || $oCompany->AllowNegativeInventory == 'N') {
						$oItem = ItemMaster::where('RecordOwnerID',$jsonData['RecordOwnerID'])
									->where('KodeItem',$key['KodeItem'])
									->where('Stock','>',0)
									->get();

						if (count($oItem) == 0) {
							$data['message'] = "Stock Item ".$key['KodeItem'].' Tidak Cukup';
							$errorCount += 1;
							goto jump;		
						}
					}
				}
				else{
					$data['message'] = "Partner Tidak ditemukan";
					$errorCount += 1;
					goto jump;
				}

				$oItemMaster = ItemMaster::where('RecordOwnerID', $jsonData['RecordOwnerID'])
								->where('itemmaster.KodeItem', $key['KodeItem'])
								->first();

				$modelDetail = new FakturPenjualanDetail;
           		$modelDetail->NoTransaksi = $NoTransaksi;
				$modelDetail->NoUrut = $key['NoUrut'];
				$modelDetail->KodeItem = $key['KodeItem'];
				$modelDetail->Qty = $key['Qty'];
				$modelDetail->QtyKonversi = $key['QtyKonversi'];
				$modelDetail->QtyRetur = 0;
				$modelDetail->Satuan = $oItemMaster->Satuan;
				$modelDetail->Harga = $key['Harga'];
				$modelDetail->Discount = $key['Discount'];

				$modelDetail->BaseReff = $key['BaseReff'];
				$modelDetail->BaseLine = $key['BaseLine'];
				$modelDetail->KodeGudang = $oCompany->GudangPoS;

				$HargaGros = $key['Qty'] * $key['Harga'];
				$modelDetail->HargaNet = $HargaGros - floatval($key['Discount']);
				$modelDetail->LineStatus = $key['LineStatus'];
				$modelDetail->VatPercent = $key['VatPercent'];
				$modelDetail->HargaPokokPenjualan = $oItemMaster->HargaPokokPenjualan;
				$modelDetail->RecordOwnerID = $jsonData['RecordOwnerID'];

				$save = $modelDetail->save();

				if (!$save) {
					$data['message'] = "Gagal Menyimpan Data Detail di Row ".$key->NoUrut;
					$errorCount += 1;
					goto jump;
				}
				skip:
			}

			$totalVariant = 0;
			foreach ($jsonData['Variant'] as $key) {
				$modelvariant = new FakturPenjualanVariant;
           		$modelvariant->NoTransaksi = $NoTransaksi;
				$modelvariant->KodeItem = $key['KodeItem'];
				$modelvariant->NoUrut = $key['NoUrut'];
				$modelvariant->VariantGrupID = $key['VariantGrupID'];
				$modelvariant->VariantID = $key['VariantID'];
				$modelvariant->AddonMenuID = $key['AddonMenuID'];
				$modelvariant->NamaGroupVariant = $key['NamaGroupVariant'];
				$modelvariant->NamaVariant = $key['NamaVariant'];
				$modelvariant->ExtraQty = $key['ExtraQty'];
				$modelvariant->ExtraPrice = $key['ExtraPrice'];
				$modelvariant->RecordOwnerID = $jsonData['RecordOwnerID'];;

				$save = $modelvariant->save();

				if (!$save) {
					$data['message'] = "Gagal Menyimpan Data Variant di Row ".$key->NoUrut;
					$errorCount += 1;
					goto jump;
				}
				$totalVariant += $key['ExtraQty'] * $key['ExtraPrice'];
			}

			if ($totalVariant > 0) {
				$UpdateFaktur = DB::table('fakturpenjualanheader')
                			->where('NoTransaksi','=', $NoTransaksi)
                            ->where('RecordOwnerID','=',$jsonData['RecordOwnerID'])
                			->update(
                				[
									'TotalTransaksi' => $jsonData['TotalTransaksi'] + $totalVariant,
                				]
                			);
			}

			// Append Pembayaran
			if($jsonData['TotalPembayaran'] > 0){
				// Header
				$modelBayar = new PembayaranPenjualanHeader;
	           	
				$numberingDataBayar = new DocumentNumbering();
				$NoTransaksiBayar = $numberingDataBayar->GetNewDoc("INPAY","pembayaranpenjualanheader","NoTransaksi");

				$modelBayar->Periode = $Year.$Month;
				$modelBayar->NoTransaksi = $NoTransaksiBayar;
				$modelBayar->TglTransaksi = $jsonData['TglTransaksi'];
				$modelBayar->KodePelanggan = $jsonData['KodePelanggan'];
				$modelBayar->TotalPembelian = $jsonData['TotalPembelian'];
				$modelBayar->TotalPembayaran = $jsonData['TotalPembayaran'];
				$modelBayar->KodeMetodePembayaran = $jsonData['MetodeBayar'];
				$modelBayar->NoReff = $jsonData['ReffPembayaran'];
				$modelBayar->Keterangan = $jsonData['Keterangan'];
				$modelBayar->RecordOwnerID = $jsonData['RecordOwnerID'];
				$modelBayar->CreatedBy = $jsonData['DeviceID'];
				$modelBayar->UpdatedBy = "";
				$modelBayar->Posted = 0;
				$modelBayar->Status = $jsonData['Status'];

				$saveBayar = $modelBayar->save();

				if (!$saveBayar) {
					$data['message'] = "Gagal Menyimpan Data Pembayaran Penjualan";
					$errorCount += 1;
					goto jump;
				}
				// Detail
				$modelDetailBayar = new PembayaranPenjualanDetail;
				$modelDetailBayar->NoTransaksi = $NoTransaksiBayar;
				$modelDetailBayar->NoUrut = 0;
				$modelDetailBayar->BaseReff = $NoTransaksi;
				$modelDetailBayar->TotalPembayaran = $jsonData['TotalPembayaran'];
				$modelDetailBayar->RecordOwnerID = $jsonData['RecordOwnerID'];
				$modelDetailBayar->KodeMetodePembayaran = $jsonData['MetodeBayar'];
				$modelDetailBayar->Keterangan = $jsonData['Keterangan'];

				$saveBayar = $modelDetailBayar->save();
				if (!$saveBayar) {
					$data['message'] = "Gagal Menyimpan Data Detail di Row ".$key->NoUrut;
					$errorCount += 1;
					goto jump;
				}
			}
			jump:
	        if ($errorCount > 0) {
		        DB::rollback();
		        $data['success'] = false;
	        }
	        else{
		        DB::commit();
		        $data['success'] = true;
	        }

		} catch (\Exception $e) {
            // $stackTrace = $e->getTrace();
	        $data['message'] = $e->getMessage()." > ". $e->getTraceAsString();
		}

		return response()->json($data);
	}
}
