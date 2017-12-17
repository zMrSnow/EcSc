@extends('layouts.master')

@section('content')

    <div class="card shopping-cart">
        <div class="card-header bg-dark text-light">
            <i class="fa fa-info" aria-hidden="true"></i>
            Kam ti máme poslať objednávku?
            <a href="{{route("product.home")}}" class="btn btn-outline-info btn-sm pull-right">Pokračovať v
                nakupovaní</a>
            <div class="clearfix"></div>
        </div>

        <form action="{{route("product.postCheckout")}}" method="post">
            <div class="form-group  row">
                <div class="col-12 col-sm-6">
                    <label for="fname" class="form-control bg-dark text-light">Meno:</label>
                    <input type="text" name="fname" class="form-control">
                </div>
                <div class="col-12 col-sm-6">
                    <label for="lname" class="form-control bg-dark text-light">Priezvysko:</label>
                    <input type="text" name="lname" class="form-control">
                </div>
                <div class="col-12 col-sm-6">
                    <label for="psc" class="form-control bg-dark text-light"><i class="fa fa-sort-numeric-asc" aria-hidden="true"></i> PSČ:</label>
                    <input type="text" name="psc" class="form-control">
                </div>
                <div class="col-12 col-sm-6">
                    <label for="city" class="form-control bg-dark text-light"><i class="fa fa-bank" aria-hidden="true"></i> Mesto:</label>
                    <input type="text" name="city" class="form-control">
                </div>
                <div class="col-12 col-sm-6">
                    <label for="adress" class="form-control bg-dark text-light"><i class="fa fa-address-book" aria-hidden="true"></i> Adresa:</label>
                    <input type="text" name="adress" class="form-control">
                </div>
                <div class="col-12 col-sm-6">
                    <label for="shipping_type" class="form-control bg-dark text-light"><i class="fa fa-car" aria-hidden="true"></i> Typ dorucenia:</label>
                    <select class="form-control" name="shipping_type">
                        @forelse($shippings as $shipping)
                            <option value="{{$shipping->id}}">{{$shipping->text}} - {{$shipping->price}}€ ({{$totalWeight}}g / {{$shipping->max_weight}}g)</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-block btn-success pull-right">Objednať</button>
            {{ csrf_field() }}
        </form>

    </div>

@endsection