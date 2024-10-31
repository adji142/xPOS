<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\TnCModel;

class TnCController extends Controller
{
    public function View(Request $request)
    {
        $tnc = TnCModel::first();

        // $bank = $bank->paginate(4);

        $title = 'Delete Tipe Order Resto !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("Admin.TermAndCondition",[
            'tnc' => $tnc, 
        ]);
    }

    public function edit(Request $request)
    {
        Log::debug($request->all());
        try {
            $model = TnCModel::where('id','=',$request->input('id'));
            
            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('termandcondition')
                			->where('id','=', $request->input('id'))
                			->update(
                				[
                					'termcondition'=>$request->input('DeskripsiSubscription'),
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Term and Conditionberhasil disimpan.');
                    return redirect('tnc');
                }else{
                    alert()->error('Error','Edit Term and Condition Gagal');
                    return redirect()->back();
                }
            } else{
                alert()->error('Error','Term and Condition Not Found');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }
}
