@extends('layouts.front')

@section('pageTitle',_lang('app.policy') )

@section('js')
	
@endsection

@section('content')

    <div class="content-details">
                <div class="container">
                    <div class="col-md-12">
                        <h1>سياسة الاستخدام</h1>
                        <p>{{$settings_translations->policy}}</p>
                    </div>
                </div>
            </div>


	
@endsection