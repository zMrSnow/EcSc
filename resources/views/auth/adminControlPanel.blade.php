@extends('layouts.master')

@section('content')
    <section class="hero hero-page padding-small">
        <div class="container-">
            <div class="row d-flex">
                <div class="col-lg-9 order-2 order-lg-1">
                    <h1>Objednávky</h1><p class="lead text-muted">ACP objednávky</p>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body p-0 clearfix">
                    <a href="{{route("auth.adminOrders")}}" style="color: black">
                        <i class="fa fa-shopping-cart alert-primary p-4 px-5 font-2xl mr-3 float-left"></i>
                    </a>
                    <div class="h5 mb-0 pt-3 text-center"> {{ count($orders)}}</div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs text-center">Objednávky</div>
                </div>
            </div>
        </div>
        <!--/.col-->

        <div class="col-sm-6 col-lg-3 {{ $payd_orders ? "alert-danger" : "" }}">
            <div class="card">
                <div class="card-body p-0 clearfix">
                    <a href="{{route("auth.adminPaydOrders")}}" style="color: black">
                        <i class="fa fa-euro alert-danger p-4 px-5 font-2xl mr-3 float-left"></i>
                    </a>
                    <div class="h5 mb-0 pt-3 text-center"> {{$payd_orders}}</div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs text-center">Zaplatené</div>
                </div>
            </div>
        </div>
        <!--/.col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body p-0 clearfix">
                    <a href="" style="color: black">
                        <i class="fa fa-car alert-success p-4 px-5 font-2xl mr-3 float-left"></i>
                    </a>
                    <div class="h5 mb-0 pt-3 text-center"> {{$expand_order}}/ {{count($orders)}}</div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs text-center">Odoslané</div>
                </div>
            </div>
        </div>
        <!--/.col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body p-0 clearfix">
                    <a href="" style="color: black">
                        <i class="fa fa-ban alert-info p-4 px-5 font-2xl mr-3 float-left"></i>
                    </a>
                    <div class="h5 mb-0 pt-3 text-center">{{$completed_orders}} / {{ count($orders)}}</div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs text-center">Prevziaté</div>
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>

    <hr>

    <section class="hero hero-page padding-small">
        <div class="container-">
            <div class="row d-flex">
                <div class="col-lg-9 order-2 order-lg-1">
                    <h1>Produkty a Doprava</h1><p class="lead text-muted">iba produkty ktore su skladom môžu byt zakupené, aspon jedna doprava musi byt</p>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body p-0 clearfix">
                    <a href="{{ route("auth.adminProoducts") }}" style="color: black">
                        <i class="fa fa-shopping-cart alert-warning p-4 px-5 font-2xl mr-3 float-left"></i>
                    </a>
                    <div class="h5 mb-0 pt-3 text-center">{{$availble_products}} / {{ count($products)}}</div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs text-center">Produkty</div>
                </div>
            </div>
        </div>
        <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body p-0 clearfix">
                        <a href="{{ route("admin.shippingMethods") }}" style="color: black">
                            <i class="fa fa-car alert-dark p-4 px-5 font-2xl mr-3 float-left"></i>
                        </a>
                        <div class="h5 mb-0 pt-3 text-center"></div>
                        <div class="text-muted text-uppercase font-weight-bold font-xs text-center">Poštovné</div>
                    </div>
                </div>
            </div>
            <!--/.col-->


    </div>

@endsection