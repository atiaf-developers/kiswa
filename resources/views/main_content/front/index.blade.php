@extends('layouts.front')

@section('pageTitle',$page_title)


@section('js')

@endsection

@section('content')

<section id="banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block">
                    <h1> مرحباً بكم في مشروع الاستفادة من فائض الملابس المستعملة</h1>
                    <h2> يمكنك الأن انشاء طلب توصيل لتحديد موعد لقدوم المندوب اليك واستلام تبرعك</h2>
                    <div class="buttons">
                        <a href="order.php" class="btn btn-learn">انشاء طلب توصيل</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="scrolldown">
        <a id="scroll" href="#features" class="scroll"></a>
    </div>
</section>
<section id="features">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="title">
                        <h2>عن كسوة</h2>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <img src="{{url('public/front/img')}}/about-bg.png" class="img-responsive" alt="" >
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="text-left">
                                <p class="wow fadeInUp" data-wow-delay=".3s">
                                    {{ mb_strimwidth($settings_translations->about , 0, 500, '...') }}
                                </p>
                                <a href="{{ route('about_us') }}"><i class="fa fa-angle-double-left"></i>{{ _lang('app.more') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="blog">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h2>{{ _lang('app.news_and_events') }}</h2>
                </div>
                <div id="blog-post" class="owl-carousel">
                    @foreach ($news as $one)
                    <div class="block wow zoomIn" data-wow-delay=".3s">
                        <img src="{{ $one->images[0] }}" alt="" class="img-responsive">
                        <div class="content">
                            <h4>{{ $one->title }}</h4>
                            <small>{{ $one->created_at }}</small>
                            <p>
                                {{ $one->description }}
                            </p>
                            <a href="{{ $one->url }}" class="btn btn-read"><i class="fa fa-angle-double-left"></i>المزيد</a>
                        </div>
                    </div>
                    @endforeach





                </div>      
            </div>
        </div>
    </div>
</section>
<section id="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h2>{{ _lang('app.albums') }}</h2>
                </div>
                <div class="block">
                    <div class="recent-work-pic">
                        <ul id="mixed-items">
                            @foreach ($albums as $one)
                            <li class="mix category-1 col-md-4">
                                <a class="example-image-link" href="gallery-details.php">
                                    <img class="img-responsive" src="{{ $one->images[0] }}" alt="">
                                    <div class="overlay">
                                        <h3>{{ $one->title }}</h3>
                                        <i class="fa fa-search"></i>
                                    </div>
                                </a>
                            </li>
                            @endforeach


                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="play-video">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block">
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">فيديو</h2>
                    <a id="video" video-url="https://www.youtube.com/watch?v=4REytytTm2c" style="cursor: pointer;">
                        <div class="button ion-ios-play-outline wow zoomIn" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: zoomIn;"></div>
                    </a>
                    <a href="videos.php" class="btn btn-read"><i class="fa fa-angle-double-left"></i>
                        المزيد من الفيدوهات
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="testimonial">
    <div class="container">
        <div class="row">
            <div class="title">
                <h2>{{ _lang('app.foundation_activities') }}</h2>
            </div>
            @if(count($activities)>0)
            @if(isset($activities[0]))
            <div class="col col-md-6">
                <a href="activity-details.php">
                    <div class="media wow fadeInLeft" data-wow-delay=".3s">
                        <div class="media-left">
                            <img src="{{ $activities[0]->images[0] }}" alt="">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{ $activities[0]->title }}</h4>
                            <p>
                                {{ $activities[0]->description }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            @endif
            @if(isset($activities[1]))
            <div class="col col-md-6 right">
                <a href="activity-details.php">
                    <div class="media wow fadeInRight" data-wow-delay=".3s">
                        <div class="media-left">
                            <img src="{{ $activities[1]->images[0] }}" alt="">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{ $activities[1]->title }}</h4>
                            <p>
                                {{ $activities[1]->description }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            @endif
            @if(isset($activities[2]))
            <div class="col col-md-6 border">
                <a href="activity-details.php">
                    <div class="media wow fadeInLeft" data-wow-delay=".3s">
                        <div class="media-left">
                            <img src="{{ $activities[2]->images[0] }}" alt="">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{ $activities[2]->title }}</h4>
                            <p>
                                {{ $activities[2]->description }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            @endif
            @if(isset($activities[3]))
            <div class="col col-md-6 right border">
                <a href="activity-details.php">
                    <div class="media wow fadeInRight" data-wow-delay=".3s">
                        <div class="media-left">
                            <img src="{{ $activities[3]->images[0]  }}" alt="">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{ $activities[3]->title }}</h4>
                            <p>
                                {{ $activities[3]->description }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            @endif
            @endif
        </div>
    </div>
</section>
<section id="contact-form">
    <div class="container">
        <div class="row">
            <div class="title">
                <h2>تواصل معنا</h2>
            </div>
            <div class="col-md-6">
                <form class="form-group">
                    <label>الاسم</label>
                    <input type="text" class="form-control">
                    <label>البريد الالكترونى</label>
                    <input type="text" class="form-control">
                    <label>نوع الرسالة</label>
                    <select class="form-control">
                        <option selected>اقتراح</option>
                        <option>شكوى</option>
                        <option>استفسار</option>
                    </select>
                    <label>الرسالة</label>
                    <textarea class="form-control" rows="3"></textarea>
                    <button class="btn btn-default" type="submit">ارسال</button>
                </form>
            </div>
            <div class="col-md-6 col">
                <p>
                    هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. 
                </p>
                <p><i class="fa fa-phone"></i> 00966123458967 - 00966123458969 </p> 
                <p><i class="fa fa-envelope-o"></i> info@keswa.com </p>                             
                <p><i class="fa fa-map-marker"></i> المملكة العربية السعودية </p>
                <div class="app">
                    <h3>حمل التطبيق الآن<i class="fa fa-download"></i> </h3>
                    <a href="#"><img src="{{url('public/front/img')}}/app.png" alt=""></a>
                    <a href="#"><img src="{{url('public/front/img')}}/google.png" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection