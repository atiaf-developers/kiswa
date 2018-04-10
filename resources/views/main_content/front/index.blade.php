@extends('layouts.home')

@section('pageTitle',$page_title)

@section('css')
<link href="{{url('public/front/css')}}/coreSlider.css" rel="stylesheet">
@endsection
@section('js')

<script src=" {{ url('public/front/js') }}/coreSlider.js"></script>
<script src=" {{ url('public/front/scripts') }}/home.js"></script>
@endsection



@section('content')
<!--banner-->
<div class="banner-w3">
    <div class="demo-1">            
        <div id="example1" class="core-slider core-slider__carousel example_1">
            <div class="core-slider_viewport">
                <div class="core-slider_list">
                    @foreach($slider as $one)
                    <div class="core-slider_item">
                        <img src="{{$one->image}}" class="img-responsive" alt="">
                    </div>
                    @endforeach

                </div>
            </div>
            <div class="core-slider_nav">
                <div class="core-slider_arrow core-slider_arrow__right"></div>
                <div class="core-slider_arrow core-slider_arrow__left"></div>
            </div>
            <div class="core-slider_control-nav"></div>
        </div>
    </div>


</div>	
<!--banner-->
<!--content-->
<div class="content">
    <div class="offers">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="tittle1">أحدث العروض</h3>
                    <div class="container">
                        <div class="row">
                            <div id="carousel" class="carousel slide" data-ride="carousel" data-type="multi" data-interval="2500">
                                <div class="carousel-inner">
                                    @foreach($games_offers as $one)
                                    <div class="item {{$loop->first?'active':''}}">
                                        <div class="carousel-col">
                                            <div class="block department-grid">
                                                <img src="{{$one->image}}" class="img-responsive" alt="" />
                                                <div class="details">
                                                    <h2>عرض جديد</h2>
                                                    <span><del style="color:#1461b8;">{{$one->price}} {{$currency_sign}}</del></span><span>{{$one->discount_price}} {{$currency_sign}}</span>
                                                    <!--<h5>12 عدد المشاهدات <i class="fa fa-eye"></i></h5>-->
                                                    <p>{{$one->title}}</p>
                                                    <a href="{{$one->url}}" style="float:left; ">المزيد</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>

                                <!-- Controls -->
                                <div class="left carousel-control">
                                    <a href="#carousel" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </div>
                                <div class="right carousel-control">
                                    <a href="#carousel" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <div class="department">
        <div class="container">
            <h3 class="tittle1">الأقسام</h3>
            @foreach($categories_chunk as $chunk)
            <div class="department-grids">
                @foreach($chunk as $one)
                <div class="col-md-4">
                    <div class="department-grid">
                        <img src="{{$one->image}}" class="img-responsive" alt="" />
                        <h2><a href="{{$one->url}}">{{$one->title}}</a></h2>
                    </div>
                </div>

                @endforeach
                <div class="clearfix"></div>
            </div>
            @endforeach

        </div>
    </div>

    <!--accessories-->
    <div class="accessories-w3l">
        <div class="container">
            <h1>من نحن</h1>
            <h3 class="tittle">{{$settings_translations->about}}</h3>
            <div class="button">
                <a href="{{_url('about-us')}}" class="button1"> مشاهدة المزيد</a>
            </div>
        </div>
    </div>
    <!--accessories-->
    <div class="latest-w3">
        <div class="container">
            <h3 class="tittle1">أفضل الألعاب</h3>
            @foreach($games_best_chunk as $chunk)
            <div class="latest-grids">
                @foreach($chunk as $one)
                <div class="col-md-4 latest-grid">
                    <div class="latest-top">
                        <a href="{{$one->url}}">
                            <img  src="{{$one->image}}" class="img-responsive"  alt="" />
                            <div class="latest-text">
                                <h4>{{$one->title}}</h4>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
                <div class="clearfix"></div>
            </div>
            @endforeach
     
        </div>
    </div>
    <!--new-arrivals-->
</div>
<!--content-->



@endsection