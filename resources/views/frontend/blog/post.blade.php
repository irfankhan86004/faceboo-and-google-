@extends('frontend.layout', [
  'title' => $post->title,
  'meta_description' => $post->meta_description ?: Settings::blogDescription(),
])

@section('og-title')
    <meta property="og:title" content="{{ $post->title }}"/>
@stop

@if ($post->page_image)
    @section('og-image')
        <meta property="og:image" content="{{ url('/uploads/' . $post->page_image) }}">
    @stop
@endif

@section('og-description')
    <meta property="og:description" content="{{ $post->meta_description }}"/>
@stop

@section('title')
    <title>{{ $title or Settings::blogTitle() }}</title>
@stop

@section('unique-js')
    <script src="{{ asset('js/frontend.js') }}" charset="utf-8"></script>
@endsection

@section('content')
    <article>
        <div class="container" id="post">
            <div class="row">

                <div class="col-lg-9  col-md-7  col-sm-12">
                    @if ($post->page_image)
                        <div class="text-center">
                            <img src="{{ asset('uploads/' . $post->page_image) }}" class="post-hero">
                        </div>
                    @endif
                    <p class="post-page-meta text-center">
                        {{ \Carbon\Carbon::parse($post->published_at)->diffForHumans() }}
                        @if ($post->tags->count())
                            in
                            {!! join(', ', $post->tagLinks()) !!}
                        @endif
                    </p>
                    <h1 class="post-page-title text-center">{{ $post->title }}</h1>
                        <div style="text-align: center" class="text-center">
                    {!! $post->content_html !!}
                    </div>
                    <p style="text-align: center" class="text-center"></p>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-12">
                    @include('frontend.blog.partials.author')
                </div>

            </div>
        </div>
    </article>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <br>
                @include('frontend.blog.partials.post-pager')
            </div>
        </div>
    </div>
@stop
