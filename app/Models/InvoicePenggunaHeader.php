<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePenggunaHeader extends BaseModel
{
    use HasFactory;
    protected $table ='tagihanpenggunaheader';
    protected $primaryKey = 'NoTransaksi';
    public $incrementing = false;
    protected $keyType = 'string';
}
