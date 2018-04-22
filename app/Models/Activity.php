<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends MyModel {

    protected $table = "activities";

    public static $sizes = array(
        's' => array('width' => 200, 'height' => 200),
        'm' => array('width' => 400, 'height' => 400),
    );

    public function translations() {
        return $this->hasMany(ActivityTranslation::class, 'activity_id');
    }

    public static function transform($item) {
        $transformer = new \stdClass();
        $transformer->title = $item->title;
        $transformer->description = $item->description;
        $prefixed_array = preg_filter('/^/', url('public/uploads/activities') . '/', json_decode($item->images));
        $transformer->images = $prefixed_array;

        return $transformer;
    }

    public static function transformHome($item) {
        $transformer = new \stdClass();
        $transformer->slug = $item->slug;
        $transformer->title = $item->title;
        $transformer->description =  mb_strimwidth($item->description, 0, 300, '...');
        $activity_images =  json_decode($item->images);
        $activity_image_without_prefix =  static::rmv_prefix($activity_images[0]);
        $transformer->image = url('public/uploads/activities') . '/m_' .$activity_image_without_prefix;


        return $transformer;
    }


    public static function transformDetailes($item) {

        $transformer = new \stdClass();
        $transformer->slug = $item->slug;
        $transformer->title = $item->title;
        $transformer->description =$item->description;
        $activity_images =  json_decode($item->images);
        foreach ($activity_images as $key => $value) {
            $activity_images[$key] =  static::rmv_prefix($value);
        }
        $prefixed_array = preg_filter('/^/', url('public/uploads/activities') . '/m_', $activity_images);
        $transformer->images = $prefixed_array;


        return $transformer;
    }


    protected static function boot() {
        parent::boot();

        static::deleting(function($activity) {
            foreach ($activity->translations as $translation) {
                $translation->delete();
            }
        });

        static::deleted(function($activity) {
                $old_images = json_decode($activity->images);
                foreach ($old_images as $key => $value) {
                    static::deleteUploaded('activities', $value);
                }
        });
    }

}
