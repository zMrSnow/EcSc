@extends('layouts.master')

@section("styles")
    <style>
        .card-01 .badge-box{position:absolute; top:47.5%; left:90%; width:100px; height:100px;margin-left:-50px; text-align:center;}
        .card-01 .badge-box-price{position:absolute; top:0%; right: 0; width:100px; height:100px;margin-left:-50px; text-align:center;}
        .card-01 .badge-box i{background: #df7d3f; color:#fff; border-radius:50%;  width:50px; height:50px; line-height:50px; text-align:center; font-size:20px;}
        .card-01 .badge-box-price{background: #df7d3f; color:#fff;  width:65px; height:25px; line-height:25px; text-align:center; font-size:20px;}
        .card-01 .badge-box i:hover{background: #df5122; color:#fff; border-radius:50%;  width:50px; height:50px; line-height:50px; text-align:center; font-size:20px;}
        .card-01 .badge-box-price:hover{background: #df5122; color:#fff; width:65px; height:25px; line-height:25px; text-align:center; font-size:20px;}
        .row > div {margin: 10px 0}

        .funkyradio div {
            clear: both;
            overflow: hidden;
        }
        .funkyradio label {
            width: 100%;
            text-align: center;
            padding-right: 10px;
            border-radius: 3px;
            border: 1px solid #D1D3D4;
            font-weight: normal;
        }
        .funkyradio input[type="radio"]:empty {
            display: none;
        }
        .funkyradio input[type="radio"]:empty ~ label {
            position: relative;
            line-height: 25px;
            text-indent: 20px;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .funkyradio input[type="radio"]:empty ~ label:before{
            position: absolute;
            display: block;
            top: 0;
            bottom: 0;
            left: 0;
            content: '';
            width: 10px;
            background: #D1D3D4;
            border-radius: 3px 0 0 3px;
        }

        .funkyradio input[type="radio"]:hover:not(:checked) ~ label {
            color: #888;
        }
        .funkyradio input[type="radio"]:hover:not(:checked) ~ label:before {
           /* content: '\2714';*/
            text-indent: 0px;
            color: #C2C2C2;
        }
        .funkyradio input[type="radio"]:checked ~ label {
            color: #771623;
        }
        .funkyradio input[type="radio"]:checked ~ label:before {
            /*content: '\2714';*/
            text-indent: 0px;
            color: #333;
            background-color: #ccc;
        }
        .funkyradio input[type="radio"]:focus ~ label:before {
            box-shadow: 0 0 0 3px #999;
        }
        .funkyradio-default input[type="radio"]:checked ~ label:before {
            color: #333;
            background-color: #cc81c2;
        }

        .funkyradio-primary input[type="radio"]:checked ~ label:before {
            color: #fff;
            background-color: #337ab7;
        }

        .funkyradio-success input[type="radio"]:checked ~ label:before {
            color: #fff;
            background-color: #5cb85c;
        }

        .funkyradio-danger input[type="radio"]:checked ~ label:before {
            color: #fff;
            background-color: #d9534f;
        }

        .funkyradio-warning input[type="radio"]:checked ~ label:before{
            color: #fff;
            background-color: #f0ad4e;
        }

        .funkyradio-info input[type="radio"]:checked ~ label:before {
            color: #fff;
            background-color: #5bc0de;
        }
    </style>
    @endsection

@section('content')
    <div class="row">
        @for($i = 0; $i < 5; $i++)
            <div class="col-md-4">
                <div class="card card-01">
                    <div id="carouselExampleControls-{{$i}}" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <img class="d-block img-fluid" src="https://images.pexels.com/photos/534164/pexels-photo-534164.jpeg?h=350&auto=compress&cs=tinysrgb" alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block img-fluid" src="https://images.pexels.com/photos/247599/pexels-photo-247599.jpeg?h=350&auto=compress&cs=tinysrgb" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block img-fluid" src="https://images.pexels.com/photos/66997/pexels-photo-66997.jpeg?h=350&auto=compress&cs=tinysrgb" alt="Third slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls-{{$i}}" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Predchadzajuci</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls-{{$i}}" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Dalsi</span>
                        </a>
                    </div>
                    <div class="card-body">
                        <span class="badge-box"><i class="fa fa-cart-plus" aria-hidden="true"></i></span>
                        <span class="badge-box-price"><i class="fa fa-euro" aria-hidden="true"></i> 99.0</span>
                        <h4 class="card-title">Názov produktu</h4>
                        <hr>

                        <div class="funkyradio row m-auto">
                            <div class="funkyradio-default">
                                <input type="radio" name="radio-{{$i}}" id="radio1-{{$i}}" />
                                <label for="radio1-{{$i}}">XS</label>
                            </div>
                            <div class="funkyradio-primary">
                                <input type="radio" name="radio-{{$i}}" id="radio2-{{$i}}" checked/>
                                <label for="radio2-{{$i}}">S</label>
                            </div>
                            <div class="funkyradio-success">
                                <input type="radio" name="radio-{{$i}}" id="radio3-{{$i}}" />
                                <label for="radio3-{{$i}}">M</label>
                            </div>
                            <div class="funkyradio-danger">
                                <input type="radio" name="radio-{{$i}}" id="radio4-{{$i}}" />
                                <label for="radio4-{{$i}}">L</label>
                            </div>
                            <div class="funkyradio-warning">
                                <input type="radio" name="radio-{{$i}}" id="radio5-{{$i}}" />
                                <label for="radio5-{{$i}}">XL</label>
                            </div>
                            <div class="funkyradio-info">
                                <input type="radio" name="radio-{{$i}}" id="radio6-{{$i}}" />
                                <label for="radio6-{{$i}}">XXL</label>
                            </div>
                        </div>

                        <a href="#" class="btn btn-outline-info text-uppercase btn-block">Viac informácií</a>

                    </div>
                </div>
            </div>
        @endfor
    </div>
@endsection