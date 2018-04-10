<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AUTHORIZATION;
use App\Models\User;
use App\Models\Setting;
use App\Models\Category;
use App\Models\News;
use App\Models\OurLocation;
use App\Models\ContactMessage;
use App\Models\CommonQuestion;
use App\Models\RateQuestion;
use App\Models\RateQuestionAnswer;
use App\Models\CommunicationGuide;
use App\Models\Rating;
use App\Helpers\Fcm;
use Carbon\Carbon;
use DB;

class BasicController extends ApiController {

    private $contact_rules = array(
        'mobile' => 'required',
        'type' => 'required',
        'message' => 'required',
        'name' => 'required'
    );

    private $rate_rules = array(
        'question_id' => 'required',
        'answer_id' => 'required',
    );

    

    public function getToken(Request $request) {
        $token = $request->header('authorization');
        if ($token != null) {
            $token = Authorization::validateToken($token);
            if ($token) {
                $new_token = new \stdClass();
                $find = User::find($token->id);
                if ($find != null) {
                    $new_token->id = $find->id;
                    $new_token->expire = strtotime('+ ' . $this->expire_no . $this->expire_type);
                    $expire_in_seconds = $new_token->expire;
                    return _api_json('', ['token' => AUTHORIZATION::generateToken($new_token), 'expire' => $expire_in_seconds]);
                } else {
                    return _api_json('', ['message' => 'user not found'], 401);
                }
            } else {
                return _api_json('', ['message' => 'invalid token'], 401);
            }
        } else {
            return _api_json('', ['message' => 'token not provided'], 401);
        }
    }

    public function getSettings() {
        try {
            $settings = Setting::select(["email", "phone", "about_us_$this->lang_code as about_us",
                        "android_url", "ios_url", "usage_conditions_$this->lang_code as usage_conditions", "usage_conditions_message_$this->lang_code as usage_conditions_message",
                        "designer_register_message_$this->lang_code as designer_register_message"])
                    ->first();
            $settings->currency_sign= $this->currency_sign;
            return _api_json(Setting::transform($settings));
        } catch (\Exception $e) {
            return _api_json(new \stdClass(), ['message' => $e->getMessage()], 400);
        }
    }

  

    public function sendContactMessage(Request $request) {
        $validator = Validator::make($request->all(), $this->contact_rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return _api_json('', ['errors' => $errors], 400);
        } else {
            try {
                $ContactMessage = new ContactMessage;
                $ContactMessage->mobile = $request->input('mobile');
                $ContactMessage->type = $request->input('type');
                $ContactMessage->message = $request->input('message');
                $ContactMessage->name = $request->input('name');
                $ContactMessage->save();
                return _api_json('', ['message' => _lang('app.message_is_sent_successfully')]);
            } catch (\Exception $ex) {
                return _api_json('', ['message' => _lang('app.error_is_occured')], 400);
            }
        }
    }

    public function getNews() {
        try {
            
            $news = News::Join('news_translations','news.id','=','news_translations.news_id')
                          ->where('news_translations.locale',$this->lang_code)
                          ->where('news.active',true)
                          ->orderBy('news.this_order')
                          ->select('news.id','news.image','news.created_at','news_translations.description')
                          ->paginate($this->limit);


            return _api_json(News::transformCollection($news));
        } catch (\Exception $e) {
            return _api_json([], ['message' => _lang('app.error_is_occured')], 400);
        }
    }


    public function getCategories() {
        try {
            $categories = Category::Join('categories_translations','categories.id','=','categories_translations.category_id')
                                   ->where('categories_translations.locale',$this->lang_code)
                                   ->where('categories.active',true)
                                   ->where('categories.parent_id',0)
                                   ->orderBy('categories.this_order')
                                   ->select("categories.id", "categories_translations.title","categories.parent_id")
                                   ->paginate($this->limit);
            return _api_json(Category::transformCollection($categories));
        } catch (\Exception $e) {
            return _api_json([], ['message' => _lang('app.error_is_occured')], 400);
        }
    }


