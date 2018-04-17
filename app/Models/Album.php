<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends MyModel {

    protected $table = "albums";

    public function translations() {
        return $this->hasMany(AlbumTranslation::class, 'album_id');
    }

    public function images() {
        return $this->hasMany(AlbumImage::class, 'album_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($album) {
            foreach ($album->translations as $translation) {
                $translation->delete();
            }
            foreach ($album->images as $image) {
                $image->delete();
            }
        });
    }

    public static function transform($item) {
        $transformer = new \stdClass();
        $transformer->id = $item->id;
        $transformer->title = $item->title;
        $album_images = $item->images()->orderBy('album_images.this_order')->pluck('image')->toArray();
        foreach ($album_images as $key => $value) {
            $album_images[$key] =  static::rmv_prefix($value);
        }
        $prefixed_array = preg_filter('/^/', url('public/uploads/albums') . '/m_', $album_images);
        $transformer->images = $prefixed_array;
        $transformer->images_count = count($prefixed_array);

        return $transformer;
    }

}
