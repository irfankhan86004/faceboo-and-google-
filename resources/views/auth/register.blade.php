@extends('backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Sign In</title>
@stop

<nav class="menu-navigation-basic">
    <a href="/" @if (Request::is('/')) class="selected" @endif>Home</a>
    <a href="#" @if (Request::is('')) class="selected" @endif>Products</a>
    <a href="#" @if (Request::is('')) class="selected" @endif>Services</a>
    <a href="/admin" @if (Request::is('admin')) class="selected" @endif>Login</a>
    <a href="/register"  @if (Request::is('register')) class="selected" @endif>Post a Job</a>
</nav>
@section('login')
    <section id="main">
        <section id="content">
            <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
                <div class="card">
                    <br>
                    <h2 class="text-center"> Register</h2>
                    <div class="card-header" style="text-align: center">
                        <img src="{{ asset('images/favicon.png') }}" style="width: 85px">
                    </div>

                    <div class="card-body card-padding" id="login-ch">

                        <p class="f-20 f-300 text-center">Welcome to using Chinausamassageo</p>
                        <p class="text-muted text-center">If you already have an account, you can post a new job for your company by <a href="/admin">logging in </a>first.</p>
                      @include('auth.partials.register') 
                        <br>
                       {{ Debugbar::info('nice')}}
                    </div>
                </div>
                <p class="text-center"><a href="/"><i class="zmdi zmdi-long-arrow-return"></i> Back to the blog</a></p>
            </div>
        </section>
    </section>
@endsection