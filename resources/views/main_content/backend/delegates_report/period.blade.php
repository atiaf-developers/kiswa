@extends('layouts.backend')

@section('pageTitle', _lang('app.period_report'))
@section('breadcrumb')
<li><a href="{{url('admin')}}">{{_lang('app.dashboard')}}</a> <i class="fa fa-circle"></i></li>
<li><span> {{_lang('app.period_report')}}</span></li>

@endsection
@section('js')
<script src="{{url('public/backend/js')}}/delegates_report.js" type="text/javascript"></script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <form method="" id="orders-reports">
            <input type="hidden" name="type" value="{{$type}}">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ _lang('app.filter_by') }}</h3>
                </div>
                <div class="panel-body">

                    <div class="row">


                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="col-sm-3 inputbox utbox control-label">{{ _lang('app.from') }}</label>
                                <div class="col-sm-9 inputbox">

                                    <input type="date" class="form-control" placeholder=""  name="from" value="{{ (isset($from)) ? $from :'' }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-sm-3 inputbox utbox control-label">{{ _lang('app.to') }}</label>
                                <div class="col-sm-9 inputbox">

                                    <input type="date" class="form-control" placeholder=""  name="to" value="{{ (isset($to)) ? $to :'' }}">
                                    <span class="help-block"></span>

                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="col-sm-3 inputbox utbox control-label">{{_lang('app.delegates')}}</label>
                                <div class="col-sm-9 inputbox">
                                    <select class="form-control" name="delegate" id="delegate">
                                        <option value="">{{_lang('app.choose')}}</option>
                                        @foreach($delegates as $one)
                                        <option {{ (isset($delegate) && $delegate==$one->id) ?'selected':''}} value="{{$one->id}}">{{$one->username}}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>


                        </div>
                        <div class="row">





                        </div>









                    </div>
                    <!--row-->
                </div>
                <div class="panel-footer text-center">
                    <button class="btn btn-info submit-form btn-report" type="submit">{{ _lang('app.apply') }}</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{ _lang('app.search_results') }}</h3>
            </div>
            <div class="panel-body">

                <div class="row">
                    @if($log->count()>0)
                    <div class="col-sm-10 col-sm-offset-2"  style="margin-bottom: 10px;">
                        <div class="col-sm-6" style="margin-bottom: 10px;">
                            <span class="label label-sm label-success" style="margin-right: 5px;margin-left: 5px;"> </span> {{_lang('app.discharge')}}
                        </div>
                        <div class="col-sm-6" style="margin-bottom: 10px;">
                            <span class="label label-sm label-danger" style="margin-right: 5px;margin-left: 5px;"> </span>   {{_lang('app.no_discharge')}}

                        </div>

                    </div>
                    <div class="col-sm-12">
                        <table class = "table table-responsive table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>{{_lang('app.day')}}</th>
                                    <th width="90%">{{_lang('app.containers')}}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($log as $day=>$containers)
                                <tr>
                                    <td>{{$day}}</td>
                                    <td>
                                        @if($containers->count()>0)
                                        @foreach($containers as $one)
                                        @php $class=$one->date_of_unloading?'label-success':'label-danger'; @endphp
                                        <p class="label label-sm {{$class}}">{{$one->container_title}}</p>

                                        @endforeach
                                        @else
                                        <span>{{_lang('app.no_containers_assigned_at_this_day')}}</span>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>




                            </tfoot>
                        </table>
                    </div>
                    <div class="text-center">
                        {{ $log->links() }}  
                    </div>
                    @else
                    <p class="text-center">{{_lang('app.no_results')}}</p>
                    @endif


                </div>
                <!--row-->
            </div>

        </div>
    </div>
</div>





<script>
var new_lang = {

};
</script>
@endsection