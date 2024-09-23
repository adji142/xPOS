<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\VariantMenuHeader;
use App\Models\VariantMenuDetail;

class VariantMenuController extends Controller
{
    public function View(Request $request)
    {
        $sql = "variantheader.id,variantheader.NamaGrup, variantheader.OpsiPilihan, COUNT(variantdetail.id) JumlahVariant";
        $grupvariant = VariantMenuHeader::selectRaw($sql)
                    ->leftJoin('variantdetail', function ($value){
                        $value->on('variantdetail.variant_id','=','variantheader.id')
                        ->on('variantdetail.RecordOwnerID','=','variantheader.RecordOwnerID');
                    })
                    ->where('variantheader.RecordOwnerID',  Auth::user()->RecordOwnerID)
                    ->groupBy('variantheader.id','variantheader.NamaGrup', 'variantheader.OpsiPilihan')
                    ->get();
        $title = 'Delete Grup variant !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("Resto.variantmenu",[
            'grupvariant' => $grupvariant
        ]);
    }
    public function Form($id = null)
    {   
        $variantheader = VariantMenuHeader::where('id', $id)->get();
        $variantdetail = VariantMenuDetail::where('variant_id',$id)->get();
        return view("Resto.variantmenu-input",[
            'variantheader' => $variantheader,
            'variantdetail' => $variantdetail
        ]);
    }

    function store(Request $request) {
        $errorCount = 0;
        $errorMessage = "";
        try {
            // DB::beginTransaction();

            $OpsiPilihan = $request->input('OpsiPilihan');
            $NamaGrup = $request->input('NamaGrup');
            $txtVariantNames = $request->input('txtVariantName');
            // $txtExtraPriceNames = $request->in_array('txtExtraPriceName');
            
            // var_dump(json_encode($txtVariantNames));
            $save = VariantMenuHeader::insertGetId([
                'OpsiPilihan' => $OpsiPilihan,
                'NamaGrup' => $NamaGrup,
                'RecordOwnerID' => Auth::user()->RecordOwnerID,
            ]);

            if (count($txtVariantNames) == 0) {
                $errorMessage = "Tidak Ada data Variant";
                $errorCount +=1;
                goto jump;
            }

            $index = 0;
            foreach ($txtVariantNames as $variant) {
                $modeldetail = new VariantMenuDetail;
                $modeldetail->variant_id = $save;
                $modeldetail->NoUrut = $index;
                $modeldetail->NamaVariant = $variant['Name'];
                $modeldetail->ExtraPrice = $variant['ExtraCost'];
                $modeldetail->RecordOwnerID = Auth::user()->RecordOwnerID;
                $dSave = $modeldetail->save();

                if (!$dSave) {
                    $errorMessage = "Simpan Data Detail";
                    $errorCount +=1;
                    goto jump;
                }
                $index+=1;
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
                return redirect('grupvariant');
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
            $OpsiPilihan = $request->input('OpsiPilihan');
            $NamaGrup = $request->input('NamaGrup');
            $txtVariantNames = $request->input('txtVariantName');
            // $txtExtraPriceNames = $request->in_array('txtExtraPriceName');
            
            $oData = VariantMenuHeader::where('id', $id);

            if (!$oData) {
                $errorMessage = "Data Tidak Valid";
                $errorCount +=1;
                goto jump;
            }
            $update = DB::table('variantheader')
                        ->where('id','=', $id)
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->update(
                            [
                                'OpsiPilihan' => $OpsiPilihan,
                                'NamaGrup' => $NamaGrup,
                            ]
                        );

            if (count($txtVariantNames) == 0) {
                $errorMessage = "Tidak Ada data Variant";
                $errorCount +=1;
                goto jump;
            }

            // Delete Row
            $delete = DB::table('variantdetail')
		                ->where('variant_id','=', $id)
		                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
		                ->delete();
            $index = 0;
            foreach ($txtVariantNames as $variant) {
                $modeldetail = new VariantMenuDetail;
                $modeldetail->variant_id = $id;
                $modeldetail->NoUrut = $index;
                $modeldetail->NamaVariant = $variant['Name'];
                $modeldetail->ExtraPrice = $variant['ExtraCost'];
                $modeldetail->RecordOwnerID = Auth::user()->RecordOwnerID;
                $dSave = $modeldetail->save();

                if (!$dSave) {
                    $errorMessage = "Simpan Data Detail";
                    $errorCount +=1;
                    goto jump;
                }
                $index+=1;
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
                return redirect('grupvariant');
	        }
        } catch (\Exception $e) {
            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function deletedata(Request $request)
    {
        $errorCount = 0;
        $errorMessage = "";
    	try {
            DB::beginTransaction();

    		$detail = DB::table('variantdetail')
	                ->where('variant_id','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();
            
            if (!$detail) {
                $errorCount +=1;
                $errorMessage = "Hapus Data Variant Tidak berhasil";
                goto jump;
            }
            $header = DB::table('variantheader')
                    ->where('id','=', $request->id)
                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->delete();
            if (!$header) {
                $errorCount +=1;
                $errorMessage = "Hapus Data Grup Variant Tidak berhasil";
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
		        alert()->success('Success','Data Variant Berhasil dihapus.');
                return redirect('grupvariant');
	        }
    	} catch (\Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
