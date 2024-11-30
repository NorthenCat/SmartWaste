@extends('layouts.app')

@section('content')
<main class="flex flex-col w-full h-full justify-between items-center mx-auto bg-[#496948] shadow-all-darker">
    <div class="flex flex-col space-y-8 p-4 w-full ">
        <div class="flex flex-row justify-between items-center w-full">
            <!-- Parent container -->
            <div x-data="{ open: false }" class="relative inline-block">
                <!-- Trigger button -->
                <div class="flex flex-row items-center p-1 bg-white rounded-full space-x-2 px-3 cursor-pointer"
                    @click="open = !open">
                    <div class="rounded-full bg-zinc-200/50 p-1">
                        <img src="{{asset('img/asset_web/avatar.png')}}" class="w-6" alt="profile image">
                    </div>
                    <p class="whitespace-nowrap font-medium">Hi, {{Auth::user()->first_name}}
                        <span><i class="fa-solid fa-chevron-down fa-sm ms-2" :class="{'rotate-180': open}"></i></span>
                    </p>
                </div>

                <!-- Dropdown Menu -->
                <div x-cloak x-show="open" @click.away="open = false"
                    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm rounded-lg text-gray-700 hover:bg-gray-100 focus:outline-none whitespace-nowrap">
                            <i class="fa-solid fa-power-off me-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <a href="#"
                class="flex justify-center items-center rounded-full bg-white p-1 w-8 h-8 text-center hover:bg-zinc-300 transition-colors duration-300 ease-in-out">
                <i class="fa-regular fa-bell text-xl text-[#496948] "></i>
            </a>
        </div>
    </div>
    <div x-data="{
            height: '100vh',
        }"
        class="relative w-full max-w-md bg-white rounded-t-[40px] shadow-lg overflow-hidden transition-all duration-300 ease-in-out z-10"
        :style="{ height: height }">
        <div class="flex flex-col bg-white/95 backdrop-blur-sm w-full px-6 py-2">
            <!-- Resize handle -->
            <div class="w-1/2 z-20 mx-auto" style="background-color: rgba(255, 255, 255, 0.95);">
                <hr class="w-full h-1 bg-gray-200 rounded-full my-2" />
            </div>
            <!-- Header -->
            <div class="sticky top-0 h-8 w-full z-20 bg-white/95 backdrop-blur-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Recent Transaction</h2>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6 overflow-y-auto h-full relative">
            <!-- Today's Transactions -->
            @if(!$todayTransactions->isEmpty())
            <div class="mb-6">
                <h3 class="text-lg font-medium mb-4">Today</h3>
                @foreach ($todayTransactions as $transaction)
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-green-700 rounded-xl flex items-center justify-center">
                            @if($transaction->type=="Buy")
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M16.5 21H18.6688C19.8945 21 20.8319 19.9074 20.6455 18.6959L19.2609 9.69589C19.1108 8.72022 18.2713 8 17.2842 8H6.71584C5.7287 8 4.8892 8.72022 4.73909 9.69589L3.35448 18.6959C3.16809 19.9074 4.10545 21 5.33122 21H7.5"
                                        stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                    <path d="M12 12V19M12 19L15 16M12 19L9 16" stroke="#fff" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5" stroke="#fff"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            @else
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M16.5 21H18.6688C19.8945 21 20.8319 19.9074 20.6455 18.6959L19.2609 9.69589C19.1108 8.72022 18.2713 8 17.2842 8H6.71584C5.7287 8 4.8892 8.72022 4.73909 9.69589L3.35448 18.6959C3.16809 19.9074 4.10545 21 5.33122 21H7.5"
                                        stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                    <path d="M12 19V12M12 12L15 15M12 12L9 15" stroke="#fff" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5" stroke="#fff"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            @endif
                        </div>
                        <div>
                            <p class="font-semibold">{{ $transaction->product_name }}</p>
                            <p class="text-gray-500 text-sm">{{ $transaction->quantity }}{{ $transaction->unit }}</p>
                        </div>
                    </div>
                    @if($transaction->type=="Buy")
                    <span class="text-red-700 font-medium">Rp. {{ number_format($transaction->total_price) }}</span>
                    @else
                    <span class="text-green-700 font-medium">{{ $transaction->bonus_point }} Points</span>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            <!-- Yesterday's Transactions -->
            @if(!$yesterdayTransactions->isEmpty())
            <div class="mb-6">
                <h3 class="text-lg font-medium mb-4">Yesterday</h3>
                @foreach ($yesterdayTransactions as $transaction)
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-green-700 rounded-xl flex items-center justify-center">
                            @if($transaction->type=="Buy")
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M16.5 21H18.6688C19.8945 21 20.8319 19.9074 20.6455 18.6959L19.2609 9.69589C19.1108 8.72022 18.2713 8 17.2842 8H6.71584C5.7287 8 4.8892 8.72022 4.73909 9.69589L3.35448 18.6959C3.16809 19.9074 4.10545 21 5.33122 21H7.5"
                                        stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                    <path d="M12 12V19M12 19L15 16M12 19L9 16" stroke="#fff" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5" stroke="#fff"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            @else
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M16.5 21H18.6688C19.8945 21 20.8319 19.9074 20.6455 18.6959L19.2609 9.69589C19.1108 8.72022 18.2713 8 17.2842 8H6.71584C5.7287 8 4.8892 8.72022 4.73909 9.69589L3.35448 18.6959C3.16809 19.9074 4.10545 21 5.33122 21H7.5"
                                        stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                    <path d="M12 19V12M12 12L15 15M12 12L9 15" stroke="#fff" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5" stroke="#fff"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            @endif
                        </div>
                        <div>
                            <p class="font-semibold">{{ $transaction->product_name }}</p>
                            <p class="text-gray-500 text-sm">{{ $transaction->quantity }}{{ $transaction->unit }}</p>
                        </div>
                    </div>
                    @if($transaction->type=="Buy")
                    <span class="text-red-700 font-medium">Rp. {{ number_format($transaction->total_price) }}</span>
                    @else
                    <span class="text-green-700 font-medium">{{ $transaction->bonus_point }} Points</span>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            <!-- Transactions After Yesterday -->
            <div>
                @foreach ($otherTransactions as $date => $groupedTransactions)
                <h3 class="text-lg font-medium mb-4">{{ $date }}</h3>
                @foreach ($groupedTransactions as $transaction)
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-green-700 rounded-xl flex items-center justify-center">
                            @if($transaction->type=="Buy")
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M16.5 21H18.6688C19.8945 21 20.8319 19.9074 20.6455 18.6959L19.2609 9.69589C19.1108 8.72022 18.2713 8 17.2842 8H6.71584C5.7287 8 4.8892 8.72022 4.73909 9.69589L3.35448 18.6959C3.16809 19.9074 4.10545 21 5.33122 21H7.5"
                                        stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                    <path d="M12 12V19M12 19L15 16M12 19L9 16" stroke="#fff" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5" stroke="#fff"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            @else
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M16.5 21H18.6688C19.8945 21 20.8319 19.9074 20.6455 18.6959L19.2609 9.69589C19.1108 8.72022 18.2713 8 17.2842 8H6.71584C5.7287 8 4.8892 8.72022 4.73909 9.69589L3.35448 18.6959C3.16809 19.9074 4.10545 21 5.33122 21H7.5"
                                        stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                    <path d="M12 19V12M12 12L15 15M12 12L9 15" stroke="#fff" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5" stroke="#fff"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                            @endif
                        </div>
                        <div>
                            <p class="font-semibold">{{ $transaction->product_name }}</p>
                            <p class="text-gray-500 text-sm">{{ $transaction->quantity }}{{ $transaction->unit }}</p>
                        </div>
                    </div>
                    @if($transaction->type=="Buy")
                    <span class="text-red-700 font-medium">Rp. {{ number_format($transaction->total_price) }}</span>
                    @else
                    <span class="text-green-700 font-medium">{{ $transaction->bonus_point }} Points</span>
                    @endif
                </div>
                @endforeach
                @endforeach
            </div>
        </div>
    </div>
    @include('components.navbar')
</main>
@endsection