<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\ItemMaster;
use App\Models\JenisItem;
use App\Models\Merk;
use App\Models\Gudang;
use App\Models\Supplier;
use App\Models\Rekening;
use App\Models\Satuan;
use App\Models\SettingAccount;
use App\Models\ItemRakitan;
use App\Models\Diskon;

class ItemMasterController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeJenis','NamaJenis'];
        $keyword = $request->input('keyword');
        $KodeJenis = $request->input('KodeJenis');
        $Merk = $request->input('Merk');
        $TipeItem = $request->input('TipeItem');
        $TipeItemIN = $request->input('TipeItemIN');
        $Active = $request->input('Active');

        $sql = "itemmaster.KodeItem, itemmaster.NamaItem, itemmaster.Barcode,itemmaster.HargaJual,itemmaster.HargaPokokPenjualan,itemmaster.HargaBeliTerakhir,itemmaster.Stock, itemmaster.StockMinimum, merk.NamaMerk, jenisitem.NamaJenis, gudang.NamaGudang, supplier.NamaSupplier, satuan.NamaSatuan, CASE WHEN itemmaster.TypeItem = 1 THEN 'Inventory' ELSE CASE WHEN itemmaster.TypeItem = 2 THEN 'Non. Inventory' ELSE CASE WHEN itemmaster.TypeItem = 3 THEN 'Rakitan' ELSE CASE WHEN itemmaster.TypeItem = 4 THEN 'Jasa' ELSE '' END END END END ItemType, itemmaster.Rak ";
        $itemmaster = ItemMaster::selectRaw($sql)
        				->leftJoin('jenisitem', 'jenisitem.KodeJenis','=','itemmaster.KodeJenisItem')
        				->leftJoin('merk','merk.KodeMerk','=','itemmaster.KodeMerk')
        				->leftJoin('gudang', 'gudang.KodeGudang','=','itemmaster.KodeGudang')
        				->leftJoin('supplier','supplier.KodeSupplier','=','itemmaster.KodeSupplier')
        				->leftJoin('satuan', 'satuan.KodeSatuan','=','itemmaster.Satuan')
        				->where('itemmaster.RecordOwnerID','=',Auth::user()->RecordOwnerID);
       	if ($KodeJenis != "") {
       		$itemmaster->where('itemmaster.KodeJenisItem','=', $KodeJenis);
       	}

       	if ($Merk != "") {
       		$itemmaster->where('itemmaster.KodeMerk','=', $Merk);
       	}

       	if ($TipeItem != "") {
       		$itemmaster->where('itemmaster.TypeItem','=', $TipeItem);
       	}

        if ($TipeItemIN != "") {
          $itemmaster->whereIn('itemmaster.TypeItem',explode(',', $TipeItemIN));
        }

       	if ($Active != "") {
       		$itemmaster->where('itemmaster.Active','=', $Active);
       	}

       	// JenisItem
       	$jenisitem = JenisItem::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
       	$merk = Merk::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();



        $title = 'Delete Grup Pelanggan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.ItemMasterData.ItemMaster",[
            'itemmaster' => $itemmaster->get(),
            'jenisitem' => $jenisitem,
            'merk' => $merk,
            'oldKodeJenis' => $KodeJenis,
            'oldMerk' => $Merk,
            'odlTipeItem' => $TipeItem,
            'oldActive' => $Active
        ]);
    }

    public function ViewJson(Request $request)
    {
      $data = array('success'=>false, 'message'=>'', 'data'=>array());
      $KodeJenis = $request->input('KodeJenis');
      $Merk = $request->input('Merk');
      $TipeItem = $request->input('TipeItem');
      $Active = $request->input('Active');
      $Scan = $request->input('Scan');
      $TipeItemIN = $request->input('TipeItemIN');

      $sql = "itemmaster.KodeItem, itemmaster.NamaItem, itemmaster.Barcode,itemmaster.HargaJual,itemmaster.HargaPokokPenjualan,itemmaster.HargaBeliTerakhir,itemmaster.Stock, itemmaster.StockMinimum, merk.NamaMerk, jenisitem.NamaJenis, gudang.NamaGudang, supplier.NamaSupplier, satuan.NamaSatuan, CASE WHEN itemmaster.TypeItem = 1 THEN 'Inventory' ELSE CASE WHEN itemmaster.TypeItem = 2 THEN 'Non. Inventory' ELSE CASE WHEN itemmaster.TypeItem = 3 THEN 'Rakitan' ELSE CASE WHEN itemmaster.TypeItem = 4 THEN 'Jasa' ELSE '' END END END END ItemType, itemmaster.Rak, COALESCE(itemmaster.HargaJual,0) - COALESCE(itemmaster.HargaBeliTerakhir, 0) Margin, itemmaster.Satuan ";
      $itemmaster = ItemMaster::selectRaw($sql)
              ->leftJoin('jenisitem', 'jenisitem.KodeJenis','=','itemmaster.KodeJenisItem')
              ->leftJoin('merk','merk.KodeMerk','=','itemmaster.KodeMerk')
              ->leftJoin('gudang', 'gudang.KodeGudang','=','itemmaster.KodeGudang')
              ->leftJoin('supplier','supplier.KodeSupplier','=','itemmaster.KodeSupplier')
              ->leftJoin('satuan', 'satuan.KodeSatuan','=','itemmaster.Satuan')
              ->where('itemmaster.RecordOwnerID','=',Auth::user()->RecordOwnerID);
      if ($KodeJenis != "") {
        $itemmaster->where('itemmaster.KodeJenisItem','=', $KodeJenis);
      }

      if ($Merk != "") {
        $itemmaster->where('itemmaster.KodeMerk','=', $Merk);
      }

      if ($TipeItem != "") {
        $itemmaster->where('itemmaster.TypeItem','=', $TipeItem);
      }

      if ($TipeItemIN != "") {
        $itemmaster->whereIn('itemmaster.TypeItem',explode(',', $TipeItemIN));
      }
        
      if ($Active != "") {
        $itemmaster->where('itemmaster.Active','=', $Active);
      }

      if ($Scan != "") {
        $itemmaster->where(DB::raw("CONCAT(itemmaster.KodeItem,' ', itemmaster.NamaItem, ' ', itemmaster.Barcode,' ', merk.NamaMerk)"),'LIKE','%' . $Scan . '%');
      }

      $data['data'] = $itemmaster->get();

      return response()->json($data);
    }

    public function Form($KodeItem = null)
    {
    	$itemmaster = ItemMaster::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
    					->where('KodeItem', '=', $KodeItem)->get();
    	$jenisitem = JenisItem::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
     	$merk = Merk::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
     	$rekening = Rekening::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
      $satuan = Satuan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
      $gudang = Gudang::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
      $rekeninghpp = Rekening::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                      ->where('KodeKelompok','=', 5)
                      ->where('Jenis','=',2)
                      ->get();
      $rekeningpenjualan = Rekening::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                      ->where('KodeKelompok','=', 4)
                      ->where('Jenis','=',2)
                      ->get();

      $rekeninginventory = Rekening::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                      ->where('KodeKelompok','=', 1)
                      ->where('Jenis','=',2)
                      ->get();

      $settingaccount = SettingAccount::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
      $supplier = Supplier::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                  ->where('Status','=',1)->get();

      $itemmasterbahanrakitan = ItemMaster::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                                ->where('TypeItem', "<>", 3)->get();

      $bahanrakitan = ItemRakitan::where('RecordOwnerID','=', Auth::user()->RecordOwnerID)
                      ->where('KodeItemHasil','=', $KodeItem)->get();
      $diskon = Diskon::where('RecordOwnerID','=', Auth::user()->RecordOwnerID)
                      ->where('KodeItem','=', $KodeItem)->get();
        
        return view("master.ItemMasterData.ItemMaster-Input",[
        	'itemmaster' => $itemmaster,
          'jenisitem' => $jenisitem,
          'merk' => $merk,
          'rekening' => $rekening,
          'satuan'=> $satuan,
          'gudang'=>$gudang,
          'rekeninghpp' => $rekeninghpp,
          'rekeningpenjualan' => $rekeningpenjualan,
          'rekeninginventory' => $rekeninginventory,
          'settingaccount' => $settingaccount,
          'supplier' => $supplier,
          'itembahanrakitan' => $itemmasterbahanrakitan,
          'bahanrakitan' => $bahanrakitan,
          'diskon' => $diskon
        ]);
    }


    public function store(Request $request)
    {

      $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

      Log::debug($request->all());
      DB::beginTransaction();

      $jsonData = $request->json()->all();
      $errorCount = 0;
      try {

          $model = new ItemMaster;

          $model->KodeItem = $jsonData['KodeItem'];
          $model->NamaItem = $jsonData['NamaItem'];
          $model->KodeJenisItem = $jsonData['KodeJenisItem'];
          $model->KodeMerk = $jsonData['KodeMerk'];
          $model->TypeItem = $jsonData['TypeItem'];
          $model->Rak = $jsonData['Rak'];
          $model->KodeGudang = $jsonData['KodeGudang'];
          $model->KodeSupplier = $jsonData['KodeSupplier'];
          $model->Satuan = $jsonData['Satuan'];
          $model->Barcode = $jsonData['Barcode'];
          $model->Gambar = "";
          $model->HargaPokokPenjualan = $jsonData['HargaPokokPenjualan'];
          $model->HargaJual = $jsonData['HargaJual'];
          $model->HargaBeliTerakhir = $jsonData['HargaBeliTerakhir'];
          $model->Stock = $jsonData['Stock'];
          $model->StockMinimum = $jsonData['StockMinimum'];
          $model->isKonsinyasi = 0;
          $model->Active = 'Y';
          $model->AcctHPP = empty($jsonData['AcctHPP']) ? "" : $jsonData['AcctHPP'];
          $model->AcctPenjualan = empty($jsonData['AcctPenjualan']) ? "" : $jsonData['AcctPenjualan'];
          $model->AcctPenjualanJasa = empty($jsonData['AcctPenjualanJasa']) ? "" : $jsonData['AcctPenjualanJasa'];
          $model->AcctPersediaan = empty($jsonData['AcctPersediaan']) ? "" : $jsonData['AcctPersediaan'];
          $model->Gambar = $jsonData['Gambar'];
          $model->RecordOwnerID = Auth::user()->RecordOwnerID;

          $save = $model->save();

          if ($save) {

            if (count($jsonData['BahanRakitan']) > 0) {
              for ($i=0; $i < count($jsonData['BahanRakitan']) ; $i++) { 
                $modelRakitan = new ItemRakitan;
                $modelRakitan->KodeItemHasil = $jsonData['BahanRakitan'][$i]['KodeItemHasil'];
                $modelRakitan->QtyHasil = $jsonData['BahanRakitan'][$i]['QtyHasil'];
                $modelRakitan->KodeItemBahan = $jsonData['BahanRakitan'][$i]['KodeItemBahan'];
                $modelRakitan->Satuan = $jsonData['BahanRakitan'][$i]['Satuan'];
                $modelRakitan->QtyBahan = $jsonData['BahanRakitan'][$i]['QtyBahan'];
                $modelRakitan->RecordOwnerID = Auth::user()->RecordOwnerID;

                $saveRakitan = $modelRakitan->save();

                if (!$saveRakitan) {
                  $data['message'] = 'Simpan Data Rakitan Baris $i Gagal disimpan';
                  $errorCount +=1;
                  goto jump;
                }

              }
            }

            if (count($jsonData['DiskonSetting']) > 0) {
              for ($i=0; $i < count($jsonData['DiskonSetting']) ; $i++) { 
                $modelDiskon = new Diskon;
                $modelDiskon->KodeItem = $jsonData['KodeItem'];
                $modelDiskon->Minimal = $jsonData['DiskonSetting'][$i]['Minimal'];
                $modelDiskon->Kelipatan = 0;
                $modelDiskon->TipeDiskon = $jsonData['DiskonSetting'][$i]['TipeDiskon'];
                $modelDiskon->Diskon = $jsonData['DiskonSetting'][$i]['Diskon'];
                $modelDiskon->RecordOwnerID = $jsonData['DiskonSetting'][$i]['RecordOwnerID'];

                $saveDiskon = $modelDiskon->save();

                if (!$saveDiskon) {
                  $data['message'] = 'Simpan Data Diskon Baris $i Gagal disimpan';
                  $errorCount +=1;
                  goto jump;
                }
              }
            }
            $data['success'] = true;
              // alert()->success('Success','Data Item Berhasil disimpan.');
              // return redirect('itemmaster');
              
          }else{
            $data['message'] = 'Penambahan Data Item Gagal';
              // throw new \Exception('Penambahan Data Item Gagal');
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
          Log::debug($e->getMessage());
          $data['message'] = 'Penambahan Data Item Gagal '. $e->getMessage();
          // alert()->error('Error',$e->getMessage());
          // return redirect()->back();
      }

      return response()->json($data);
    }

    public function edit(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        Log::debug($request->all());
        DB::beginTransaction();

        $jsonData = $request->json()->all();
        $errorCount = 0;
        try {
            // $this->validate($request, [
            //     'KodeGudang'=>'required',
            //     'NamaGudang'=>'required'
            // ]);

            $model = ItemMaster::where('KodeItem','=',$request->input('KodeGudang'))
                      ->where('RecordOwnerID','=', Auth::user()->RecordOwnerID);

            if ($model) {
              // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
              $update = DB::table('itemmaster')
                    ->where('KodeItem','=', $request->input('KodeItem'))
                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->update(
                      [
                        'NamaItem' => $jsonData['NamaItem'],
                        'KodeJenisItem' => $jsonData['KodeJenisItem'],
                        'KodeMerk' => $jsonData['KodeMerk'],
                        'TypeItem' => $jsonData['TypeItem'],
                        'Rak' => $jsonData['Rak'],
                        'KodeGudang' => $jsonData['KodeGudang'],
                        'KodeSupplier' => $jsonData['KodeSupplier'],
                        'Satuan' => $jsonData['Satuan'],
                        'Barcode' => $jsonData['Barcode'],
                        'Gambar' => "",
                        'HargaPokokPenjualan' => $jsonData['HargaPokokPenjualan'],
                        'HargaJual' => $jsonData['HargaJual'],
                        'HargaBeliTerakhir' => $jsonData['HargaBeliTerakhir'],
                        'Stock' => $jsonData['Stock'],
                        'StockMinimum' => $jsonData['StockMinimum'],
                        'isKonsinyasi' => 0,
                        'Active' => 1,
                        'AcctHPP' => empty($jsonData['AcctHPP']) ? "" :$jsonData['AcctHPP'],
                        'AcctPenjualan' => empty($jsonData['AcctPenjualan']) ? "" : $jsonData['AcctPenjualan'],
                        'AcctPenjualanJasa' => empty($jsonData['AcctPenjualanJasa']) ? "" : $jsonData['AcctPenjualanJasa'],
                        'AcctPersediaan' => empty($jsonData['AcctPersediaan']) ? "" : $jsonData['AcctPersediaan'],
                        'Gambar' => $jsonData['Gambar']
                      ]
                    );

                if (count($jsonData['BahanRakitan']) > 0) {
                  $itemRakitan = DB::table('itemrakitan')
                            ->where('KodeItemHasil','=',  $jsonData['KodeItem'])
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->delete();
                  for ($i=0; $i < count($jsonData['BahanRakitan']) ; $i++) { 

                    $modelRakitan = new ItemRakitan;
                    $modelRakitan->KodeItemHasil = $jsonData['BahanRakitan'][$i]['KodeItemHasil'];
                    $modelRakitan->QtyHasil = $jsonData['BahanRakitan'][$i]['QtyHasil'];
                    $modelRakitan->KodeItemBahan = $jsonData['BahanRakitan'][$i]['KodeItemBahan'];
                    $modelRakitan->Satuan = $jsonData['BahanRakitan'][$i]['Satuan'];
                    $modelRakitan->QtyBahan = $jsonData['BahanRakitan'][$i]['QtyBahan'];
                    $modelRakitan->RecordOwnerID = Auth::user()->RecordOwnerID;

                    $saveRakitan = $modelRakitan->save();

                    if (!$saveRakitan) {
                      $data['message'] = 'Simpan Data Rakitan Baris $i Gagal disimpan';
                      $errorCount +=1;
                      goto jump;
                    }
                  }
                }

                if (count($jsonData['DiskonSetting']) > 0) {
                  $diskon = DB::table('diskon')
                            ->where('KodeItem','=',  $jsonData['KodeItem'])
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->delete();
                  for ($i=0; $i < count($jsonData['DiskonSetting']) ; $i++) { 
                    $modelDiskon = new Diskon;
                    $modelDiskon->KodeItem = $jsonData['KodeItem'];
                    $modelDiskon->Minimal = $jsonData['DiskonSetting'][$i]['QtyMinimum'];
                    $modelDiskon->Kelipatan = 0;
                    $modelDiskon->TipeDiskon = $jsonData['DiskonSetting'][$i]['TipeDiskon'];
                    $modelDiskon->Diskon = $jsonData['DiskonSetting'][$i]['Diskon'];
                    $modelDiskon->RecordOwnerID = Auth::user()->RecordOwnerID;

                    $saveDiskon = $modelDiskon->save();

                    if (!$saveDiskon) {
                      $data['message'] = 'Simpan Data Diskon Baris $i Gagal disimpan';
                      $errorCount +=1;
                      goto jump;
                    }
                  }
                }
                $data['success'] =  true;
            } else{
                // throw new \Exception('Item not found.');
              $data['message'] = "Item not found";
              $errorCount +=1;
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
            Log::debug($e->getMessage());

             $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function deletedata(Request $request)
    {
      try {
        $gudang = DB::table('gudang')
                  ->where('KodeGudang','=', $request->id)
                  ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                  ->delete();

          if ($gudang) {
            alert()->success('Success','Delete Gudang berhasil.');
          }
          else{
            alert()->error('Error','Delete Gudang Gagal.');
          }
          return redirect('gudang');
      } catch (Exception $e) {
        Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
      }
    }
}
