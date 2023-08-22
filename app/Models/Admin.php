<?php



    namespace App\models;



    use Illuminate\Notifications\Notifiable;

    use Illuminate\Foundation\Auth\User as Authenticatable;



    class Admin extends Authenticatable

    {

        use Notifiable;



        protected $guard = 'admin';
        protected $table = 'ms_admin';

	    protected $primaryKey = 'id_admin';

        protected $fillable = [

            'username','email', 'password',

        ];



        protected $hidden = [

            'password',

        ];

    }