<?php
include("../Functions/functions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        :root {
            --primary-color: #292b2c;
            --secondary-color: #FFD700;
            --accent-color: #198754;
            --light-gray: #f8f9fa;
            --dark-gray: #6c757d;
        }
        
        body {
            background-color: var(--light-gray);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-custom {
            background-color: var(--primary-color);
        }
        
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-text,
        .navbar-custom .nav-link {
            color: var(--secondary-color);
        }
        
        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            font-weight: 600;
            border-bottom: none;
            padding: 1rem;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .table tbody tr:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.02);
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .quantity-input {
            width: 80px;
            text-align: center;
            font-weight: bold;
            margin: 0 0.5rem;
        }
        
        .quantity-label {
            font-size: 0.8rem;
            color: var(--dark-gray);
            display: block;
            text-align: center;
            margin-top: 0.25rem;
        }
        
        .quantity-control-btn {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50% !important;
        }
        
        .btn-gold {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 0.5rem 1.5rem;
        }
        
        .btn-gold:hover {
            background-color: #e6c200;
            transform: translateY(-2px);
        }
        
        .grand-total-box {
            background-color: var(--primary-color);
            color: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .empty-cart-img {
            max-width: 300px;
            opacity: 0.8;
        }
        
        .deletion-link {
            color: #dc3545;
            transition: all 0.3s ease;
            font-size: 1.25rem;
        }
        
        .deletion-link:hover {
            color: #a71d2a;
            transform: scale(1.2);
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .price-cell {
            font-weight: 600;
        }
        
        .subtotal-cell {
            font-weight: 700;
            color: var(--accent-color);
        }
        
        @media (max-width: 768px) {
            .table td::before {
                color: var(--primary-color);
                font-weight: 600;
            }
            
            .mobile-stack {
                flex-direction: column;
                gap: 1rem;
            }
            
            .mobile-center {
                justify-content: center !important;
            }
            
            .quantity-control {
                justify-content: flex-end;
            }
        }
    </style>
</head>

<body>
    <?php include("../layout/nav.php"); ?>

    <div class="container py-5 fade-in">
        <?php
        if (isset($_SESSION['phonenumber'])) {
            $temp = totalItems();
            echo "<div class='d-flex justify-content-between align-items-center mb-4'>
                    <h2 class='mb-0 fw-bold'>Your Shopping Cart</h2>
                    <span class='badge bg-primary rounded-pill p-2'>$temp items</span>
                  </div>
                  <hr class='mb-4'>";
        }
        ?>

        <div class="table-container animate__animated animate__fadeIn">
            <table class="table table-hover align-middle">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="width: 5%">#</th>
                        <th scope="col" style="width: 30%">Product</th>
                        <th scope="col" style="width: 15%">Price (₹/kg)</th>
                        <th scope="col" style="width: 25%">Quantity</th>
                        <th scope="col" style="width: 15%">Subtotal</th>
                        <th scope="col" style="width: 10%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $total = 0;
                    global $con;
                    if (isset($_SESSION['phonenumber'])) {
                        $sess_phone_number = $_SESSION['phonenumber'];
                        $sel_price = "SELECT * FROM cart WHERE phonenumber = '$sess_phone_number'";
                        $run_price = mysqli_query($con, $sel_price);

                        $qtycart = array();
                        $i = 0;
                        while ($p_price = mysqli_fetch_array($run_price)) {
                            $product_id = $p_price['product_id'];
                            $_SESSION['qtycart'][$i] = $p_price['qty'];

                            $pro_price = "SELECT * FROM products WHERE product_id='$product_id'";
                            $run_pro_price = mysqli_query($con, $pro_price);
                            while ($pp_price = mysqli_fetch_array($run_pro_price)) {
                                $product_title = $pp_price['product_title'];
                                $product_price = $pp_price['product_price'];
                                $product_image = $pp_price['product_image'];
                                $subtotal = $_SESSION['qtycart'][$i] * $product_price;
                    ?>
                                <tr class="animate__animated animate__fadeIn" style="animation-delay: <?= $i * 0.05 ?>s">
                                    <th scope="row" data-label="#"><?= $i + 1 ?></th>
                                    <td data-label="Product">
                                        <div class="d-flex align-items-center">
                                            <img src="../Admin/product_images/<?= $product_image ?>" 
                                                 class="rounded me-3" 
                                                 alt="<?= $product_title ?>" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                            <span><?= $product_title ?></span>
                                        </div>
                                    </td>
                                    <td data-label="Price" class="price-cell">₹<?= number_format($product_price, 2) ?></td>
                                    
                                    <td data-label="Quantity">
                                        <div class="quantity-control">
                                            <a href="MinusQty.php?id=<?= $product_id ?>" 
                                               class="btn btn-outline-secondary quantity-control-btn"
                                               title="Decrease quantity">
                                                <i class="fas fa-minus"></i>
                                            </a>
                                            
                                            <div class="text-center mx-2">
                                                <input type="number" 
                                                       class="form-control quantity-input" 
                                                       value="<?= number_format($_SESSION['qtycart'][$i], 1) ?>" 
                                                       min="0.1" 
                                                       step="0.1"
                                                       onchange="updateQuantity(this.value, <?= $product_id ?>)">
                                                <span class="quantity-label">kilograms</span>
                                            </div>
                                            
                                            <a href="AddQty.php?id=<?= $product_id ?>" 
                                               class="btn btn-outline-secondary quantity-control-btn"
                                               title="Increase quantity">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </td>
                                    
                                    <?php $subtotal = $_SESSION['qtycart'][$i] * $product_price; ?>
                                    <?php
                                    $subquery = "UPDATE cart SET subtotal = $subtotal WHERE product_id = $product_id";
                                    $run = mysqli_query($con, $subquery);
                                    ?>
                                    
                                    <td data-label="Subtotal" class="subtotal-cell">₹<?= number_format($subtotal, 2) ?></td>
                                    <?php $total = $total + $subtotal ?>
                                    <td data-label="Action">
                                        <a href="DeleteProductCart.php?id=<?= $product_id ?>" 
                                           class="deletion-link"
                                           title="Remove item">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                    <?php
                            }
                            $i++;
                        }
                    } else {
                        echo "<tr>
                                <td colspan='6' class='text-center py-5'>
                                    <img src='https://cdn-icons-png.flaticon.com/512/2038/2038854.png' class='empty-cart-img mb-4 animate__animated animate__pulse'>
                                    <h3 class='mb-3'>Your cart is empty</h3>
                                    <p class='text-muted mb-4'>Please login to view your cart items</p>
                                    <a href='../auth/BuyerLogin.php' class='btn btn-primary btn-lg'>
                                        <i class='fas fa-sign-in-alt me-2'></i>Login Now
                                    </a>
                                </td>
                              </tr>";
                    } 
                    ?>
                </tbody>
            </table>
        </div>

        <?php if (isset($_SESSION['phonenumber']) && $total > 0) : ?>
            <div class="row mt-4 mobile-stack">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="d-flex gap-3 mobile-center">
                        <a href="emptyCart.php" class="btn btn-danger btn-lg px-4">
                            <i class="fas fa-trash-alt me-2"></i>Empty Cart
                        </a>
                        <a href="bhome.php" class="btn btn-outline-primary btn-lg px-4">
                            <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="grand-total-box text-end animate__animated animate__pulse">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Subtotal:</h4>
                            <h4 class="mb-0">₹<?= number_format($total, 2) ?></h4>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Delivery:</h5>
                            <h5 class="mb-0">₹0.00</h5>
                        </div>
                        <hr class="my-2" style="background-color: rgba(255,255,255,0.2)">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-0">Total:</h3>
                            <h3 class="mb-0 fw-bold">₹<?= number_format($total, 2) ?></h3>
                        </div>
                        <?php
                        $sel_price = "SELECT * FROM cart WHERE phonenumber = '$sess_phone_number'";
                        $run_price = mysqli_query($con, $sel_price);
                        $count = mysqli_num_rows($run_price);
                        
                        if ($count > 0) {
                            echo "<a href='Checkout.php' class='btn btn-success btn-lg w-100 py-2'>
                                    <i class='fas fa-credit-card me-2'></i>Proceed to Checkout
                                  </a>";
                        } else {
                            echo "<a href='Includes/alert.php' class='btn btn-success btn-lg w-100 py-2'>
                                    <i class='fas fa-credit-card me-2'></i>Proceed to Checkout
                                  </a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php $_SESSION['grandtotal'] = $total; ?>
        <?php endif; ?>
    </div>

    <?php include("../layout/footer.php"); ?>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Enhanced quantity update function
        function updateQuantity(qty, productId) {
            // Validate input
            qty = parseFloat(qty);
            if (isNaN(qty)) {
                alert('Please enter a valid number');
                return;
            }
            
            if (qty <= 0) {
                alert('Quantity must be greater than 0 kg');
                return;
            }

            // Round to 1 decimal place
            qty = Math.round(qty * 10) / 10;
            
            // Update the input field with formatted value
            const inputField = document.querySelector(`input[onchange*="${productId}"]`);
            inputField.value = qty.toFixed(1);
            
            // Show loading state
            inputField.disabled = true;
            
            // Send to server
            fetch(`UpdateQty.php?id=${productId}&qty=${qty}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error updating quantity: ' + (data.message || 'Unknown error'));
                        inputField.value = data.currentQty || qty.toFixed(1);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating quantity');
                })
                .finally(() => {
                    inputField.disabled = false;
                });
        }
        
        // Add animation to table rows on page load
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.05}s`;
            });
        });
    </script>
</body>
</html>