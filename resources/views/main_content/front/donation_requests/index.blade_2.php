@extends('layouts.front')

@section('pageTitle',_lang('app.donation_request'))

@section('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWYbhmg32SNq225SO1jRHA2Bj6ukgAQtA&libraries=places&language={{App::getLocale()}}"></script>

<script src="{{url('public/front/scripts')}}/map.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.0/moment-with-locales.min.js"></script>
<script src=" {{ url('public/front/js') }}/datetimepicker.js"></script>
<script src=" {{ url('public/front/scripts') }}/donation_request.js"></script>
@endsection

@section('content')

<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">شكرا لك</h4>
            </div>
            <div class="modal-body">
                <h3>
                    سوف يأتى إليك المندوب لأستلام التبرع</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default submit-form" data-dismiss="modal">حسنا</button>
            </div>
        </div>

    </div>
</div>
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="title">
                    <h2>{{ _lang('app.create_a _donation_request') }}</h2>
                </div>
                <div class="login-area">
                    <div class="form-w3agile margin">
                        <form id="regForm">
                            {{ csrf_field() }}
                            <img class="user" src="{{ url('public/front/img') }}/order.png" alt="" >
                            <!-- One "tab" for each step in the form: -->
                            <div class="tab">

                                <div class="tab-details">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label color">{{ _lang('app.donation_type') }}</label>
                                                <select class="form-control" name="donation_type">
                                                    <option value="">{{_lang('app.choose')}}</option>
                                                    @foreach($donation_types as $one)
                                                    <option value="{{$one->id}}">{{$one->title}}</option>
                                                    @endforeach

                                                </select>
                                                <span class="help-block">
                                                    @if ($errors->has('name'))
                                                    {{ $errors->first('name') }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group"> 
                                            <div class="col-md-12">
                                                <label class="control-label color">{{ _lang('app.detailes') }}</label>
                                                <textarea class="form-control" id="description" name="description" rows="4" cols="50"></textarea>
                                                <span class="help-block">
                                                    @if ($errors->has('description'))
                                                    {{ $errors->first('description') }}
                                                    @endif
                                                </span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group"> 
                                            <div class="col-md-12">
                                                <div>
                                                    <label class="control-label color">{{ _lang('app.specify_an_appointment') }}</label>
                                                    <div  class="form-control" id="appropriate_time"> </div>
                                                    <input type="hidden" id="result" name="appropriate_time" value="" />
                                                    <span class="help-block">
                                                        @if ($errors->has('appropriate_time'))
                                                        {{ $errors->first('appropriate_time') }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label color">{{ _lang('app.attach_maximum_4_photos') }}</label>
                                                <input type="file" name="images[]" id="images" multiple>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab">
                                @if(!$User)
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label color">{{_lang('app.name')}}</label>
                                            <input type="text" class="form-control " name="name">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="row">
                                            <p class="num-code" style="margin-top: 30px;">+966</p>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="control-label color">{{_lang('app.mobile')}}</label>
                                            <input type="hidden"  name="dial_code" value="966">
                                            <input type="text" class="form-control " name="mobile" id="mobile">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <input type="hidden" id="lat" name="lat">
                                        <input type="hidden" id="lng" name="lng">
                                        <span class="help-block"></span>

                                    </div>
                                    <div class="col-md-12">
                                        <input id="pac-input" class="controls" type="text"
                                               placeholder="{{_lang('app.enter_location')}}" style="height: 30px;width: 30%;">
                                        <div id="map" style="height: 500px; width:100%;"></div>
                                    </div>

                                </div>

                            </div>
                            @if(!$User)
                            <div class="tab">
                                <div class="alert alert-success" style="display:{{Session('successMessage')?'block;':'none;'}}; " role="alert"><i class="fa fa-check" aria-hidden="true"></i> <span class="message">{{Session::get('successMessage')}}</span></div>
                                <div class="row form-w3agile">
                                    <h3 class="h3-dir">{{ _lang('app.you_will_receive_a_text_message_with_activation_code_on_your_mobile_number') }} <span id="mobile-message"></span> <a href="#" class="change-num" onclick="DonationRequest.nextPrev(this, -1)">
                                            {{ _lang('app.change_number') }}
                                        </a></h3>
                                    <div class="form-group col-sm-3 inputbox">
                                        <input type="text" class="form-control text-center" name="code[0]" placeholder="0">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group col-sm-3 inputbox">
                                        <input type="text" class="form-control text-center" name="code[1]" placeholder="0">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group col-sm-3 inputbox">
                                        <input type="text" class="form-control text-center" name="code[2]" placeholder="0">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group col-sm-3 inputbox">
                                        <input type="text" class="form-control text-center" name="code[3]" placeholder="0">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="msg-error" style="display: none;">
                                        <span id="activation-code-message" ></span>
                                    </div>
                                    <a class="a-signin" href="#" onclick="Main.resend_code(this);return false;"><strong>{{ _lang('app.send_the_code_again') }}</strong></a>
                                </div>
                            </div>
                            @endif

                            <div class="tab">
                                <div class="alert alert-success" style="display:{{Session('successMessage')?'block;':'none;'}}; " role="alert"><i class="fa fa-check" aria-hidden="true"></i> <span class="message">{{Session::get('successMessage')}}</span></div>
                                <div class="alert alert-danger" style="display:{{Session('errorMessage')?'block;':'none;'}}; " role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="message">{{Session::get('errorMessage')}}</span></div>
                            </div>
                            <div class="next2">
                                <button type="button" id="nextBtn" data-type="next" onclick="DonationRequest.nextPrev(this, 1)">التالى</button>
                                <button type="button" id="prevBtn" data-type="prev" onclick="DonationRequest.nextPrev(this, -1)">السابق</button>
                            </div>
                            <!-- Circles which indicates the steps of the form: -->
                            <div class="steps">
                                <span class="step"></span>
                                <span class="step"></span>
                                @if(!$User)
                                <span class="step"></span>
                                @endif
                                <span class="step"></span>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>



@endsection