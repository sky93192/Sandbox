@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm">
            <h2>商品列表</h2>
            <ul>
                @foreach($items as $item)
                <li>
                    <img src="" alt="">
                    {{ $item->title }} (${{ $item->price }})&nbsp;&nbsp;&nbsp;
                    <a href="" wire:click="addCart({{ $item->id }})">購買</a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-sm">
            @isset($order)
            <h2>訂單明細</h2>
            <ul>
                @foreach($order->items as $item)
                <li>
                    {{ $item->title }} {{ $item->price }} x {{ $item->pivot->qty }}
                </li>
                @endforeach
            </ul>
            <h3>總計：{{ $order->sum }}</h3>
            @endisset
        </div>
    </div>
</div>
@endsection