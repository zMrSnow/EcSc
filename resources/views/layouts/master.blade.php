<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>@yield("title", "DEKOJA")</title>
    <link rel="stylesheet" href="{{asset("css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("css/font-awesome.min.css")}}">
    <link rel="stylesheet" href="{{asset("css/customStyle.css")}}">
    @yield("styles")
</head>
<body>
@include("partials.header")

<div class="container">
    @include("partials.errors")
</div>

<div class="container">
    @yield("content")
</div>

@include("auth.loginModal")
@include("auth.registerModal")

@include("partials.footer")
<script src="{{asset("js/jquery-3.2.1.min.js")}}"></script>
<script src="{{asset("js/popper.min.js")}}"></script>
<script src="{{asset("js/bootstrap.min.js")}}"></script>
@yield("script")

</body>
</html>