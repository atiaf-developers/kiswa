<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\ModelTrait;
use DB;

class User extends Authenticatable {

    use Notifiable;
    use ModelTrait;

    protected $casts = array(
        'id' => 'integer',
        'mobile' => 'integer',
    );
    public static $sizes = array(
        's' => array('width' => 150, 'height' => 150)
    );

    protected static function boot() {
        parent::boot();

        static::deleting(function($user) {
            
        });
    }

}
