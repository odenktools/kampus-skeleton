@extends('layouts.app')

@section('title', 'Login'.' | ')

@section('body-class', 'class="hold-transition login-page"')

@section('cssFiles')
<!-- Plugins -->
<link rel="stylesheet" type="text/css" href="/{{ config('path.plugins') }}/datatables/1.10.12/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/{{ config('path.plugins') }}/datetimepicker/4.17.42/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" type="text/css" href="/{{ config('path.plugins') }}/daterangepicker/2.1.24/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="/{{ config('path.plugins') }}/datepicker/1.6.1/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" type="text/css" href="/{{ config('path.plugins') }}/timepicker/0.5.2/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" type="text/css" href="/{{ config('path.plugins') }}/icheck/1.0.2/skins/all.css">
<link rel="stylesheet" type="text/css" href="/{{ config('path.plugins') }}/select2/4.0.3/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="/{{ config('path.plugins') }}/fancybox/jquery.fancybox.min.css">

<!-- Themes -->
<link rel="stylesheet" type="text/css" href="/{{ config('path.themes.backend') }}/css/AdminLTE.min.css">
<link rel="stylesheet" type="text/css" href="/{{ config('path.themes.backend') }}/css/skins/_all-skins.min.css">


<!-- Styles -->
<link rel="stylesheet" type="text/css" href="/{{ config('path.css') }}/styles.css">

@endsection

@section('jsFiles')

@endsection

@section('wrapper')
<div class="login-box">
    <div class="login-logo">
        <a href="#"><strong style="color:#d39a07;">KAMPUS </strong><strong style="color:#00556f;">APPS</strong></a>
    </div>
    <div class="login-box-body">
        <div class="page-header text-center">
            <h4>{!! trans('label.title_box_login') !!}</h4>
        </div>
        {!! Form::open(['route' => 'auth::login.post', 'method' => 'POST']) !!}
        <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{!! trans('label.email_ph') !!}" autofocus>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" class="form-control" name="password" placeholder="{!! trans('label.password_ph') !!}">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <div class="checkbox icheck">
                <label>
                    <input type="checkbox" name="remember"> {!! trans('label.remember_me') !!}
                </label>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">
                {!! trans('button.login') !!}
            </button>
        </div>
        {!! Form::close() !!}
        <ul class="nav nav-pills nav-justified">
            <li><a href="#">{!! trans('button.forgot_password') !!}</a></li>
            <li><a href="#">{!! trans('button.register') !!}</a></li>
        </ul>
    </div>
</div>
@endsection
