@extends('layouts.front')

@section('pageTitle',_lang('app.about_us'))


@section('css')

@endsection
@section('js')

@endsection

@section('content')

<div class="reservation-details">
    <div class="container">
        <h1>حجوزاتى</h1>
        @foreach($reservations as $one)
        <div class="reservation-games col-md-12">
            <div class="col-md-5">
                <img src="{{$one->image}}" class="img-responsive" alt="" />
            </div>
            <div class="col-md-7">
                <p>{{$one->title}}</p>
                <p><span>وقت الحجز :</span> {{$one->reservation_date}}</p>
            </div>
        </div>
        @endforeach
       
    </div>
     <div class="col-md-12">
            <div class="pager">
               {{$reservations->links()}}

            </div>
        </div>
</div>



@endsection