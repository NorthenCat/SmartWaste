<nav class="w-full mx-auto z-50 bg-[#496948] border-t border-zinc-300">
    <div class="flex justify-around items-center py-2">
        <a href="{{ route('c.home') }}"
            class="flex flex-col items-center space-y-1 p-4 rounded-full transition-all duration-300 ease-in-out group {{ Route::currentRouteName() == 'c.home' ? 'bg-white' : 'hover:bg-white' }}">
            <i
                class="fa-solid fa-house text-xl {{ Route::currentRouteName() == 'c.home' ? 'text-[#496948]' : 'text-white' }} group-hover:text-[#496948]"></i>
        </a>
        <a href="{{ route('c.history') }}"
            class="flex flex-col items-center space-y-1 p-4 rounded-full transition-all duration-300 ease-in-out group {{ Route::currentRouteName() == 'c.history' ? 'bg-white' : 'hover:bg-white' }}">
            <i
                class="fa-solid fa-chart-simple text-xl {{ Route::currentRouteName() == 'c.history' ? 'text-[#496948]' : 'text-white' }} group-hover:text-[#496948]"></i>
        </a>
        <a href="{{ route('c.redeemPoint') }}"
            class="flex flex-col items-center space-y-1 p-4 rounded-full transition-all duration-300 ease-in-out group {{ Route::currentRouteName() == 'c.redeemPoint' ? 'bg-white' : 'hover:bg-white' }}">
            <i
                class="fa-solid fa-gift text-xl {{ Route::currentRouteName() == 'c.redeemPoint' ? 'text-[#496948]' : 'text-white' }} group-hover:text-[#496948]"></i>
        </a>
    </div>
</nav>