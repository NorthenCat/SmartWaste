@extends('layouts.app')

@section('content')
<main class="flex flex-col w-full h-full items-center bg-[#496948] shadow-all-darker">
    <div class="p-8 w-full">
        <div class="relative flex flex-row items-center justify-center w-full">
            <a href="@if($title=='Buy'){{route('c.transactions.buy')}}@else{{route('c.transactions.sell')}}@endif"
                class="absolute left-0 flex justify-center items-center bg-white w-10 h-10 rounded-full hover:bg-zinc-300 transition-colors duration-300 ease-in-out">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </a>
            <p class="text-white text-2xl font-medium">{{$title}}</p>
        </div>
    </div>
    <div class="w-full h-full">
        <form id="transactionForm"
            class="flex flex-col p-4 justify-start items-center space-y-8 bg-white rounded-tl-[40px] h-full w-full overflow-y-auto">
            @csrf
            <div class="grid grid-cols-2 bg-[#496948] w-full rounded-3xl p-4 gap-4">
                <div class="bg-white w-full h-full rounded-xl flex items-center justify-center">
                    <img src="{{asset('img/asset_web/box.png')}}" alt="Cardboard" class="w-32 h-32 object-cover">
                </div>
                @if($title=='Buy')
                <div class="flex flex-col justify-center space-y-2">
                    <p class="text-white text-lg font-bold">{{$product->name}}</p>
                    <p class="text-white">Rp. {{$product->price_per_unit}} /{{$product->unit}}</p>
                    <span class="text-gray-300 text-sm">Min > {{$product->minimal_weight.$product->unit}}</span>
                    <span class="text-gray-300 text-sm">Stock : {{$product->stock.$product->stock_unit}}</span>
                </div>
                @else
                <div class="flex flex-col justify-center space-y-2">
                    <p class="text-white text-lg font-bold">{{$product->name}}</p>
                    <p class="text-white">Rp. {{$product->price_sell_per_unit}} /{{$product->unit}}</p>
                    <span class="text-gray-300 text-sm">Min > {{$product->minimal_sell_weight.$product->unit}}</span>
                </div>
                @endif
            </div>
            <div class="bg-white w-full rounded-3xl p-4 shadow-all space-y-4">
                <p class="text-2xl font-semibold">Quantity</p>
                <div class="flex flex-row space-x-2 justify-between items-center">
                    <div class="w-2/3">
                        <input id="quantity" type="number" min="0" step="0.1" name="quantity" id="quantity"
                            placeholder="0"
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
                {{-- error --}}
                <div class="flex flex-row justify-between items-center">
                    <span id="error-quantity" class="error-message text-red-500 text-sm"></span>
                </div>
            </div>
            <div class="bg-white w-full rounded-3xl p-4 shadow-all space-y-4">
                <div class="flex flex-row justify-between items-center">
                    <h2 class="text-2xl font-semibold">@if($title=="Buy") Destination @else Pick Up Point @endif
                    </h2>
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" type="button"
                        class="p-2 bg-[#496948] text-white rounded-full"><i
                            class=" fa-solid fa-plus fa-lg"></i></button>
                </div>
                <div class="flex w-full items-center">
                    <div class="relative w-full">
                        <input id="addressInput"
                            class="w-full border-0 border-b-2 border-gray-300 focus:ring-0 focus:outline-none mt-1"
                            type="text" placeholder="Jl.Perumahan ABC Blok Z No.1" readonly>
                    </div>
                </div>
                <div id="addressList" class="flex items-center mb-4 overflow-x-auto">
                    {{-- List of address --}}
                </div>
                <span id="error-address" class="error-message text-red-500 text-sm hidden"></span>
            </div>
            <div class="bg-white w-full rounded-3xl p-4 shadow-all space-y-4">
                <div class="flex flex-row justify-between items-center">
                    <h2 class="text-2xl font-semibold">Choose Promo</h2>
                </div>
                <div id="promoList" class="flex items-center mb-4 space-x-2 overflow-x-auto">
                    {{-- List of promo --}}
                </div>
                <span id="error-promo" class="error-message text-red-500 text-sm hidden"></span>
            </div>
            @if($title=='Buy')
            <button id="formButton" type="submit"
                class="flex items-center  justify-center px-6 py-2.5 w-full rounded-lg bg-[#496948] text-white border-2 border-[#496948] hover:bg-white hover:text-[#496948] transition-colors duration-300 ease-in-out disabled:cursor-not-allowed">Buy:
                <span id="price" class="ms-2 font-bold"></span>
            </button>
            @else
            <button id="formButton" type="submit"
                class="flex items-center justify-center px-6 py-2.5 w-full rounded-lg bg-[#496948] text-white border-2 border-[#496948] hover:bg-white hover:text-[#496948] transition-colors duration-300 ease-in-out disabled:cursor-not-allowed group">
                <div>
                    <p>Ready To Pick Up </p>
                    <span id="point"
                        class="text-xs text-gray-300 group-hover:text-gray-600 transition-colors duration-300 ease-in-out"></span>
                </div>
            </button>
            @endif
            <span id="error-form-main" class="error-message text-red-500 text-sm hidden"></span>
        </form>
    </div>

    <!-- Main modal -->
    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow ">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                    <h3 class="text-lg font-semibold text-gray-900 ">
                        Add New Address
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form id="addressForm" class="p-4 md:p-5" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="location_name" class="block mb-2 text-sm font-medium text-gray-900 ">Address
                                Name</label>
                            <input type="text" id="location_name" name="location_name"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Home" />
                            <span id="error-name" class="error-message text-red-500 text-sm hidden">Address name already
                                exist</span>
                        </div>
                        <div class="col-span-2">
                            <label for="location_address"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Address</label>
                            <textarea id="location_address" name="location_address" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 max-h-24"
                                placeholder="Write your new address here"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-center w-full">
                        <button type="submit" id="submitBtn"
                            class="text-white inline-flex items-center bg-[#496948] hover:bg-zinc-300 hover:text-[#496948] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-2.5 text-center transition-colors duration-300 ease-in-out mx-auto">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Save
                        </button>
                        <span id="error-form" class="error-message text-red-500 text-sm hidden"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@push('end-script')
{{-- AddressForm --}}
<script>
    async function refreshAddressList() {
        try {
            const addressList = document.getElementById('addressList');
            const addressInput = document.getElementById('addressInput');
            addressList.innerHTML = '<div class="animate-pulse">Loading...</div>';

            const response = await fetch("{{route('c.transactions.addressList')}}");
            const result = await response.json();

            if (result.status === 'success') {
                addressList.innerHTML = '';
                const addresses = result.data;

                if (addresses && addresses.length > 0) {
                    addresses.forEach(address => {
                        const button = document.createElement('button');
                        const isActive = address.is_default;
                        button.type="button";

                        button.className = isActive
                            ? 'inline-flex flex-row items-center bg-[#496948] text-white font-medium py-2 px-4 rounded-xl mr-4'
                            : 'inline-flex flex-row items-center bg-white border-2 border-[#496948] text-[#496948] font-medium py-2 px-4 rounded-xl mr-4 hover:bg-[#496948] hover:text-white transition-colors duration-300 ease-in-out';

                        button.innerHTML = `
                            <div class="flex items-center">
                                <i class="fa-solid fa-bookmark pr-2"></i>
                                <span>${address.location_name}</span>
                            </div>
                        `;

                        // Add click handler
                        button.addEventListener('click', () => {
                            // Remove active class from all buttons
                            addressList.querySelectorAll('button').forEach(btn => {
                                btn.classList.remove('bg-[#496948]', 'text-white');
                                btn.classList.add('bg-white', 'border-[#496948]', 'text-[#496948]');
                            });

                            // Add active class to clicked button
                            button.classList.remove('bg-white', 'border-[#496948]', 'text-[#496948]');
                            button.classList.add('bg-[#496948]', 'text-white');

                            // Update input field
                            addressInput.value = address.location_address;

                            // Store selected address data if needed
                            document.getElementById('addressForm').dataset.selectedAddressId = address.id;
                        });

                        addressList.appendChild(button);

                        // Set default address if exists
                        if (isActive) {
                            button.click();
                        }
                    });
                }
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        refreshAddressList();
    });

    document.getElementById('addressForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const originalContent = submitBtn.innerHTML;
        const errorSpan = document.getElementById('error-name');
        let result;

        // Show loading state
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Saving...
        `;
        submitBtn.disabled = true;

        try {
            const formData = new FormData(this);
            const response = await fetch("{{route('c.transactions.addAddress')}}", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            });

            result = await response.json();

            if (response.ok) {
                // Show success feedback
                submitBtn.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Saved!
                `;
                submitBtn.classList.remove('bg-[#496948]');
                submitBtn.classList.add('bg-green-500');

                await refreshAddressList();
            } else {
                throw new Error(result.message || 'Something went wrong',result);
            }
        } catch (error) {
            // Show error feedback
            submitBtn.innerHTML = `
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Error!
            `;
            if (result && result.errors && result.errors.location_name) {
                errorSpan.textContent = result.errors.location_name[0];
                errorSpan.classList.remove('hidden');
                return;
            }
            console.log('Error:', error);
            submitBtn.classList.remove('bg-[#496948]');
            submitBtn.classList.add('bg-red-500');
        } finally {
            // Reset button and form after 2 seconds
            setTimeout(() => {
                // Reset button state
                submitBtn.innerHTML = originalContent;
                submitBtn.disabled = false;

                // Reset button styling
                submitBtn.classList.remove('bg-green-500', 'bg-red-500');
                submitBtn.classList.add('bg-[#496948]');

                // Reset form data
                document.getElementById('addressForm').reset();

                // Clear any error messages
                const errorElements = document.querySelectorAll('.error-message');
                errorElements.forEach(element => element.remove());
            }, 2000);
        }
    });
</script>

{{-- QuantityForm --}}
<script>
    function calculatePoint(weight) {
        const pointPerWeight = {{ $product->point_per_weight }};
        const weightForPoint = {{ $product->weight_for_point }};
        return Math.floor((pointPerWeight * weight) / weightForPoint);
    }

    function updatePointDisplay(points) {
        const pointElement = document.getElementById('point');
        if (pointElement) {
            pointElement.textContent = `You will get ${points} points`;
        }
    }

    function calculatePrice(){
        const quantityInput = document.getElementById('quantity');
        const unitSelect = document.getElementById('unit');
        const priceSpan = document.getElementById('price');

        const quantity = parseFloat(quantityInput.value) || 0;
        const unit = unitSelect.value;

        const title = '{{$title}}';

        // Convert current input to grams
        const currentWeight = convertToGrams(quantity, unit);

        // Calculate price
        const pricePerUnit =
            @if($title=='Buy')
                {{$product->price_per_unit}}
            @else
                {{$product->price_sell_per_unit}}
            @endif;

        return currentWeight * pricePerUnit;
    }

    function showErrorQuantity(message) {
        const errorSpan = document.getElementById('error-quantity');
        errorSpan.textContent = message;
        errorSpan.classList.remove('hidden');
    }

    function clearErrorQuantity() {
        const errorSpan = document.getElementById('error-quantity');
        errorSpan.textContent = '';
        errorSpan.classList.add('hidden');
    }
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    }

    function convertToGrams(value, unit) {
        return unit === 'kg' ? value * 1000 : parseFloat(value);
    }

    function validateAndCalculate() {
        const quantityInput = document.getElementById('quantity');
        const unitSelect = document.getElementById('unit');
        const formButton = document.getElementById('formButton');
        const priceSpan = document.getElementById('price');

        const quantity = parseFloat(quantityInput.value) || 0;
        const unit = unitSelect.value;
        const title = '{{$title}}';

        // Get minimal weight and stock
        const minimalWeight = convertToGrams(
            @if($title=='Buy')
                {{$product->minimal_weight}}
            @else
                {{$product->minimal_sell_weight}}
            @endif,
            '{{$product->unit}}'
        );

        const stockInGrams = convertToGrams({{$product->stock}}, '{{$product->stock_unit}}');
        const currentWeight = convertToGrams(quantity, unit);

        clearErrorQuantity();

        // Validate minimum weight
            if (currentWeight < minimalWeight) {
                if(title=='Buy'){
                    showErrorQuantity(`Minimum purchase is ${minimalWeight} grams (${minimalWeight/1000} kg)`);
                } else {
                    showErrorQuantity(`Minimum sell is ${minimalWeight} grams (${minimalWeight/1000} kg)`);
                }

                formButton.disabled = true;
                formButton.classList.add('opacity-50', 'cursor-not-allowed');
                formButton.classList.remove('hover:bg-white', 'hover:text-[#496948]');

                if(title=='Buy') priceSpan.textContent = '-';
                if(title=='Sell') updatePointDisplay(0);
                return;
            }

        // Validate stock
        if(title=='Buy'){
            if (currentWeight > stockInGrams) {
                showErrorQuantity(`Exceeds available stock. Maximum purchase is ${stockInGrams} grams (${stockInGrams/1000} kg)`);
                formButton.disabled = true;
                formButton.classList.add('opacity-50', 'cursor-not-allowed');
                formButton.classList.remove('hover:bg-white', 'hover:text-[#496948]');

                priceSpan.textContent = '-';
                return;
            }
        }

        formButton.disabled = false;
        formButton.classList.remove('opacity-50', 'cursor-not-allowed');
        formButton.classList.add('bg-[#496948]', 'text-white', 'hover:bg-white', 'hover:text-[#496948]', 'transition-colors', 'duration-300', 'ease-in-out');

        // Calculate price
        const pricePerUnit = @if($title=='Buy') {{$product->price_per_unit}} @else {{$product->price_sell_per_unit}} @endif;
        let totalPrice = currentWeight * pricePerUnit;

        if(title == 'Buy') {
            // Handle buy transaction with discount promo
            if(selectedPromo && selectedPromo.promo.type_promo === 'discount' && selectedPromo.promo.discount > 0) {
                const discount = (selectedPromo.promo.discount / 100) * totalPrice;
                totalPrice -= discount;
            }
            priceSpan.textContent = totalPrice > 0 ? `${formatRupiah(totalPrice)}` : '-';
        } else {
            let points = calculatePoint(currentWeight);
            if(selectedPromo && selectedPromo.promo.type_promo === 'point' && selectedPromo.promo.multiply_point > 0) {
                points = points * selectedPromo.promo.multiply_point;
            }
            updatePointDisplay(points);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const quantityInput = document.getElementById('quantity');
        const unitSelect = document.getElementById('unit');
        const formButton = document.getElementById('formButton');

        // Add listeners for changes
        quantityInput.addEventListener('input', validateAndCalculate);
        unitSelect.addEventListener('change', validateAndCalculate);

        // Initial calculation
        validateAndCalculate();
    });
