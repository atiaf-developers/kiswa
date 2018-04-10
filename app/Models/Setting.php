<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends MyModel {

    protected $table = 'settings';
    protected $fillable=['value'];
    public static $sizes = array(
        's' => array('width' => 120, 'height' => 120),
        'm' => array('width' => 400, 'height' => 400),
    );
    protected $casts = array(
        'phone' => 'integer'
    );

    public static function transform($item) {
        return $item;
    }

}
