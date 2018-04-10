<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends MyModel
{
    protected $table = "videos";

	public function translations() {
		return $this->hasMany(VideoTranslation::class, 'video_id');
	}

	public static function transform($item)
	{
		$transformer = new \stdClass();
		$transformer->url = $item->url;
		$transformer->title = $item->title;

       return $transformer;
		
	}



	protected static function boot() {
		parent::boot();

		static::deleting(function($video) {
			foreach ($video->translations as $translation) {
				$translation->delete();
			}
		});

	
	}


}
