@extends('layouts.front')

@section('pageTitle',$category->title)

@section('js')
	
@endsection

@section('content')

   <section id="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="title">
                                    <h2>{{ $category->title }}</h2>
                                </div>
                                <div class="content-area">
                                    <div class="col-md-12">
                                        @foreach ($categories as $one)
                                        <div class="content-details">
                                            <div class="col-md-3">
                                                <img src="{{ url("public/uploads/categories/$one->image") }}" alt="">
                                            </div>
                                            <div class="col-md-9">
                                                <h4>{{ $one->title }}</h4>
                                                <p>
                                                    {{ mb_strimwidth($one->description , 0, 500, '...') }}
                                                   
                                                </p>
                                                <a href="{{ route('show_others',[$category->slug,$one->slug]) }}"><i class="fa fa-angle-double-left"></i>{{ _lang('app.more') }}</a>
                                            </div>
                                        </div>
                                        @endforeach
                                        
                                       
                                    </div>

                                </div>
                                <div class="pager">
                                    {{ $categories->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            

@endsection