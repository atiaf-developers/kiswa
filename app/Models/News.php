<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends MyModel
{
    protected $table = "news";

	public function translations() {
		return $this->hasMany(NewsTranslation::class, 'news_id');
	}

	public static function transform($item)
	{
		$transformer = new \stdClass();
		$transformer->title = $item->title;
		$transformer->description = $item->description;
		$prefixed_array = preg_filter('/^/', url('public/uploads/news') . '/', json_decode($item->images));
		$transformer->images = $prefixed_array;
		$transformer->created_at = date('d/m/Y',strtotime($item->created_at));

       return $transformer;
		
	}


	public static function transformHome($item)
	{
		$transformer = new \stdClass();
		$transformer->slug = $item->slug;
		$transformer->title = $item->title;
		$transformer->description = mb_strimwidth($item->description, 0, 300, '...');
		$prefixed_array = preg_filter('/^/', url('public/uploads/news') . '/', json_decode($item->images));
		$transformer->images = $prefixed_array;
		$transformer->created_at = date('d/m/Y',strtotime($item->created_at));

       return $transformer;
		
	}



	protected static function boot() {
		parent::boot();

		static::deleting(function($news) {
			foreach ($news->translations as $translation) {
				$translation->delete();
			}
		});

		static::deleted(function($news) {
				$old_images = json_decode($news->images);
				
				foreach ($old_images as $key => $value) {
					static::deleteUploaded('news', $value);
				}
		});
	}


}
