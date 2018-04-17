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

}
