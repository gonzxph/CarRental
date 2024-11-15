<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <style>
        /* Container for the gallery */
        .gallery-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            width: 400px;
            margin: auto;
            background-color: #f9f9f9;
        }

        /* Large main image */
        .main-image img {
            width: 100%;
            max-width: 300px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Thumbnails container */
        .thumbnails {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        /* Styling each thumbnail */
        .thumbnail img {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Zoom effect on hover */
        .thumbnail img:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>

<div class="gallery-container">
    <!-- Main image -->
    <div class="main-image">
        <img id="mainImage" src="images/logo/logo1.png" alt="Main Car Image">
    </div>

    <!-- Thumbnails -->
    <div class="thumbnails">
        <div class="thumbnail">
            <img src="images/logo/logo1.png" alt="Thumbnail 1" onclick="changeImage('images/logo/logo1.png')">
        </div>
        <div class="thumbnail">
            <img src="images/bg/bg-cclex.jpeg" alt="Thumbnail 2" onclick="changeImage('images/bg/bg-cclex.jpeg')">
        </div>
        <div class="thumbnail">
            <img src="images/logo/logo1.png" alt="Thumbnail 3" onclick="changeImage('images/logo/logo1.png')">
        </div>
        <div class="thumbnail">
            <img src="images/logo/logo1.png" alt="Thumbnail 4" onclick="changeImage('images/logo/logo1.png')">
        </div>
    </div>
</div>

<script>
    // Function to change the main image based on thumbnail click
    function changeImage(imageSrc) {
        document.getElementById('mainImage').src = imageSrc;
    }
</script>

</body>
</html>
