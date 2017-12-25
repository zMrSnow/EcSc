@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Všetky produkty
                </div>
                <div class="row col-12 mx-auto">
                    <a href="" class="btn btn-outline-primary mt-1 col-md-6" data-toggle="modal" data-target="#addSize"><span class="fa fa-plus"></span> 1. Pridať typ Veľkosti</a>
                    <a href="" class="btn btn-outline-primary mt-1 col-md-6" data-toggle="modal" data-target="#addProduct"><span class="fa fa-plus"></span> 2. Pridať produkt</a>
                </div>
                <a href="" class="btn btn-outline-primary mt-1 col-md-12" data-toggle="modal" data-target="#addStock"><span class="fa fa-plus"></span> 3. Naskladovať produkt</a>
                <div class="card-body">
                    <table class="table table-responsive-sm table-sm table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Názov produktu</th>
                            <th>Popis</th>
                            <th>Skladom</th>
                            <th>Váha (g)</th>
                            <th>Cena (€)</th>
                            <th>Vytvorené</th>
                            <th>Pridamé</th>
                            <th>Úprava</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $product)
                            <tr class="{{ count($product->sizes) ? "alert alert-success" : "" }}">
                                <td>{{$product->id}}</td>
                                <td>{{$product->name}} </td>
                                <td>{{ str_limit($product->description, 20) }}</td>
                                @php
                                $totalqty = 0;
                                @endphp
                                @forelse($product->sizes as $size)
                                    @php
                                        $totalqty += $size->quantities;
                                    @endphp
                                    @empty
                                    @endforelse
                                <td>{{ $totalqty }}</td>
                                <td>{{$product->weight}}</td>
                                <td>{{$product->price}} €</td>
                                <td>{{$product->created_at}}</td>
                                <td>{{$product->updated_at}}</td>

                                <td class="row">
                                    <a href="{{route("auth.adminProductImage", $product->id)}}" class="btn btn-outline-info"><span
                                                class="fa fa-image"></span></a>
                                    <a href="{{route("auth.adminEditProduct", $product->id)}}"  class="btn btn-outline-info"><span
                                                class="fa fa-edit"></span></a>
                                    <form action="{{route("auth.deleteAdminProduct", $product->id)}}" method="post">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-outline-danger fa fa-trash"></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <h1></h1>
                        @endforelse

                        </tbody>
                    </table>
                    {{--<ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Predošlá</a></li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">Ďalej</a></li>
                    </ul>--}}
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="addProduct" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pridať produkt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route("admin.addProduct")}}" method="post">
                    {{ csrf_field() }}
                    <!-- Invoice Address-->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name" class="form-label">Názov produktu</label>
                                <input id="name" type="text" name="name" placeholder="Názov" class="form-control">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="weight" class="form-label">Váha (g)</label>
                                <input id="weight" type="text" name="weight" placeholder="Váha" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="price" class="form-label">Cena (€)</label>
                                <input id="price" type="text" name="price" placeholder="0" class="form-control">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="description" class="form-label">Popis produktu</label>
                                <input id="description" type="text" name="description" placeholder="Popis" class="form-control">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="img" class="form-label">Link na obrázok - <a href="https://epvpimg.com/" target="_blank">TU</a></label>
                                <input id="img" type="text" name="img" placeholder="https://obrazok.png" class="form-control">
                            </div>
                            {{--<div class="form-group col-md-6">
                                <label for="phone-number" class="form-label">Telefónne číslo</label>
                                <input id="phone-number" type="tel" name="phone-number" placeholder="Kám ma kurier volať?" class="form-control">
                            </div>--}}

                        </div>
                        <div class="modal-footer">
                            <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">

                                <button class="btn btn-template wide next" type="submit">
                                    Pridať produkt
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addSize" tabindex="-1" role="dialog" aria-labelledby="addProduct" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pridať typ veľkosti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route("admin.addProductType")}}" method="post">
                    {{ csrf_field() }}
                    <!-- Invoice Address-->
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name" class="form-label">Názov veľkosti</label>
                                <input id="name" type="text" name="name" placeholder="Názov" class="form-control">
                            </div>
                            {{--<div class="form-group col-md-6">
                                <label for="phone-number" class="form-label">Telefónne číslo</label>
                                <input id="phone-number" type="tel" name="phone-number" placeholder="Kám ma kurier volať?" class="form-control">
                            </div>--}}

                        </div>
                        <div class="modal-footer">
                            <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">

                                <button class="btn btn-template wide next" type="submit">
                                    Pridať typ / veľkosť
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addStock" tabindex="-1" role="dialog" aria-labelledby="addProduct" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Naskladovať produkt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route("admin.addProductStock")}}" method="post">
                    {{ csrf_field() }}
                    <!-- Invoice Address-->
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="product" class="form-label">Ktorý produkt?</label>
                                <select class="form-control" name="product" style="height:50px">
                                    @forelse($products as $product)
                                        <option value="{{$product->id}}">#{{$product->id}} - {{$product->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="size" class="form-label">Veľkosť / Typ</label>
                                <select class="form-control" name="size" style="height:50px">
                                    @forelse($sizers as $sizer)
                                        <option value="{{$sizer->id}}"> {{$sizer->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="qty" class="form-label">Množstvo (ks)</label>
                                <input id="qty" type="text" name="qty" placeholder="0" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">

                                <button class="btn btn-template wide next" type="submit">
                                    Naskladovať produkt
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