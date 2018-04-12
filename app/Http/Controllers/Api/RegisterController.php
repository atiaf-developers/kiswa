<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AUTHORIZATION;
use App\Models\User;
use App\Models\Device;
use DB;

class RegisterController extends ApiController {

    private $rules = array(
        
        'name' => 'required',
        'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'mobile' => 'required|unique:users',
        'password' => 'required',
        'confirm_password' => 'required|same:password',
        'device_id' => 'required',
        'device_token' => 'required',
        'device_type' => 'required',
        
    );

    private $verification_rules = array(
        'mobile' => 'required', 
    );

    public function __construct() {
        parent::__construct();
    }

    public function sendVerificationCode(Request $request)
    {
        try {
        $validator = Validator::make($request->all(), $this->verification_rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return _api_json(new \stdClass(), ['errors' => $errors], 400);
        }

        $verification_code = Random(4);

        return _api_json('',['code' => $verification_code ]);
            
        } catch (\Exception $e) {
            $message = _lang('app.error_is_occured');
            return _api_json('', ['message' => $message],400);
        }
        
    }

    public function register(Request $request) {
       
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return _api_json(new \stdClass(), ['errors' => $errors], 400);
        } else {
   
            DB::beginTransaction();
            try {
                $user = $this->create_user($request);
                DB::commit();
                
                $token = new \stdClass();
                $token->id = $user->id;
                $token->expire = strtotime('+' . $this->expire_no . $this->expire_type);
                $expire_in_seconds = $token->expire;
                return _api_json(User::transform($user), ['token' => AUTHORIZATION::generateToken($token), 'expire' => $expire_in_seconds], 201);
                
            } catch (\Exception $e) {
                DB::rollback();
                dd($e);
                $message = _lang('app.error_is_occured');
                return _api_json(new \stdClass(), ['message' => $message],400);
            }
        }
    }

    private function create_user($request) {
        
        $device = Device::updateOrCreate(
                    ['device_id' => $request->input('device_id')],
                    ['device_token' => $request->input('device_token'),'device_type' => $request->input('device_type')]
                );
       
        $User = new User;
       
        $User->name = $request->input('name');
        $User->username = $request->input('username');
        $User->mobile = $request->input('mobile');
        $User->email = $request->input('email');
        $User->password = bcrypt($request->input('password'));
        $User->active = 1;
        $User->type = 1;
        $User->device_id = $device->id;

        $User->save();
       
        return $User;
    }

}
