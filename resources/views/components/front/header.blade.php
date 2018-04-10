<div class="header">
    <div class="header-top col-md-12">
        <div class="container">
            <div class="top-left col-md-5">
                <div class="social">
                    <a href="{{$settings['social_media']->facebook}}"><span class="fa fa-facebook"></span></a>
                    <a href="{{$settings['social_media']->twitter}}"><span class="fa fa-twitter"></span></a>
                    <a href="{{$settings['social_media']->google}}"><span class="fa fa-google-plus"></span></a>
                    <a href="{{$settings['social_media']->youtube}}"><span class="fa fa-youtube"></span></a>
                    <a href="{{$settings['social_media']->instagram}}"><span class="fa fa-instagram"></span></a>
                </div>
            </div>
            <div class="top-right col-md-7">
                <ul>
                    <li><a href="{{url($next_lang_code.'/'.substr(Request()->path(), 3))}}">{{$next_lang_text}} </a></li>
                    <li class="hidden-xs"><i class="fa fa-envelope"></i> {{$settings['email']->value}}</li>
                    <li class="hidden-xs"><i class="fa fa-phone"></i> {{$settings['phone']->value}}</li>
                    @if($User)
                    <li>
                        <a href="{{ _url('logout') }}"
                           onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i> {{ _lang('app.logout') }}</a>
                        <form id="logout-form" action="{{ _url('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    @else
                    <li><a href="{{_url('login?return='.base64_encode(request()->getPathInfo() . (request()->getQueryString() ? ('?' . request()->getQueryString()) : ''))) }}">تسجيل الدخول</a></li>
                    @endif

                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="heder-bottom">
        <div class="container">
            <div class="logo-nav col-md-12">
                <div class="row">
                    <div class="logo-nav-left col-md-3">
                        <a href="{{_url('')}}"><img src="{{url('public/front/images')}}/logo.png" alt="" /></a>
                    </div>
                    <div class="logo-nav-left1 col-md-9">
                        <nav class="navbar navbar-default">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header nav_2">
                                <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
                                    <span class="sr-only">القائمة</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div> 
                            <div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
                                <ul class="nav navbar-nav">
                                    <li><a href="{{_url('')}}" class="act">الرئيسية</a></li>
                                    <li><a href="{{_url('about-us')}}">من نحن</a></li>
                                    <li><a href="{{_url('categories')}}">الأقسام</a></li>
                                    <li><a href="{{_url('offers')}}">العروض</a></li>
                                    <li><a href="{{_url('games')}}">الالعاب</a></li>
                                    @if($User)
                                    <li><a href="{{_url('customer/reservations')}}">حجوزاتى</a></li>
                                    @endif
                                    <li><a href="{{_url('policy')}}">سياسة الاستخدام</a></li>
                                    <li><a href="{{_url('contact-us')}}">اتصل بنا</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>

                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
</div>