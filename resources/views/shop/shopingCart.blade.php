@extends('layouts.master')

@section('content')
    @if(Session::has("cart"))


        <div class="card shopping-cart">
            <div class="card-header bg-dark text-light">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                Nákupný košík
                <a href="{{route("product.home")}}" class="btn btn-outline-info btn-sm pull-right">Pokračovať v
                    nakupovaní</a>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                @foreach($products as $product)

                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-2 text-center">
                            @foreach($product["item"]->images as $image)
                                <img class="img-responsive" src="{{$image->img}}" alt="prewiew" width="120" height="80">
                                @break
                            @endforeach
                        </div>
                        <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6">
                            <h4 class="product-name"><strong>{{$product["item"]["name"]}}</strong></h4>
                            <h4>
                                <small>Product description</small>
                            </h4>
                        </div>
                        <div class="col-12 col-sm-12 text-sm-center col-md-4 text-md-right row">
                            <div class="col-3 col-sm-3 col-md-6 text-md-right" style="padding-top: 5px">
                                <h6><strong>{{$product["item"]["price"]}}.00 <span class="text-muted">x</span></strong></h6>
                            </div>
                            <div class="col-4 col-sm-4 col-md-4">
                                <div class="quantity">
                                    <input type="button" value="+" class="plus">
                                    <input type="number" step="1" max="99" min="1" value="{{$product["qty"]}}" title="Qty" class="qty"
                                           size="4">
                                    <input type="button" value="-" class="minus">
                                </div>
                            </div>
                            <div class="col-2 col-sm-2 col-md-2 text-right">
                                <button type="button" class="btn btn-outline-danger btn-xs">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr>

                @endforeach


                <div class="pull-right">
                    <a href="{{route("product.home")}}" class="btn btn-outline-secondary pull-right">Aktualizovať
                        košík</a>
                </div>
            </div>
            <div class="card-footer">
                <div class="coupon col-md-5 col-sm-5 no-padding-left pull-left">
                    <div class="row">
                        <div class="col-6">
                            <input type="text" class="form-control" placeholder="Kód kupónu">
                        </div>
                        <div class="col-6">
                            <input type="submit" class="btn btn-default" value="Použiť kupón">
                        </div>
                    </div>
                </div>
                <div class="pull-right" style="margin: 10px">
                    <a href="{{route("product.checkout")}}" class="btn btn-success pull-right">Objednať</a>
                    <div class="pull-right" style="margin: 5px">
                        Celková cena: <b>{{$totalPrice + 2}}.00€</b>
                    </div>
                </div>
            </div>
        </div>

    @else
    @endif
@endsection

@section("script")

    <script>
    </script>

@endsection