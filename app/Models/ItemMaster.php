<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class ItemMaster extends Model
{
    use HasFactory;
    protected $table = "itemmaster";


    public function GetItemData($RecordOwnerID,$KodeJenis, $Merk, $TipeItem,$TipeItemIN, $Active, $Scan, $ShowKonversi)
    {
    	$sql = "itemmaster.KodeItem, itemmaster.NamaItem, itemmaster.Barcode,itemmaster.HargaJual,itemmaster.HargaPokokPenjualan,itemmaster.HargaBeliTerakhir,itemmaster.Stock, itemmaster.StockMinimum, merk.NamaMerk, jenisitem.NamaJenis, gudang.NamaGudang, supplier.NamaSupplier, satuan.NamaSatuan, CASE WHEN itemmaster.TypeItem = 1 THEN 'Inventory' ELSE CASE WHEN itemmaster.TypeItem = 2 THEN 'Non. Inventory' ELSE CASE WHEN itemmaster.TypeItem = 3 THEN 'Rakitan' ELSE CASE WHEN itemmaster.TypeItem = 4 THEN 'Jasa' ELSE '' END END END END ItemType, itemmaster.Rak, 1 As QtyKonversi, itemmaster.Satuan ";
        $itemmaster = ItemMaster::selectRaw($sql)
                ->leftJoin('jenisitem', function ($value){
                  $value->on('jenisitem.KodeJenis','=','itemmaster.KodeJenisItem')
                  ->on('jenisitem.RecordOwnerID','=','itemmaster.RecordOwnerID');
                })
                ->leftJoin('merk', function ($value){
                  $value->on('merk.KodeMerk','=','itemmaster.KodeMerk')
                  ->on('merk.RecordOwnerID','=','itemmaster.RecordOwnerID');
                })
                ->leftJoin('gudang', function ($value){
                  $value->on('gudang.KodeGudang','=','itemmaster.KodeGudang')
                  ->on('gudang.RecordOwnerID','=','itemmaster.RecordOwnerID');
                })
                ->leftJoin('supplier', function ($value){
                  $value->on('supplier.KodeSupplier','=','itemmaster.KodeSupplier')
                  ->on('supplier.RecordOwnerID','=','itemmaster.RecordOwnerID');
                })
                ->leftJoin('satuan', function ($value){
                  $value->on('satuan.KodeSatuan','=','itemmaster.Satuan')
                  ->on('satuan.RecordOwnerID','=','itemmaster.RecordOwnerID');
                })
        				->where('itemmaster.RecordOwnerID','=',$RecordOwnerID);
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
       		$itemmaster->where(DB::raw("CONCAT(itemmaster.KodeItem,' ', itemmaster.NamaItem, ' ', itemmaster.Barcode,' ', COALESCE(merk.NamaMerk,''))"),'LIKE','%' . $Scan . '%');
       	}

        if ($ShowKonversi == 1) {
          // Union with item konversi

          $sql2 = "itemmaster.KodeItem, itemmaster.NamaItem, itemkonversi.Barcode,itemkonversi.HargaJual,itemkonversi.HargaPokok,itemmaster.HargaBeliTerakhir,itemmaster.Stock, itemmaster.StockMinimum, merk.NamaMerk, jenisitem.NamaJenis, gudang.NamaGudang, supplier.NamaSupplier, satuan.NamaSatuan, CASE WHEN itemmaster.TypeItem = 1 THEN 'Inventory' ELSE CASE WHEN itemmaster.TypeItem = 2 THEN 'Non. Inventory' ELSE CASE WHEN itemmaster.TypeItem = 3 THEN 'Rakitan' ELSE CASE WHEN itemmaster.TypeItem = 4 THEN 'Jasa' ELSE '' END END END END ItemType, itemmaster.Rak,CASE WHEN COALESCE(itemkonversi.QtyKonversi,0) = 0 then 1 else COALESCE(itemkonversi.QtyKonversi,0) end QtyKonversi,itemkonversi.Satuan  ";
          $itemmaster2 = ItemMaster::selectRaw($sql2)
                  ->leftJoin('jenisitem', function ($value){
                    $value->on('jenisitem.KodeJenis','=','itemmaster.KodeJenisItem')
                    ->on('jenisitem.RecordOwnerID','=','itemmaster.RecordOwnerID');
                  })
                  ->leftJoin('merk', function ($value){
                    $value->on('merk.KodeMerk','=','itemmaster.KodeMerk')
                    ->on('merk.RecordOwnerID','=','itemmaster.RecordOwnerID');
                  })
                  ->leftJoin('gudang', function ($value){
                    $value->on('gudang.KodeGudang','=','itemmaster.KodeGudang')
                    ->on('gudang.RecordOwnerID','=','itemmaster.RecordOwnerID');
                  })
                  ->leftJoin('supplier', function ($value){
                    $value->on('supplier.KodeSupplier','=','itemmaster.KodeSupplier')
                    ->on('supplier.RecordOwnerID','=','itemmaster.RecordOwnerID');
                  })
                  ->leftJoin('satuan', function ($value){
                    $value->on('satuan.KodeSatuan','=','itemmaster.Satuan')
                    ->on('satuan.RecordOwnerID','=','itemmaster.RecordOwnerID');
                  })
                  ->Join('itemkonversi', function ($value){
                    $value->on('itemkonversi.KodeItem','=','itemmaster.KodeItem')
                    ->on('itemkonversi.RecordOwnerID','=','itemmaster.RecordOwnerID');
                  })
                  ->where('itemmaster.RecordOwnerID','=',$RecordOwnerID);
          if ($KodeJenis != "") {
            $itemmaster2->where('itemmaster.KodeJenisItem','=', $KodeJenis);
          }

          if ($Merk != "") {
            $itemmaster2->where('itemmaster.KodeMerk','=', $Merk);
          }

          if ($TipeItem != "") {
            $itemmaster2->where('itemmaster.TypeItem','=', $TipeItem);
          }

          if ($TipeItemIN != "") {
            $itemmaster2->whereIn('itemmaster.TypeItem',explode(',', $TipeItemIN));
          }

          if ($Active != "") {
            $itemmaster2->where('itemmaster.Active','=', $Active);
          }

          if ($Scan != "") {
            $itemmaster2->where(DB::raw("CONCAT(itemmaster.KodeItem,' ', itemmaster.NamaItem, ' ', itemkonversi.Barcode,' ', COALESCE(merk.NamaMerk,''))"),'LIKE','%' . $Scan . '%');
          }

          $itemmaster->union($itemmaster2);
        }

       	return $itemmaster;
    }

    
}
