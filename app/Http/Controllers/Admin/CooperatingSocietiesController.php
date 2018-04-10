<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BackendController;
use App\Models\CooperatingSociety;
use App\Models\CooperatingSocietyTranslation;
use Validator;
use DB;


class CooperatingSocietiesController extends BackendController {

    private $rules = array(
        'image' => 'required|image|mimes:gif,png,jpeg|max:1000',
        'active' => 'required',
        'this_order' => 'required'
    );

    public function __construct() {

        parent::__construct();
        $this->middleware('CheckPermission:cooperating_societies,open', ['only' => ['index']]);
        $this->middleware('CheckPermission:cooperating_societies,add', ['only' => ['store']]);
        $this->middleware('CheckPermission:cooperating_societies,edit', ['only' => ['show', 'update']]);
        $this->middleware('CheckPermission:cooperating_societies,delete', ['only' => ['delete']]);
    }

    public function index(Request $request) {
        return $this->_view('cooperating_societies/index', 'backend');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        return $this->_view('cooperating_societies/create', 'backend');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $columns_arr = array(
            'title' => 'required',
            'description' => 'required'
        );
        $lang_rules = $this->lang_rules($columns_arr);
        $this->rules = array_merge($this->rules, $lang_rules);

        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return _json('error', $errors);
        }
        DB::beginTransaction();
        try {
            $cooperating_society = new CooperatingSociety;
            $cooperating_society->active = $request->input('active');
            $cooperating_society->this_order = $request->input('this_order');
            $cooperating_society->image = CooperatingSociety::upload($request->file('image'), 'cooperating_societies', true);
            
            $cooperating_society->save();
            
            $cooperating_society_translations = array();
            $cooperating_society_title = $request->input('title');
            $cooperating_society_description = $request->input('description');

            foreach ($this->languages as $key => $value) {
                $cooperating_society_translations[] = array(
                    'locale' => $key,
                    'title'  => $cooperating_society_title[$key],
                    'description' => $cooperating_society_description[$key],
                    'cooperating_society_id' => $cooperating_society->id
                );
            }
            CooperatingSocietyTranslation::insert($cooperating_society_translations);
            DB::commit();
            return _json('success', _lang('app.added_successfully'));
        } catch (\Exception $ex) {
             DB::rollback();
            return _json('error', _lang('app.error_is_occured'), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $find = CooperatingSociety::find($id);

        if ($find) {
            return _json('success', $find);
        } else {
            return _json('error', _lang('app.error_is_occured'), 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $cooperating_society = CooperatingSociety::find($id);

        if (!$cooperating_society) {
            return _json('error', _lang('app.error_is_occured'), 404);
        }

        $this->data['translations'] = CooperatingSocietyTranslation::where('cooperating_society_id',$id)->get()->keyBy('locale');
        $this->data['cooperating_society'] = $cooperating_society;

        return $this->_view('cooperating_societies/edit', 'backend');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $cooperating_society = CooperatingSociety::find($id);

        if (!$cooperating_society) {
            return _json('error', _lang('app.error_is_occured'), 404);
        }

        if (!$request->file('image')) {
           unset($this->rules['image']);
        }
        
       $columns_arr = array(
            'title' => 'required',
            'description' => 'required'
        );
        $lang_rules = $this->lang_rules($columns_arr);
        $this->rules = array_merge($this->rules, $lang_rules);

        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return _json('error', $errors);
        }

        DB::beginTransaction();
        try {

            $cooperating_society->active = $request->input('active');
            $cooperating_society->this_order = $request->input('this_order');
            if ($request->file('image')) {
                if ($cooperating_society->image) {
                    $old_image = $cooperating_society->image;
                    CooperatingSociety::deleteUploaded('cooperating_societies', $old_image);
                }
                $cooperating_society->image = CooperatingSociety::upload($request->file('image'), 'cooperating_societies', true);
            }
            $cooperating_society->save();
            
            $cooperating_society_translations = array();

            CooperatingSocietyTranslation::where('cooperating_society_id', $cooperating_society->id)->delete();

            $cooperating_society_title = $request->input('title');
            $cooperating_society_description = $request->input('description');

            foreach ($this->languages as $key => $value) {
                $cooperating_society_translations[] = array(
                    'locale' => $key,
                    'title'  => $cooperating_society_title[$key],
                    'description' => $cooperating_society_description[$key],
                    'cooperating_society_id' => $cooperating_society->id
                );
            }
            CooperatingSocietyTranslation::insert($cooperating_society_translations);

            DB::commit();
            return _json('success', _lang('app.updated_successfully'));
        } catch (\Exception $ex) {
            DB::rollback();
            return _json('error', _lang('app.error_is_occured'), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $cooperating_society = CooperatingSociety::find($id);
        if (!$cooperating_society) {
            return _json('error', _lang('app.error_is_occured'), 404);
        }
        DB::beginTransaction();
        try {
            $cooperating_society->delete();
            DB::commit();
            return _json('success', _lang('app.deleted_successfully'));
        } catch (\Exception $ex) {
            DB::rollback();
            if ($ex->getCode() == 23000) {
                return _json('error', _lang('app.this_record_can_not_be_deleted_for_linking_to_other_records'), 400);
            } else {
                return _json('error', _lang('app.error_is_occured'), 400);
            }
        }
    }

    public function data(Request $request) {

        $cooperating_societies = CooperatingSociety::Join('cooperating_societies_translations', 'cooperating_societies.id', '=', 'cooperating_societies_translations.cooperating_society_id')
                ->where('cooperating_societies_translations.locale', $this->lang_code)
                ->select([
            'cooperating_societies.id', "cooperating_societies_translations.title", "cooperating_societies.this_order", 'cooperating_societies.active',
        ]);

        return \Datatables::eloquent($cooperating_societies)
        ->addColumn('options', function ($item) {

            $back = "";
            if (\Permissions::check('cooperating_societies', 'edit') || \Permissions::check('cooperating_societies', 'delete')) {
                $back .= '<div class="btn-group">';
                $back .= ' <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> options';
                $back .= '<i class="fa fa-angle-down"></i>';
                $back .= '</button>';
                $back .= '<ul class = "dropdown-menu" role = "menu">';
                if (\Permissions::check('cooperating_societies', 'edit')) {
                    $back .= '<li>';
                    $back .= '<a href="' . route('cooperating_societies.edit', $item->id) . '">';
                    $back .= '<i class = "icon-docs"></i>' . _lang('app.edit');
                    $back .= '</a>';
                    $back .= '</li>';
                }

                if (\Permissions::check('cooperating_societies', 'delete')) {
                    $back .= '<li>';
                    $back .= '<a href="" data-toggle="confirmation" onclick = "CooperatingSocieties.delete(this);return false;" data-id = "' . $item->id . '">';
                    $back .= '<i class = "icon-docs"></i>' . _lang('app.delete');
                    $back .= '</a>';
                    $back .= '</li>';
                }

                $back .= '</ul>';
                $back .= ' </div>';
            }
            return $back;
        })
        ->editColumn('active', function ($item) {
                          if ($item->active == 1) {
                          $message = _lang('app.active');
                          $class = 'label-success';
                          } else {
                          $message = _lang('app.not_active');
                          $class = 'label-danger';
                          }
                          $back = '<span class="label label-sm ' . $class . '">' . $message . '</span>';
                          return $back;
                      }) 
                      ->escapeColumns([])
                      ->make(true);
    }

              
}
