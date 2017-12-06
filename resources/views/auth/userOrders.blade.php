@extends('layouts.master')

@section('content')
    <h1>Moje objednávky</h1>


    <ul>
        @forelse($orders as $order)
            <li>sss</li>

            @forelse($order->cart->items as $item)
                <li>iiiiii</li>
            @empty
            @endforelse
        @empty
        @endforelse
    </ul>
@endsection