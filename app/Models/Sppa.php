<?php
    namespace App\Models;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;


    class Sppa extends Authenticatable
    {

        // use Notifiable;

        protected $guard = 'regid';
        protected $table = 'tr_sppa';

	    protected $primaryKey = null;
        public $incrementing = false;

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
            'tempat_lahir'
        ];

    }