@extends('layouts.app')

@section('content')
<main class="flex flex-col w-[430px] h-[932px] justify-between items-center mx-auto bg-[#496948] shadow-all-darker">
    <div class="flex flex-col space-y-4 p-4 w-full h-full max-h-1/2 ">
        <div class="flex flex-row justify-between items-center w-full">
            <div class="flex flex-row items-center p-1 bg-white rounded-full space-x-2 px-1">
                <div class="rounded-full bg-zinc-200/50 p-1">
                    <img src="{{asset('img/asset_web/avatar.png')}}" class="w-6" alt="profile image">
                </div>
                <p>Hi, {{Auth::user()->first_name}} <span><i class="fa-solid fa-chevron-down fa-sm"></i></span></p>
            </div>

            <a href="#"
                class="flex justify-center items-center rounded-full bg-white p-1 w-8 h-8 text-center hover:bg-zinc-300 transition-colors duration-300 ease-in-out">
                <i class="fa-regular fa-bell text-xl text-[#496948] "></i>
            </a>
        </div>

        <div class="flex flex-row justify-between items-center bg-white rounded-lg p-2 h-[134.8px]">
            <div class="flex flex-col space-y-2 justify-start items-center shadow-all rounded-xl p-1 h-full w-1/3">
                <div>
                    <p class="text-sm">My Points</p>
                    <hr class="w-full">
                </div>
                <p class="text-2xl flex items-center font-bold">{{Auth::user()->customer->point}}</p>
            </div>
        </div>
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
