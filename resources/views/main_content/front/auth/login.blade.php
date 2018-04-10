@extends('layouts.front')

@section('pageTitle',_lang('app.login'))

@section('js')
<script src=" {{ url('public/front/scripts') }}/login.js"></script>
@endsection

@section('content')

<div class="login">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="form-w3agile">
                <h3>تسجيل الدخول</h3>
                <form action="" novalidate="novalidate" class="contactus" id = "login-form">
                    {{ csrf_field() }}
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
                    <div class="row">
                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="password" id="password" name="password" class="form-control" maxlength="100" data-msg-email="من فضلك ضع كلمة السر" data-msg-required="Please enter your email address." value="" placeholder="كلمة السر" >
                                <span class="help-block">
                                    @if ($errors->has('password'))
                                    {{ $errors->first('password') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" data-loading-text="Loading..." class="submit-form btn btn-default btn-lg" value="دخول">
                        </div>
                    </div>

                </form>
                <div class="alert alert-success" style="display:{{Session('successMessage')?'block;':'none;'}}; " role="alert"><i class="fa fa-check" aria-hidden="true"></i> <span class="message">{{Session::get('successMessage')}}</span></div>
                <div class="alert alert-danger" style="display:{{Session('errorMessage')?'block;':'none;'}}; " role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="message">{{Session::get('errorMessage')}}</span></div>
            </div>
            <div class="forg">
                <!--<a href="#" class="forg-left">نسيت كلمة السر؟</a>-->
                <a href="{{_url('register')}}" class="forg-right">تسجيل جديد</a>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>





@endsection