@extends('layouts.front')

@section('pageTitle',_lang('app.categories'))

@section('js')

@endsection

@section('content')
<div class="content-details">
    <div class="container">
        <div class="col-md-12">
            <h1>الأقسام</h1>
            @foreach($categories as $one)
            <div class="col-md-4">
                <a href="{{$one->url}}">
                    <div class="contact-border">
                        <img src="{{$one->image}}" class="img-responsive" alt="" />
                        <div class="contact-box">
                            <h2>{{$one->title}}</h2>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach

        </div>
        <div class="col-md-12">
            <div class="pager">
               {{$categories->links()}}

            </div>
        </div>
    </div>
</div>



@endsection