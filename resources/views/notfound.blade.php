<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Page is not found</title>

    <link rel="stylesheet" href="/css/all.css">
    <!-- Fonts -->


    <script>
        (function() {
            window.Laravel = {
                csrfToken: '{{csrf_token()}}'
            }
        })();
    </script>
</head>

<body>
<div class="content">
    <div class="container-fluid">
        <h3 class="_text_center">You are not permitted to access this page ..</h3>
    </div>
</div>

</body>
{{--<script src="{{mix('/js/app.js')}}"></script>--}}

</html>