</script>

{{-- PromoList --}}
<script>
    let selectedPromo = null;
    let selectedPromoId = null;

    async function fetchPromos() {
        const promoList = document.getElementById('promoList');
        try {
            promoList.innerHTML = '<div class="w-full text-center text-gray-500">Loading vouchers...</div>';

            const response = await fetch(`{{ route('c.transactions.promoList', strtolower($title)) }}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (data.status === 'success') {
                if (data.data && data.data.length > 0) {
                    console.log(data);
                    renderPromos(data.data);
                } else {
                    promoList.innerHTML = '<div class="w-full text-center text-gray-500">You don\'t have any voucher promo</div>';
                }
            }
        } catch (error) {
            console.error('Error fetching promos:', error);
            promoList.innerHTML = '<div class="w-full text-center text-red-500">Failed to load vouchers</div>';
        }
    }

    function renderPromos(promos) {
        const promoList = document.getElementById('promoList');
        promoList.innerHTML = '';

        promos.forEach(data => {
            const promoCard = document.createElement('div');
            promoCard.className = 'flex-shrink-0 w-48 p-4 border rounded-lg cursor-pointer snap-start transition-all duration-200 hover:shadow-md';
            promoCard.setAttribute('data-promo-id', data.promo.id);

            promoCard.innerHTML = `
                <div class="space-y-2">
                    <p class="font-semibold">${data.promo.name}</p>
                    <p class="text-xs text-gray-400">Have : ${data.promo_count} voucher</p>
                </div>
            `;

            promoCard.addEventListener('click', () => selectPromo(data, promoCard));
            promoList.appendChild(promoCard);
        });
    }

    function selectPromo(promo, element) {
        const isCurrentlySelected = element.classList.contains('selected-promo');

        // Remove styling from previous selection
        const previousSelected = document.querySelector('.selected-promo');
        if (previousSelected) {
            previousSelected.classList.remove('selected-promo', 'border-[#496948]', 'bg-[#496948]/10');
        }

        // If clicking the same promo, unselect it
        if (isCurrentlySelected) {
            selectedPromo = null;
            selectedPromoId = null;

            const quantity = parseFloat(document.getElementById('quantity').value) || 0;
            const currentWeight = convertToGrams(quantity, document.getElementById('unit').value);


            // Reset points to base calculation
            let basePoints = calculatePoint(currentWeight);
            updatePointDisplay(basePoints);
            validateAndCalculate();
            return;
        }

        // Select new promo
        element.classList.add('selected-promo', 'border-[#496948]', 'bg-[#496948]/10');
        selectedPromo = promo;
        selectedPromoId = promo.id;
        document.getElementById('error-promo').classList.add('hidden');

        validateAndCalculate();
    }

    document.addEventListener('DOMContentLoaded', fetchPromos);
</script>


{{-- TransactionForm --}}
<script>
    document.getElementById('transactionForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formButton = document.getElementById('formButton');
        const originalContent = formButton.innerHTML;
        const addressInput = document.getElementById('addressInput');
        const quantityInput = document.getElementById('quantity');
        const priceSpan = document.getElementById('price');

        // Validate required fields
        if (!addressInput.value) {
            const errorAddress = document.getElementById('error-address');
            errorAddress.textContent = 'Please select an address';
            errorAddress.classList.remove('hidden');
            return;
        }

        if (!quantityInput.value) {
            showErrorQuantity('Please enter quantity');
            return;
        }

        // Show loading state
        formButton.disabled = true;
        formButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Processing...
        `;

        try {
            const formData = new FormData(this);
            formData.append('title', '{{$title}}');
            formData.append('product_id', '{{$product->id}}');
            formData.append('product_name', '{{$product->name}}');
            formData.append('destination', addressInput.value);
            formData.append('customer_promo_id', selectedPromoId);
            const price = priceSpan ? calculatePrice() : 0;
            if (price && (price !== '-' || price !== '')) {
                formData.append('price', price);
            } else {
                formData.append('price',0);
            }
            // // Replace console.log(formData.data) with:
            // for (let [key, value] of formData.entries()) {
            //     console.log(`${key}: ${value}`);
            // }

            const response = await fetch("{{route('c.transactions.store')}}", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                // Show success state
                formButton.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Success!
                `;
                formButton.classList.remove('bg-[#496948]');
                formButton.classList.add('bg-green-500');
                // Redirect after success
                setTimeout(() => {
                    window.location.href = "{{route('c.home')}}";
                }, 2000);
            } else {
                console.log(result.debug);
                throw new Error(result.message || 'Transaction failed');
            }
        } catch (error) {
            console.error('Error:', error);
            formButton.innerHTML = `
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Failed
            `;
            formButton.classList.remove('bg-[#496948]');
            formButton.classList.add('bg-red-500');
            const errorForm = document.getElementById('error-form-main');
            errorForm.textContent = error.message;
            errorForm.classList.remove('hidden');
        } finally {
            setTimeout(() => {
                formButton.disabled = false;
                formButton.innerHTML = originalContent;
                formButton.classList.remove('bg-green-500', 'bg-red-500');
                formButton.classList.add('bg-[#496948]');
            }, 2000);
        }
    });
</script>
@endpush
@endsection