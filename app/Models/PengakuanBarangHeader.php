<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengakuanBarangHeader extends Model
{
    use HasFactory;
    protected $table = "pengakuanbarangheader";
    protected $fillable = [
        'Periode',
        'NoTransaksi',
        'TglTransaksi',
        'NoReff',
        'Keterangan',
        'Status',
        'TotalTransaksi',
        'CreatedBy',
        'UpdatedBy',
        'Posted',
        'RecordOwnerID',
        'created_at',
        'updated_at'
    ];
}
