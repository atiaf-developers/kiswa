@extends('layouts.profile')

@section('pageTitle',_lang('app.dashboard'))


@section('js')
<script src=" {{ url('public/front/scripts') }}/contact.js"></script>
@endsection

@section('content')
<table>
    <tr>
        <td>{{_lang('app.name')}}</td>
        <td>{{$User->name}}</td>
    </tr>
    <tr>
        <td>{{_lang('app.username')}}</td>
        <td>{{$User->username}}</td>
    </tr>
    <tr>
        <td>{{_lang('app.email')}}</td>
          <td>{{$User->email}}</td>
    </tr>
    <tr>
        <td>{{_lang('app.mobile')}}</td>
       <td>{{$User->mobile}}</td>
    </tr>
 
</table>


@endsection