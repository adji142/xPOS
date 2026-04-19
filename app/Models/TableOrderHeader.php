<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableOrderHeader extends BaseModel
{
    use HasFactory;
    protected $table = 'tableorderheader';
    protected $primaryKey = 'NoTransaksi';
    public $incrementing = false;
    protected $keyType = 'string';
}
