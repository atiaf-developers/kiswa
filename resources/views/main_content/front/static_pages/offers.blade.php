@extends('layouts.front')

@section('pageTitle',_lang('app.offers'))

@section('js')

@endsection

@section('content')
<div class="content-details">
    <div class="container">
        <div class="col-md-12">
            <h1>أحدث العروض</h1>
            @foreach($offers as $one)
            <div class="col-md-4">
                <div class="contact-border">
                    <img src="{{$one->image}}" class="img-responsive" alt="" />
                    <div class="contact-box">
                        <h2>{{$one->title}}</h2>
                        <span><del style="color:#1461b8;">{{$one->price.' '.$currency_sign}}</del></span><span>{{$one->discount_price.' '.$currency_sign}}</span>
                        <!--<h4>12 عدد المشاهدات <i class="fa fa-eye"></i></h4>-->
                        <p>{{$one->description}}</p>
                        <a href="{{$one->url}}">المزيد</a>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
</div>




@endsection