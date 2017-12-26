@extends('layouts.master')

@section('content')

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Poštovné
                </div>
                <div class="mx-auto col-12">
                    <a href="" class="btn btn-outline-primary mt-1 col-md-12" data-toggle="modal" data-target="#addShippingOption">Pridať možnosť</a>
                </div>
                <div class="card-body">
                    <table class="table table-responsive-sm table-sm table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Názov</th>
                            <th>Maximalná váha</th>
                            <th>Cena</th>
                            <th>Úprava</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($shipping as $shipp)
                            <tr>
                                <td>{{$shipp->id}}</td>
                                <td>{{$shipp->text}} €</td>
                                <td>{{$shipp->max_weight}}</td>
                                <td>{{$shipp->price}}</td>
                                <td>
                                    <form action="{{route("auth.deleteAdminShipping", $shipp->id)}}" method="post">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-outline-danger fa fa-trash"></button>
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


    <!-- Modal -->
    <div class="modal fade" id="addShippingOption" tabindex="-1" role="dialog" aria-labelledby="addProduct" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pridať možnosť dodania</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route("admin.addShippingOption")}}" method="post">
                    {{ csrf_field() }}
                    <!-- Invoice Address-->
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name" class="form-label">Názov poštovného</label>
                                <input id="name" type="text" name="name" placeholder="Názov" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="weight" class="form-label">Váha (g)</label>
                                <input id="weight" type="text" name="weight" placeholder="Váha" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price" class="form-label">Cena (€)</label>
                                <input id="price" type="text" name="price" placeholder="0" class="form-control">
                            </div>
                            {{--<div class="form-group col-md-6">
                                <label for="phone-number" class="form-label">Telefónne číslo</label>
                                <input id="phone-number" type="tel" name="phone-number" placeholder="Kám ma kurier volať?" class="form-control">
                            </div>--}}

                        </div>
                        <div class="modal-footer">
                            <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">

                                <button class="btn btn-template wide next" type="submit">
                                    Pridať možnosť
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection