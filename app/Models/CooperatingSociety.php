<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CooperatingSociety extends MyModel
{
    protected $table = "cooperating_societies";

	public function translations() {
		return $this->hasMany(CooperatingSocietyTranslation::class, 'cooperating_society_id');
	}

	public static function transform($item)
	{
		$transformer = new \stdClass();
		$transformer->image = $item->image ? url('public/uploads/cooperating_societies') . '/' . $item->image : '';
		$transformer->description = $item->description;
		$transformer->created_at = date('d/m/Y',strtotime($item->created_at));

       return $transformer;
		
	}



	protected static function boot() {
		parent::boot();

		static::deleting(function($cooperating_society) {
			foreach ($cooperating_society->translations as $translation) {
				$translation->delete();
			}
		});

		static::deleted(function($cooperating_society) {
			if ($cooperating_society->image) {
				$old_image = $cooperating_society->image;
                static::deleteUploaded('cooperating_societies', $old_image);
			}
		});
	}


}
