<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Noti extends MyModel {

    protected $table = 'noti';
    public static $status_text = [
        2 => 'the_delegate_is_coming_to_you_to_receive_the_donation',
        3 => 'The_delegate_has_arrived_to_receive_the_donation',
        4 => 'The_donation_was_received_by_the_delegate'
    ];

    public static function transformFront($item) {
        $lang_code = static::getLangCode();
        $obj = new \stdClass();
        $obj->noti_id = $item->id;
        $obj->id = $item->entity_id;
        $obj->title = '';
        $obj->type = $item->entity_type_id;
        $obj->created_at = date('d/m/Y   g:i A', strtotime($item->created_at));
        $obj->read_status = $item->read_status;
        $message = '';
        $url = '';
        if ($item->entity_type_id == 5) {
            $activity = Activity::Join('activities_translations', 'activities.id', '=', 'activities_translations.activity_id')
                    ->where('activities_translations.locale', $lang_code)
                    ->where('activities.active', true)
                    ->where('activities.id', $item->entity_id)
                    ->select("activities.slug", "activities_translations.title")
                    ->first();
            if ($activity) {
                $url = _url('corporation-activities/' . $activity->slug);
                $message = _lang('app.new_activity') . ' ' . $activity->title;
            }
        } else if ($item->entity_type_id == 6) {
            $news = News::Join('news_translations', 'news.id', '=', 'news_translations.news_id')
                    ->where('news_translations.locale', $lang_code)
                    ->where('news.active', true)
                    ->where('news.id', $item->entity_id)
                    ->select("news.slug", 'news_translations.title')
                    ->first();
            if ($news) {
                $message = _lang('app.new_news') . ' ' . $news->title;
                $url = _url('news-and-events/' . $news->slug);
            }
        } else {
            $message = _lang('app.' . static::$status_text[$item->entity_type_id]);
        }
        $obj->body = $message;
        $obj->url = $url;

        return $obj;
    }

    public static function getNoti($where_array) {

        $notifications = DB::table('noti_object as n_o')->join('noti as n', 'n.noti_object_id', '=', 'n_o.id');
        $notifications->select('n.id', 'n_o.entity_id', 'n_o.entity_type_id', 'n.notifier_id', 'n_o.created_at', 'n.read_status');

        $notifications->where(function ($query) use($where_array) {
            $query->where(function ($query2) {
                $query2->whereNull('n.notifier_id');
            });
            $query->orWhere(function ($query2) use($where_array) {
                $query2->where('n.notifier_id', $where_array['notifier_id']);
                $query2->where('n_o.notifiable_type', $where_array['notifiable_type']);
            });
        });
        $notifications->orderBy('n_o.created_at', 'DESC');
        $result = $notifications->get();
        $result = $notifications->paginate(static::$limit);
        $result->getCollection()->transform(function($item, $key) {
            return static::transformFront($item);
        });
        return $result;
    }

}
