@extends('layouts.app')

@section('content')
<main class="flex flex-col w-full h-full items-center bg-[#496948] shadow-all-darker">
    <div class="p-8 w-full">
        <div class="relative flex flex-row items-center justify-center w-full">
            <a href="{{route('c.home')}}"
                class="absolute left-0 flex justify-center items-center bg-white w-10 h-10 rounded-full hover:bg-zinc-300 transition-colors duration-300 ease-in-out">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </a>
            <p class="text-white text-2xl font-medium">{{$title}}</p>
        </div>
    </div>
    <div
        class="flex flex-col p-4 justify-start items-center space-y-4 bg-white rounded-tl-[40px] h-full w-full overflow-y-auto">
        @foreach($products as $product)
        @if($title=='Buy')
        <a href="{{route('c.transactions.form', ['title'=>$title, 'uuid'=>$product->uuid])}}"
            class="grid grid-cols-2 bg-[#496948] w-full rounded-3xl p-4 gap-4">
            <div class="bg-white w-full h-full rounded-xl flex items-center justify-center">
                <img src="{{asset('img/asset_web/box.png')}}" alt="Cardboard" class="w-32 h-32 object-cover">
            </div>
            <div class="flex flex-col justify-center space-y-2">
                <p class="text-white text-lg font-bold">{{ucwords($product->name)}}</p>
                <p class="text-white">Rp. {{$product->price_per_unit}} /{{$product->unit}}</p>
                <span class="text-gray-300 text-sm">Min > {{$product->minimal_weight.$product->unit}}</span>
                <span class="text-gray-300 text-sm">Stock : {{$product->stock.$product->stock_unit}}</span>
            </div>
        </a>
        @else
        <a href="{{route('c.transactions.form', ['title'=>$title, 'uuid'=>$product->uuid])}}"
            class="grid grid-cols-2 bg-[#496948] w-full rounded-3xl p-4 gap-4">
            <div class="bg-white w-full h-full rounded-xl flex items-center justify-center">
                <img src="{{asset('img/asset_web/box.png')}}" alt="Cardboard" class="w-32 h-32 object-cover">
            </div>
            <div class="flex flex-col justify-center space-y-2">
                <p class="text-white text-lg font-bold">{{ucwords($product->name)}}</p>
                <p class="text-white">Rp. {{$product->price_sell_per_unit}} /{{$product->unit}}</p>
                <span class="text-gray-300 text-sm">Min > {{$product->minimal_sell_weight.$product->unit}}</span>
            </div>
        </a>
        @endif
        @endforeach
    </div>
</main>
@endsection