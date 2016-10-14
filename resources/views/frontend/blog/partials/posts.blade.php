
@foreach ($posts as $post)
    <a href="{{ $post->url($tag) }}">
        <div class="post-preview">
            <h2 class="post-title text-center">
                   {{ $post->title }}
                    {{--<a href="{{ $post->url($tag) }}">{{ $post->title }}</a>--}}
                </h2>
            <p class="post-meta">
               <span class="text-center">
                   {{ $post->published_at->diffForHumans() }}
                   </span>
                @unless ($post->tags->isEmpty())
                    in
                <span class="pull-right">
                    {!! implode(', ', $post->tagLinks()) !!}
                    </span>
                @endunless
            </p>
            <p id="postSubtitle">
                {{ str_limit($post->subtitle, config('blog.frontend_trim_width')) }}
            </p>
             <div  style="font-size: 13px">
             <p class="text-left">READ MORE...
                 <span class="pull-right"><i class="fa fa-map-marker"></i> <i class=" fa fa-globe muted"></i>Location:{{$post->location_id}}</span>
             </p>
            </div>
            </div>
    </a>
@endforeach
