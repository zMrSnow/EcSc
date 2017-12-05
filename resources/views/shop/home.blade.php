@extends('layouts.master')

@section('content')
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4">
                <div class="card card-01">
                    <div id="carouselExampleControls-{{$product->id}}" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            @php
                                $counter = false;
                            @endphp
                            @forelse($product->images as $image)
                                @if($counter)
                                    <div class="carousel-item">
                                        @else
                                            <div class="carousel-item active">
                                                @php
                                                    $counter = true;
                                                @endphp
                                                @endif
                                                <img class="d-block img-fluid"
                                                     src="{{$image->img}}"
                                                     alt="slide">
                                            </div>

                                            @empty
                                                <div class="carousel-item active">
                                                    <img class="d-block img-fluid"
                                                         src="http://vollrath.com/ClientCss/images/VollrathImages/No_Image_Available.jpg"
                                                         alt="slide">
                                                </div>
                                            @endforelse
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleControls-{{$product->id}}"
                                       role="button"
                                       data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Predchadzajuci</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls-{{$product->id}}"
                                       role="button"
                                       data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Dalsi</span>
                                    </a>
                        </div>
                        <div class="card-body">
                            <span class="badge-box" id="product-{{$product->id}}"><i class="fa fa-cart-plus" aria-hidden="true"></i></span>
                            <span class="badge-box-price"><i class="fa fa-euro"
                                                             aria-hidden="true"></i> {{$product->price}}</span>
                            <h4 class="card-title">{{$product->name}}</h4>
                            <hr>

                            <div class="funkyradio row m-auto">
                                @php
                                    $sizeCounter = 1;
                                    $siteArray = [
                                        "",
                                        "default",
                                        "primary",
                                        "success",
                                        "danger",
                                         "warning",
                                         "info"
                                    ];
                                @endphp
                                @forelse($product->sizes as $size)
                                    <div class="funkyradio-{{$siteArray[$sizeCounter]}}">
                                        @if($sizeCounter == 1)
                                            <input type="radio" name="radio-{{$product->id}}"
                                                   id="radio{{$sizeCounter}}-{{$product->id}}" value="{{$sizeCounter}}" checked/>
                                        @else
                                            <input type="radio" name="radio-{{$product->id}}"
                                                   id="radio{{$sizeCounter}}-{{$product->id}}" value="{{$sizeCounter}}" />
                                        @endif
                                        <label for="radio{{$sizeCounter}}-{{$product->id}}" value="{{$sizeCounter}}" >XS</label>
                                    </div>


                                    @php
                                        $sizeCounter++;
                                    @endphp
                                @empty
                                @endforelse
                            </div>
                            <a href="#" class="btn btn-outline-info text-uppercase btn-block">Viac informácií</a>
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
@endsection

@section("script")
    <script>
        var CartCount = {{ Session::has("cart") ? Session::get("cart")->totalQty : "0" }} ;
        var size;
        @forelse($products as $productsjs)
            $("#product-{{$productsjs->id}}").click(function () {

                var radios{{$productsjs->id}} = document.getElementsByName('radio-{{$productsjs->id}}');
                for (var i = 0, length = radios{{$productsjs->id}}.length; i < length; i++)
                {
                    if (radios{{$productsjs->id}}[i].checked)
                    {
                        // do whatever you want with the checked radio
                        size = radios{{$productsjs->id}}[i].value;

                        // only one radio can be logically checked, don't check the rest
                        break;
                    }
                }

                $.ajax({
                    type: "get",
                    url: "{{route("product.addToCartAjax", $productsjs->id)}}",
                    success: function () {
                        CartCount++;
                        $("#shoppingCartCounter").html(CartCount);
                        console.log("Produkt bol pridani");
                        console.log("Velkost produktu je : " + size); // size obsahuje hodnotu radioboxu
                    }
                })
            });
        @empty
        @endforelse
    </script>
@endsection