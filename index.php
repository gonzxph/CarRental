<!DOCTYPE html>
<html lang="en">
<head>
    
    <?php include 'header/header.php'?>
    <title>D & I Cebu Car Rental</title>
</head>
<body>

    <?php include 'header/nav.php'?> 

    <div class="container one vh-70">
        <div class="row p-5">
            <div class="col-lg-6 mt-5 mb-3">
                <h1 class="text-center">Your ON-THE-GO road partner</h1>
                <p class="text-center ">Explore Cebu with reliable, affordable, and quality vehicles.</p>
            </div>
            <div class="col-lg-6">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="card text-center shadow-lg p-4" style="width: 22rem;">
                        <h5 class="card-title mb-3">Find the right car now!</h5>
                        <div class="card-body">
                            <form>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-white"><i class="fas fa-map-marker-alt text-warning"></i></span>
                                    <input readonly type="text" class="form-control" placeholder="Choose pick up location">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-white"><i class="fas fa-map-marker-alt text-danger"></i></span>
                                    <input readonly type="text" class="form-control" placeholder="Choose drop off location">
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


    <?php include 'footer/footer.php'?> 

</body>

<?php include 'footer/js/js.php'?>

</html>