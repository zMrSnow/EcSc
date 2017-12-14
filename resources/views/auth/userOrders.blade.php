@extends('layouts.master')

@section('content')
    <h1>Moje objednávky</h1>


    <p class="text-center">
        <a class="btn btn-outline-danger" data-toggle="collapse" href="#neuhradene" aria-expanded="false"
           aria-controls="collapseExample">
            Neuhradené
        </a>
        <a class="btn btn-outline-success" data-toggle="collapse" href="#uhradene" aria-expanded="false"
           aria-controls="collapseExample">
            Uhradené
        </a>
    </p>
    <div class="collapse" id="neuhradene">
        <div class="card card-body ">

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
                                    <button type="submit" class="btn btn-danger pull-left">
                                        PayPall
                                    </button>
                                    {{ csrf_field() }}
                                </form>
                            @endif
                        </div>
                    </div>
                    <hr>
                @endif
            @empty
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
            @endforelse
        </div>
    </div>

    <ul>

    </ul>
@endsection