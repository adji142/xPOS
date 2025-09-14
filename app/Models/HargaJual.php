<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaJual extends BaseModel
{
    use HasFactory;
    protected $table ='historyhargajual';
    protected $fillable = [
        'KodeItem',
        'HargaJual',
        'TipeMarkUp',
        'RecordOwnerID',
        'created_at',
        'updated_at'
    ];
}
