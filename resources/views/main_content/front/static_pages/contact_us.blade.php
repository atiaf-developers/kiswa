@extends('layouts.front')

@section('pageTitle',_lang('app.contact_us'))

@section('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWYbhmg32SNq225SO1jRHA2Bj6ukgAQtA&libraries=places&language={{App::getLocale()}}"></script>

<script src="{{url('public/front/scripts')}}/map.js" type="text/javascript"></script>
<script src=" {{ url('public/front/scripts') }}/contact.js"></script>
@endsection

@section('content')

<div class="mail-w3ls">
    <div class="container">
        <h1>اتصل بنا</h1>
        <div class="mail-grids">
            <div class="mail-top">
                <div class="col-md-4 mail-grid">
                    <i class="glyphicon glyphicon-map-marker" aria-hidden="true"></i>
                    <h5>العنوان</h5>
                    <p>{{$settings_translations->address}}</p>
                </div>
                <div class="col-md-4 mail-grid">
                    <i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>
                    <h5>الهاتف</h5>
                    <p>{{$settings['phone']->value}}</p>
                </div>
                <div class="col-md-4 mail-grid">
                    <i class="glyphicon glyphicon-envelope" aria-hidden="true"></i>
                    <h5>البريد الالكترونى</h5>
                    <p><a href="#"> {{$settings['email']->value}}</a></p>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="map-w3">
                   <input value="{{$settings['lat']->value}}" type="hidden" id="lat" name="lat">
                <input value="{{$settings['lng']->value}}" type="hidden" id="lng" name="lng">
                <input id="pac-input" class="controls" type="text"
                       placeholder="Enter a location">
                <div id="map" style="height: 500px; width:100%;"></div>
            </div>
            <div class="mail-bottom col-md-7 col-md-offset-2">
                <h1>راسلنا</h1>
                <form action="" novalidate="novalidate" class="contactus" id="contact-form">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-6  {{ $errors->has('name') ? ' has-error' : '' }}">
                            <div style="margin:10px 0;">
                                <input type="text" id="name" name="name" class="form-control" maxlength="100"  value="" placeholder="الهاتف" >
                                <span class="help-block">
                                    @if ($errors->has('name'))
                                    {{ $errors->first('name') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-6  {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <div style="margin:10px 0;">
                                <input type="text" id="phone" name="phone" class="form-control" maxlength="100"  value="" placeholder="الهاتف" >
                                <span class="help-block">
                                    @if ($errors->has('email'))
                                    {{ $errors->first('phone') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12" style="margin:10px 0;">
                                <input type="email" id="email" name="email" class="form-control" maxlength="100"  value="" placeholder="البريد الالكترونى" >
                                <span class="help-block">
                                    @if ($errors->has('email'))
                                    {{ $errors->first('email') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 {{ $errors->has('type') ? ' has-error' : '' }}">
                            <div style="margin:10px 0;"> 
                                <p style="text-align:right; color:#fff; font-size:22px; margin-bottom:15px;">نوع الرسالة</p>
                                <select style="float: right;font-size:1.3em; padding: 5px;" name="type" id="type">
                                    @foreach($types as $one)
                                    <option>{{_lang('app.'.$one)}}</option>
                                    @endforeach
                                </select>
                                <span class="help-block">
                                    @if ($errors->has('type'))
                                    {{ $errors->first('type') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 {{ $errors->has('subject') ? ' has-error' : '' }}">
                            <div style="margin:10px 0;">
                                <input type="text" id="subject" name="subject" class="form-control" maxlength="100" data-msg-required="ضع اسم الموضوع." value="" placeholder="الموضوع">
                                <span class="help-block">
                                    @if ($errors->has('subject'))
                                    {{ $errors->first('subject') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12  {{ $errors->has('message') ? ' has-error' : '' }}">
                            <div style="margin:10px 0;">
                                <textarea id="message" class="form-control" name="message" rows="10" cols="50" data-msg-required="من فضلك اكتب رسالتك" maxlength="5000" placeholder="الرسالة"></textarea>
                                <span class="help-block">
                                    @if ($errors->has('message'))
                                    {{ $errors->first('message') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="margin:10px 0;">
                            <input type="submit" style="background:#1461b8; color:#fff; border:none;" data-loading-text="Loading..." class="submit-form btn btn-default btn-lg" value="ارسال">
                        </div>
                    </div>

                </form>
                <div class="alert alert-success" style="display:{{Session('successMessage')?'block;':'none;'}}; " role="alert"><i class="fa fa-check" aria-hidden="true"></i> <span class="message">{{Session::get('successMessage')}}</span></div>
                <div class="alert alert-danger" style="display:{{Session('errorMessage')?'block;':'none;'}}; " role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="message">{{Session::get('errorMessage')}}</span></div>
            </div>
        </div>
    </div>
</div>



@endsection