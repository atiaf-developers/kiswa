<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Helpers\AUTHORIZATION;
use App\Models\User;
use App\Models\DesignerCategory;
use App\Models\Designer;
use Validator;
use DB;

class UserController extends ApiController {

    public function __construct() {
        parent::__construct();
    }

    public function show() {
        $User = $this->auth_user();
        return _api_json(true, User::transform($User));
    }

    protected function update(Request $request) {
        $User = $this->auth_user();
        $rules = array();
        if ($request->input('name')) {
            $rules['name'] = "required";
        }
        if ($request->input('username')) {
            $rules['username'] = "required|unique:users,username,$User->id";
        }
        if ($request->input('email')) {
            $rules['email'] = "required|email|unique:users,email,$User->id";
        }
        if ($request->input('image')) {
            $rules['image'] = "is_base64image";
        }
        if ($request->input('mobile')) {
            $rules['mobile'] = "required|unique:users,mobile,$User->id";
        }
        if ($request->input('old_password')) {
            $rules['password'] = "required";
            $rules['confirm_password'] = "required|same:password";
        }


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return _api_json('', ['errors' => $errors]);
        } else {

            DB::beginTransaction();
            try {
                if ($request->input('name')) {
                    $User->name = $request->input('name');
                }
                if ($request->input('username')) {
                    $User->username = $request->input('username');
                }
                if ($request->input('email')) {
                    $User->email = $request->input('email');
                }
                if ($request->input('mobile')) {
                    $User->mobile = $request->input('mobile');
                }
                if ($old_password = $request->input('old_password')) {
                    if (!password_verify($old_password, $User->password)) {
                        return _api_json(false, '', ['message' => _lang('app.invalid_old_password')]);
                    } else {
                        $User->password = bcrypt($request->input('password'));
                    }
                }
                if ($request->input('image')) {
                       
                   $file = public_path("uploads/users/$User->image");
                    if (!is_dir($file)) {
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }

                    $User->user_image = img_decoder($request->input('image'), 'users');
                }
                $User->save();        
                $User = User::transform($User);
                DB::commit();
                return _api_json($User, ['message' => _lang('app.updated_successfully')]);
            } catch (\Exception $e) {
                $message = _lang('app.error_is_occured');
                return _api_json(new \stdClass(), ['message' => $e->getMessage() . $e->getLine()]);
            }
        }
    }

    public function raters() {
        return _api_json(Designer::transformCollection(Designer::raters($this->auth_user()->id), 'Raters'));
    }

}
