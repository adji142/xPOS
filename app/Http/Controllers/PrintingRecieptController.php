<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrintingRecieptController extends Controller
{
    public function GetData(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'token' => "");

        var_dump(auth('sanctum')->check());
        if(auth('sanctum')->check()){
            // auth()->user()->tokens()->delete();
            $data['success'] = true;
            $data['message'] = "Have a Access";
        }
        else{
            $data['message'] = "Unautorized";
        }

        return response()->json($data);
    }
}
