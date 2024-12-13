@extends('layouts.app')

@section('content')
<main class="flex flex-col w-full h-full justify-between items-center mx-auto bg-white shadow-all-darker pt-4">
    <div x-data="{
            height: '100vh',
        }"
        class="relative w-full max-w-md bg-[#496948] rounded-t-[40px] shadow-lg overflow-hidden transition-all duration-300 ease-in-out z-10"
        :style="{ height: height }">
        <div class="flex flex-col bg-[#496948]/95 backdrop-blur-sm w-full px-6 py-2">
            <!-- Resize handle -->
            <div class="w-1/2 z-20 mx-auto bg-[#496948]">
                <hr class="w-full h-1 bg-gray-200 rounded-full my-2" />
            </div>
        </div>
        <div class="flex flex-row justify-center items-center w-full mt-6 h-1/6">
            <div
                class="flex flex-col justify-start items-center rounded-xl p-1 h-full bg-white w-2/3 transition-transform duration-300 ease-in-out">
                <p class="text-sm font-bold">My Points</p>
                <hr class="w-3/4 border-t-2 border-gray-300">
                <div class="w-full h-full flex items-center justify-center px-1">
                    <p class="text-lg md:text-xl font-bold text-center break-all overflow-hidden">
                        {{ number_format(Auth::user()->customer->point) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6 overflow-y-auto h-full relative">
            <p class="text-white text-lg md:text-xl mb-6">Rewards</p>
            <div class="flex flex-col space-y-4 h-full overflow-y-auto">
                @foreach($promos as $promo)
                <div class="relative flex flex-col w-full bg-white rounded-lg px-2 text-sm space-y-2 pb-1 cursor-pointer"
                    @if(auth()->user()->customer->point >= $promo->point_price)
                    onclick="showConfirmModal('{{$promo->uuid}}', {{$promo->point_price}})"
                    style="pointer-events: pointer;"
                    @else
                    style="pointer-events:none;"
                    @endif>
                    @if(auth()->user()->customer->point < $promo->point_price)
                        <div class="absolute inset-0 bg-gray-300/40 pointer-events-auto rounded-lg"></div>
                        @endif
                        <header>
                            <p class="font-medium">{{$promo->point_price}}</p>
                            <div class="w-full border-t border-dashed border-gray-300"></div>
                        </header>
                        <div class="flex w-full justify-center py-4">
                            <p class="text-xl md:text-2xl font-semibold">{{$promo->name}}</p>
                        </div>
                        @if($promo->note && (auth()->user()->customer->point > $promo->point_price))
                        <span id="voucherNote" class="text-xs text-gray-300">*{{$promo->note}}</span>
                        @endif
                        @if(auth()->user()->customer->point < $promo->point_price)
                            <span class="text-xs text-red-500 text-center">Your points are not enough</span>
                            @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Add Modal -->
        <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-xl">
                <h3 class="text-lg font-bold mb-4">Confirm Purchase</h3>
                <p class="mb-4">Do you want to buy this promo?</p>
                <div class="flex justify-end space-x-3">
                    <button id="cancelButton" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</button>
                    <button id="confirmButton"
                        class="px-4 py-2 bg-[#496948] text-white rounded-lg hover:bg-[#3e5a3e]">Buy</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    @include('components.navbar')

    @push('end-script')
    <script>
        let currentPromoId = null;

        function showConfirmModal(promoId, pointPrice) {
            currentPromoId = promoId;
            document.getElementById('confirmModal').classList.remove('hidden');
            document.getElementById('confirmModal').classList.add('flex');
        }

        document.getElementById('cancelButton').addEventListener('click', () => {
            document.getElementById('confirmModal').classList.add('hidden');
            document.getElementById('confirmModal').classList.remove('flex');
        });

        document.getElementById('confirmButton').addEventListener('click', async () => {
            try {
                const response = await fetch(`{{ route('c.buyPromo', '') }}/${currentPromoId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                if (data.status === 'success') {
                    window.location.href = "{{ route('c.home') }}";
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Transaction failed');
            }
        });
    </script>
    @endpush
</main>
@endsection