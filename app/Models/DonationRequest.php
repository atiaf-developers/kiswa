<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;


class DonationRequest extends Model
{
    use ModelTrait;
    protected $table = "donation_requests";

    public static function transform($item)
    {
    	$transformer = new \stdClass();
        $transformer->id = $item->id;
        if (static::getLangCode() == 'ar') {
        	$transformer->date = ArabicDateSpecial($item->appropriate_time);
        }
        else{
        	$transformer->date = date('l ,F j , Y h:i A',strtotime($item->appropriate_time));
        }
        $transformer->donation_type = $item->donation_type;
        $transformer->description = $item->description;
        $prefixed_array = preg_filter('/^/', url('public/uploads/donation_requests') . '/', json_decode($item->images));
		$transformer->images = $prefixed_array;
        $transformer->name = $item->name;
        if ($item->mobile) {
        	$transformer->mobile = $item->mobile;
        }
        if ($item->lat && $item->lng) {
        	$transformer->lat = $item->lat;
            $transformer->lng = $item->lng;
        }
        $transformer->status = $item->status;
        $transformer->status_text = _lang('app.'.static::$status_text[$item->status + 1]);
    	return $transformer;
    }
}
