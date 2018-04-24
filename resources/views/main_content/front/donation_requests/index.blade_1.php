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
<div class="modal fade" id="getLocation" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">حدد موقعك على الخريطة</h4>
            </div>
            <div class="modal-body">



                <input id="pac-input" class="controls" type="text"
                       placeholder="Enter a location" style="height: 30px;width: 30%;">
                <div id="map" style="height: 500px; width:100%;"></div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
            </div>
        </div>

    </div>
</div>
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
                    <h2>انشاء طلب توصيل</h2>
                </div>
                <div class="login-area">
                    <div class="form-w3agile margin">
                        <form class="contactus" novalidate id="donation-request-form" method="post" action="{{_url('donation-request')}}">
                            {{ csrf_field() }}
                            <img class="user" src="{{ url('public/front/img') }}/order.png" alt="" >
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>نوع التبرع</label>
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
                                        <label>تفاصيل نصية</label>
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
                                            <label>تحديد موعد للاستلام</label>
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
                                        <label>ارفاق 4 من الصور</label>
                                        <input type="file" name="images[]" id="images" multiple>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-md-12">
                                    <input type="hidden" id="lat" name="lat">
                                    <input type="hidden" id="lng" name="lng">
                                    <a href="#" class="button-login btn btn-lg map-button" onclick="DonationRequest.getLocation()">حدد موقعك على الخريطة</a>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <p>يمكنك إنشاء طلب توصيل بدون تسجيل الدخول ولكن سوف نحتاج الاسم ورقم الهاتف</p>
                            @if(!$User)
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>{{_lang('app.name')}}</label>
                                        <input type="text" class="form-control " name="name">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>{{_lang('app.mobile')}}</label>
                                        <input type="text" class="form-control " name="mobile">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="button-login btn btn-lg submit-form">ارسال</button>
                                </div>
                            </div>

                        </form>
                        <div class="alert alert-success" style="display:{{Session('successMessage')?'block;':'none;'}}; " role="alert"><i class="fa fa-check" aria-hidden="true"></i> <span class="message">{{Session::get('successMessage')}}</span></div>
                        <div class="alert alert-danger" style="display:{{Session('errorMessage')?'block;':'none;'}}; " role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="message">{{Session::get('errorMessage')}}</span></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection