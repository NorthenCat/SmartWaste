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
        <a href="{{route('c.transactions.form')}}" class="grid grid-cols-2 bg-[#496948] w-full rounded-3xl p-4 gap-4">
            <div class="bg-white w-full h-full rounded-xl flex items-center justify-center">
                <img src="{{asset('img/asset_web/box.png')}}" alt="Cardboard" class="w-32 h-32 object-cover">
            </div>
            <div class="flex flex-col justify-center space-y-2">
                <p class="text-white text-lg font-bold">Cardboard Box</p>
                <p class="text-white">Rp. 5 /gr</p>
                <span class="text-gray-300 text-sm">Min > 800gr</span>
            </div>
        </a>
        <a href="#" class="grid grid-cols-2 bg-[#496948] w-full rounded-3xl p-4 gap-4">
            <div class="bg-white w-full h-full rounded-xl flex items-center justify-center">
                <img src="{{asset('img/asset_web/papers.png')}}" alt="Cardboard" class="w-32 h-32 object-cover">
            </div>
            <div class="flex flex-col justify-center space-y-2">
                <p class="text-white text-lg font-bold">Paper</p>
                <p class="text-white">Rp. 11 /gr</p>
                <span class="text-gray-300 text-sm">Min > 800gr</span>
            </div>
        </a>
        <a href="#" class="grid grid-cols-2 bg-[#496948] w-full rounded-3xl p-4 gap-4">
            <div class="bg-white w-full h-full rounded-xl flex items-center justify-center">
                <img src="{{asset('img/asset_web/plastic.png')}}" alt="Cardboard" class="w-32 h-32 object-cover">
            </div>
            <div class="flex flex-col justify-center space-y-2">
                <p class="text-white text-lg font-bold">Cardboard Box</p>
                <p class="text-white">Rp. 3 /gr</p>
                <span class="text-gray-300 text-sm">Min > 800gr</span>
            </div>
        </a>
    </div>
</main>
@endsection
