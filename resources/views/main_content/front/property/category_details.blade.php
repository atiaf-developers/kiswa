@extends('layouts.front')

@section('pageTitle',$category->title)

@section('js')

@endsection

@section('content')
<div class="content-details">
    <div class="container">
        <div class="col-md-12">
            <h1>العاب {{$category->title}}</h1>
            @foreach($games as $one)
            <div class="col-md-4">
                <div class="contact-border">
                    <a href="{{$one->url}}">
                        <img src="{{$one->image}}" class="img-responsive" alt="" />
                        <div class="contact-box">
                            <h2>{{$one->title}}</h2>
                            <p></p>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach

        </div>
        <div class="col-md-12">
            <div class="pager">
                {{$games->links()}}
            </div>
        </div>
    </div>
</div>



@endsection