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
                $User->save();
                if ($User->type == 2) {
                    $Client = $User->client;
                    if ($request->input('fname')) {
                        $Client->fname = $request->input('fname');
                    }
                    if ($request->input('lname')) {
                        $Client->lname = $request->input('lname');
                    }
                    if ($request->input('image')) {
                        //dd($request->input('image'));
                        $Client->image = $this->_upload($request->input('image'), 'users', true, '\App\Models\User', false, true);
                    }
                    $Client->save();
                    $User = User::transformClient($User);
                } else if ($User->type == 3) {
                    $Designer = $User->designer;
                    if ($request->input('responsible_person_name')) {
                        $Designer->responsible_person_name = $request->input('responsible_person_name');
                    }
                    if ($request->input('trade_name')) {
                        $Designer->trade_name = $request->input('trade_name');
                    }
                    if ($request->input('about')) {
                        $Designer->about = $request->input('about');
                    }
                    if ($request->input('lat')) {
                        $Designer->lat = $request->input('lat');
                    }
                    if ($request->input('lng')) {
                        $Designer->lng = $request->input('lng');
                    }
                    if ($request->input('image')) {
                        $Designer->image = $this->_upload($request->input('image'), 'users', true, '\App\Models\User', false, true);
                    }
                    $Designer->save();
                    $categories = json_decode($request->input('categories'));
                    $data = array();
                    foreach ($categories as $category) {
                        $where_arr = [
                            'category_id' => $category,
                            'designer_id' => $Designer->id,
                        ];
                        $data_arr = [
                            'category_id' => $category,
                            'designer_id' => $Designer->id,
                        ];
                        DesignerCategory::updateOrCreate($where_arr, $data_arr);
                    }
                    $User = User::transformDesigner($User);
                }

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
