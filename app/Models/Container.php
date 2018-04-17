<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Container extends MyModel
{
    protected $table = "containers";

    public function transform($item)
    {
    	$transformer = new \stdClass();
    	$transformer->id = $item->id;
    	$transformer->title = $item->title;
    	$transformer->address = $item->address;
    	$transformer->lat = $item->lat;
    	$transformer->lng = $item->lng;
    	$transformer->status = $item->status ? 1 : 0;
        
        return $transformer;

    }
}
