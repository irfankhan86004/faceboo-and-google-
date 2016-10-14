@extends('frontend.layout')

@section('title')
    <title>{{ $tag->title or Settings::blogTitle() }} | Blog</title>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

               {{--{{ Debugbar::info($posts)}}--}}

                @include('frontend.blog.partials.post_search')
                @include('frontend.blog.partials.tag-head')
                @include('frontend.blog.partials.posts')
                @include('frontend.blog.partials.index-pager')
            </div>
        </div>
    </div>
@stop