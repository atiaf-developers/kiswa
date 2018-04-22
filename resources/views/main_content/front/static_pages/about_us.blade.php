@extends('layouts.front')

@section('pageTitle',_lang('app.about_keswa'))

@section('js')
	
@endsection

@section('content')

    <section id="aboutus">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="title">
                                    <h2>{{ _lang('app.about_keswa') }}</h2>
                                </div>
                                <div class="aboutus-area">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <img src="{{ url('public/front/img') }}/about-bg.png" class="img-responsive" alt="" >
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <p class="wow fadeInUp" data-wow-delay=".3s">
                                                   {{$settings_translations->about}}
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