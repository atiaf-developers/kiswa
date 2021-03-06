@extends('layouts.backend')

@section('pageTitle',_lang('app.add_video'))

@section('breadcrumb')
<li><a href="{{url('admin')}}">{{_lang('app.dashboard')}}</a> <i class="fa fa-circle"></i></li>
<li><a href="{{route('videos.index')}}">{{_lang('app.videos')}}</a> <i class="fa fa-circle"></i></li>
<li><span> {{_lang('app.add_videos')}}</span></li>
@endsection

@section('js')
<script src="{{url('public/backend/js')}}/videos.js" type="text/javascript"></script>
@endsection
@section('content')
<form role="form"  id="addEditVideosForm" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{_lang('app.video_title') }}</h3>
        </div>
        <div class="panel-body">


            <div class="form-body">
                <input type="hidden" name="id" id="id" value="0">

                @foreach ($languages as $key => $value)

                <div class="form-group form-md-line-input col-md-6">

                    <input type="text" class="form-control" id="title[{{ $key }}]" name="title[{{ $key }}]" value="">

                    <label for="title">{{_lang('app.title') }} {{ _lang('app.'.$key) }}</label>
                    <span class="help-block"></span>

                </div>

                @endforeach


            </div>
        </div>


    </div>


    <div class="panel panel-default">

        <div class="panel-body">


            <div class="form-body">

                <div class="form-group form-md-line-input col-md-6">
                    <input type="hidden" name="youtube_url" id="youtube_url" value="">
                    <input type="text" class="form-control" id="url" name="url" value="">
                    <label for="url">{{_lang('app.url') }}</label>
                    <span class="help-block"></span>

                </div>

                <div id="youtube-iframe" class="col-md-12">

                </div>

                <div class="form-group form-md-line-input col-md-3">
                    <input type="number" class="form-control" id="this_order" name="this_order" value="">
                    <label for="this_order">{{_lang('app.this_order') }}</label>
                    <span class="help-block"></span>
                </div>

                <div class="form-group form-md-line-input col-md-2">
                    <select class="form-control edited" id="active" name="active">
                        <option  value="1">{{ _lang('app.active') }}</option>
                        <option  value="0">{{ _lang('app.not_active') }}</option>
                    </select>
                     <label for="status">{{_lang('app.status') }}</label>
                    <span class="help-block"></span>
                </div> 



                
                

            </div>
        </div>

        <div class="panel-footer text-center">
            <button type="button" class="btn btn-info submit-form"
                    >{{_lang('app.save') }}</button>
        </div>


    </div>


</form>
<script>
var new_lang = {

};
var new_config = {
   
};

</script>
@endsection