@extends('layouts.master')

@section('content')

    <section class="hero hero-page padding-small" style="border-bottom: 1px solid gray">
        <div class="container-">
            <div class="row d-flex">
                <div class="col-lg-9 order-2 order-lg-1">
                    <h1>Objednávka</h1><p class="lead text-muted">iba produkty ktore su skladom môžu byt zakupené</p>
                </div>
                <div class="col-lg-3 text-right order-1 order-lg-2">
                    <ul class="breadcrumb justify-content-lg-end">
                        <li class="breadcrumb-item"><a href="{{route("product.home")}}">Domov</a></li>
                        <li class="breadcrumb-item active">Objednávka</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="checkout">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="tab-content">
                        <div id="address" class="active tab-block">
                            <form action="{{route("product.postCheckout")}}" method="post">
                            {{ csrf_field() }}
                                <!-- Invoice Address-->
                                <div class="block-header mb-5">
                                    <h6>Dodacia adressa</h6>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="fname" class="form-label">Meno</label>
                                        <input id="fname" type="text" name="fname" placeholder="Tvoje meno" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="lname" class="form-label">Priezvysko</label>
                                        <input id="lname" type="text" name="lname" placeholder="Tvoje priezvysko" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="street" class="form-label">Ulica</label>
                                        <input id="street" type="text" name="address" placeholder="Ulica" class="form-control">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="city" class="form-label">Mesto</label>
                                        <input id="city" type="text" name="city" placeholder="Mesto" class="form-control">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="psc" class="form-label">PSČ</label>
                                        <input id="psc" type="text" name="psc" placeholder="XXX XX" class="form-control">
                                    </div>
                                    {{--<div class="form-group col-md-6">
                                        <label for="phone-number" class="form-label">Telefónne číslo</label>
                                        <input id="phone-number" type="tel" name="phone-number" placeholder="Kám ma kurier volať?" class="form-control">
                                    </div>--}}

                                    <div class="form-group col-md-12">
                                        <label for="shipping_type" class="form-label">Typ doručenia</label>
                                        <select class="form-control" name="shipping_type" style="height:50px">
                                            @forelse($shippings as $shipping)
                                                <option value="{{$shipping->id}}">{{$shipping->text}} - {{$shipping->price}}€ ({{$totalWeight}}g / {{$shipping->max_weight}}g)</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>

                                </div>

                                <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">
                                    <a href="{{route("product.shopingCart")}}" class="btn btn-template-outlined wide prev">
                                        <i class="fa fa-angle-left"></i>
                                        Späť do košíka
                                    </a>
                                    <button class="btn btn-template wide next" type="submit">Objednať <i class="fa fa-angle-right"></i></button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="block-body order-summary">
                        <h6 class="text-uppercase">Dodatočné informácie</h6>
                        <p>Poštovné je vyratane automaticky podla aktualného cenníka Slovenskej Pošty a zobrazuju sa len dostupne moznosti pre vašu objednávku</p>
                        <hr>
                        <p>Po objednávke budete presmerovaný na vaše objednávky kde možete uhradiť vašu objednávku</p>
                        <hr>
                        <p>V prípade ak zaplatite za objednávku prevodom na účet alebo nastane chyba a danny tvovar sa medzičasom vypredá, odošleme vám produkt + sumu za nedostupný produkt na účet platiteľa</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection