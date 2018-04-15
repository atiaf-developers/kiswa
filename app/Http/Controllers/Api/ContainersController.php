<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Validator;
use App\Models\Container;
use App\Models\UnloadContainer;
use DatePeriod;
use DateTime;
use DateInterval;
use DB;

class ContainersController extends ApiController
{
    public function __construct() {
        parent::__construct();
    }

    public function index(Request $request)
    {
        try {
            $user = $this->auth_user();
            $lat = $request->input('lat');
            $lng = $request->input('lng');

            $delegate_containers = Container::leftJoin('unloaded_containers','unloaded_containers.container_id','=','containers.id')
            ->join('containers_translations','containers_translations.container_id','=','containers.id')
            ->where('containers.delegate_id',$user->id)
            ->where('unloaded_containers.date_of_unloading')
            ->where('containers_translations.locale',$this->lang_code)
            ->select('containers.id','containers_translations.title','containers_translations.address','containers.lat','containers.lng',DB::raw($this->iniDiffLocations('containers',$lat,$lng)),'unloaded_containers.id as status')
            ->orderBy('distance')
            ->paginate($this->limit);

            return _api_json(Container::transformCollection($delegate_containers));
        } catch (\Exception $e) {
            dd($e);
            $message = _lang('app.error_is_occured');
            return _api_json('', ['message' => $message],400);
        }
    }

    public function Logdump(Request $req){
       $rules = array(
            'container_id' => 'required',
        );
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return _api_json(new \stdClass(), ['errors' => $errors], 400);
        }
        $startDate=$req->startdate;
        if(!$startDate){
            $startDate=date('Y-m-d', strtotime(date('Y-m-d')));
        }
        $start    = new DateTime($startDate);
        $end      = new DateTime(date('Y-m-d',strtotime('1-3-2018')));   
        $diff = $end->diff($start);
        $interval = \DateInterval::createFromDateString('-1 day');
        $dateRange = new \DatePeriod($start, $interval, $diff->days);
        $User = $this->auth_user();
        $countainer=UnloadContainer::where('delegate_id',$User->id)
        ->where('container_id',$req->container_id)
        ->get();
        $loadedDates = $countainer->pluck('date_of_unloading')->toArray();
        $count=1;
        foreach ($dateRange as $date) {
            if($count>10){
                break;
            }
            if(date('Y-m-d',strtotime($date->format('Y-m-d'))) == $end){
                break;
            }
            $range['date'] = $date->format('Y-m-d');
            if(in_array($range['date'],$loadedDates)){
                $range['load']=true;
            }else{
                $range['load']=false;
            }
            $result[]=$range;
            $count++;
        }
        return _api_json($result);
    }
}
