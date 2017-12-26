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

        <p>
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseBank" aria-expanded="false" aria-controls="collapseExample">
                Bankový účet
            </a>
            <a class="btn btn-primary" data-toggle="collapse" href="#collapsePP" aria-expanded="false" aria-controls="collapseExample">
                PayPal
            </a>
        </p>
        <div class="collapse" id="collapseBank">
            <div class="card card-body">
                <form action="{{route("auth.setBankAccountNumber")}}" method="post">
                {{ csrf_field() }}
                <!-- Invoice Address-->
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="value" class="form-label">Číslo účtu, ktoré sa bude zobrazovat pri uhrade na účet</label>
                            <input id="value" type="text" name="value" value="{{$b_account->iban}}" placeholder="SKkk bbbb rrrr rruu uuuu uuuu" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">
                            <button class="btn btn-template wide next" type="submit">
                                Aktualizovať
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="collapse" id="collapsePP">
            <div class="card card-body">
                <form action="{{route("auth.setPayPalDev")}}" method="post">
                {{ csrf_field() }}
                <!-- Invoice Address-->
                    <div class="row">
                        <a href="https://developer.paypal.com/" target="_blank" class="mx-3">Developer PayPal</a>
                        <div class="form-group col-md-12">
                            <label for="value" class="form-label">PayPal ID</label>
                            <input id="value" type="text" name="paypal_id" value="{{$client_id}}" placeholder="" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="value" class="form-label">PayPal SECRET</label>
                            <input id="value" type="text" name="paypal_secret" value="{{$secret}}" placeholder="" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">
                            <button class="btn btn-template wide next" type="submit">
                                Aktualizovať
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
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
                    <a href="" style="color: black">
                        <i class="fa fa-list alert-secondary p-4 px-5 font-2xl mr-3 float-left"></i>
                    </a>
                    <div class="h5 mb-0 pt-3 text-center">{{$storage}}</div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs text-center">Sklad</div>
                </div>
            </div>
        </div>
        <!--/.col-->

        <div class="col-sm-6 col-lg-3 {{ $shipping == 0 ? "alert-danger" : "" }}">
            <div class="card">
                <div class="card-body p-0 clearfix">
                    <a href="{{ route("admin.shippingMethods") }}" style="color: black">
                        <i class="fa fa-car alert-dark p-4 px-5 font-2xl mr-3 float-left"></i>
                    </a>
                    <div class="h5 mb-0 pt-3 text-center">{{$shipping}}</div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs text-center">Poštovné</div>
                </div>
            </div>
        </div>
        <!--/.col-->




    </div>

@endsection