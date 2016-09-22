<!DOCTYPE html>
<html lang="en">
    <head>
        @include('shared.meta-tags')
        @yield('title')
        @include('backend.partials.backend-css')
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>
    <body @if(Auth::check()) class="toggled sw-toggled" @endif>
        @if (Auth::guest())
            @yield('login')
        @else
            @include('backend.partials.header')
            @yield('content')
            @include('shared.page-loader')
            @include('backend.partials.footer')
        @endif
        @include('backend.partials.backend-js')
        @include('backend.partials.search-js')
        @yield('unique-js')
        <script>

            $(function(){

                var menu = $('.menu-navigation-basic');

                menu.slicknav();

                // Mark the clicked item as selected

                menu.on('click', 'a', function(){
                    var a = $(this);

                    a.siblings().removeClass('selected');
                    a.addClass('selected');
                });
            });

        </script>
    </body>
</html>
