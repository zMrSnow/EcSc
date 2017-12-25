<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="all,follow">
    <meta property="fb:app_id" content="" />
    <meta property="og:locale" content="sk_SK" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="dekoja.sk" />
    <meta property="og:image" content="https://www.dekoja.sk/img/logo.png" />
    <meta property="og:image:width" content="200" />
    <meta property="og:image:height" content="50" />
    <meta property="og:url" content="https://dekoja.sk" />
    <meta property="og:description" content="Domáce výrobky, čiapky, nohavice, šály, ..." />
    <meta property="og:site_name" content="Dekoja.sk - Domáce výrobky, čiapky, nohavice, šály, ..." />

    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>@yield("title", "DEKOJA")</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
    <link rel="stylesheet" href="{{asset("css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("css/font-awesome.min.css")}}">
    <link rel="stylesheet" href="{{asset("css/customStyle.css")}}">
    <link rel="stylesheet" href="{{asset("css/cTheme.css")}}">
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

<footer class=" main-footer">

    <div class="copyrights">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="text col-md-6">
                    <p>© 2017, <a href="" target="_blank"></a> Vytvoril <a href="https://snowfox.sk" target="_blank"><b>SnowFox.sk</b></a> </p>
                </div>
                <div class="payment col-md-6 clearfix">
                    <ul class="payment-list list-inline-item pull-right">
                        <li class="list-inline-item">
                            <img src="https://d32d8xzgnjxuvk.cloudfront.net/hub/1-2/img/paypal.svg" alt="...">
                        </li>
                        <li class="list-inline-item">
                            <img src="https://d32d8xzgnjxuvk.cloudfront.net/hub/1-2/img/western-union.svg" alt="...">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</footer>

@include("partials.footer")
<script src="{{asset("js/jquery-3.2.1.min.js")}}"></script>
<script src="{{asset("js/popper.min.js")}}"></script>
<script src="{{asset("js/bootstrap.min.js")}}"></script>
@yield("script")

</body>
</html>