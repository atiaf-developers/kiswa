@extends('layouts.front')

@section('pageTitle',$category->title)

@section('js')
	
@endsection

@section('content')
  
  <section id="aboutus">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="title">
                                    <h2>{{ $category->title }}</h2>
                                </div>
                                <div class="aboutus-area">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <img src="{{ url("public/uploads/categories/m_$category->image") }}" class="img-responsive" alt="" >
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <p class="wow fadeInUp" data-wow-delay=".3s">
                                                   {{$category->description}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
 

@endsection