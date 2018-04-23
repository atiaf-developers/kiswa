@extends('layouts.front')

@section('pageTitle','Ga3aaan - Register')

@section('js')
<script src=" {{ url('public/front/scripts') }}/login.js"></script>
@endsection

@section('content')

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="title">
                    <h2>انشاء حساب جديد</h2>
                </div>
                <div class="login-area">
                    <form id="regForm">
                        {{ csrf_field() }}
                        <img class="user" src="img/signin1.png" alt="" >
                        <!-- One "tab" for each step in the form: -->
                        <div class="tab form-group">
                            <h3>ادخل رقم جوالك لانشاء حساب جديد</h3>
                            <div class="tab-details">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="row">
                                                <p class="num-code">+966</p>
                                            </div>
                                        </div>
                                        <div class="col-md-10 form-group">
                                            <input type="text" class="form-control" name="mobile" id="mobile">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab">
                            <div class="row form-w3agile">
                                <h3 class="h3-dir"> ستصلك رسالة نصية بكود التفعيل على رقم الجوال الخاص بك 00966123456789 <a href="#" class="change-num">تغيير الرقم</a></h3>
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
                                <a class="a-signin" href="#" ><strong>ارسال الكود مرة أخرى</strong></a>
                            </div>
                        </div>
                        <div class="tab dir form-group">
                            <h3>استكمال البيانات</h3>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <input type="text" class="form-control" name="name" placeholder="الاسم">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <input type="text" class="form-control" name="username" placeholder="اسم المستخدم">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <input type="text" class="form-control" name="email" placeholder="البريد الالكترونى - اختياري">
                                        <span class="help-block"></span>
                                    </div> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <input type="password" class="form-control" name="password" placeholder="كلمة السر">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <input type="password" class="form-control" name="confirm_password" placeholder="إعادة كلمة السر">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="tab">
                            <div class="alert alert-success" style="display:{{Session('successMessage')?'block;':'none;'}}; " role="alert"><i class="fa fa-check" aria-hidden="true"></i> <span class="message">{{Session::get('successMessage')}}</span></div>
                            <div class="alert alert-danger" style="display:{{Session('errorMessage')?'block;':'none;'}}; " role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="message">{{Session::get('errorMessage')}}</span></div>
                        </div>
                        <div class="next2">
                            <button type="button" id="nextBtn" data-type="next" onclick="Login.nextPrev(this, 1)">التالى</button>
                            <button type="button" id="prevBtn" data-type="prev" onclick="Login.nextPrev(this, -1)">السابق</button>
                        </div>
                        <!-- Circles which indicates the steps of the form: -->
                        <div class="steps">
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>





@endsection