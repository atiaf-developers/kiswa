<!--content-->
<!---footer--->
<div class="footer-w3l">
    <div class="container">
        <div class="footer-grids">
            <div class="col-md-4 footer-grid">
                <h4>القائمة</h4>
                <ul>
                    <li><a href="{{_url('')}}">الرئيسية</a></li>
                    <li><a href="{{_url('about-us')}}">من نحن</a></li>
                    <li><a href="{{_url('offers')}}">العروض</a></li>
                    <li><a href="{{_url('games')}}">الالعاب</a></li>
                    @if($User)
                    <li><a href="{{_url('customer/reservations')}}">حجوزاتى</a></li>
                    @endif
                    <li><a href="{{_url('policy')}}">سياسة الاستخدام</a></li>
                    <li><a href="{{_url('contact-us')}}">اتصل بنا</a></li>
                </ul>
            </div>
            <div class="col-md-4 footer-grid">
                <h4>الاقسام</h4>

                <ul>
                    @foreach($categories_chunk as $chunk)
                    @foreach($chunk as $one)
                    <li><a href="{{$one->url}}">{{$one->title}}</a></li>
                    @endforeach
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3 footer-grid foot">
                <h4>تواصل معنا</h4>
                <ul>
                    <li>{{$settings_translations->address}}<i class="glyphicon glyphicon-map-marker" aria-hidden="true"></i></li>
                    <li>{{$settings['phone']->value}}<i class="glyphicon glyphicon-earphone" aria-hidden="true"></i></li>
                    <li>{{$settings['email']->value}}<i class="glyphicon glyphicon-envelope" aria-hidden="true"></i></li>

                </ul>
            </div>
            <div class="clearfix"> </div>
        </div>

    </div>
</div>
<!---footer--->
<!--copy-->
<div class="copy-section">
    <div class="container">
        <div class="border">
            <div class="copy-left">
                <p>تصميم وتطوير<a href="http://www.atiafco.com/" target="_blank">اطياف للحلول المتكاملة</a></p>
            </div>
            <div class="copy-right">
                <p>جميع حقوق الطبع محفوظة 2018 	&copy; </p>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>