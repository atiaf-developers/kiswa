<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AUTHORIZATION;
use App\Models\User;
use App\Models\Device;
use App\Models\DonationRequest;
use DB;

class DonationRequestsController extends ApiController {

    private $step_one_rules = array(
        'images' => 'required',
        'description' => 'required',
        'appropriate_time' => 'required',
        'lat' => 'required',
        'lng' => 'required',
        'donation_type' => 'required', 
        'device_id' => 'required',
        'device_token' => 'required',
        'device_type' => 'required',
    );

    private $step_two_rules = array(
        'name'   => 'required',
        'mobile' => 'required',
    );

    private $step_three_rules = array(
        'name'   => 'required',
        'mobile' => 'required|unique:users',
        'images' => 'required',
        'description' => 'required',
        'appropriate_time' => 'required',
        'lat' => 'required',
        'lng' => 'required',
        'donation_type' => 'required', 
        'device_id' => 'required',
        'device_token' => 'required',
        'device_type' => 'required',
    );

    public function __construct() {
        parent::__construct();
    }

    public function store(Request $request) {
       if ($request->step) {
            if ($request->step == 1) {
                $validator = Validator::make($request->all(), $this->step_one_rules);
                if ($validator->fails()) {
                        $errors = $validator->errors()->toArray();
                        return _api_json(new \stdClass(), ['errors' => $errors], 400);
                }
                return _api_json('');
            }
            else if($request->step == 2){

                $validator = Validator::make($request->all(), $this->step_two_rules);
                if ($validator->fails()) {
                    $errors = $validator->errors()->toArray();
                    return _api_json(new \stdClass(), ['errors' => $errors], 400);
                }
                $verification_code = Random(4);
                return _api_json('',['code' => $verification_code ]);
           }
           else if($request->step == 3){
                    $validator = Validator::make($request->all(), $this->step_three_rules);
                    if ($validator->fails()) {
                        $errors = $validator->errors()->toArray();
                        return _api_json('', ['errors' => $errors], 400);
                    }
                    DB::beginTransaction();
                    try {

                        $this->create_donation_request($request);
                        DB::commit();
                        $message = _lang('app.request_has_been_sent_successfully');
                        return _api_json('', ['message' =>  $message], 201);
                            
                    } catch (\Exception $e) {
                        DB::rollback();
                        $message = _lang('app.error_is_occured');
                        return _api_json('', ['message' => $message],400);
                    }
                }
                else{
                  return _api_json('', ['message' => _lang('app.error_is_occured')], 400);
               } 
       }
       else{
          unset($this->step_one_rules['device_id'],$this->step_one_rules['device_token'],$this->step_one_rules['device_type']);
          $validator = Validator::make($request->all(), $this->step_one_rules);
            if ($validator->fails()) {
                    $errors = $validator->errors()->toArray();
                    return _api_json(new \stdClass(), ['errors' => $errors], 400);
            }

            DB::beginTransaction();
            try {
                    $this->create_donation_request($request);
                    DB::commit();
                    $message = _lang('app.request_has_been_sent_successfully');
                    return _api_json('', ['message' =>  $message], 201);
                            
            } catch (\Exception $e) {
                DB::rollback();
                $message = _lang('app.error_is_occured');
                return _api_json('', ['message' => $message],400);
            }
       } 
    }

    private function create_donation_request($request) {
        
        $donation_request = new DonationRequest;

        $donation_request->description = $request->input('description');
        $donation_request->appropriate_time = $request->input('appropriate_time');
        $donation_request->lat = $request->input('lat');
        $donation_request->lng = $request->input('lng');
        $donation_request->donation_type_id = $request->input('donation_type');
        $donation_images  = json_decode($request->images);
        $images = [];
        foreach ($donation_images as $image) {
            $images[] = img_decoder($image, 'donation_requests');
        }
        $donation_request->images = json_encode($images);
        if ($this->auth_user()) {
            $donation_request->name = $this->auth_user()->name;
            $donation_request->mobile =  $this->auth_user()->mobile;
            $donation_request->device_id =  $this->auth_user()->device_id;

        }else{
            $donation_request->name = $request->input('name');
            $donation_request->mobile = $request->input('mobile');
            $device = Device::updateOrCreate(
                    ['device_id' => $request->input('device_id')],
                    ['device_token' => $request->input('device_token'),'device_type' => $request->input('device_type')]
            );
            $donation_request->device_id =  $device->id;
        }
        $donation_request->save(); 
    }

}
