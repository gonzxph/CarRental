<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header/header.php' ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB70fmdxTT6eYDICyXwGr7rZDy-0DZJSQY&libraries=places"></script>
    <title>D & I Cebu Car Rental Testing pre</title>
</head>
<body>

    <?php include 'header/nav.php' ?>

    <div class="container-fluid one vh-75">
        <div class="row p-5">
            <div class="col-lg-6 mt-4 mb-3">
                <h1 class="text-center">Your ON-THE-GO road partner</h1>
                <p class="text-center">Explore Cebu with reliable, affordable, and quality vehicles.</p>
            </div>
            <div class="col-lg-6 d-flex justify-content-center">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="card text-center shadow-lg p-4" style="width: 25rem;">
                        <h5 class="card-title mb-3">Find the right car now!</h5>
                        <div class="card-body">
                            <form>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-white"><i class="fas fa-map-marker-alt text-warning"></i></span>
                                    <input readonly type="text" data-bs-toggle="modal" data-bs-target="#pickupModal" class="form-control" placeholder="Choose pick up location" value="">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-white"><i class="fas fa-map-marker-alt text-danger"></i></span>
                                    <input readonly type="text" class="form-control" placeholder="Choose drop off location" value="">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-white"><i class="fas fa-calendar-alt text-secondary"></i></span>
                                    <input readonly type="text" class="form-control" placeholder="Choose date and time">
                                </div>
                                <button type="button" class="btn btn-dark mt-3">Book Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="pickupModal" tabindex="-1" aria-labelledby="pickupModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="pickupModal">Choose your pick location</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Search location</strong></p>
                    <form class="d-flex">
                        <input id="locationSearch" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    </form>

                    <div class="d-flex flex-column gap-0 mt-0">
                        <button class="btn d-flex align-items-center mt-2" onclick="getLocation()">
                            <i class="fa-regular fa-circle-dot me-2"></i>
                            <span>Use my current location</span>
                        </button>
                        <button class="btn d-flex align-items-center">
                            <i class="fa-solid fa-map me-2"></i>
                            <span>Set location in map</span>
                        </button>
                        <button class="btn d-flex align-items-center">
                            <i class="fa-solid fa-warehouse me-2"></i>
                            <span>Pickup in garage</span>
                        </button>
                    </div>

                    <!-- Display the location coordinates here -->
                    <div id="locationResult" class="mt-3"></div>

                </div> <!-- Closing modal-body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveChangesBtn">Select location</button>
                </div> <!-- Closing modal-footer -->

            </div> <!-- Closing modal-content -->
        </div> <!-- Closing modal-dialog -->
    </div> <!-- Closing modal -->

    <?php include 'footer/footer.php' ?>

</body>

<script>

let pickupAddress = ''; // Variable to store the address

// Initialize Google Places Autocomplete
function initAutocomplete() {
    const input = document.getElementById('locationSearch');
    const autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener('place_changed', () => {
        const place = autocomplete.getPlace();
        if (place.formatted_address) {
            // Store the formatted address and display it
            pickupAddress = place.formatted_address;
            document.getElementById("locationResult").innerText = "Address: " + pickupAddress;
        } else {
            document.getElementById("locationResult").innerText = "No location found.";
        }
    });
}

// Initialize autocomplete when the page loads
window.addEventListener('load', initAutocomplete);

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


</script>



<?php include 'footer/js/js.php' ?>

</html>
