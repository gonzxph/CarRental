<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Google Places Autocomplete</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB70fmdxTT6eYDICyXwGr7rZDy-0DZJSQY&libraries=places"></script>
</head>
<body>
    <h1>Google Places Autocomplete Test</h1>
    <input id="autocomplete" type="text" placeholder="Start typing a location..." style="width: 300px; padding: 8px;">
    <script>
        function initAutocomplete() {
            const input = document.getElementById('autocomplete');
            const autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();
                console.log('Selected place:', place);
                if (place.formatted_address) {
                    alert("Autocomplete works! Address: " + place.formatted_address);
                } else {
                    alert("Autocomplete is not enabled or API key is restricted.");
                }
            });
        }

        // Initialize autocomplete when the page loads
        window.onload = initAutocomplete;
    </script>
</body>
</html>
