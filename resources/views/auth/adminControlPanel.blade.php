@extends('layouts.master')

@section('content')
    <h1>Objednávky</h1>

    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body p-0 clearfix">
                    <a href="{{route("auth.adminOrders")}}" style="color: black">
                        <i class="fa fa-shopping-cart bg-primary p-4 px-5 font-2xl mr-3 float-left"></i>
                    </a>
                    <div class="h5 mb-0 pt-3 text-center"> {{ count($orders)}}</div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs text-center">Objednávky</div>
                </div>
            </div>
        </div>
        <!--/.col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body p-0 clearfix">
                    <a href="{{route("auth.adminPaydOrders")}}" style="color: black">
                        <i class="fa fa-euro bg-danger p-4 px-5 font-2xl mr-3 float-left"></i>
                    </a>
                    <div class="h5 mb-0 pt-3 text-center"> {{$payd_orders}}/ {{count($orders)}}</div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs text-center">Zaplatené</div>
                </div>
            </div>
        </div>
        <!--/.col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body p-0 clearfix">
                    <a href="" style="color: black">
                        <i class="fa fa-car bg-success p-4 px-5 font-2xl mr-3 float-left"></i>
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
                        <i class="fa fa-ban bg-info p-4 px-5 font-2xl mr-3 float-left"></i>
                    </a>
                    <div class="h5 mb-0 pt-3 text-center">{{$completed_orders}} / {{ count($orders)}}</div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs text-center">Prevziaté</div>
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>

    <h1>Produkt</h1>

    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body p-0 clearfix">
                    <a href="" style="color: black">
                        <i class="fa fa-shopping-cart bg-primary p-4 px-5 font-2xl mr-3 float-left"></i>
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
                        <i class="fa fa-laptop bg-danger p-4 px-5 font-2xl mr-3 float-left"></i>
                    </a>
                    <div class="h5 mb-0 pt-3 text-center"></div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs text-center"></div>
                </div>
            </div>
        </div>
        <!--/.col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body p-0 clearfix">
                    <a href="" style="color: black">
                        <i class="fa fa-moon-o bg-success p-4 px-5 font-2xl mr-3 float-left"></i>
                    </a>
                    <div class="h5 mb-0 pt-3 text-center"></div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs text-center"></div>
                </div>
            </div>
        </div>
        <!--/.col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body p-0 clearfix">
                    <a href="" style="color: black">
                        <i class="fa fa-bell bg-info p-4 px-5 font-2xl mr-3 float-left"></i>
                    </a>
                    <div class="h5 mb-0 pt-3 text-center"></div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs text-center"></div>
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>

@endsection