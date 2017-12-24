@extends('layouts.master')

@section('content')

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Všetky objednávky
                </div>
                <div class="card-body">
                    <table class="table table-responsive-sm table-sm table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Cena</th>
                            <th>Rok / Mesiac / Deň</th>
                            <th>Status</th>
                            <th>Úprava</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->price}} €</td>
                                <td>{{$order->created_at}}</td>
                                <td>
                                    <span class="badge
                                    @switch($order->status)
                                    @case(0)
                                            badge-danger">Nezaplatené

                                        @break
                                        @case(1)
                                        badge-warning">Zaplaťené / Neodoslané
                                        @break
                                        @case(2)
                                        badge-info">Zaplaťené / Odoslané
                                        @break
                                        @case(3)
                                        badge-success">Prevziate
                                        @break
                                        @endswitch
                                    </span>
                                </td>
                                <td class="row">
                                    @if($order->status == 0)
                                    <form action="{{route("auth.changeOrderToPayd", $order->id)}}" method="post">
                                        {{csrf_field()}}
                                        <button class="fa fa-check btn btn-outline-success" type="submit"></button>
                                    </form>
                                    @endif
                                    <form action="{{route("auth.deleteAdminOrder", $order->id)}}" method="post">
                                        {{csrf_field()}}
                                        <button class="fa fa-trash btn btn-outline-danger" type="submit"></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                        @endforelse

                        </tbody>
                    </table>
                    {{--<ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Prev</a></li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>--}}
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>

@endsection