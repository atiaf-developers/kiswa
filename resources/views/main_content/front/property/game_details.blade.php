@extends('layouts.front')

@section('pageTitle',$game->title)


@section('css')
<link href="{{url('public/front/css')}}/flexslider.css" rel="stylesheet">
<link href="{{url('public/front/css')}}/jstarbox.css" rel="stylesheet">
@endsection
@section('js')
<script src=" {{ url('public/front/js') }}/jquery.flexslider.js"></script>
<script src=" {{ url('public/front/js') }}/imagezoom.js"></script>
<script src=" {{ url('public/front/js') }}/simpleCart.min.js"></script>
<script src=" {{ url('public/front/js') }}/jstarbox.js"></script>
<script src=" {{ url('public/front/scripts') }}/games.js"></script>
@endsection

@section('content')

<div class="single-wl3">
    <div class="container">
        <div class="single-grids">
            <div class="col-md-12 single-grid">
                <div class="single-top">
                    <div class="col-md-5">
                        <div class="flexslider">
                            <ul class="slides">
                                @foreach($game->gallery as $one)
                                <li data-thumb="{{$one}}">
                                    <div class="thumb-image"> <img src="{{$one}}" data-imagezoom="true" class="img-responsive"> </div>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                    <div class="col-md-7 simpleCart_shelfItem">
                        <div class="top">
                            <h4>{{$game->title}}</h4>
                            <p>{{$game->description}}</p>
                        </div>
                        <div class="bottom">
                            <h3>طرق الدفع</h3>
                            <div class="bottom-pic">
                                <span><img src="{{url('public/front/images')}}/visa.png" alt="" /></span>
                                <span><img src="{{url('public/front/images')}}/paypal.png" alt="" /></span>
                                <span><img src="{{url('public/front/images')}}/discover.png" alt="" /></span>
                                <span><img src="{{url('public/front/images')}}/mastercard.png" alt="" /></span>
                            </div>
                        </div>
                        <div class="button">
                            <a href="{{_url('game/'.$game->slug.'/reserve')}}" class="button1">احجز الأن</a>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
            <div class="col-md-12 video">
                <iframe src="//www.youtube.com/embed/{{$game->youtube_url}}" width="100%" height="300" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>

        </div>
    </div>
</div>



@endsection