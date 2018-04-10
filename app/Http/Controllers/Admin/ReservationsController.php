<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Pagination\LengthAwarePaginator;
use App;
use Auth;
use DB;
use Redirect;
use Validator;
use App\Models\User;
use App\Models\Reservation;
use PDF;

class ReservationsController extends BackendController {

    private $limit = 10;

    public function __construct() {


        parent::__construct();
        $this->middleware('CheckPermission:reservations,open', ['only' => ['index']]);
    }

    public function index(Request $request) {
        //$pdf = PDF::loadView('pdf.document', []);
        // dd($pdf);
        if ($request->all()) {
            foreach ($request->all() as $key => $value) {

                if ($value) {
                    $this->data[$key] = $value;
                }
            }
        }
        $this->data['reservations'] = $this->getReservations($request);
        $this->data['info'] = $this->getInfo($request);
        $this->data['users'] = $this->getUsers();
        return $this->_view('reservations.index', 'backend');
    }

    private function getReservations($request, $id = false) {


        $reservations = Reservation::join('games', 'games.id', '=', 'reservations.game_id');
        $reservations->join('games_translations as trans', 'games.id', '=', 'trans.game_id');
        $reservations->join('categories', 'categories.id', '=', 'games.category_id');
        $reservations->join('users', 'users.id', '=', 'reservations.user_id');
        $reservations->select([
            'reservations.id', "users.username","trans.title as game_title",
            "reservations.price", "reservations.overtime_price", "reservations.created_at", "reservations.date"
        ]);
         $reservations->where('trans.locale', $this->lang_code);
        if (!$id) {
            $reservations = $this->handleWhere($reservations, $request);
            $reservations->orderBy('reservations.created_at', 'DESC');
            return $reservations->paginate($this->limit)->appends($request->all());
        } else {
            $reservations->where("reservations.id", $id);
            return $reservations->first();
        }

        //$bills->orderBy('bills.creatsed_at','DESC');
    }

    private function getInfo($request) {
        $reservations = Reservation::join('games', 'games.id', '=', 'reservations.game_id');
        $reservations->join('categories', 'categories.id', '=', 'games.category_id');
        $reservations->join('users', 'users.id', '=', 'reservations.user_id');
 

        $reservations = $this->handleWhere($reservations, $request);
        $reservations->select(DB::raw('sum(reservations.price+reservations.overtime_price) as total_price'));

        return $reservations->first();
    }

    private function getUsers() {
        $Users = User::select('id', "username")->get();
        return $Users;
    }

    private function handleWhere($reservations, $request) {

        if ($request->all()) {
            if ($from = $request->input('from')) {
                $reservations->where("reservations.date", ">=", "$from");
            }
            if ($to = $request->input('to')) {
                $reservations->where("reservations.date", "<=", "$to");
            }
            if ($user = $request->input('user')) {
                $reservations->where("reservations.user_id", $user);
            }
            if ($reservation = $request->input('reservation')) {
                $reservations->where("reservations.id", $reservation);
            }
        }
        return $reservations;
    }

}
