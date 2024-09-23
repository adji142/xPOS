<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\DocumentNumbering;
use App\Models\DocumentType;

class DocumentNumberingController extends Controller
{
    
    public function View(Request $request)
    {
        return view("setting.DocumentNumbering");
    }
    
    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
    	
    	$RecordOwnerID = Auth::user()->RecordOwnerID;
    	$SQL = "documenttype.KodeDokumen,documenttype.NamaDokumen, COALESCE(documentnumbering.prefix, '') AS prefix, COALESCE(documentnumbering.NumberLength,10) NumberLength ";
    	$model = DocumentType::selectRaw($SQL)
    				->leftJoin('documentnumbering', function ($value) use($RecordOwnerID){
    					$value->on('documentnumbering.DocumentID','=','documenttype.KodeDokumen')
    					->on('documentnumbering.RecordOwnerID','=',DB::raw("'".$RecordOwnerID."'"));
    				})->get();
    
        $data['data']= $model;
        return response()->json($data);
    }
    
    public function storeJson(Request $request)
    {
        Log::debug($request->all());
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
        try {

    		$model = DocumentNumbering::where('DocumentID','=',$request->input('DocumentID'))
                      ->where('RecordOwnerID','=', Auth::user()->RecordOwnerID)->get();

            if (count($model) > 0) {
            	$update = DB::table('documentnumbering')
                    ->where('DocumentID','=', $request->input('DocumentID'))
                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->update(
                      [
                        'prefix' => $request->input('prefix'),
                        'NumberLength' => $request->input('NumberLength'),
                      ]
                    );
	    
	            if ($update) {
	                $data['success'] = true;
	                
	            }else{
	                $data['message'] = 'Update Data Gagal';
	            }
            }
            else{
            	$addModel = new DocumentNumbering;
	            $addModel->DocumentID = $request->input('DocumentID');
	            $addModel->prefix = $request->input('prefix');
	            $addModel->NumberLength = $request->input('NumberLength');
	            $addModel->RecordOwnerID = Auth::user()->RecordOwnerID;
	    
	            $save = $addModel->save();
	    
	            if ($save) {
	                $data['success'] = true;
	                
	            }else{
	                $data['message'] = 'Penambahan Data Gagal';
	            }
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }
    
    public function editJson(Request $request)
    {
        Log::debug($request->all());
        try {
    
            $model = Models::where('KodeModels','=',$request->input('KodeModels'));
    
            if ($model) {
                $update = DB::table('model')
                            ->where('KodeModels','=', $request->input('KodeModels'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'NamaModels'=>$request->input('NamaModels'),
                                ]
                            );
    
                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message'] = 'Edit Models Gagal';
                }
            } else{
                $data['message'] = 'Models not found.';
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());
    
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }
    
    public function deletedata(Request $request)
    {
    	try {
    		$model = DB::table('model')
                    ->where('KodeModels','=', $request->id)
                    ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->delete();
    
            if ($model) {
            	alert()->success('Success','Delete Models berhasil.');
            }
            else{
            	alert()->error('Error','Delete Models Gagal.');
            }
            return redirect('model');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());
    
            alert()->error('Error',$e->getMessage());
    	}
    }
}
