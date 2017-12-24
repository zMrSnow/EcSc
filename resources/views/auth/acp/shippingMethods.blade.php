@extends('layouts.master')

@section('content')

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Poštovné
                </div>
                <div class="card-body">
                    <table class="table table-responsive-sm table-sm table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Názov</th>
                            <th>Maximalná váha</th>
                            <th>Cena</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($shipping as $shipp)
                            <tr>
                                <td>{{$shipp->id}}</td>
                                <td>{{$shipp->text}} €</td>
                                <td>{{$shipp->max_weight}}</td>
                                <td>{{$shipp->price}}</td>

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