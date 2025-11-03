<?php
include("../Functions/functions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Homepage</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <a href="https://icons8.com/icon/83325/roman-soldier"></a>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/c587fc1763.js" crossorigin="anonymous"></script>

    <style>
        <?php
        include("../styles/buyer/bhome.css");
        ?>
    </style>
</head>

<body>
    <?php
    include("../layout/nav.php");
    ?>
    <div class="container py-3 mt-3">
        <div class="d-flex justify-content-center gap-4 mb-4">
            <!-- Fruits Dropdown -->
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle px-4 py-2 rounded-pill shadow-sm" type="button" id="fruitsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-apple-alt me-2"></i> Fruits
                </button>
                <ul class="dropdown-menu dropdown-menu-lg-end p-3 border-0 shadow" aria-labelledby="fruitsDropdown">
                    <?php getFruits(); ?>
                </ul>
            </div>

            <!-- Vegetables Dropdown -->
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle px-4 py-2 rounded-pill shadow-sm" type="button" id="vegetablesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-carrot me-2"></i> Vegetables
                </button>
                <ul class="dropdown-menu dropdown-menu-lg-end p-3 border-0 shadow" aria-labelledby="vegetablesDropdown">
                    <?php getVegetables(); ?>
                </ul>
            </div>

            <!-- Crops Dropdown -->
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle px-4 py-2 rounded-pill shadow-sm" type="button" id="cropsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-wheat-alt me-2"></i> Crops
                </button>
                <ul class="dropdown-menu dropdown-menu-lg-end p-3 border-0 shadow" aria-labelledby="cropsDropdown">
                    <?php getCrops(); ?>
                </ul>
            </div>
        </div>
    </div>


<!-- Fruits Section -->
<section class="fruits-section">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-success mb-4">
                <span class="position-relative">
                    Fresh Fruits
                    <span class="position-absolute bottom-0 start-50 translate-middle-x bg-success" style="height: 3px; width: 100px;"></span>
                </span>
            </h1>
            <p class="lead text-muted">Seasonal, organic, and delivered fresh to your doorstep</p>
        </div>

        <div class="row g-4">
            <?php getFruitsHomepage(); ?>
        </div>
    </div>
</section>
    <!-- Vegetables Section -->
<section class="vegetables-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-success position-relative d-inline-block">
                <span>Fresh Vegetables</span>
                <span class="position-absolute bottom-0 start-0 end-0 mx-auto bg-success" style="height: 3px; width: 80%;"></span>
            </h2>
            <p class="lead text-muted mt-3">Farm-fresh and packed with nutrients</p>
        </div>

        <div class="row g-4">
            <?php getVegetablesHomepage(); ?>
        </div>

        
    </div>
</section>
    <br><br>
   <!-- Best Selling Products Section -->
<section class="best-sellers py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-dark position-relative pb-3">
                <span class="position-relative">
                    Best Selling Products
                    <span class="position-absolute bottom-0 start-50 translate-middle-x bg-success" style="height: 4px; width: 120px;"></span>
                </span>
                <small class="d-block mt-2 text-muted">Most loved across India</small>
            </h2>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php getProducts(); ?>
        </div>

        
    </div>
</section>

<!-- Shopping Cart Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-shopping-cart me-2"></i>Your Shopping Cart</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <?php cart(); ?>
            </div>
           
        </div>
    </div>
</div>
    <?php
    include("../layout/footer.php");
    ?>
</body>

</html>