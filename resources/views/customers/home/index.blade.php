@extends('layouts.app')

@section('content')
<main class="flex flex-col w-full h-full justify-between items-center mx-auto bg-[#496948] shadow-all-darker">
    <div class="flex flex-col space-y-8 p-4 w-full h-full max-h-1/2 ">
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

        <div class="flex flex-row justify-between items-center bg-white rounded-2xl py-2 px-4 h-[134.8px]">
            <a href="{{route('c.redeemPoint')}}"
                class="flex flex-col justify-start items-center shadow-all rounded-xl p-1 h-full w-2/3 hover:-translate-y-1 transition-transform duration-300 ease-in-out">
                <p class="text-sm font-bold">My Points</p>
                <hr class="w-3/4 border-t-2 border-gray-300">
                <div class="w-full h-full flex items-center justify-center px-1">
                    <p class="text-base md:text-lg font-bold text-center break-all overflow-hidden">
                        {{ number_format(Auth::user()->customer->point) }}
                    </p>
                </div>
            </a>
            <a href="{{route('c.transactions.buy')}}"
                class="flex flex-col justify-center items-center w-1/3 p-4 hover:-translate-y-1 transition-transform duration-300 ease-in-out">
                <div class="p-4 bg-[#496948] w-full h-full flex items-center justify-center rounded-lg shadow-all ">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M16.5 21H18.6688C19.8945 21 20.8319 19.9074 20.6455 18.6959L19.2609 9.69589C19.1108 8.72022 18.2713 8 17.2842 8H6.71584C5.7287 8 4.8892 8.72022 4.73909 9.69589L3.35448 18.6959C3.16809 19.9074 4.10545 21 5.33122 21H7.5"
                                stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path d="M12 12V19M12 19L15 16M12 19L9 16" stroke="#ffffff" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5" stroke="#ffffff"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </div>
                <span>Buy</span>
            </a>
            <a href="{{route('c.transactions.sell')}}"
                class="flex flex-col justify-center items-center w-1/3 p-4 hover:-translate-y-1 transition-transform duration-300 ease-in-out">
                <div class="p-4 bg-[#496948] w-full h-full flex items-center justify-center rounded-lg shadow-all">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M16.5 21H18.6688C19.8945 21 20.8319 19.9074 20.6455 18.6959L19.2609 9.69589C19.1108 8.72022 18.2713 8 17.2842 8H6.71584C5.7287 8 4.8892 8.72022 4.73909 9.69589L3.35448 18.6959C3.16809 19.9074 4.10545 21 5.33122 21H7.5"
                                stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path d="M12 19V12M12 12L15 15M12 12L9 15" stroke="#ffffff" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M14 5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5" stroke="#ffffff"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </div>
                <span>Sell</span>
            </a>
        </div>
        @if (session('success_transaction'))
        <div id="successCard" class="flex flex-col w-full p-2 bg-white rounded-2xl">
            <button type="button"
                onclick="event.preventDefault(); document.getElementById('successCard').classList.add('hidden');"
                class="ml-auto flex justify-center items-center rounded-full border-2 border-[#496948] bg-white w-8 h-8 text-center text-[#496948] hover:bg-[#496948] hover:text-white transition-colors duration-300 ease-in-out">
                <i class="fa-solid fa-times text-xl"></i>
            </button>

            <div class="flex flex-col justify-center items-center space-y-2 h-full">
                <img src="{{asset('img/asset_web/success.png')}}" alt="" class="w-full max-w-64">
                <div class="space-y-2 pb-8 text-center">
                    <p class="font-semibold text-xl">Transaction Success</p>
                    <span class="font-light text-gray-300">Please wait until item to be delivered</span>
                </div>
            </div>
        </div>
        @endif
        @if (session('success_redeem'))
        <div id="successCard" class="flex flex-col w-full p-2 bg-white rounded-2xl">
            <button type="button"
                onclick="event.preventDefault(); document.getElementById('successCard').classList.add('hidden');"
                class="ml-auto flex justify-center items-center rounded-full border-2 border-[#496948] bg-white w-8 h-8 text-center text-[#496948] hover:bg-[#496948] hover:text-white transition-colors duration-300 ease-in-out">
                <i class="fa-solid fa-times text-xl"></i>
            </button>

            <div class="flex flex-col justify-center items-center space-y-2 h-full">
                <img src="{{asset('img/asset_web/success.png')}}" alt="" class="w-full max-w-64">
                <div class="space-y-2 pb-8 text-center">
                    <p class="font-semibold text-xl">Redeem Successful</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div x-data="{
            height: parseInt(localStorage.getItem('panelHeight')) || 800,
            minHeight:100,
            maxHeight: 3600,
            isDragging: false,
            startY: 0,
            toggleHeight() {
                const targetHeight = this.height === this.maxHeight ? this.minHeight : this.maxHeight;
                this.height = targetHeight;
                localStorage.setItem('panelHeight', this.height);
            }
        }"
        class="w-full max-w-md bg-white rounded-t-[40px] shadow-lg overflow-hidden transition-all duration-300 ease-in-out z-10"
        :class="{ 'select-none': isDragging }" :style="`height: ${height}px`">
        <div class="flex flex-col bg-white/95 backdrop-blur-sm w-full px-6 py-2">
            <!-- Resize handle -->
            <div class="w-1/2 cursor-ns-resize z-20 mx-auto" style="background-color: rgba(255, 255, 255, 0.95);"
                @mousedown="
                    isDragging = true;
                    startY = $event.pageY;
                    document.body.classList.add('select-none');
                " @mousemove.window="
                    if (isDragging) {
                        $event.preventDefault();
                        const delta = (startY - $event.pageY) * 2;
                        const newHeight = height + delta;

                        if (newHeight >= minHeight && newHeight <= maxHeight) {
                            height = newHeight;
                            startY = $event.pageY;
                        }
                    }
                " @mouseup.window="
                    isDragging = false;
                    document.body.classList.remove('select-none');
                " @mouseleave.window="
                    isDragging = false;
                    document.body.classList.remove('select-none');
                ">
                <hr class="w-full h-1 bg-gray-200 rounded-full my-2" />
            </div>
            <!-- Header -->
            <div class="sticky top-0 h-8 w-full z-20 bg-white/95 backdrop-blur-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Recent Transaction</h2>
                    <button @click="toggleHeight()"
                        class="text-green-700 font-medium hover:text-green-800 transition-colors">See All</button>
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