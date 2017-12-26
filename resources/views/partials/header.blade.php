{{--<nav class="navbar navbar-expand-lg navbar-dark bg-info">

    <ul class="navbar-nav mx-auto">

            <li class="nav-item">
                <h1>DEMO VERZIA - testovanie</h1>
            </li>

    </ul>
</nav>--}}


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <ul class="navbar-nav mx-auto">
        @if(Auth::check())
            @can("admin_only", Auth::user())
                <li class="nav-item">
                    <a href="{{route("auth.adminControlPanel")}}"
                       class="nav-link {{Nav::isRoute("auth.adminControlPanel", "active")}}"><span
                                class="fa fa-modx"></span> Admin Panel</a>
                </li>
            @endcan

            <li class="nav-item">
                <a href="{{route("auth.orders")}}" class="nav-link {{Nav::isRoute("auth.orders", "active")}}"><span
                            class="fa fa-list"></span> Objednávky</a>
            </li>
            <li class="nav-item">
                <a href="{{route("auth.logout")}}" class="nav-link"><span class="fa fa-power-off"></span> Odhlásiť
                    sa</a>
            </li>

        @else
            <li class="nav-item">
                <a href="#" data-toggle="modal" data-target="#loginModal" class="nav-link">Prihlásiť sa</a>
            </li>
            <li class="nav-item">
                <a href="#" data-toggle="modal" data-target="#registerModal" class="nav-link">Zaregistrovať</a>
            </li>
        @endif
    </ul>
</nav>


<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <!-- Navbar Header  --><a href="{{route("product.home")}}" class="navbar-brand"><img
                    src="{{asset("img/logo.png")}}" alt="DEKOJA.SK"></a>
        <button type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse"
                aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i
                    class="fa fa-bars"></i></button>
        <!-- Navbar Collapse -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a href="{{route("product.home")}}" class="nav-link {{Nav::isRoute("product.home", "active")}}">Domov</a>
                </li>
                {{--<li class="nav-item">
                    <a href="" class="nav-link">Kontakt</a>
                </li>--}}
            </ul>
            <div class="right-col d-flex align-items-lg-center flex-column flex-lg-row">
                <!-- Search Button-->
            {{--<div class="search"><i class="icon-search fa fa-search"></i></div>--}}
            <!-- Cart Dropdown-->
                <div class="cart dropdown"><a id="cartdetails" href="https://example.com" data-toggle="dropdown"
                                              aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i
                                class="icon-cart fa fa-shopping-basket"></i>
                        <div class="cart-no" id="shoppingCartCounter">
                            {{ Session::has("cart") ? Session::get("cart")->totalQty : "0" }}
                        </div>
                    </a><a href="{{route("product.shopingCart")}}" class="text-primary view-cart">Nákupný košík</a>
                    <div aria-labelledby="cartdetails" class="dropdown-menu">
                        <!-- cart item-->
                    @if(Session::has("cart"))
                            @php
                                $sessionCart = Session::get("cart")->items;
                            @endphp
                        @forelse($sessionCart as $product)
                                <div class="dropdown-item cart-product">
                                    <div class="d-flex align-items-center">
                                        <div class="img">
                                            @foreach($product["item"]->images as $image)
                                                <img src="{{$image->img}}" alt="..." class="img-fluid">
                                                @break
                                            @endforeach
                                        </div>
                                        <div class="details d-flex justify-content-between">
                                            <div class="text">
                                                <a href="#"><strong></strong></a>
                                                <small>Veľkost/i: {{$product["info"]}} </small>
                                                <span class="price">€{{$product["item"]["price"]}}.00 </span>
                                            </div>
                                            <a href="{{route("product.reduceByItemCart", $product["item"]["id"])}}" class="delete">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        @empty
                        @endforelse
                    @endif
                    <!-- total price-->
                        <div class="dropdown-item total-price d-flex justify-content-between"><span>Celková suma</span>
                            <strong class="text-primary" id="shoppingCartTotalPrice">
                                {{ Session::has("cart") ? Session::get("cart")->totalPrice : "0" }}€
                            </strong></div>
                        <!-- call to actions-->
                        <div class="dropdown-item CTA d-flex">
                            <a href="{{route("product.shopingCart")}}" class="btn btn-template wide">Nákupný Košík</a>
                            <a href="{{route("product.checkout")}}" class="btn btn-template wide">Objednať</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>


