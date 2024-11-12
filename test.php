<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accurate Location with Mapbox</title>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css" rel="stylesheet" />
</head>
<body>
    <h1>Get Accurate Location</h1>
    <button onclick="getAccurateLocation()">Get Current Location</button>
    <p id="locationResult">Your location will appear here.</p>

    <script>
        // Mapbox access token
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2hpbnRhMHgwMSIsImEiOiJjbTNkYW53NDkwMWF1MmpvbXFxaXhweWZmIn0.p2MOT6B5U-nT7MAqc77EGQ';

        function getAccurateLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        reverseGeocodeWithMapbox(latitude, longitude);
                    },
                    (error) => {
                        document.getElementById("locationResult").innerText = "Error getting location: " + error.message;
                    },
                    { enableHighAccuracy: true } // High accuracy mode
                );
            } else {
                document.getElementById("locationResult").innerText = "Geolocation is not supported by this browser.";
            }
        }

        function reverseGeocodeWithMapbox(latitude, longitude) {
            const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${longitude},${latitude}.json?access_token=${mapboxgl.accessToken}`;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.features && data.features.length > 0) {
                        const placeName = data.features[0].place_name;
                        document.getElementById("locationResult").innerText = "Address: " + placeName;
                    } else {
                        document.getElementById("locationResult").innerText = "No address found for this location.";
                    }
                })
                .catch(error => {
                    document.getElementById("locationResult").innerText = "Error fetching address: " + error;
                });
        }
    </script>
</body>
</html>
