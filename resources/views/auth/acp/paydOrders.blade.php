@extends('layouts.master')

@section('content')

        <div class="card card-body">
            @forelse($orders as $order)
                @if($order->status == 1)
                    <div class="card break">
                        <div class="card-header">
                            # {{$order->id}}
                            <span class="badge badge-success pull-right">Uhradené</span>
                            <span class="badge badge-warning pull-right">Neodoslané</span>
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

                            <ul>
                                <li>Meno: {{$order->name}}</li>
                                <li>Adressa: {{$order->adress}}</li>
                                <li>Mesto: {{$order->city}}</li>
                                <li>PSČ: {{$order->psc}}</li>

                            </ul>
                            <a href="" class="btn btn-outline-success">Označiť ako odoslané</a>


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

@endsection