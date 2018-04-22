@extends('layouts.front')

@section('pageTitle',_lang('app.gallary'))

@section('js')

@endsection

@section('content')

<section id="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h2>{{ _lang('app.gallary') }}</h2>
                </div>
                <div class="block">
                    <div class="recent-work-pic">
                        <ul id="mixed-items">
                           @foreach ($albums as $album)
                                <li class="mix category-1 col-md-4">
                                    <a class="example-image-link" href="{{ route('show_gallary',$album->slug) }}">
                                            <img class="img-responsive" src="{{ $album->image }}" alt="">
                                            <div class="overlay">
                                                <h3>{{ $album->title }}</h3>
                                                <i class="fa fa-search"></i>
                                            </div>
                                    </a>
                                </li>
                           @endforeach
                           

                        </ul>
                    </div>
                </div>
            </div>
            <div class="pager">
               {{ $albums->links() }}
            </div>
        </div>
    </div>
</section>

@endsection