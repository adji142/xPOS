<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $table = 'pelanggan';
    protected $fillable = [
        'KodePelanggan',
        'NamaPelanggan',
        'KodeGrupPelanggan',
        'LimitPiutang',
        'ProvID',
        'KotaID',
        'KelID',
        'KecID',
        'Email',
        'NoTlp1',
        'NoTlp2',
        'Alamat',
        'Keterangan',
        'Status',
        'RecordOwnerID',
        'created_at',
        'updated_at'
    ];
}
