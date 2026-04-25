<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturPembelianHeader extends BaseModel
{
    use HasFactory;
    protected $table = "fakturpembelianheader";
     protected $primaryKey = 'NoTransaksi';
    public $incrementing = false;   // karena KodeBank bukan auto increment
    protected $keyType = 'string';  // kalau KodeBank tipe varchar
}
