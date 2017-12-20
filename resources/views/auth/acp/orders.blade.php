@extends('layouts.master')

@section('content')

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Všetky objednávky
                </div>
                <div class="card-body">
                    <table class="table table-responsive-sm table-sm">
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
                                <td>
                                    {{--<a href=""><span class="fa fa-edit text-dark"></span></a>--}}
                                    <a href=""><span class="fa fa-trash text-danger"></span></a>
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