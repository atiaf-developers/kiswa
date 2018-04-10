<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AUTHORIZATION;
use App\Models\User;

class LoginController extends ApiController {

    private $rules = array(
        'username' => 'required',
        'password' => 'required',
        'type' => 'required|in:1,2,3'
    );

    public function login(Request $request) {
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return _api_json(new \stdClass(), ['errors' => $errors], 400);
        } else {
            if ($request->type == 1) {


                
            }
            elseif ($request->type == 2) {
                
            }
            elseif ($request->type == 3) {
                
            }
            else{

            }

            $credentials = $request->only('username', 'password');
            if ($user = $this->auth_check($credentials)) {
                $token = new \stdClass();
                $token->id = $user->id;
                $token->expire = strtotime('+' . $this->expire_no . $this->expire_type);
                $expire_in_seconds = $token->expire;
                $user = $user->type == 2 ? User::transformClient($user) : User::transformDesigner($user);
                return _api_json($user, ['message' => _lang('app.login_done_successfully'), 'token' => AUTHORIZATION::generateToken($token), 'expire' => $expire_in_seconds]);
            }
            return _api_json(new \stdClass(), ['message' => _lang('app.invalid_credentials')], 400);
        }
    }

    private function auth_check($credentials) {

        $find = User::where(function ($query) use($credentials) {
                    $query->where('email', $credentials['username']);
                    $query->orWhere('mobile', $credentials['username']);
                })
                ->where('type', $credentials['type'])
                ->where('active', 1)
                ->first();
        if ($find) {
            if (password_verify($credentials['password'], $find->password)) {
                return $find;
            }
        }
        return false;
    }

}
