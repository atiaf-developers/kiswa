<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Album extends MyModel
{
    protected $table = "albums";

    public function images()
    {
    	return $this->hasMany(AlbumImage::class,'album_id');
    }


    public static function transform($item)
    {
    	$transformer = new \stdClass();
    	$transformer->id = $item->id;
    	$transformer->title = $item->title;
    	$album_images = $item->images()->pluck('image')->toArray();
    	$prefixed_array = preg_filter('/^/', url('public/uploads/albums') . '/', $album_images);
        $transformer->images = $prefixed_array;
        $transformer->images_count = count($prefixed_array);

        return $transformer;

    	
    }

}
