<?php
include("../Functions/functions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details | AgroBazaar</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #28a745;
            --secondary-color: #f8f9fa;
            --accent-color: #ffc107;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .product-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        
        .product-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .product-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .product-info-card {
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
        }
        
        .farmer-card {
            background-color: var(--dark-color);
            color: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            height: 100%;
        }
        
        .price-tag {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .stock-info {
            font-size: 1.2rem;
            color: var(--dark-color);
        }
        
        .delivery-info {
            font-size: 1.2rem;
            color: var(--dark-color);
        }
        
        .btn-addtocart {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .btn-addtocart:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .section-title {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .farmer-name {
            color: var(--accent-color);
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .product-image {
                height: 300px;
            }
            
            .product-info-card, .farmer-card {
                margin-top: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <?php include("../layout/nav.php"); ?>
    
    <div class="container product-container">
        <?php
        if (isset($_GET['id'])) {
            global $con;
            $product_id = $_GET['id'];
            $query = "SELECT * FROM products WHERE product_id = $product_id";
            $run_query = mysqli_query($con, $query);
            
            if ($run_query && mysqli_num_rows($run_query) > 0) {
                $product = mysqli_fetch_array($run_query);
                $farmer_fk = $product['farmer_fk'];
                $product_title = htmlspecialchars($product['product_title']);
                $product_image = htmlspecialchars($product['product_image']);
                $product_price = $product['product_price'];
                $product_stock = $product['product_stock'];
                $product_type = htmlspecialchars($product['product_type']);
                $product_delivery = $product['product_delivery'] == "yes" ? "Delivery Available" : "Pickup Only";
                $product_desc = htmlspecialchars($product['product_desc']);
                
                // Get farmer details
                $farmer_query = "SELECT * FROM farmerregistration WHERE farmer_id = $farmer_fk";
                $farmer_result = mysqli_query($con, $farmer_query);
                
                if ($farmer_result && mysqli_num_rows($farmer_result) > 0) {
                    $farmer = mysqli_fetch_array($farmer_result);
                    $farmer_name = htmlspecialchars($farmer['farmer_name']);
                    $farmer_phone = htmlspecialchars($farmer['farmer_phone']);
                    $farmer_state = htmlspecialchars($farmer['farmer_state']);
                    $farmer_district = htmlspecialchars($farmer['farmer_district']);
                    
                    echo '
                    <div class="text-center mb-5">
                        <h1 class="product-title">'.$product_title.'</h1>
                        <span class="badge bg-success text-white fs-6">'.$product_type.'</span>
                    </div>
                    
                    <div class="row">
                        <!-- Product Image -->
                        <div class="col-lg-5">
                            <img src="../Admin/product_images/'.$product_image.'" class="product-image" alt="'.$product_title.'">
                        </div>
                        
                        <!-- Product Info -->
                        <div class="col-lg-4">
                            <div class="product-info-card">
                                <div class="mb-4">
                                    <h2 class="price-tag">₹'.$product_price.' <small class="text-muted">/kg</small></h2>
                                </div>
                                
                                <div class="mb-4">
                                    <p class="stock-info"><i class="fas fa-box-open me-2"></i> Available: '.$product_stock.' kgs</p>
                                </div>
                                
                                <div class="mb-4">
                                    <p class="delivery-info"><i class="fas fa-truck me-2"></i> '.$product_delivery.'</p>
                                    <p class="delivery-info"><i class="fas fa-map-marker-alt me-2"></i> '.$farmer_district.', '.$farmer_state.'</p>
                                </div>
                                
                                <form action="" method="post">
                                    <input type="hidden" name="product_id" value="'.$product_id.'">
                                    <button type="submit" name="cart" class="btn btn-addtocart w-100">
                                        <i class="fas fa-cart-plus me-2"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Farmer Info -->
                        <div class="col-lg-3">
                            <div class="farmer-card">
                                <h3 class="section-title text-white"><i class="fas fa-user-tie me-2"></i> Farmer Details</h3>
                                
                                <div class="mb-3">
                                    <h5 class="farmer-name">'.$farmer_name.'</h5>
                                </div>
                                
                                <div class="mb-3">
                                    <p><i class="fas fa-phone me-2"></i> '.$farmer_phone.'</p>
                                </div>
                                
                                <div class="mb-3">
                                    <p><i class="fas fa-map-marker-alt me-2"></i> '.$farmer_district.', '.$farmer_state.'</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Description -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <h3 class="section-title"><i class="fas fa-info-circle me-2"></i> Product Description</h3>
                            <p class="lead">'.$product_desc.'</p>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="alert alert-danger text-center">Product not found!</div>';
            }
        } else {
            echo '<div class="alert alert-danger text-center">No product selected!</div>';
        }
        
        // Handle add to cart functionality
        if (isset($_POST['cart'])) {
            if (isset($_POST['product_id'])) {
                $product_id = $_POST['product_id'];
                $qty = 1; // Default quantity
                
                if (isset($_SESSION['phonenumber'])) {
                    $sess_phone_number = $_SESSION['phonenumber'];
                    
                    // Check if product already in cart
                    $check_pro = "SELECT * FROM cart WHERE phonenumber = $sess_phone_number AND product_id = '$product_id'";
                    $run_check = mysqli_query($con, $check_pro);
                    
                    if (mysqli_num_rows($run_check) == 0) {
                        // Get product price
                        $price_query = "SELECT product_price FROM products WHERE product_id = '$product_id'";
                        $run_price = mysqli_query($con, $price_query);
                        
                        if ($run_price && mysqli_num_rows($run_price) > 0) {
                            $price_row = mysqli_fetch_array($run_price);
                            $product_price = $price_row['product_price'];
                            $subtotal = $product_price * $qty;
                            
                            // Insert into cart
                            $insert_pro = "INSERT INTO cart (product_id, phonenumber, qty, subtotal) 
                                         VALUES ('$product_id', '$sess_phone_number', '$qty', '$subtotal')";
                            $run_insert_pro = mysqli_query($con, $insert_pro);
                            
                            if ($run_insert_pro) {
                                echo '<script>window.location.reload(true)</script>';
                            }
                        }
                    }
                } else {
                    echo '<script>alert("Please login first to add items to cart.");</script>';
                }
            }
        }
        ?>
    </div>
    
    <?php include("../layout/footer.php"); ?>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>