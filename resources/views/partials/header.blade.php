<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{route("product.home")}}">DEKOJA.sk</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{Nav::isRoute("product.home", "active")}}">
                <a class="nav-link" href="{{route("product.home")}}">Domov <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto navbar-right">
            <li class="nav-item">
                <a class="nav-link" href="{{route("product.shopingCart")}}"><i class="fa fa-shopping-cart"
                                                                               aria-hidden="true"></i>
                    <span class="badge badge-secondary" id="shoppingCartCounter">
                        {{ Session::has("cart") ? Session::get("cart")->totalQty : "0" }}
                    </span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    Môj účet
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    @if(Auth::check())
                        @can("admin_only", Auth::user())
                            <a class="dropdown-item" href="{{route("auth.adminControlPanel")}}">
                                <i class="fa fa-cog" aria-hidden="true"></i>
                                Admin Panel
                            </a>
                        @endcan
                        <a class="dropdown-item" href="{{route("auth.orders")}}">
                            <i class="fa fa-list" aria-hidden="true"></i>
                            Objednávky
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route("auth.logout")}}">
                            <i class="fa fa-power-off" aria-hidden="true"></i>
                            Odhlásiť sa
                        </a>
                    @else
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#loginModal">
                            <i class="fa fa-sign-in" aria-hidden="true"></i>
                            Prihlásiť sa
                        </a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#registerModal">
                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                            Zaregistrovať sa
                        </a>
                    @endif
                </div>
            </li>
        </ul>
    </div>

</nav>