<?php



    namespace App\Models;



    use Illuminate\Notifications\Notifiable;

    use Illuminate\Foundation\Auth\User as Authenticatable;



    class Master extends Authenticatable

    {

        // use Notifiable;

        protected $guard = 'msid';
        protected $table = 'ms_master';

	    protected $primaryKey = null;
        public $incrementing = false;

        protected $fillable = [

            'msid','msdesc', 'mstype', 'createby', 'createdt', 'editby', 'editdt'

        ];

        public function getDesc($mstype) {
            $master = Master::whereRaw("mstype = '$mstype'")->get();
            $data = [];
            foreach ($master as $r) {
                $data[$r->msid] = $r;
            }
            return $data;
        }

    }