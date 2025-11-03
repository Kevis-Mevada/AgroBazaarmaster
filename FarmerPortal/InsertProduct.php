<?php
// MUST BE THE VERY FIRST LINE - NO WHITESPACE BEFORE THIS
session_start();
include("../Includes/db.php");
$sessphonenumber = $_SESSION['phonenumber'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer - Insert Product</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #28a745;
            --secondary-color: #ffc107;
            --dark-color: #343a40;
            --light-bg: #f8f9fa;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: #495057;
            padding-top: 70px; /* For fixed navbar */
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem;
            text-align: center;
            border-bottom: none;
        }
        
        .card-header h4 {
            font-weight: 700;
            margin: 0;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        /* Two-column layout */
        .form-row-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate {
            animation: fadeIn 0.6s ease forwards;
        }
        
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        
        /* Radio button styling */
        .radio-group {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .radio-group label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }
        
        input[type="radio"] {
            accent-color: var(--primary-color);
            width: 18px;
            height: 18px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .form-row-group {
                grid-template-columns: 1fr;
            }
        }
        .navigation {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
    </style>
</head>

<body>
    <div class="navigation">
        <?php include("../layout/farmernav.php"); ?>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center animate">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-leaf me-2"></i>Insert Your New Product</h4>
                    </div>
                    <div class="card-body">
                        <form name="my-form" action="InsertProduct.php" method="post" enctype="multipart/form-data">
                            <div class="form-row-group">
                                <!-- Column 1 -->
                                <div class="form-group delay-1">
                                    <label for="product_title" class="form-label">Product Title:</label>
                                    <input type="text" id="product_title" class="form-control" name="product_title" placeholder="Enter Product title" required>
                                </div>
                                
                                <div class="form-group delay-2">
                                    <label for="product_stock" class="form-label">Product Stock (In kg):</label>
                                    <input type="text" id="product_stock" class="form-control" name="product_stock" placeholder="Enter Product Stock" required>
                                </div>
                                
                                <div class="form-group delay-3">
                                    <label for="product_cat" class="form-label">Product Categories:</label>
                                    <select id="product_cat" class="form-select" name="product_cat" required>
                                        <option value="">Select a Category</option>
                                        <?php
                                        $get_cats = "select * from categories";
                                        $run_cats = mysqli_query($con, $get_cats);
                                        while ($row_cats = mysqli_fetch_array($run_cats)) {
                                            $cat_id = $row_cats['cat_id'];
                                            $cat_title = $row_cats['cat_title'];
                                            echo "<option value='$cat_id'>$cat_title</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="form-group delay-1">
                                    <label for="product_type" class="form-label">Product Type:</label>
                                    <input type="text" id="product_type" class="form-control" name="product_type" placeholder="Example: potato" required>
                                </div>
                                
                                <!-- Column 2 -->
                                <div class="form-group delay-2">
                                    <label for="product_expiry" class="form-label">Product Expiry:</label>
                                    <input type="date" id="product_expiry" class="form-control" name="product_expiry" required>
                                </div>
                                
                                <div class="form-group delay-3">
                                    <label for="product_image" class="form-label">Product Image:</label>
                                    <input type="file" id="product_image" class="form-control" name="product_image" accept="image/*">
                                </div>
                                
                                <div class="form-group delay-1">
                                    <label for="product_price" class="form-label">Product MRP (Per kg):</label>
                                    <input type="text" id="product_price" class="form-control" name="product_price" placeholder="Enter Product price" required>
                                </div>

                                <div class="form-group delay-2">
                                    <label for="minimum_order" class="form-label">Minimum Order (In kg):</label>
                                    <input type="text" id="minimum_order" class="form-control" name="minimum_order" placeholder="Enter Minimum Order" required>
                                </div>
                                <div class="form-group delay-2">
                                    <label for="product_keywords" class="form-label">Product Keywords:</label>
                                    <input type="text" id="product_keywords" class="form-control" name="product_keywords" placeholder="Example: best potatoes" required>
                                </div>
                                <div class="form-group delay-2">
                                    <label for="product_delivery" class="form-label">Delivery Available:</label>
                                    <div class="radio-group">
                                        <label>
                                            <input type="radio" name="product_delivery" value="yes" checked> Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="product_delivery" value="no"> No
                                        </label>
                                    </div>
                                </div>
                                
                            </div>

                            
                            
                            <div class="form-group mt-4 delay-3">
                                <label for="product_desc" class="form-label">Product Description:</label>
                                <textarea id="product_desc" class="form-control" name="product_desc" rows="4" required></textarea>
                            </div>
                            
                            <div class="form-group text-center mt-5 delay-2">
                                <button type="submit" class="btn btn-primary px-5 py-2" name="insert_pro">
                                    <i class="fas fa-plus-circle me-2"></i> INSERT PRODUCT
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("../layout/footer.php"); ?>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Add animation when elements come into view
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('.animate, .delay-1, .delay-2, .delay-3');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });
            
            animateElements.forEach(element => {
                observer.observe(element);
            });
            
            // Set minimum date to today for expiry date
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('product_expiry').min = today;
        });
    </script>
</body>
</html>

<?php
if (isset($_POST['insert_pro'])) {
    // getting the text data from fields
    $product_title = $_POST['product_title'];
    $product_cat = $_POST['product_cat'];
    $product_type = $_POST['product_type'];
    $product_stock = $_POST['product_stock'];
    $product_price = $_POST['product_price'];
    $product_expiry = $_POST['product_expiry'];
    $product_desc = $_POST['product_desc'];
    $product_keywords = $_POST['product_keywords'];
    $product_delivery = $_POST['product_delivery'];
    $minimum_order = $_POST['minimum_order'];

    // getting image
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp = $_FILES['product_image']['tmp_name'];

    if (isset($_SESSION['phonenumber'])) {
        move_uploaded_file($product_image_tmp, "../Admin/product_images/$product_image");

        $phone = $_SESSION['phonenumber'];
        $getting_id = "select * from farmerregistration where farmer_phone = $sessphonenumber";
        $run = mysqli_query($con, $getting_id);
        $row = mysqli_fetch_array($run);
        $id = $row['farmer_id'];
        
        $insert_product = "insert into products (farmer_fk, product_title, product_cat, 
                          product_type, product_expiry, product_image, min_order, product_stock, product_price,
                          product_desc, product_keywords, product_delivery) 
                          values ('$id', '$product_title', '$product_cat', '$product_type', 
                                  '$product_expiry', '$product_image', '$minimum_order','$product_stock',
                                  '$product_price', '$product_desc', 
                                  '$product_keywords', '$product_delivery')";

        $insert_query = mysqli_query($con, $insert_product);
        
        if ($insert_query) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Product has been added successfully',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    window.location.href = 'farmerHomepage.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Error uploading data. Please check your connection.',
                    confirmButtonColor: '#dc3545'
                });
            </script>";
        }
    }
}
?>