<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;

class CustomerController extends FrontController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $type = $this->User->type;
        switch ($type) {
            case 1:    //company
                $view = 'company/index';
                break;
            case 3:   //governmental
                $view = 'company/index';
                break;
            case 2:  //station
                $view = 'station/index';
                break;
            case 9:  //company branch
                $view = 'company/branch_index';
                break;
            case 5:  //station branch
                $view = 'station/branch_index';
                break;

            default:
                $view = '';
                break;
        }
        return $this->_view($view, 'front');
    }

}
