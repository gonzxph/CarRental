

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header/header.php' ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB70fmdxTT6eYDICyXwGr7rZDy-0DZJSQY&libraries=places"></script>
    <title>D & I Cebu Car Rental Testing pre</title>
    <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/build/vanilla-calendar.min.css" rel="stylesheet">
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
                            <form id="bookingForm" action="index.php" method="POST">
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-white"><i class="fas fa-map-marker-alt text-warning"></i></span>
                                    <input readonly id="pickupInput" name="pickupinput" type="text" data-bs-toggle="modal" data-bs-target="#pickupModal" class="form-control" placeholder="Choose pick up location" value="">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-white"><i class="fas fa-map-marker-alt text-danger"></i></span>
                                    <input readonly id="dropoffInput" name="dropoffinput" type="text" data-bs-toggle="modal" data-bs-target="#pickupModal" class="form-control" placeholder="Choose drop off location" value="">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-white"><i class="fas fa-calendar-alt text-secondary"></i></span>
                                    <input readonly id="dateTimeInput" type="text" data-bs-toggle="modal" data-bs-target="#dateTimeModal" class="form-control" placeholder="Choose date and time">
                                </div>
                                <div id="warningMessage" class="text-danger m-3" style="display: none;">
                                    Please fill out all fields before submitting!
                                </div>
                                <button type="submit" class="btn btn-dark mt-3">Book Now</button>
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
                    <h1 class="modal-title fs-5" id="modalTitle"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Search location</strong></p>
                    <form class="d-flex">
                        <input id="autocomplete" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    </form>

                    <div class="d-flex flex-column gap-0 mt-0">
                        <button class="btn d-flex align-items-center mt-2" onclick="getLocation()">
                            <i class="fa-regular fa-circle-dot me-2"></i>
                            <span>Use my current location</span>
                        </button>
                        <button class="btn d-flex align-items-center" onclick="openMapModal()">
                            <i class="fa-solid fa-map me-2"></i>
                            <span>Set location in map</span>
                        </button>
                        <button class="btn d-flex align-items-center" onclick="pickupGarage()">
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



<!-- Second Modal for Map -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="back-btn" onclick="backToPickupModal()"><i class="fas fa-arrow-left"></i></button>
                <h1 class="modal-title fs-5 m-3">Set Location on Map</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="map" style="height: 450px;"></div>
                <div id="locationResultMap" class="mt-3"></div> <!-- Display selected address here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="selectMapLocation()">Select Location</button>
            </div>
        </div>
    </div>
</div>


<!-- Pickup date and time modal -->
<div class="modal fade" id="dateTimeModal" tabindex="-1" aria-labelledby="dateTimeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <!-- Adjusted modal size and centering -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateTimeModalLabel">Select Pickup & Drop-off Dates and Times</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Centered Calendar Container for Pick-up Date -->
                <div id="vanillaCalendar" class="vanilla-calendar calendar-center"></div>
                
                <!-- Time Picker -->
                <div class="row mt-4">
                    <div class="col">
                        <label for="pickupTimeInput">Pickup Time:</label>
                        <input type="text" class="form-control" id="pickupTimeInput" readonly value="">
                    </div>
                    <div class="col">
                        <label for="dropOffTimeInput">Drop-Off Time:</label>
                        <input type="text" class="form-control" id="dropOffTimeInput" readonly value="">
                    </div>
                </div>
                <p class="text-muted mt-3">Please choose a pickup time that is at least 1 hour from the current time.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="pconfirm">Confirm</button>
            </div>
        </div>
    </div>
</div>



    <?php include 'footer/footer.php' ?>

</body>


<?php include 'footer/js/js.php' ?>
<script src="js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/build/vanilla-calendar.min.js" defer></script>
</html>
