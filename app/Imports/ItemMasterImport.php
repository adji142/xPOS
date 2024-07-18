<?php

namespace App\Imports;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\ItemMaster;
use App\Models\Merk;
use App\Models\Gudang;
use App\Models\Supplier;
use App\Models\Satuan;
use App\Models\JenisItem;
use App\Models\DocumentNumbering;
use App\Models\PengakuanBarangHeader;
use App\Models\PengakuanBarangDetail;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemMasterImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // var_dump($row);
        $item = ItemMaster::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                                ->where('KodeItem', $row['kodeitem'])
                                ->first();
        if ($item) {
            session()->flash('error', 'Item ' . $row['kodeitem'] . ' Sudah Terdaftar');
            return null;
        }

        $itembarcode = ItemMaster::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                                ->where('Barcode', $row['barcode'])
                                ->first();
        if ($itembarcode) {
            session()->flash('error', 'Barcode ' . $row['barcode'] . ' Sudah Terdaftar');
            return null;
        }

        // JenisItem
        $jenisitem = JenisItem::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('KodeJenis', $row['kodejenisitem'])
                    ->first();
                    
        if (!$jenisitem) {
            session()->flash('error', 'Kode Jenis Item ' . $row['kodejenisitem'] . ' Tidak ada, Silahkan Masukan terlebih dahulu Melalui Master -> Item Master-> Jenis Item');
            return null;
        }

        // Merk
        $merk = Merk::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('KodeMerk', $row['merk'])
                    ->first();
                    
        if (!$merk) {
            session()->flash('error', 'Kode Merek ' . $row['merk'] . ' Tidak ada, Silahkan Masukan terlebih dahulu Melalui Master -> Item Master-> Merk');
            return null;
        }

        // Gudang
        $gudang = Gudang::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('KodeGudang', $row['kodegudang'])
                    ->first();
        if (!$gudang) {
            session()->flash('error', 'Kode Gudang ' . $row['kodegudang'] . ' Tidak ada, Silahkan Masukan terlebih dahulu Melalui Master -> Item Master -> Gudang Penyimpanan');
            return null;
        }

        // Supplier
        $supplier = Supplier::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('KodeSupplier', $row['kodesupplier'])
                    ->first();
        if (!$supplier) {
            session()->flash('error', 'Kode Supplier ' . $row['kodesupplier'] . ' Tidak ada, Silahkan Masukan terlebih dahulu Melalui Master -> Business Partner -> Supplier');
            return null;
        }

        // Satuan
        $satuan = Satuan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('KodeSatuan', $row['satuan'])
                    ->first();
        if (!$satuan) {
            session()->flash('error', 'Kode Satuan ' . $row['satuan'] . ' Tidak ada, Silahkan Masukan terlebih dahulu Melalui Master -> Item Master -> Satuan');
            return null;
        }

        $item = ItemMaster::create([
            'KodeItem'=>$row['kodeitem'],
            'NamaItem'=>$row['namaitem'],
            'KodeJenisItem'=>$row['kodejenisitem'],
            'KodeMerk'=>$row['merk'],
            'TypeItem'=>$row['typeitem'],
            'Rak'=>$row['rak'],
            'KodeGudang'=>$row['kodegudang'],
            'KodeSupplier'=>$row['kodesupplier'],
            'Satuan'=>$row['satuan'],
            'Barcode'=>$row['barcode'],
            'Gambar'=>'',
            'HargaPokokPenjualan'=>$row['hargapokokpenjualan'],
            'HargaJual'=>$row['hargajual'],
            'HargaBeliTerakhir'=>$row['hargabeliterakhir'],
            'Stock'=>0,
            'StockMinimum'=>$row['stockminimum'],
            'isKonsinyasi'=>$row['iskonsinyasi'],
            'Active'=>$row['active'],
            'AcctHPP'=>$row['accthpp'],
            'AcctPenjualan'=>$row['acctpenjualan'],
            'AcctPenjualanJasa'=>$row['acctpenjualanjasa'],
            'AcctPersediaan'=>$row['acctpersediaan'],
            'VatPercent'=>$row['vatpercent'],
            'RecordOwnerID'=>Auth::user()->RecordOwnerID
        ]);

        if ($row['stock'] > 0) {
            $currentDate = Carbon::now();
			$Year = $currentDate->format('y');
			$Month = $currentDate->format('m');

            $model = new PengakuanBarangHeader;
           	
           	$numberingData = new DocumentNumbering();
           	$NoTransaksi = $numberingData->GetNewDoc("GR","pengakuanbarangheader","NoTransaksi");

            PengakuanBarangHeader::create([
                'Periode'=>$Year.$Month,
                'NoTransaksi'=>$NoTransaksi,
                'TglTransaksi'=>Carbon::now(),
                'NoReff'=>"IMPORT",
                'Keterangan'=>'Import Dari Excel',
                'Status'=>'O',
                'TotalTransaksi'=>0,
                'CreatedBy'=>Auth::user()->name,
                'UpdatedBy'=>'',
                'Posted'=>0,
                'RecordOwnerID'=>Auth::user()->RecordOwnerID

            ]);

            PengakuanBarangDetail::create([
                'NoTransaksi'=>$NoTransaksi,
                'NoUrut'=> 0,
                'KodeItem'=>$row['kodeitem'],
                'Qty'=>$row['stock'],
                'Satuan'=>$row['satuan'],
                'Harga'=>$row['hargapokokpenjualan'],
                'TotalTransaksi'=>$row['stock'] * $row['hargapokokpenjualan'],
                'KodeGudang'=>$row['kodegudang'],
                'KodeRekening'=>$row['acctpersediaan'],
                'RecordOwnerID'=>Auth::user()->RecordOwnerID
            ]);

            DB::table('pengakuanbarangheader')
            ->where('NoTransaksi','=', $NoTransaksi)
            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
            ->update(
                [
                    'TotalTransaksi'=>$row['stock'] * $row['hargapokokpenjualan']
                ]
            );
        }

        return $item;
    }
}
