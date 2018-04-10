@extends('layouts.front')

@section('pageTitle',_lang('app.reservation'))



@section('js')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWYbhmg32SNq225SO1jRHA2Bj6ukgAQtA&libraries=places&language={{App::getLocale()}}"></script>

<script src="{{url('public/front/scripts')}}/map.js" type="text/javascript"></script>

<script src=" {{ url('public/front/scripts') }}/game.js"></script>
@endsection

@section('content')

<div class="content-details">
    <div class="container">
        <div class="col-md-12">
            <h1>احجز الأن</h1>
            <form action="" novalidate="novalidate" class="contactus" id="reserve-form" style="border-right:1px solid #292c35;">
                <input type="hidden" name="game_id" id="game_id" value="{{base64_encode($game->id)}}">
                <div class="col-md-6">
                    <h2>أدخل بياناتك</h2>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-lg-6 ">
                                <input type="text" id="name" name="name" class="form-control" maxlength="100" data-msg-required="من فضلك ضع اسمك" value="" placeholder="الاسم" >
                                <span class="help-block">
                                    @if ($errors->has('name'))
                                    {{ $errors->first('name') }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                            <div class="col-lg-6 ">
                                <input type="text" id="phone" name="phone" class="form-control" maxlength="100" data-msg-required="ضع رقم الهاتف" value="" placeholder="رقم الهاتف">
                                <span class="help-block">
                                    @if ($errors->has('phone'))
                                    {{ $errors->first('phone') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="email" id="email" name="email" class="form-control" maxlength="100" data-msg-email="من فضلك ضع بريدك الالكترونى" data-msg-required="Please enter your email address." value="" placeholder="البريد الالكترونى" >
                                <span class="help-block">
                                    @if ($errors->has('email'))
                                    {{ $errors->first('email') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--                    <div class="row">
                                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                                <input value="" type="text" style="display: none;" id="lat" name="lat">
                                                <input value="" type="hidden" id="lng" name="lng">
                                                <span class="help-block">
                                                    @if ($errors->has('email'))
                                                    {{ $errors->first('email') }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>-->



                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <input value="" type="hidden"  id="lat" name="lat">
                                <input value="" type="hidden" id="lng" name="lng">
                                <input id="pac-input" class="controls" type="text" placeholder="Enter a location">
                                <div id="map" style="height: 500px; width:100%;"></div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <input type="submit" style="background:#1461b8; border:none; color:#fff;" data-loading-text="Loading..." class="btn btn-default btn-lg submit-form" value="حجز">
                        </div>
                    </div>


                </div>
                <div class="col-md-6">
                    <h2>الاوقات المتاحة</h2>
                    <div class="">
                        <div class="mens-toolbar col-md-12">
                            <div class="col-md-6">
                                <input style="float: right;font-size:1.3em; padding: 5px;" type="date" class="form-control" id="reservation_date" name="reservation_date"/>

                            </div>
                            <div class="col-md-6">
                                <p>اختر اليوم</p>
                            </div>
                        </div>
                        <div class="form-group mens-toolbar col-md-12">
                            <div class="col-md-6">
                                <select style="float: right;" class="form-control" id="reservation_time" name="reservation_time">
                                    <option value="">{{_lang('app.choose')}}</option>

                                </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-6">
                                <p>الوقت المتاح لهذا اليوم<span style="color:#1461b8; font-size:.9em; padding:0 5px;">على العلم ان أقل مدة للحجز 3 ساعات</span></p>
                            </div>	
                        </div>
                        <div class="col-md-12">
                            <p>السعر الاجمالى<span style="color:#1461b8; font-size:1.1em; padding:0 5px;">: {{$game->price.' '.$currency_sign}}</span></p>
                            @if($game->discount_price > 0)
                            <p>السعر بعد الخصم<span style="color:#1461b8; font-size:1.1em; padding:0 5px;">: {{$game->discount_price.' '.$currency_sign}}</span></p>
                            @endif
                        </div>
                        <div class="mens-toolbar col-md-12">
                            <p style="color:#fff; margin-right:10px; font-size:1.5em; text-align:center;">حجز ساعة اضافية
                                <input type="checkbox" name="has_over" id="has_over" value="1"></p>
                        </div>
                        <div class="col-md-12">
                            @php 
                            $price=$game->discount_price > 0?$game->discount_price :$game->price ; 
                            $price_with_over=$price+$game->over_price ; 
                            @endphp
                            <p>السعر الاجمالى بعد اضافة ساعة<span style="color:#1461b8; font-size:1.1em; padding:0 5px;">:{{$price_with_over.' '.$currency_sign}}</span></p>
                        </div>
                    </div>

                </div>
            </form>
            <div class="clearfix"></div>
            <div class="alert alert-success" style="display:{{Session('successMessage')?'block;':'none;'}}; " role="alert"><i class="fa fa-check" aria-hidden="true"></i> <span class="message">{{Session::get('successMessage')}}</span></div>
            <div class="alert alert-danger" style="display:{{Session('errorMessage')?'block;':'none;'}}; " role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="message">{{Session::get('errorMessage')}}</span></div>

        </div>
    </div>
</div>



@endsection