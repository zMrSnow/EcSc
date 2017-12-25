@extends('layouts.master')

@section('content')
    <section class="hero hero-page padding-small">
        <div class="container-">
            <div class="row d-flex">
                <div class="col-lg-9 order-2 order-lg-1">
                    <h1>Moje objednávky</h1><p class="lead text-muted">tu sledujete stav objednavok a pladby za objednavky</p>
                </div>
                <div class="col-lg-3 text-right order-1 order-lg-2">
                    <ul class="breadcrumb justify-content-lg-end">
                        <li class="breadcrumb-item"><a href="{{route("product.home")}}">Domov</a></li>
                        <li class="breadcrumb-item active">Objednávky</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    <p class="text-center">
        <a class="btn btn-outline-danger active" data-toggle="collapse" href="#neuhradene" aria-expanded="true"
           aria-controls="collapseExample">
            Neuhradené
        </a>
        <a class="btn btn-outline-success" data-toggle="collapse" href="#uhradene" aria-expanded="false"
           aria-controls="collapseExample">
            Uhradené
        </a>
    </p>
    <div class="collapse show" id="neuhradene">
        <div class="card card-body">

            @forelse($orders as $order)
                @if($order->status == 0)
                    <div class="card break">
                        <div class="card-header">
                            # {{$order->id}}
                            @switch($order->status)
                                @case(0)
                                <span class="badge badge-danger pull-right">Neuhradené</span>
                                @break
                                @case(1)
                                <span class="badge badge-success pull-right">Uhradené</span>
                                <span class="badge badge-warning pull-right">Neodoslané</span>
                                @break
                                @case(2)
                                <span class="badge badge-success pull-right">Uhradené</span>
                                <span class="badge badge-success pull-right">Odoslané</span>
                                @break
                            @endswitch
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Názov produktu</th>
                                    <th scope="col">Množstvo</th>
                                    <th scope="col">Veľkosť</th>
                                    <th scope="col">Cena za kus</th>

                                </tr>
                                </thead>
                                <tbody>
                                @forelse($order->cart->items as $item)
                                    <tr>
                                        <th scope="row">{{$item["item"]["id"]}}</th>
                                        <td>{{$item["item"]["name"]}}</td>
                                        <td>{{$item["qty"]}}</td>
                                        <td>{{$item["info"]}}</td>
                                        <td>{{$item["item"]["price"]}}€</td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>


                        </div>
                        <div class="card-footer text-muted text-right">
                            Celkova suma: € {{$order->price}}
                            @if($order->status == 0)
                                <form action="{{route("paypal.pay", $order->id)}}" method="post">
                                    <button type="submit" class="btn btn-outline-info pull-left">
                                        <span class="fa fa-paypal"></span> PayPal - SandBox
                                    </button>
                                    <a href="#" class="btn btn-outline-info pull-left" data-toggle="modal" data-target="#bankPayment">
                                       <span class="fa fa-bank"></span> Prevodom na účet
                                    </a>
                                    {{ csrf_field() }}
                                </form>
                            @endif
                        </div>
                    </div>
                    <hr>
                @endif
            @empty
                <p>Nemate ešte žiadnu objednávku</p>
            @endforelse

        </div>
    </div>
    <div class="collapse" id="uhradene">
        <div class="card card-body">
            @forelse($orders as $order)
                @if($order->status != 0)
                    <div class="card break">
                        <div class="card-header">
                            # {{$order->id}}
                            @switch($order->status)
                                @case(0)
                                <span class="badge badge-danger pull-right">Neuhradené</span>
                                @break
                                @case(1)
                                <span class="badge badge-success pull-right">Uhradené</span>
                                <span class="badge badge-warning pull-right">Neodoslané</span>
                                @break
                                @case(2)
                                <span class="badge badge-success pull-right">Uhradené</span>
                                <span class="badge badge-success pull-right">Odoslané</span>
                                @break
                                @case(3)
                                <span class="badge badge-success pull-right">Prevziaté</span>
                                @break
                            @endswitch
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Názov produktu</th>
                                    <th scope="col">Množstvo</th>
                                    <th scope="col">Veľkosť</th>
                                    <th scope="col">Cena za kus</th>

                                </tr>
                                </thead>
                                <tbody>
                                @forelse($order->cart->items as $item)
                                    <tr>
                                        <th scope="row">{{$item["item"]["id"]}}</th>
                                        <td>{{$item["item"]["name"]}}</td>
                                        <td>{{$item["qty"]}}</td>
                                        <td>{{$item["info"]}}</td>
                                        <td>{{$item["item"]["price"]}}€</td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>


                        </div>
                        <div class="card-footer text-muted text-right">
                            Celkova suma: € {{$order->price}}
                        </div>
                    </div>
                    <hr>
                @endif
            @empty
                <p>Nemate ešte žiadnu uhradenú objednávku</p>
            @endforelse
        </div>
    </div>

    <ul>

    </ul>

    <!-- Modal -->
    <div class="modal fade" id="bankPayment" tabindex="-1" role="dialog" aria-labelledby="addProduct" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pladba na účet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-md-6">
                        <label for="price" class="form-label">Číslo účtu</label>
                        <kbd>
                            {{$info->value}}
                        </kbd>
                        <br>
                        <label for="price" class="form-label">Informácia pre príjemcu</label>
                        <kbd>
                            Dekoja.sk - Číslo vašej objednávky
                        </kbd>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection