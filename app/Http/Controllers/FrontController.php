<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Basic;
use Auth;
use App\Models\Setting;
use App\Models\SettingTranslation;
use App\Models\Category;
use App\Models\Game;

class FrontController extends Controller {

    use Basic;

    protected $lang_code;
    protected $User = false;
    protected $isUser = false;
    protected $_Request = false;
    protected $limit = 10;
    protected $order_minutes_limit = 16;
    protected $_settings;
    protected $data = array();

    public function __construct() {
        if (Auth::guard('web')->user() != null) {
            $this->User = Auth::guard('web')->user();
            $this->isUser = true;
        }
        $this->data['User'] = $this->User;
        $this->data['isUser'] = $this->isUser;
        $segment2 = \Request::segment(2);
        $this->data['page_link_name'] = $segment2;


        $this->getLangCode();
        $this->getSettings();
        $this->data['page_title'] = '';
       
    }

    private function getLangCode() {
        $this->lang_code = app()->getLocale();
        $this->data['lang_code'] = $this->lang_code;
        session()->put('lang_code', $this->lang_code);
        if ($this->data['lang_code'] == 'ar') {
            $this->data['next_lang_code'] = 'en';
            $this->data['next_lang_text'] = 'English';
            $this->data['currency_sign'] = 'جنيه';
        } else {
            $this->data['next_lang_code'] = 'ar';
            $this->data['next_lang_text'] = 'العربية';
            $this->data['currency_sign'] = 'EGP';
        }
        $this->slugsCreate();
    }

    protected function iniDiffLocations($tableName, $lat, $lng) {
        $diffLocations = "SQRT(POW(69.1 * ($tableName.lat - {$lat}), 2) + POW(69.1 * ({$lng} - $tableName.lng) * COS($tableName.lat / 57.3), 2)) as distance";
        return $diffLocations;
    }

    private function getSettings() {
        $this->data['settings'] = Setting::get()->keyBy('name');
        $this->_settings = $this->data['settings'];
        $this->data['settings']['social_media'] = json_decode($this->data['settings']['social_media']->value);
        $this->data['settings_translations'] = SettingTranslation::where('locale', $this->lang_code)->first();
        //dd($this->data['settings']);
    }

    protected function _view($main_content, $type = 'front') {
        $main_content = "main_content/$type/$main_content";
        //dd($main_content);
        return view($main_content, $this->data);
    }

    protected function err404($code = false, $message = false) {
        if (!$message) {
            $message = _lang('app.page_not_found');
        }
        if (!$code) {
            $code = 404;
        }
        $this->data['code'] = $code;
        $this->data['message'] = $message;
        return $this->_view('err404');
    }

    protected function getCategories($page = 'home') {
        $categories = Category::join('categories_translations as trans', 'categories.id', '=', 'trans.category_id');
        $categories->select('categories.id', "categories.image", "categories.slug", "trans.title");
        $categories->orderBy('categories.this_order', 'ASC');
        $categories->where('categories.active', 1);
        $categories->where('trans.locale', $this->lang_code);


        if ($page == 'home') {
            $categories->take(6);
            $categories = $categories->get();
            $categories = Category::transformCollection($categories);
            $categories = array_chunk($categories, 3);
        } else if ($page == 'categories') {
            $categories = $categories->paginate($this->limit);
            $categories->getCollection()->transform(function($category, $key) {
                return Category::transform($category);
            });
            //dd($categories);
        } else if ($page == 'category_details') {
            $categories->where('categories.slug', \Request::segment(3));
            $categories = $categories->first($this->limit);

            //dd($categories);
        }

        return $categories;
    }

    protected function getGames($page = 'home_offers') {
        $games = Game::join('games_translations as trans', 'games.id', '=', 'trans.game_id');
        $games->join('categories', 'categories.id', '=', 'games.category_id');
        $games->select(['games.id', "games.discount_price", "games.over_price", "games.youtube_url",
            "games.slug", "games.gallery", "trans.description", "trans.title", "games.price", "games.discount_price"]);
        if ($page == 'home_offers' || $page == 'offers') {
            $games->orderBy('games.offers_order', 'ASC');
            $games->where('games.discount_price', '>', 0);
        }
        if ($page == 'home_best' || $page == 'offers') {
            $games->orderBy('games.best_order', 'ASC');
        }
        $games->where('trans.locale', $this->lang_code);
        $games->where('games.active', 1);
        $games->where('categories.active', 1);
        if ($page == 'home_offers') {
            $games->take(8);
            $games = $games->get();
            $games = Game::transformCollection($games);
            //dd('$games');
        } else if ($page == 'home_best') {
            $games->take(8);
            $games = $games->get();
            $games = Game::transformCollection($games);
            $games = array_chunk($games, 3);
        } else if ($page == 'offers_page') {
            $games = $games->paginate($this->limit);
            $games->getCollection()->transform(function($game, $key) {
                return Game::transform($game);
            });
        } else if ($page == 'games_page') {
            if (\Request::all()) {
                if ($category= \Request::input('category')) {
                    $games->where("categories.slug", $category);
                }
                if ($sort_by = \Request::input('sort_by')) {
                    $games->orderBy("games.category_order",$sort_by);
                }
                
            }
            $games = $games->paginate($this->limit)->appends(\Request::all());
            
            $games->getCollection()->transform(function($game, $key) {
                return Game::transform($game);
            });
        } else if ($page == 'category_details') {
            //dd(\Request::segment(3));
            $games->where('categories.slug', \Request::segment(3));
            $games = $games->paginate($this->limit);
            $games->getCollection()->transform(function($game, $key) {
                return Game::transform($game);
            });
        } else if ($page == 'game_details') {
            //dd(\Request::segment(3));
            $games->where('games.slug', \Request::segment(3));
            $games = $games->first();
            if ($games) {
                $games = Game::transformGameDetails($games);
            }
        }

        return $games;
    }

}
