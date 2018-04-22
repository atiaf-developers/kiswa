@extends('layouts.front')

@section('pageTitle',_lang('app.corporation_activities'))

@section('js')
	
@endsection

@section('content')
  
  <section id="testimonial">
                    <div class="container test-inner">
                        <div class="row">

                            <div class="title">
                                <h2>{{ _lang('app.corporation_activities') }}</h2>
                            </div>
                            @foreach ($activities as $key => $activity)

                                <div class="col col-md-6 {{ $key % 2 == 0 ? '' : 'right' }}">
                                    <a href="{{ route('show_corporation_activities',$activity->slug) }}">
                                        <div class="media wow {{ $key % 2 == 0 ? 'fadeInLeft' : 'fadeInRight' }} " data-wow-delay=".3s">
                                          <div class="media-left">
                                              <img src="{{ $activity->image }}" alt="">
                                          </div>
                                          <div class="media-body">
                                            <h4 class="media-heading">{{ $activity->title }}</h4>
                                            <p>
                                                 {{ $activity->description }}
                                            </p>
                                          </div>
                                        </div>
                                    </a>
                                </div>

                            @endforeach
                           
                        </div>
                    </div>
                    <div class="pager">
                        {{ $activities->links() }}
                    </div>
        </section>
  
            

@endsection