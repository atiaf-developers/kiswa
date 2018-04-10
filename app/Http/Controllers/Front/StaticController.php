<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use App\Models\ContactMessage;
use App\Models\Offer;
use App\Models\Game;
use Validator;

class StaticController extends FrontController {

    private $contact_rules = array(
        'email' => 'required|email',
        'subject' => 'required',
        'message' => 'required',
        'type' => 'required',
        'phone' => 'required',
        'name' => 'required',
    );

    public function __construct() {
        parent::__construct();
    }

    public function about_us() {
        return $this->_view('static_pages/about_us');
    }

    public function policy() {
        return $this->_view('static_pages/policy');
    }

    public function contact_us() {
        $this->data['types'] = ContactMessage::$types;
        return $this->_view('static_pages/contact_us');
    }

    public function offers() {
        $this->data['offers'] = $this->getGames('offers_page');
        //dd($this->data['offers']);
        return $this->_view('static_pages/offers');
    }

    public function sendContactMessage(Request $request) {
        $validator = Validator::make($request->all(), $this->contact_rules);
        if ($validator->fails()) {
            if ($request->ajax()) {

                $errors = $validator->errors()->toArray();
                return response()->json([
                            'type' => 'error',
                            'errors' => $errors
                ]);
            } else {
                return redirect()->back()->withInput()->withErrors($validator->errors()->toArray());
            }
        } else {
            try {
                $ContactMessage = new ContactMessage;
                $ContactMessage->name = $request->input('name');
                $ContactMessage->phone = $request->input('phone');
                $ContactMessage->subject = $request->input('subject');
                $ContactMessage->message = $request->input('message');
                $ContactMessage->type = $request->input('type');
                $ContactMessage->save();
                $message = _lang('app.sent_successfully');
                if ($request->ajax()) {
                    return _json('success', $message);
                } else {
                    return redirect()->back()->withInput($request->all())->with(['successMessage' => $message]);
                }
            } catch (\Exception $ex) {
                $message = _lang('app.error_is_occured');
                if ($request->ajax()) {
                    return _json('error', $message);
                } else {
                    return redirect()->back()->withInput($request->all())->with(['errorMessage' => $message]);
                }
            }
        }
    }

   

}
