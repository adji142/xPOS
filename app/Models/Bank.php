<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends BaseModel
{
    use HasFactory;
    protected $table = "bank";
    // protected $primaryKey = 'KodeBank';
    // public $incrementing = false;   // karena KodeBank bukan auto increment
    // protected $keyType = 'string';  // kalau KodeBank tipe varchar
}
