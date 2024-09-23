<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\FirebaseService;

class Printer extends Model
{
    use HasFactory;
    protected $table = "printer";

    // protected $firebaseService;

    // public function __construct(FirebaseService $firebaseService)
    // {
    //     $this->firebaseService = $firebaseService;
    // }

    public function SendNotif($param, $firebaseService)
    {
    	
    	$response = $firebaseService->sendNotification($param['title'], $param['body'], $param['token'], $param['data']);

    	return $response;
    }
}
