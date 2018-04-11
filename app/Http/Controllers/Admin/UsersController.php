<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BackendController;
use App\Models\User;
use App\Models\Massage;
use App\Models\Chat;
use App\Models\Jobs;
use App\Models\ConsultationGroup;
use Validator;

class UsersController extends BackendController {

    private $rules = array(
        'fullname' => 'required',
        'username' => 'required|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'mobile' => 'required|unique:users,mobile',
        'password' => 'required',
        'user_image' => 'required|image|mimes:gif,png,jpeg|max:1000',
    );
    private $ruels_page;
    public function __construct() {

        parent::__construct();
        $page=$_GET['type'];

        if($page=='delegates'){
          $this->ruels_page='delegates';
        }else{
          $this->ruels_page='clients';
        }
        $this->middleware('CheckPermission:'.$this->ruels_page.',open');
        $this->middleware('CheckPermission:'.$this->ruels_page.',add', ['only' => ['store']]);
        $this->middleware('CheckPermission:'.$this->ruels_page.',edit', ['only' => ['show', 'update']]);
        $this->middleware('CheckPermission:'.$this->ruels_page.',delete', ['only' => ['delete']]);
    }

    public function index(Request $request) {
        $page=$request->input('type');

        if($page=='clients'){
          $this->data['type']=1;
          return $this->_view('users/index', 'backend');
        }else{
          $this->data['type']=2;
          return $this->_view('worker/index', 'backend');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return _json('error', $errors);
        } else {
            $image=User::upload($request->file('user_image'), 'users',true);
            $User = new User;
            $User->fullname = $request->input('fullname');
            $User->username = $request->input('username');
            $User->email = $request->input('email');
            $User->mobile = $request->input('mobile');
            $User->password = bcrypt($request->input('password'));
            $User->active = $request->input('active');
            $User->type = $request->input('type');
            $User->user_image = $image;
            try {
                $User->save();
                return _json('success', _lang('app.added_successfully'));
            } catch (Exception $ex) {
                return _json('error', _lang('app.error_is_occured'));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $User = User::find($id);

        if ($User != null) {
            $User=User::transform($User);
            $Massage=Massage::whereNull('from_id')->where('to_id',$id)->first();
            if($Massage){
                $User->msg_id=$Massage->id;
            }else{
                $Massage=new Massage;
                $Massage->to_id=$id;
                $Massage->chat='';
                $Massage->save();
                $Massage=Massage::whereNull('from_id')->where('to_id',$id)->first();
                $User->msg_id=$Massage->id;

            }
            // dd($User);
            return _json('success', $User);
        } else {
            return _json('error', _lang('app.error_is_occured'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id) {
    //   echo $id;die;
        $User = User::find($id);
        if (!$User) {
            return _json('error', _lang('app.error_is_occured'));
        }
        if ($request->file('user_image')) {
            $rules['user_image'] = 'required|image|mimes:gif,png,jpeg|max:1000';
        }
        $rules['username'] = "required|unique:users,username,$User->id";
        $rules['email'] = "required|unique:users,email,$User->id";
        $rules['mobile'] = "required|unique:users,mobile,$User->id";
        if ($request->input('password') === null) {
            unset($rules['password']);
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return _json('error', $errors);
        } else {
          $User->fullname = $request->input('fullname');
          $User->username = $request->input('username');
          $User->email = $request->input('email');
          $User->mobile = $request->input('mobile');
            if ($request->input('password')) {
                $User->password = bcrypt($request->input('password'));
            }
            $User->active = $request->input('active');
            if ($request->file('user_image')) {
                $old_image = $User->user_image;
                $file = public_path("uploads/users/$old_image");
                if (!is_dir($file)) {
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $User->user_image = $this->_upload($request->file('user_image'), 'users');
            }
        
        
            try {
                $User->save();
                return _json('success', _lang('app.updated_successfully'));
            } catch (Exception $ex) {
                return _json('error', _lang('app.error_is_occured'));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id) {
        $User = User::find($id);
        if ($User == null) {
            return _json('error', _lang('app.error_is_occured'));
        }
        try {

            $files = array(
                public_path("uploads/users/$User->image"),
            );
            foreach ($files as $file) {
                if (!is_dir($file)) {
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }
            $User->delete();
            return _json('success', _lang('app.deleted_successfully'));
        } catch (Exception $ex) {
            return _json('error', _lang('app.error_is_occured'));
        }
    }
    public function data(Request $request) {
        $type = $request->input('type');
        $user = User::where('type', $type)->select('id', 'email', 'type', 'username', 'mobile', 'active','image')
        ->where('type',$type);

        return \Datatables::eloquent($user)
                ->addColumn('options', function ($item){
                    if($item->type==1){
                        $js='Users';
                    }else{
                        $js='Delegates';
                    }
                    $back = "";

                        if (\Permissions::check($this->ruels_page, 'edit') || \Permissions::check($this->ruels_page, 'delete')) {
                            $back .= '<div class="btn-group">';
                            $back .= ' <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> options';
                            $back .= '<i class="fa fa-angle-down"></i>';
                            $back .= '</button>';
                            $back .= '<ul class = "dropdown-menu" role = "menu">';
                            if (\Permissions::check($this->ruels_page, 'edit')) {
                                $back .= '<li>';
                                $back .= '<a href="" onclick = "'.$js.'.edit(this);return false;" data-id = "' . $item->id . '">';
                                $back .= '<i class = "icon-docs"></i>' . _lang('app.show_data');
                                $back .= '</a>';
                                $back .= '</li>';
                            }
                            if (\Permissions::check($this->ruels_page, 'delete')) {
                                $back .= '<li>';
                                $back .= '<a href="" data-toggle="confirmation" onclick = "'.$js.'.delete(this);return false;" data-id = "' . $item->id . '">';
                                $back .= '<i class = "icon-docs"></i>' . _lang('app.delete');
                                $back .= '</a>';
                                $back .= '</li>';
                            }
                            $back .= '</ul>';
                            $back .= ' </div>';
                        }


                    return $back;
                })
                ->addColumn('active', function ($item) {
                    if($item->type==1){
                        $js='Users';
                    }else{
                        $js='Worker';
                    }
                    if ($item->active == 1) {
                        $message = _lang('app.active');
                        $class = 'btn-info';
                    } else {
                        $message = _lang('app.not_active');
                        $class = 'btn-danger';
                    }
                    $back = '<a class="btn ' . $class . '" onclick = "'.$js.'.status(this);return false;" data-id = "' . $item->id . '" data-status = "' . $item->active . '">' . $message . ' <a>';
                    return $back;
                })
                ->addColumn('image', function ($item) {
                    $back = '<img src="' . url('public/uploads/users/' . $item->image) . '" style="height:64px;width:64px;"/>';
                    return $back;
                })
                ->escapeColumns([])
                ->make(true);
    }
    // public function get_country(){
    //   $Countrys = Country::select([
    //     'id', "title_en","title_ar", "this_order", 'active', 'image','country_id'
    //   ])->whereNull('country_id')->get();
    // }
    public function get_city($id){

    }
    public function get_state($id){

    }
    // public function get_jobs(){
    //   $jobs = Jobs::select([
    //               'id', "title_ar", "title_en", "this_order", 'active','main_job'
    //   ])->whereNull('main_job')->get();
    //   return $jobs;
    // }
    // public function First_subJob(){
    //   $jobs = Jobs::select([
    //               'id', "title_ar", "title_en", "this_order", 'active','main_job'
    //   ])->whereNotNull('main_job')->get();
    //   return $jobs;
    // }
    // public function get_subJob($id){
    //   $jobs = Jobs::select([
    //               'id', "title_ar", "title_en", "this_order", 'active'
    //   ])->where('main_job',$id);
    // }


}
