<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<meta>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>CAR DEALER</title>


{{--   // <link rel="stylesheet" href="{{asset('css/all.css')}}">--}}
    <link rel="stylesheet" href="/css/bootstrap.min.css">
{{--    <link rel="stylesheet" href="/css/bootstrap-theme.min.css">--}}
{{--    <link rel="stylesheet" href="/css/fontAwesome.css">--}}
    <link rel="stylesheet" href="/css/hero-slider.css">
    <link rel="stylesheet" href="/css/owl-carousel.css">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <!-- Fonts -->
    <script src="/js/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.css">
    <script src="/js/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <script>
        (function() {
            window.Laravel = {
                csrfToken: '{{csrf_token()}}'
            }
        })();
    </script>
</head>

<body>
<div id="app">
    @if(Auth::check())
        <storemainapp  :user="{{Auth::user()}}"  :isloggedin="{{\Illuminate\Support\Facades\Auth::check()}}"></storemainapp>
    @else
        <storemainapp ></storemainapp>

    @endif
</div>
</body>

<script src="{{mix('/js/app.js')}}"></script>
{{--<script src="{{mix('/js/store/app.js')}}"></script>--}}
{{--<script src="{{mix('/js/store/app.js')}}"></script>--}}

</html>
