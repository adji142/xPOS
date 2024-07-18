<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'supplier';
    protected $fillable = [
        'KodeSupplier',
        'NamaSupplier',
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
        'NPWP',
        'Bank',
        'NoRekening',
        'PemilikRekening',
        'RecordOwnerID',
        'created_at',
        'updated_at'
    ];
}