    public function getOurLocations() {
        try {

            $our_locations = OurLocation::Join('our_locations_translations','our_locations.id','=','our_locations_translations.our_location_id')
                                   ->where('our_locations_translations.locale',$this->lang_code)
                                   ->where('our_locations.active',true)
                                   ->orderBy('our_locations.this_order')
                                   ->select("our_locations.id","our_locations.location_image","our_locations_translations.title","our_locations_translations.address","our_locations.lat","our_locations.lng","our_locations.contact_numbers")
                                   ->paginate($this->limit);

            return _api_json(OurLocation::transformCollection($our_locations));
        } catch (\Exception $e) {
            return _api_json([], ['message' => _lang('app.error_is_occured')], 400);
        }
    }


    public function getCommonQuestions() {
        try {

            $common_questions = CommonQuestion::Join('common_questions_translations','common_questions.id','=','common_questions_translations.common_question_id')
                                   ->where('common_questions_translations.locale',$this->lang_code)
                                   ->where('common_questions.active',true)
                                   ->orderBy('common_questions.this_order')
                                   ->select("common_questions.id","common_questions_translations.question","common_questions_translations.answer")
                                   ->paginate($this->limit);

            return _api_json(CommonQuestion::transformCollection($common_questions));
        } catch (\Exception $e) {
            return _api_json([], ['message' => _lang('app.error_is_occured')], 400);
        }
    }


    public function getRateQuestions() {
        try {
            
            $rate_questions = RateQuestion::Join('rate_questions_translations','rate_questions.id','=','rate_questions_translations.rate_question_id')
                                   ->where('rate_questions_translations.locale',$this->lang_code)
                                   ->where('rate_questions.active',true)
                                   ->orderBy('rate_questions.this_order')
                                   ->select("rate_questions.id","rate_questions_translations.title")
                                   ->paginate($this->limit);

            return _api_json(RateQuestion::transformCollection($rate_questions));
        } catch (\Exception $e) {
           
            return _api_json([], ['message' => _lang('app.error_is_occured')], 400);
        }
    }

    public function getCommunicationGuides() {
        try {
            
            $communication_guides = CommunicationGuide::Join('communication_guides_translations', 'communication_guides.id', '=', 'communication_guides_translations.communication_guide_id')
                                                ->where('communication_guides_translations.locale', $this->lang_code)
                                                ->where('communication_guides.active',true)
                                                ->orderBy('communication_guides.this_order')
                                                ->select([
                                                  'communication_guides.id', "communication_guides_translations.title","communication_guides_translations.description"
                                               ])
                                               ->paginate($this->limit);

            return _api_json(CommunicationGuide::transformCollection($communication_guides));
        } catch (\Exception $e) {
            return _api_json([], ['message' => _lang('app.error_is_occured')], 400);
        }
    }


    public function rate(Request $request) {
        try {
            $validator = Validator::make($request->all(), $this->rate_rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return _api_json('', ['errors' => $errors], 400);
            }   
                DB::beginTransaction();
                try {
                    $check = Rating::where('question_id',$request->input('question_id'))
                                  ->where('user_id',$this->auth_user()->id)
                                  ->first();
                    if ($check) {
                        $check->answer_id = $request->answer_id;
                        $check->save();
                        DB::table('rate_question_answers')->where('id', $check->answer_id)->decrement('count_of_raters',1);
                    }
                    else{
                        $rate = new Rating;
                        $rate->question_id = $request->input('question_id');
                        $rate->answer_id = $request->input('answer_id');
                        $rate->user_id = $this->auth_user()->id;
                        $rate->save();
                    }
                    DB::table('rate_question_answers')->where('id', $request->answer_id)->increment('count_of_raters',1);
                
                   DB::commit();
                    return _api_json('', ['message' => _lang('app.thank_you_for_your_answer')]);
                } catch (\Exception $ex) {
                    DB::rollback();
                    return _api_json('', ['message' => _lang('app.error_is_occured')], 400);
                }
            
           
        } catch (\Exception $e) {
            
            return _api_json([], ['message' => _lang('app.error_is_occured')], 400);
        }
    }

   
  

   

}
