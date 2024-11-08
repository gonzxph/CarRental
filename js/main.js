let pickupAddress = ''; // Variable to store the address

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('pickupModal');

    modal.addEventListener('shown.bs.modal', function () {
        const input = document.getElementById('autocomplete');
        const autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', () => {
            const place = autocomplete.getPlace();
            console.log('Selected place:', place);
            if (place.formatted_address) {
                pickupAddress = place.formatted_address;
                document.getElementById("locationResult").innerText = "Address: " + pickupAddress;
            } else {
                alert("Autocomplete is not enabled or API key is restricted.");
            }
        });
    });
});

function getLocation() {
    // Check if Geolocation is supported
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        document.getElementById("locationResult").innerText = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    // Get latitude and longitude
    const latitude = position.coords.latitude;
    const longitude = position.coords.longitude;

    // Call reverse geocoding function to get the address
    reverseGeocode(latitude, longitude);
}

function showError(error) {
    // Handle different error cases
    switch (error.code) {
        case error.PERMISSION_DENIED:
            document.getElementById("locationResult").innerText = "User denied the request for Geolocation.";
            break;
        case error.POSITION_UNAVAILABLE:
            document.getElementById("locationResult").innerText = "Location information is unavailable.";
            break;
        case error.TIMEOUT:
            document.getElementById("locationResult").innerText = "The request to get user location timed out.";
            break;
        case error.UNKNOWN_ERROR:
            document.getElementById("locationResult").innerText = "An unknown error occurred.";
            break;
    }
}

function reverseGeocode(latitude, longitude) {
    // Your Google Maps Geocoding API key
    const apiKey = "AIzaSyB70fmdxTT6eYDICyXwGr7rZDy-0DZJSQY"; // Replace with your actual API key
    const url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=${apiKey}`;

    // Fetch data from Google Maps API
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.status === "OK") {
                // Get the formatted address
                const formattedAddress = data.results[0].formatted_address;

                // Store the formatted address in pickupAddress
                pickupAddress = formattedAddress;

                // Display the formatted address in the modal
                document.getElementById("locationResult").innerText = "Address: " + formattedAddress;
            } else {
                document.getElementById("locationResult").innerText = "Unable to retrieve location information.";
            }
        })
        .catch(error => {
            document.getElementById("locationResult").innerText = "Error fetching location: " + error;
        });
}

// Update the pick-up location input field when 'Save changes' is clicked
document.getElementById("saveChangesBtn").addEventListener("click", function() {
    if (pickupAddress) {
        // Find the input field for pick-up location and set its value
        const pickUpInputField = document.querySelector("input[placeholder='Choose pick up location']");
        pickUpInputField.value = pickupAddress; // Set the address as the value

        // Close the modal
        let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('pickupModal'))
        modal.hide();
    } else {
        document.getElementById("locationResult").innerText = "No location selected.";
    }
});