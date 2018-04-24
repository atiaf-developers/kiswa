<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Validator;
use App\Models\Container;
use App\Models\UnloadContainer;
use App\Models\ContainerAssignedHistory;
use DatePeriod;
use DateTime;
use DateInterval;
use DB;

class ContainersController extends ApiController {

    private $rules = array(
        'container_id' => 'required'
    );

    public function __construct() {
        parent::__construct();
    }

    public function index(Request $request) {
        try {
            $user = $this->auth_user();
            $lat = $request->input('lat');
            $lng = $request->input('lng');
            $delegate_containers = Container::leftJoin('unloaded_containers', function ($join) {
                        $join->on('unloaded_containers.container_id', '=', 'containers.id')
                        ->whereDate('unloaded_containers.date_of_unloading', date('Y-m-d'));
                    })
                    ->join('containers_translations', 'containers_translations.container_id', '=', 'containers.id')
                    ->where('containers.delegate_id', $user->id)
                    ->where('containers_translations.locale', $this->lang_code)
                    ->select('containers.id', 'containers_translations.title', 'containers_translations.address', 'containers.lat', 'containers.lng', DB::raw($this->iniDiffLocations('containers', $lat, $lng)), 'unloaded_containers.id as status')
                    ->orderBy('distance')
                    ->groupBy('containers.id')
                    ->paginate($this->limit);
            return _api_json(Container::transformCollection($delegate_containers));
        } catch (\Exception $e) {
            $message = _lang('app.error_is_occured');
            return _api_json('', ['message' => $message], 400);
        }
    }

    public function unload_container(Request $request) {
        try {
            $validator = Validator::make($request->all(), $this->rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return _api_json(new \stdClass(), ['errors' => $errors], 400);
            }
            $user = $this->auth_user();
            $container = Container::find($request->input('container_id'));
            if (!$container) {
                return _api_json('', ['message' => _lang('app.not_found')], 404);
            }
            $unlaod_container = new UnloadContainer();
            $unlaod_container->container_id = $request->input('container_id');
            $unlaod_container->delegate_id = $user->id;
            $unlaod_container->date_of_unloading = date('Y-m-d');
            $unlaod_container->save();

            return _api_json('', ['message' => _lang('app.updated_successfully')]);
        } catch (\Exception $e) {
            $message = _lang('app.error_is_occured');
            return _api_json('', ['message' => $message], 400);
        }
    }

    public function Logdump(Request $req) {
        $User = $this->auth_user();
        $rules = array(
            'container_id' => 'required',
        );
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return _api_json(new \stdClass(), ['errors' => $errors], 400);
        }
        $startDate = $req->startdate;
        if (!$startDate) {
            $startDate = date('Y-m-d', strtotime(date('Y-m-d')));
        }

        $last_assign_date = ContainerAssignedHistory::where('container_id',$req->container_id)->where('delegate_id',$User->id)->where('end',null)->first();

        $start = new DateTime($startDate);
        $end = new DateTime(date('Y-m-d', strtotime($last_assign_date->start)));
        $diff = $end->diff($start);
        $interval = \DateInterval::createFromDateString('-1 day');
        $dateRange = new \DatePeriod($start, $interval, $diff->days);
        
        $days = 10;
        $Pageination_date = strtotime("-" . $days . " days", strtotime($start->format('Y-m-d')));

        $countainer = UnloadContainer::where('delegate_id', $User->id)
                ->where('container_id', $req->container_id)
                ->whereBetween('date_of_unloading', [date('Y-m-d', $Pageination_date), $start])
                ->get();
        $loadedDates = $countainer->pluck('date_of_unloading')->toArray();
        $count = 1;

        foreach ($dateRange as $date) {
            if ($count > 10) {
                break;
            }
            if (date('Y-m-d', strtotime($date->format('Y-m-d'))) == $end) {
                break;
            }
            if ($this->lang_code == 'ar') {
                $range['date'] = ArabicDateSpecial($date->format('l ,F j , Y h:i A'), false);
            } else {
                $range['date'] = $date->format('l ,F j , Y');
            }
            if (in_array(date('Y-m-d', strtotime($date->format('Y-m-d'))), $loadedDates)) {
                $range['load'] = true;
            } else {
                $range['load'] = false;
            }
            $range['date_sended'] = $date->format('Y-m-d');
            $result[] = $range;
            $count++;
        }
        return _api_json($result, ['end_date' => date('Y-m-d', strtotime('1-3-2018'))]);
    }

}
