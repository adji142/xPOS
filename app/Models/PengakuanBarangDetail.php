<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengakuanBarangDetail extends BaseModel
{
    use HasFactory;
    protected $table = "pengakuanbarangdetail";

    protected $fillable = [
        'NoTransaksi',
        'NoUrut',
        'KodeItem',
        'Qty',
        'Satuan',
        'Harga',
        'TotalTransaksi',
        'KodeGudang',
        'KodeRekening',
        'RecordOwnerID',
        'created_at',
        'updated_at'
    ];
}
