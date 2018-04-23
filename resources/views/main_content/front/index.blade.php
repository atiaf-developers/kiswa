@extends('layouts.front')

@section('pageTitle',$page_title)


@section('js')
  <script src=" {{ url('public/front/scripts') }}/contact.js"></script>
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
                        <a href="{{_url('donation-request')}}" class="btn btn-learn">انشاء طلب توصيل</a>
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
                        <h2>{{ _lang('app.about_keswa') }}</h2>
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
                        <img src="{{ $one->image }}" alt="" class="img-responsive">
                        <div class="content">
                            <h4>{{ $one->title }}</h4>
                            <small>{{ $one->created_at }}</small>
                            <p>
                                {{ $one->description }}
                            </p>
                            <a href="{{ route('show_news',$one->slug) }}" class="btn btn-read"><i class="fa fa-angle-double-left"></i>{{ _lang('app.more') }}</a>
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
                                <a class="example-image-link" href="">
                                    <img class="img-responsive" src="{{ $one->image }}" alt="">
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
                    <h2 class="wow fadeInUp" data-wow-delay=".3s">{{ $video->title }}</h2>
                    <a id="video" video-url="{{ $video->url }}" style="cursor: pointer;">
                        <div class="button ion-ios-play-outline wow zoomIn" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: zoomIn;"></div>
                    </a>
                    <a href="" class="btn btn-read"><i class="fa fa-angle-double-left"></i>
                       {{ _lang('app.more') }}
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
                <a href="">
                    <div class="media wow fadeInLeft" data-wow-delay=".3s">
                        <div class="media-left">
                            <img src="{{ $activities[0]->image }}" alt="">
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
                <a href="">
                    <div class="media wow fadeInRight" data-wow-delay=".3s">
                        <div class="media-left">
                            <img src="{{ $activities[1]->image }}" alt="">
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
                <a href="">
                    <div class="media wow fadeInLeft" data-wow-delay=".3s">
                        <div class="media-left">
                            <img src="{{ $activities[2]->image }}" alt="">
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
                <a href="">
                    <div class="media wow fadeInRight" data-wow-delay=".3s">
                        <div class="media-left">
                            <img src="{{ $activities[3]->image  }}" alt="">
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
                <h2>{{ _lang('app.contact_us') }}</h2>
            </div>
            <div class="col-md-6">
                <form class="form-group" action="" method="post" id="contactus_form">

                     <div class="form-group">
                         <label class="control-label">{{ _lang('app.name') }}</label>
                         <input type="text" class="form-control" name="name">
                     </div>
                    
                     
                     <div class="form-group">
                        <label class="control-label">{{ _lang('app.email') }}</label>
                        <input type="email" class="form-control" name="email">
                     </div>
                  
                     
                     <div class="form-group">
                          <label class="control-label">{{ _lang('app.message_type') }}</label>
                            <select class="form-control" name="type">
                                @foreach ($types as $key => $value)
                                    <option value="{{ $key }}">{{ _lang('app.'.$value)  }}</option>
                                @endforeach
                                
                            </select>
                     </div>
                   
                    
                    <div class="form-group">
                        <label class="control-label">{{ _lang('app.message') }}</label>
                        <textarea class="form-control" rows="3" name="message"></textarea>
                    </div>
                   

                    <button class="btn btn-default submit-form" type="submit">{{ _lang('app.send') }}</button>
                </form>
            </div>
            <div class="col-md-6 col">
                <p><i class="fa fa-phone"></i> {{ $settings['phone']->value }} </p> 
                <p><i class="fa fa-envelope-o"></i> {{ $settings['email']->value }} </p>                             
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