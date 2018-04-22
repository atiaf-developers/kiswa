@extends('layouts.front')

@section('pageTitle',_lang('app.news_and_events'))

@section('js')
	
@endsection

@section('content')

   <section id="news">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="title">
                                    <h2>{{ _lang('app.news_and_events') }}</h2>
                                </div>
                                <div class="news-area">
                                    <div class="row">
                                        @foreach ($news as $one)
                                       
                                        <div class="col-md-4">
                                            <div class="box">
                                                <img src="{{ $one->image  }}" alt="" />
                                                <div class="box-det">
                                                    <h4>{{ $one->title }}</h4>
                                                    <small>{{ $one->created_at }}</small>
                                                    <p>{{ $one->description }}</p>
                                                    <a href="{{ route('show_news',$one->slug) }}" class="btn btn-read"><i class="fa fa-angle-double-left"></i>{{ _lang('app.more') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                       
                                        
                                    </div>
                                </div>
                                
                                <div class="pager">
                                   {{ $news->links() }}
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
            </section>
            

@endsection