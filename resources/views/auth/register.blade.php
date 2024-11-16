@extends('layouts.app')

@section('content')
<main class="flex flex-col w-full h-full mx-auto bg-[#496948] shadow-all-darker">
    <div class="flex flex-col h-full justify-center items-center p-8">
        <h1 class="font-semibold text-3xl md:text-4xl text-white">Sign Up</h1>
    </div>
    <div class="w-full bg-white p-8 rounded-tl-[40px]">
        <form class="flex flex-col w-full h-full items-center" action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="py-3 px-4 w-full border shadow-lg rounded-lg mb-2">
                <label for="first_name" class="block text-gray-700">First Name</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"
                    placeholder="Your First Name"
                    class="w-full border-0 border-b-2 border-gray-300 focus:border-blue-500 outline-none mt-1" />
                @error('first_name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="py-3 px-4 w-full border shadow-lg rounded-lg mb-2">
                <label for="last_name" class="block text-gray-700">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"
                    placeholder="Your Last Name"
                    class="w-full border-0 border-b-2 border-gray-300 focus:border-blue-500 outline-none mt-1" />
                @error('last_name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="py-3 px-4 w-full border shadow-lg rounded-lg mb-2">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="YourEmail@gmail.com"
                    class="w-full border-0 border-b-2 border-gray-300 focus:border-blue-500 outline-none mt-1" />
                @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="py-3 px-4 w-full border shadow-lg rounded-lg mb-2">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••"
                    class="w-full border-0 border-b-2 border-gray-300 focus:border-blue-500 outline-none mt-1" />
                @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="py-3 px-4 w-full border shadow-lg rounded-lg mb-4">
                <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••"
                    class="w-full border-0 border-b-2 border-gray-300 focus:border-blue-500 outline-none mt-1" />
                @error('password_confirmation')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-full px-4 mb-4">
                <button
                    class="p-2 px-4 w-full shadow-lg rounded-l-lg rounded-br-lg bg-[#496948] flex justify-center items-center text-white font-medium text-lg md:text-xl hover:shadow-all-darker hover:bg-opacity-90 transition-all duration-300 ease-in-out">
                    Sign Up
                </button>
            </div>
            <span>Already have an account? <a href="{{ route('login') }}" class="text-gray-600 underline">Sign
                    In</a></span>
        </form>
    </div>
</main>
@endsection
