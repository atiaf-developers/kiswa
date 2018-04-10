<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Game;


class HomeController extends FrontController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->data['slider']= $this->getSlider();
        $this->data['games_offers']= $this->getGames('home_offers');
        //dd($this->data['games_offers']);
        //$this->data['games_offers']= $this->getGamesOffers();
        $this->data['games_best_chunk']= $this->getGames('home_best');
        
        //dd($this->data['games_best_chunk']);
        return $this->_view('index');
    }

    private function getSlider() {
        $slider = Slider::where('active', 1)->orderBy('this_order', 'ASC')->get();
        return Slider::transformCollection($slider,'FrontHome');
    }
    
    private function getGamesOffers() {
        $games = Game::join('games_translations as trans', 'games.id', '=', 'trans.game_id')
                        ->select('games.id',"games.slug","games.gallery", "trans.title","games.price","games.discount_price")
                        ->orderBy('games.offers_order', 'ASC')
                        ->where('trans.locale', $this->lang_code)
                        ->where('games.discount_price', '>',0)
                        ->take(8)
                        ->get();
        return Game::transformCollection($games,'FrontHome');
    }
    private function getGamesBest() {
        $games = Game::join('games_translations as trans', 'games.id', '=', 'trans.game_id')
                        ->select('games.id',"games.slug", "games.gallery","trans.title","games.price","games.discount_price")
                        ->orderBy('games.best_order', 'ASC')
                        ->where('trans.locale', $this->lang_code)
                        ->take(8)
                        ->get();
        return array_chunk(Game::transformCollection($games,'FrontHome'), 3);
    }
    


}
