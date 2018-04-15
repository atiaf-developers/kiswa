<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Validator;
use App\Models\Container;

class ContainersController extends ApiController
{
    public function __construct() {
        parent::__construct();
    }
}
