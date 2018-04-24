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
        'mobile' => 'string',
    );
    public static $sizes = array(
        's' => array('width' => 120, 'height' => 120),
        'm' => array('width' => 400, 'height' => 400),
    );

    public static function transform($item)
    {
        $transformer = new \stdClass();
        $transformer->name = $item->name;
        $transformer->username = $item->username;
        $transformer->email = $item->email ? $item->email : "";
        $transformer->mobile = $item->mobile;
        if ($item->image) {
            $transformer->image = url('public/uploads/users').'/'.$item->image;
        }
        else{
             $transformer->image = url('public/uploads/users/default.png');
        }
        
        return $transformer;
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($user) {
            
        });
    }
   

}
