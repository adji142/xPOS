<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends BaseModel
{
    use HasFactory;
    protected $table = 'company';
    protected $primaryKey = 'KodePartner';
    public $incrementing = false;
    protected $keyType = 'string';

    public function ReadSetting()
    {
    	return $this::where('RecordOwnerID', Auth::user()->RecordOwnerID)->first();
    }
}
