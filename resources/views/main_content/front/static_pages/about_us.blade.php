@extends('layouts.front')

@section('pageTitle',_lang('app.about_us'))

@section('js')
	
@endsection

@section('content')

   <div class="content-details">
                <div class="container">
                    <div class="col-md-12">
                        <h1>من نحن</h1>
                        <div class="col-md-5">
                            <img src="{{url('public/uploads/m_'.substr($settings['about_image']->value, strpos($settings['about_image']->value, '_') + 1))}}" class="img-responsive" alt="" />
                        </div>
                        <div class="col-md-7">
                            <p>{{$settings_translations->about}}</p>
                        </div>
                    </div>
                </div>
            </div>


	
@endsection