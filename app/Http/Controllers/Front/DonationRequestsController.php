<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use App\Models\DonationType;
use Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use DB;
use App\Models\Rate;

class DonationRequestsController extends FrontController {

    private $rules = array(
        'donation_type' => 'required',
        'name' => 'required',
        'mobile' => 'required',
        'lat' => 'required',
        'lng' => 'required',
        'description' => 'required',
        'appropriate_time' => 'required',
        'images.*' => 'required|image|mimes:gif,png,jpeg',
    );

    public function __construct() {
        parent::__construct();
    }

    public function showDonationRequestForm() {
        $this->data['donation_types'] = DonationType::Join('donation_types_translations', 'donation_types.id', '=', 'donation_types_translations.donation_type_id')
                ->where('donation_types_translations.locale', $this->lang_code)
                ->where('donation_types.active', true)
                ->orderBy('donation_types.this_order', 'asc')
                ->select("donation_types.id", "donation_types_translations.title")
                ->get();
        //dd( $this->data['donation_types']);
        return $this->_view('donation_requests.index');
    }

    public function submitDonationRequestForm(Request $request) {
        //dd($request->file('images'));

        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
       
           
            $this->errors = $validator->errors()->toArray();
            if ($request->ajax()) {
                return _json('error', $this->errors);
            } else {
                return redirect()->back()->withInput($request->all())->withErrors($this->errors);
            }
        }

        try {

            $message = _lang('app.registered_done_successfully');
            if ($request->ajax()) {
                return _json('success', $message);
            } else {
                return redirect()->back()->withInput($request->all())->with(['successMessage' => $message]);
            }
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            $message = _lang('app.error_is_occured');
            if ($request->ajax()) {
                return _json('error', $message);
            } else {
                return redirect()->back()->withInput($request->all())->with(['errorMessage' => $message]);
            }
        }
    }

}
