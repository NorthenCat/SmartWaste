@extends('layouts.app')

@section('content')
<main class="flex flex-col w-full h-full bg-[#496948] shadow-all-darker">
    <div class="flex flex-col justify-center items-center p-6">
        <img src="{{ asset('img/asset_web/logo.png') }}" alt="Logo SmartWaste" class="w-[270px]">
    </div>
    <div class="w-full flex-1 bg-white p-6 rounded-tl-[40px]">
        <form class="flex flex-col w-full h-full items-center space-y-6" action="{{route('login.post')}}" method="POST">
            @csrf
            <h3 class="uppercase text-[#496948] font-semibold text-xl">LOGIN</h3>
            <div class="py-3 px-4 w-full border shadow-all rounded-lg">
                <label for="email" class="block text-gray-700 text-sm">Email</label>
                <input type="email" name="email" id="email" placeholder="YourEmail@gmail.com"
                    class="w-full border-0 border-b-2 border-gray-300 focus:border-blue-500 outline-none mt-1" />
            </div>
            <div class="py-3 px-4 w-full border shadow-all rounded-lg">
                <label for="password" class="block text-gray-700 text-sm">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••"
                    class="w-full border-0 border-b-2 border-gray-300 focus:border-blue-500 outline-none mt-1" />
            </div>
            <button type="submit"
                class="p-3 w-full shadow-all rounded-tl-lg rounded-b-lg bg-[#496948] flex justify-center items-center hover:shadow-all-darker hover:bg-opacity-90 transition-all duration-300 ease-in-out">
                <span class="text-white font-medium text-lg">Login</span>
            </button>
            <span class="text-sm">Don't have any account? <a href="{{route('register')}}"
                    class="text-gray-600 underline">Sign Up</a></span>
        </form>
    </div>
</main>
</div>
@endsection
