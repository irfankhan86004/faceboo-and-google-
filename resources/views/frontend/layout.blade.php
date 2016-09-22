<!DOCTYPE html>
<html lang="en">
    <head>
        @include('shared.meta-tags')
        @yield('title')
        <meta name="description" content="{{ $meta_description }}">
        @include('frontend.partials.frontend-css')
    </head>
    <body>
        @include('frontend.partials.header')
        @yield('content')
        @yield('unique-js')
        @include('frontend.partials.subscribe')
        @include('frontend.partials.footer')

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
