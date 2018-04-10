<?php

namespace App\Traits;

use App\Models\Setting;
use Image;

trait Basic {

    protected $languages = array(
        'ar' => 'arabic',
        'en' => 'english'
    );

    protected function inputs_check($model, $inputs = array(), $id = false, $return_errors = true) {
        $errors = array();
        foreach ($inputs as $key => $value) {
            $where_array = array();
            $where_array[] = array($key, '=', $value);
            if ($id) {
                $where_array[] = array('id', '!=', $id);
            }

            $find = $model::where($where_array)->get();

            if (count($find)) {

                $errors[$key] = array(_lang('app.' . $key) . ' ' . _lang("app.added_before"));
            }
        }

        return $errors;
    }

    public function _view($main_content, $type = 'front') {
        $main_content = "main_content/$type/$main_content";
        return view($main_content, $this->data);
    }

    protected function settings() {
        $settings = Setting::get();
        $settings[0]->noti_status = json_decode($settings[0]->noti_status);
        return $settings[0];
    }

    protected function slugsCreate() {
        $this->title_slug = 'title_' . $this->lang_code;
        $this->data['title_slug'] = $this->title_slug;
    }

    

   

    protected function lang_rules($columns_arr=array())
    {
        $rules=array();

        if(!empty($columns_arr)){
            foreach($columns_arr as $column=>$rule){
                foreach($this->languages as $lang_key => $locale){
                    $key=$column.'.'.$lang_key;
                    $rules[$key]=$rule;
                }
            }
        }
        return $rules;
    }
    

}
