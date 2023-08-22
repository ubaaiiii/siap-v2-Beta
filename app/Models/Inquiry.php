<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;
    protected $table = "tr_sppa";
    protected $primaryKey = "regid";
    protected $fillable = [
        'regid',
        'nama',
        'noktp',
        'jkel',
        'pekerjaan',
        'cabang',
        'tgllahir',
        'mulai',
        'akhir',
        'masa',
        'tmt_pensiun',
        'up',
        'status',
        'createdt',
        'createby',
        'editdt',
        'editby',
        'validby',
        'validdt',
        'nopeserta',
        'usia',
        'premi',
        'epremi',
        'tpremi',
        'bunga',
        'tunggakan',
        'produk',
        'mitra',
        'nama_ahli_waris',
        'notelp_ahli_waris',
        'hubungan_ahli_waris',
        'comment',
        'asuransi',
        'policyno',
        'alamat',
        'tempat_lahir',
        'jenis_pengajuan'
    ];
}
