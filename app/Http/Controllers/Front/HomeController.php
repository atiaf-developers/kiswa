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
       
        return $this->_view('index');
    }

}
