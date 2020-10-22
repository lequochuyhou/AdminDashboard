<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Car dealers</title>

{{--   // <link rel="stylesheet" href="/css/all.css">--}}
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/fontAwesome.css">
    <link rel="stylesheet" href="/css/hero-slider.css">
    <link rel="stylesheet" href="/css/owl-carousel.css">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <!-- Fonts -->

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
<div id="storeapp">
    @if(Auth::check())
        <storemainapp :user="{{Auth::user()}}" :permission="{{Auth::user()->role->permission}}"></storemainapp>
    @else
        <storemainapp :user="false"></storemainapp>
    @endif
</div>
</body>
<script src="/js/modernizr-2.8.3-respond-1.4.2.min.js"></script>
<script src="{{mix('/js/app.js')}}"></script>

</html>
