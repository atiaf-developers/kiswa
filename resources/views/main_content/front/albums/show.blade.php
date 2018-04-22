@extends('layouts.front')

@section('pageTitle',$album->title)

@section('js')

@endsection

@section('content')

<section id="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h2>{{ $album->title }}</h2>
                </div>
                <div class="block">
                    <div class="recent-work-pic">
                        <ul id="mixed-items">
                            @foreach ($album->images as $image)
                            <li class="mix category-1 col-md-4 col-xs-6" data-my-order="1">
                                <a class="example-image-link" href="{{ $image }}" data-lightbox="example-set">
                                    <img class="img-responsive" src="{{ $image }}" alt="">
                                    <div class="overlay">
                                        <i class="ion-ios-plus-empty"></i>
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

@endsection