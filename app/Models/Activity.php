<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends MyModel
{
    protected $table = "activities";

	public function translations() {
		return $this->hasMany(ActivityTranslation::class, 'activity_id');
	}

	public static function transform($item)
	{
		$transformer = new \stdClass();
		$transformer->title = $item->title;
		$transformer->description = $item->description;
		$transformer->image = $item->image ? url('public/uploads/activities') . '/' . $item->image : '';

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
			if ($activity->image) {
				$old_image = $activity->image;
                static::deleteUploaded('activities', $old_image);
			}
		});
	}


}
