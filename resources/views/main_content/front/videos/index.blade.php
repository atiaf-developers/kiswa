@extends('layouts.front')

@section('pageTitle', _lang('app.videos') )

@section('js')

@endsection

@section('content')


<section id="videos">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h2>{{ _lang('app.videos') }}</h2>
                </div>
                <div class="videos-area">
                    <div class="col-lg-12 col-md-12 col-sm-12">

                       @foreach ($videos as $video)
                         <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="row">
                                <h3>{{ $video->title }}</h3>
                                <div class="video">
                                    <iframe width="470" height="300" src="https://www.youtube.com/embed/{{$video->youtube_url}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

                                   
                                </div>
                            </div>
                        </div>
                       @endforeach
                        

                    </div>
                </div>
            </div>
              <div class="pager">
                   {{ $videos->links() }}
              </div>
           
        </div>
    </div>
</section>


@endsection