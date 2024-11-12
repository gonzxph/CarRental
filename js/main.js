let selectedLocationType = ''; // To store if it's pickup or drop-off
let selectedAddress = ''; // To store the selected address
let marker = null;  // To store the marker
let cebuProvinceBounds;  // To define the bounds of Cebu Province

document.addEventListener('DOMContentLoaded', function() {
    const pickupModal = document.getElementById('pickupModal');
    const mapModal = new bootstrap.Modal(document.getElementById('mapModal'));

    // Define the boundary for Cebu Province (approximate bounds for the whole province)
    cebuProvinceBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(9.5800, 123.0200),  // Southwest corner of Cebu Province
        new google.maps.LatLng(10.8500, 124.1000)   // Northeast corner of Cebu Province
    );

    // Event listener for the pickup input field
    document.getElementById('pickupInput').addEventListener('click', () => {
        selectedLocationType = 'pickup';
        document.getElementById('modalTitle').innerText = 'Choose your pickup location';
    });

    // Event listener for the drop-off input field
    document.getElementById('dropoffInput').addEventListener('click', () => {
        selectedLocationType = 'dropoff';
        document.getElementById('modalTitle').innerText = 'Choose your drop-off location';
    });

    // Initialize Google Places Autocomplete when modal is shown
    pickupModal.addEventListener('shown.bs.modal', function () {
        const input = document.getElementById('autocomplete');
        const autocomplete = new google.maps.places.Autocomplete(input, {
            componentRestrictions: { country: 'PH' }, // Restrict to the Philippines
            bounds: cebuProvinceBounds  // Restrict autocomplete results to Cebu Province
        });

        autocomplete.addListener('place_changed', () => {
            const place = autocomplete.getPlace();
            if (place.formatted_address) {
                selectedAddress = place.formatted_address;
                document.getElementById("locationResult").innerText = "Address: " + selectedAddress;
            } else {
                alert("No valid address found. Please try again.");
            }
        });
    });
});

// Function to get the user's current location using Geolocation API
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        document.getElementById("locationResult").innerText = "Geolocation is not supported by this browser.";
    }
}

// Callback for successful geolocation
function showPosition(position) {
    const { latitude, longitude } = position.coords;
    reverseGeocode(latitude, longitude);
}

// Error handling for geolocation
function showError(error) {
    const locationResult = document.getElementById("locationResult");
    switch (error.code) {
        case error.PERMISSION_DENIED:
            locationResult.innerText = "Permission denied for Geolocation.";
            break;
        case error.POSITION_UNAVAILABLE:
            locationResult.innerText = "Location information is unavailable.";
            break;
        case error.TIMEOUT:
            locationResult.innerText = "The request to get user location timed out.";
            break;
        default:
            locationResult.innerText = "An unknown error occurred.";
    }
}

// Function to reverse geocode coordinates to get an address
function reverseGeocode(latitude, longitude) {
    const apiKey = "AIzaSyB70fmdxTT6eYDICyXwGr7rZDy-0DZJSQY"; // Replace with your API key
    const url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=${apiKey}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.status === "OK" && data.results.length > 0) {
                selectedAddress = data.results[0].formatted_address;
                document.getElementById("locationResult").innerText = "Address: " + selectedAddress;
            } else {
                document.getElementById("locationResult").innerText = "Unable to retrieve location information.";
            }
        })
        .catch(error => {
            document.getElementById("locationResult").innerText = "Error fetching location: " + error;
        });
}

// Pre-defined address for pickup in garage
function pickupGarage() {
    selectedAddress = "Guada Plains Guadalupe 6000 Cebu City, Philippines";
    document.getElementById("locationResult").innerText = "Address: " + selectedAddress;
}

// Update the selected input field when 'Save changes' is clicked
document.getElementById("saveChangesBtn").addEventListener("click", function() {
    if (selectedAddress) {
        const inputField = selectedLocationType === 'pickup' 
            ? document.getElementById('pickupInput') 
            : document.getElementById('dropoffInput');

        inputField.value = selectedAddress;

        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('pickupModal'));
        modal.hide();

        selectedAddress = '';
        document.getElementById("locationResult").innerText = '';
    } else {
        document.getElementById("locationResult").innerText = "No location selected.";
    }
});

function openMapModal() {
    const pickupModal = bootstrap.Modal.getInstance(document.getElementById('pickupModal'));
    const mapModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('mapModal'));
    pickupModal.hide();
    mapModal.show();
    loadGoogleMap(); 
}

function backToPickupModal() {
    const mapModal = bootstrap.Modal.getInstance(document.getElementById('mapModal'));
    const pickupModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('pickupModal'));
    mapModal.hide();
    pickupModal.show();
}

function selectMapLocation() {
    const mapModal = bootstrap.Modal.getInstance(document.getElementById('mapModal'));
    const inputField = selectedLocationType === 'pickup' 
        ? document.getElementById('pickupInput') 
        : document.getElementById('dropoffInput');

    inputField.value = selectedAddress;
    mapModal.hide();
}

// Load Google Map with clickable functionality
function loadGoogleMap() {
    const mapDiv = document.getElementById('map');
    const map = new google.maps.Map(mapDiv, {
        center: { lat: 10.3157, lng: 123.8854 }, // Centered at Cebu City
        zoom: 10,  // Set zoom level for Cebu Province view
        disableDefaultUI: true, // Disable all default UI elements
        restriction: {
            latLngBounds: cebuProvinceBounds, // Limit the map to Cebu Province bounds
            strictBounds: true // Enforce strict boundary restriction
        }
    });

    const geocoder = new google.maps.Geocoder();

    // Click event to get the address from lat/lng
    map.addListener('click', function(event) {
        const clickedLocation = event.latLng;

        // Check if the clicked location is within Cebu Province bounds
        if (!cebuProvinceBounds.contains(clickedLocation)) {
            alert("Please select a location within Cebu Province.");
            return;
        }

        geocodeLatLng(geocoder, clickedLocation);

        // If a marker exists, remove it before adding a new one
        if (marker) {
            marker.setMap(null);
        }

        // Create a new marker at the clicked location
        marker = new google.maps.Marker({
            position: clickedLocation,
            map: map,
            icon: {
                url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png", // Red marker icon
                scaledSize: new google.maps.Size(40, 40)  // Adjust the size of the marker
            },
            draggable: true  // Make the marker draggable
        });
    });
}

// Function to geocode latitude and longitude to an address
function geocodeLatLng(geocoder, latLng) {
    geocoder.geocode({ location: latLng }, function(results, status) {
        if (status === "OK") {
            if (results[0]) {
                selectedAddress = results[0].formatted_address;
                document.getElementById("locationResultMap").innerText = "Selected Address: " + selectedAddress;
            } else {
                document.getElementById("locationResultMap").innerText = "No address found.";
            }
        } else {
            document.getElementById("locationResultMap").innerText = "Geocoder failed: " + status;
        }
    });
}
