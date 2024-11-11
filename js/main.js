let selectedLocationType = ''; // Variable to store whether it's pickup or drop-off
let selectedAddress = ''; // Variable to store the selected address
let modalTitle = '';

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('pickupModal');

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

    // Initialize Google Places Autocomplete
    modal.addEventListener('shown.bs.modal', function () {
        const input = document.getElementById('autocomplete');
        const autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', () => {
            const place = autocomplete.getPlace();
            if (place.formatted_address) {
                selectedAddress = place.formatted_address;
                document.getElementById("locationResult").innerText = "Address: " + selectedAddress;
            } else {
                alert("Autocomplete is not enabled or API key is restricted.");
            }
        });
    });
});

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        document.getElementById("locationResult").innerText = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    const latitude = position.coords.latitude;
    const longitude = position.coords.longitude;
    reverseGeocode(latitude, longitude);
}

function showError(error) {
    const locationResult = document.getElementById("locationResult");
    switch (error.code) {
        case error.PERMISSION_DENIED:
            locationResult.innerText = "User denied the request for Geolocation.";
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

function reverseGeocode(latitude, longitude) {
    const apiKey = "AIzaSyB70fmdxTT6eYDICyXwGr7rZDy-0DZJSQY";
    const url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=${apiKey}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.status === "OK") {
                const formattedAddress = data.results[0].formatted_address;
                selectedAddress = formattedAddress;
                document.getElementById("locationResult").innerText = "Address: " + formattedAddress;
            } else {
                document.getElementById("locationResult").innerText = "Unable to retrieve location information.";
            }
        })
        .catch(error => {
            document.getElementById("locationResult").innerText = "Error fetching location: " + error;
        });
}

function pickupGarage(){
    selectedAddress = "Guada Plains Guadalupe 6000 Cebu City, Philippines";
    document.getElementById("locationResult").innerText = "Address: " + selectedAddress;
}

// Update the selected input field when 'Save changes' is clicked
document.getElementById("saveChangesBtn").addEventListener("click", function() {
    if (selectedAddress) {
        // Select the appropriate input field based on selectedLocationType
        const inputField = selectedLocationType === 'pickup' 
            ? document.getElementById('pickupInput') 
            : document.getElementById('dropoffInput');

        // Set the selected address to the correct input field
        inputField.value = selectedAddress;

        // Close the modal
        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('pickupModal'));
        modal.hide();
    } else {
        document.getElementById("locationResult").innerText = "No location selected.";
    }
});
