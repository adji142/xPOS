<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ActivityLog;

class LogingController extends Controller
{
    public function view($id){
        $idE = base64_decode($id);
        $oData = ActivityLog::join('users', function($join) {
                $join->on('activity_logs.user_id', '=', 'users.id')
                    ->on('activity_logs.RecordOwnerID', '=', 'users.RecordOwnerID');
            })
            ->where('activity_logs.RecordOwnerID', $idE)
            ->select('activity_logs.*', 'users.name as user_name', 'users.email as user_email')
            ->get();
        return view('loging.view', compact('oData'));
    }
}
