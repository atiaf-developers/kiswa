<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable {

    use Notifiable;

    protected $casts = array(
        'id' => 'integer',
        'mobile' => 'integer',
    );
    public static $sizes = array(
        's' => array('width' => 120, 'height' => 120),
        'm' => array('width' => 400, 'height' => 400),
    );

    protected static function boot() {
        parent::boot();

        static::deleting(function($user) {
          
        });
    }
   

}
