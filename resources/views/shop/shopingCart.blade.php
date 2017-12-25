@extends('layouts.master')

@section('content')

    <section class="hero hero-page padding-small">
        <div class="container-">
            <div class="row d-flex">
                <div class="col-lg-9 order-2 order-lg-1">
                    <h1>Nákupný košík</h1><p class="lead text-muted">iba produkty ktore su skladom môžu byt zakupené</p>
                </div>
                <div class="col-lg-3 text-right order-1 order-lg-2">
                    <ul class="breadcrumb justify-content-lg-end">
                        <li class="breadcrumb-item"><a href="{{route("product.home")}}">Domov</a></li>
                        <li class="breadcrumb-item active">Nákupný košík</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    @if(Session::has("cart"))
        <section class="shopping-cart">
            <div class="container">
                <div class="basket">
                    <div class="basket-holder">
                        <div class="basket-header">
                            <div class="row">
                                <div class="col-5">Produkt</div>
                                <div class="col-2">Cena</div>
                                <div class="col-2">?</div>
                                <div class="col-2">Celkom</div>
                                <div class="col-1 text-center">Vymazať</div>
                            </div>
                        </div>
                        <div class="basket-body">
                            <!-- Product-->
                            @forelse($products as $product)

                                <div class="item">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-5">
                                            <div class="d-flex align-items-center">
                                                @foreach($product["item"]->images as $image)
                                                    <img src="{{$image->img}}" alt="..." class="img-fluid">
                                                    @break
                                                @endforeach
                                                <div class="title"><a href="detail.html">
                                                        <h5>{{$product["item"]["name"]}}t</h5><span class="text-muted">Veľkosti: {{$product["info"]}}</span></a></div>
                                            </div>
                                        </div>
                                        <div class="col-2"><span>€{{$product["item"]["price"]}}.00</span></div>
                                        <div class="col-2">
                                            <div class="d-flex align-items-center">
                                                <div class="quantity d-flex align-items-center">
                                                    {{--<div class="dec-btn">-</div>
                                                    <input type="text" value="4" class="quantity-no">
                                                    <div class="inc-btn">+</div>--}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <span>€{{$product["item"]["price"] * $product["qty"]}}.00</span>
                                        </div>
                                        <div class="col-1 text-center">
                                            <a href="{{route("product.reduceByItemCart", $product["item"]["id"])}}">
                                                <i class="delete fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="CTAs d-flex align-items-center justify-content-center justify-content-md-end flex-column flex-md-row">
                    <div class="col-6"><span>Celková cena bez poštovného: <b>{{$totalPrice}}.00€</b></span></div>
                    <a href="{{route("product.home")}}" class="btn btn-template-outlined wide">
                        Pokračovať v nakupovaní</a>
                    <a href="{{route("product.checkout")}}" class="btn btn-template wide">Objednať <i class="fa fa-long-arrow-right"></i>
                    </a>

                </div>
            </div>
        </section>

        {{--<section class="order-details no-padding-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="block">
                            <div class="block-header">
                                <h6 class="text-uppercase">Zlavový kupón</h6>
                            </div>
                            <div class="block-body">
                                <p>Ak vlastnite zlavový kupón, použite ho tu</p>
                                <form action="#">
                                    <div class="form-group d-flex">
                                        <input type="text" name="coupon">
                                        <button type="submit" class="cart-black-button">Použiť kupón</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>--}}
    @endif

@endsection

@section("script")


@endsection