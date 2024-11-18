@extends('layouts.app')
@section('content')
<main class="flex flex-col w-full h-full items-center bg-[#496948] shadow-all-darker">
    <div id="map" class="h-full rounded-lg w-full"></div>
    <a href="@route('c.home')"
        class="absolute left-0 flex justify-center items-center bg-white w-10 h-10 rounded-full hover:bg-zinc-300 transition-colors duration-300 ease-in-out z-50"
        aria-label="Back">
        <i class="fa-solid fa-arrow-left fa-lg"></i>
    </a>
    <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-md mx-auto">
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2" for="address">
                Your Location
            </label>
            <input
                class="border rounded-lg py-2 px-4 w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                type="text" id="address" value="Jl.Perumahan ABC Blok Z No.1" readonly>
        </div>
        <button class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg w-full"
            aria-label="Save Address">
            Save Address
        </button>
    </div>
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANHpWA77Oh-A4ShX7GaB1qN63oRfHG59I"></script>
    <script>
        // Initialize the map
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: -7.7794, lng: 110.3695 },
                zoom: 13
            });

            // Add a marker for the selected location
            var marker = new google.maps.marker.AdvancedMarkerElement({
                position: { lat: -7.7794, lng: 110.3695 },
                map: map,
                title: "Jl.Perumahan ABC Blok Z No.1"
            });

            // Handle map click to update the marker and address input
            map.addListener('click', function(event) {
                marker.setPosition(event.latLng);
                var newLocation = event.latLng.lat().toFixed(4) + ", " + event.latLng.lng().toFixed(4);
                marker.setTitle(newLocation);
                document.getElementById('address').value = newLocation;
            });
        }

        initMap();
    </script>
</main>
@endsection
