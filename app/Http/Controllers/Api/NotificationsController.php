<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\AdminNotification;
use App\Models\Device;
use DB;

class NotificationsController extends ApiController {

    public function __construct() {
        parent::__construct();
    }

    public function index(Request $request) {
        $rules['device_id'] = 'required';
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return _api_json([], ['errors' => $errors], 400);
        } else {
            $where_array = array();
            $user = $this->auth_user();
            if ($user) {
                $where_array['user_id'] = $user->id;
            } else {
                $device = Device::where('device_id', $request->input('device_id'))->first();
                $where_array['device_id'] = $user->id;
            }
            $noti = $this->getNoti($where_array);
            return _api_json($this->handleFormateNoti($noti));
        }
    }

    private function getNoti($where_array) {

        $notifications = DB::table('noti_object as n_o')->join('noti as n', 'n.noti_object_id', '=', 'n_o.id');
        $notifications->select('n.id', 'n_o.entity_id', 'n_o.entity_type_id', 'n.notifier_id', 'n_o.created_at', 'n.read_status');
        if ($where_array['user_id']) {
            $query->where('n.notifier_id', $where_array['user_id']);
            $query->where('n_o.notifiable_type', 1);
        }
        if ($where_array['device_id']) {
            $query->where('n.notifier_id', $where_array['device_id']);
            $query->where('n_o.notifiable_type', 3);
        }
        $notifications->orderBy('n_o.created_at', 'DESC');
        $result = $notifications->get();
        $result = $notifications->paginate($this->limit);


        return $result;
    }

    private function handleFormateNoti($noti) {
        $result = array();
        if ($noti->count() > 0) {
            foreach ($noti as $one) {
                $obj = new \stdClass();
                $obj->noti_id = $one->id;
                $obj->id = $one->entity_id;
                $obj->title = '';
                $obj->body = '';
                $obj->type = $one->entity_type_id;
                $obj->created_at = date('d-m-Y   g:i a', strtotime($one->created_at));
                $obj->read_status = $one->read_status;
                $result[] = $obj;
            }
        }
        return $result;
    }


    private function notiMarkAsReadByNotifier($user, $read_status) {
        $sql = "UPDATE noti_object n_o 
                JOIN noti n ON n_o.id = n.noti_object_id And n.read_status=0 And n.notifier_id=$user->id              
                SET n.read_status = $read_status";
        DB::statement($sql);
    }


}
