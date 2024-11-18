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
        class="flex flex-col p-4 justify-start items-center space-y-8 bg-white rounded-tl-[40px] h-full w-full overflow-y-auto">
        <div class="grid grid-cols-2 bg-[#496948] w-full rounded-3xl p-4 gap-4">
            <div class="bg-white w-full h-full rounded-xl flex items-center justify-center">
                <img src="{{asset('img/asset_web/box.png')}}" alt="Cardboard" class="w-32 h-32 object-cover">
            </div>
            <div class="flex flex-col justify-center space-y-2">
                <p class="text-white text-lg font-bold">Cardboard Box</p>
                <p class="text-white">Rp. 5 /gr</p>
                <span class="text-gray-300 text-sm">Min > 800gr</span>
            </div>
        </div>
        <div class="bg-white w-full rounded-3xl p-4 shadow-all space-y-4">
            <p class="text-2xl font-semibold">Quantity</p>
            <div class="flex flex-row space-x-2 justify-between items-center">
                <div class="w-2/3">
                    <input type="number" name="quantity" id="quantity" placeholder="0"
                        class="w-full border-0 border-b-2 border-gray-300 focus:ring-0 focus:outline-none mt-1 text-center" />
                </div>
                <div class="w-1/3 text-center">
                    <select name="unit" id="unit"
                        class="w-full rounded-lg  border-2 border-gray-300 p-2 text-gray-500 focus:ring-0 focus:border-gray-300 focus:outline-none">
                        <option value="kg">Kg</option>
                        <option value="gr">Gr</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="bg-white w-full rounded-3xl p-4 shadow-all space-y-4">
            <h2 class="text-2xl font-semibold">Destination</h2>
            <div class="flex w-full items-center">
                <div class="relative w-full">
                    <input class="w-full border-0 border-b-2 border-gray-300 focus:ring-0 focus:outline-none mt-1"
                        type="text" placeholder="Jl.Perumahan ABC Blok Z No.1">
                    <button class="absolute inset-y-0 right-0 px-3 flex items-center">
                        <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex items-center mb-4">
                <button class="bg-[#496948] hover: text-white font-medium py-2 px-4 rounded-xl mr-4">
                    <i class="fa-solid fa-bookmark pr-2"></i> Home
                </button>
                <button
                    class="bg-white border-2 border-[#496948] text-[#496948] font-medium py-2 px-4 rounded-xl mr-4 hover:bg-[#496948] hover:text-white transition-colors duration-300 ease-in-out">
                    <i class="fa-solid fa-bookmark pr-2"></i> Office
                </button>
            </div>
        </div>
    </div>
</main>
@endsection
