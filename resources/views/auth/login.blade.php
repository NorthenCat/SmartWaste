@extends('layouts.app')

@section('content')
<main class="flex flex-col w-[430px] h-[932px] justify-between items-center mx-auto bg-[#496948] shadow-all-darker">
    <div class="flex flex-col h-full justify-center items-center">
        <img src="{{ asset('img/asset_web/logo.png') }}" alt="Logo SmartWaste" class="w-[350px]">
    </div>
    <div class="w-full bg-white p-4 rounded-tl-[40px]">
        <form class="flex flex-col w-full h-full items-center space-y-8" action="{{route('login.post')}}" method="POST">
            @csrf
            <h3 class="uppercase text-[#496948] font-semibold text-xl md:text-2xl">LOGIN</h3>
            <div class="py-3 px-4 w-full border shadow-all rounded-lg">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" placeholder="YourEmail@gmail.com"
                    class="w-full border-0 border-b-2 border-gray-300 focus:border-blue-500 outline-none mt-1" />
            </div>
            <div class="py-3 px-4 w-full border shadow-all rounded-lg mt-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••"
                    class="w-full border-0 border-b-2 border-gray-300 focus:border-blue-500 outline-none mt-1" />
            </div>
            <button type="submit"
                class="p-4 w-full shadow-all rounded-tl-lg rounded-b-lg bg-[#496948] flex justify-center items-center hover:shadow-all-darker hover:bg-opacity-90 transition-all duration-300 ease-in-out">
                <span class="text-white font-medium text-lg md:text-xl">Login</span>
            </button>
            <span>Don't have any account ? <a href="{{route('register')}}" class="text-gray-600 underline">Sign
                    Up</a></span>
        </form>
    </div>
</main>
@endsection
