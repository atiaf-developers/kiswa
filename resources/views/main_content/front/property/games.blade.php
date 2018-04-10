@extends('layouts.front')

@section('pageTitle',_lang('app.games'))


@section('css')

@endsection
@section('js')
<script src=" {{ url('public/front/scripts') }}/games.js"></script>
@endsection

@section('content')

<div class="content-details">
    <div class="container">
        <div class="col-md-12">
            <h1>العاب</h1>
            <form id="filter-form">
                <div class="mens-toolbar">
                    <p>الاقسام
                        <select class="filter-item" name="category">
                            <option value="">اختر</option>
                            @foreach($filter_categories as $one)
                            <option {{isset($category)&&$category==$one->slug?'selected':''}} value="{{$one->slug}}">{{$one->title}}</option>
                            @endforeach
                        </select>
                    </p>
                    <p>الترتيب
                        <select class="filter-item" name="sort_by">
                            <option value="">اختر</option>
                            <option {{isset($sort_by)&&$sort_by=="desc"?'selected':''}}  value="desc">من الأحدث للأقدم</option>
                            <option {{isset($sort_by)&&$sort_by=="asc"?'selected':''}} value="asc">من الأقدم للأحدث</option>
                        </select>
                    </p>
                    <div class="clearfix"></div>	                    
                </div>
            </form>

            @foreach($games as $one)
            <div class="col-md-4">
                <div class="contact-border">
                    <a href="{{$one->url}}">
                        <img src="{{$one->image}}" class="img-responsive" alt="" />
                        <div class="contact-box">
                            <h2>{{$one->title}}</h2>
                            <p>{{$one->description}}</p>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach

        </div>
        <div class="col-md-12">
            <div class="pager">
                {{$games->links()}}
            </div>
        </div>
    </div>
</div>



@endsection