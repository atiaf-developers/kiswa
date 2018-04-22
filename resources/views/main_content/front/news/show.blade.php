@extends('layouts.front')

@section('pageTitle',$news->title)

@section('js')
	<script>
		$(window).load(function() {
		  $('.flexslider').flexslider({
		    animation: "slide",
		    controlNav: "thumbnails"
		  });
		});
	</script>
@endsection

@section('content')
  
  <section id="blog-details">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="title">
                                    <h2>{{ $news->title }}</h2>
                                </div>
                                <div class="blog-details-area">
                                    <div class="col-md-12">
                                        <div class="col-md-5">
                                            <div class="flexslider">
                                                <ul class="slides">
                                                	@foreach ($news->images as $image)
	                                                	<li data-thumb="{{ $image }}">
	                                                        <img src="{{ $image }}" />
	                                                    </li>
                                                	@endforeach
                                                	
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <span class="time">تاريخ الخبر : {{ $news->created_at }}</span>
                                            <p>{{ $news->description }}</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
 

@endsection