@extends('layouts.master')

@section('content')

    <main>
        <div id="alertFlash">

        </div>
        <div class="container">
            <div class="row">
                @forelse($products as $product)
                    @skladom($product)
                    @continue
                    @endskladom

                <div class="item col-xl-3 col-lg-4 col-md-6">
                    <div class="product is-gray">
                        <div class="image d-flex align-items-center justify-content-center">
                            <div class="ribbon ribbon-primary text-uppercase">#{{$product->id}}</div>
                            @forelse($product->images as $image)
                                <img src="{{$image->img}}" alt="product" class="img-fluid">
                                @break
                            @empty
                            @endforelse
                            <div class="hover-overlay d-flex align-items-center justify-content-center">
                                <div class="CTA d-flex align-items-center justify-content-center">
                                    <a href="#" class="add-to-cart" id="product-{{$product->id}}">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                    {{--<a href="" class="visit-product active">
                                        <i class="icon-search"></i>
                                        Viac Info
                                    </a>--}}
                                    <a href="#" data-toggle="modal" data-target="#productModal-{{$product->id}}" class="quick-view">
                                        <i class="fa fa-arrows-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="title">
                            {{--<small class="text-muted">Men Wear</small>--}}
                            <a href="">
                                <h3 class="h6 text-uppercase no-margin-bottom">{{$product->name}}</h3>
                            </a>
                            <span class="price text-muted">€{{$product->price}}</span>
                        </div>
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
                                               id="radio{{$sizeCounter}}-{{$product->id}}"
                                               value="{{$size->sizer_id}}"
                                               checked/>
                                    @else
                                        <input type="radio" name="radio-{{$product->id}}"
                                               id="radio{{$sizeCounter}}-{{$product->id}}"
                                               value="{{$size->sizer_id}}"/>
                                    @endif
                                    <label for="radio{{$sizeCounter}}-{{$product->id}}" value="{{$size->sizer_id}}">
                                        {{$size->sizerName($size->sizer_id)}}
                                        -
                                        {{$size->quantities}}ks
                                    </label>
                                </div>


                                @php
                                    $sizeCounter++;
                                @endphp
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>

                    @empty
                    @endforelse

            </div>
        </div>
    </main>



    @forelse($products as $product)
        @skladom($product)
        @continue
        @endskladom
        <!-- Overview Popup    -->
        <div id="productModal-{{$product->id}}" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade overview">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="icon-close fa fa-close"></i></span></button>
                    <div class="modal-body">
                        <div class="ribbon-primary text-uppercase">#{{$product->id}}</div>
                        <div class="row d-flex align-items-center">
                            <div class="image col-lg-5">

                                @forelse($product->images as $image)
                                    <img src="{{$image->img}}" alt="..." class="img-fluid d-block">
                                    @break
                                @empty
                                @endforelse
                            </div>
                            <div class="details col-lg-7">
                                <h2>{{$product->name}}</h2>
                                <ul class="price list-inline">
                                    <li class="list-inline-item current">€{{$product->price}}</li>
                                    <li class="list-inline-item original">€{{$product->price + 3}}</li>
                                </ul>
                                <p>{{$product->description}}</p>
                                <div class="d-flex align-items-center">

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
                                                    <input type="radio" name="radio--{{$product->id}}"
                                                           id="radio{{$sizeCounter}}--{{$product->id}}"
                                                           value="{{$size->sizer_id}}"
                                                           checked/>
                                                @else
                                                    <input type="radio" name="radio--{{$product->id}}"
                                                           id="radio{{$sizeCounter}}--{{$product->id}}"
                                                           value="{{$size->sizer_id}}"/>
                                                @endif
                                                <label for="radio{{$sizeCounter}}--{{$product->id}}" value="{{$size->sizer_id}}">
                                                    {{$size->sizerName($size->sizer_id)}}
                                                    -
                                                    {{$size->quantities}}ks
                                                </label>
                                            </div>


                                            @php
                                                $sizeCounter++;
                                            @endphp
                                        @empty
                                        @endforelse
                                    </div>

                                </div>
                                <ul class="CTAs list-inline">
                                    <li class="list-inline-item"><a href="#" class="btn btn-template wide" id="product--{{$product->id}}"> <i class="fa fa-shopping-cart"></i>Pridať do košíka</a></li>
                                    {{--<li class="list-inline-item"><a href="#" class="visit-product active btn btn-template-outlined wide"> <i class="icon-heart"></i>Add to wishlist</a></li>--}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @empty
    @endforelse



@endsection



        @section("script")
            <script>
                var $productAddedFlash = "<div class=\"alert-flash alert alert-success alert-dismissible fade show\" role=\"alert\">\n" +
                    "  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                    "    <span aria-hidden=\"true\">&times;</span>\n" +
                    "  </button>\n" +
                    "  <strong>:)</strong> Produkt bol pridaný.   \n" +
                    "</div>";
                var CartCount = {{ Session::has("cart") ? Session::get("cart")->totalQty : "0" }} ;
                var CartPrice = {{ Session::has("cart") ? Session::get("cart")->totalPrice : "0" }} ;
                var size;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                // product
                @forelse($products as $productsjs)
                @skladom($productsjs)
                @continue
                @endskladom
                $("#product-{{$productsjs->id}}").click(function () {
                    var radios{{$productsjs->id}} = document.getElementsByName('radio-{{$productsjs->id}}');
                    for (var i = 0, length = radios{{$productsjs->id}}.length; i < length; i++) {
                        if (radios{{$productsjs->id}}[i].checked) {
                            // do whatever you want with the checked radio
                            size = radios{{$productsjs->id}}[i].value;
                            // only one radio can be logically checked, don't check the rest
                            break;
                        }
                    }
                    $.ajax({
                        type: "post",
                        url: '/add-to-cart/{{$productsjs->id}}/' + size,
                        success: function () {
                            CartCount++;
                            CartPrice += {{$product->price}};
                            $("#shoppingCartCounter").html(CartCount);
                            $("#shoppingCartTotalPrice").html(CartPrice + "€");
                            $("#alertFlash").html($productAddedFlash);
                            //console.log("Produkt bol pridani");
                            //console.log("Velkost produktu je : " + size); // size contain value of checked radio box
                        }

                    })
                });
                @empty
                @endforelse

                //product modal
                @forelse($products as $productsjs)
                @skladom($productsjs)
                @continue
                @endskladom
                $("#product--{{$productsjs->id}}").click(function () {
                    var radios{{$productsjs->id}} = document.getElementsByName('radio--{{$productsjs->id}}');
                    for (var i = 0, length = radios{{$productsjs->id}}.length; i < length; i++) {
                        if (radios{{$productsjs->id}}[i].checked) {
                            // do whatever you want with the checked radio
                            size = radios{{$productsjs->id}}[i].value;
                            // only one radio can be logically checked, don't check the rest
                            break;
                        }
                    }
                    $.ajax({
                        type: "post",
                        url: '/add-to-cart/{{$productsjs->id}}/' + size,
                        success: function () {
                            CartCount++;
                            CartPrice += {{$product->price}};
                            $("#shoppingCartCounter").html(CartCount);
                            $("#shoppingCartTotalPrice").html(CartPrice + "€");
                            $("#alertFlash").html($productAddedFlash);
                            //console.log("Produkt bol pridani");
                            //console.log("Velkost produktu je : " + size); // size contain value of checked radio box
                        }

                    })
                });
                @empty
                @endforelse
            </script>
@endsection