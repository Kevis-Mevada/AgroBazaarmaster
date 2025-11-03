<?php
include("../Includes/db.php");
session_start();

// Check if user is logged in
if (!isset($_SESSION['phonenumber'])) {
    header("Location: ../auth/FarmerLogin.php");
    exit();
}

$sessphonenumber = $_SESSION['phonenumber'];

// Handle form submission
if (isset($_POST['update_pro'])) {
    // Get form data
    $product_id = $_POST['product_id'];
    $product_title = mysqli_real_escape_string($con, $_POST['product_title']);
    $product_cat = mysqli_real_escape_string($con, $_POST['product_cat']);
    $product_type = mysqli_real_escape_string($con, $_POST['product_type']);
    $product_stock = mysqli_real_escape_string($con, $_POST['product_stock']);
    $product_price = mysqli_real_escape_string($con, $_POST['product_price']);
    $product_expiry = mysqli_real_escape_string($con, $_POST['product_expiry']);
    $product_desc = mysqli_real_escape_string($con, $_POST['product_desc']);
    $product_keywords = mysqli_real_escape_string($con, $_POST['product_keywords']);
    $product_delivery = mysqli_real_escape_string($con, $_POST['product_delivery']);

    // Handle image upload
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp = $_FILES['product_image']['tmp_name'];
    
    if (!empty($product_image)) {
        // Move uploaded image
        move_uploaded_file($product_image_tmp, "../Admin/product_images/$product_image");
        
        // Update with new image
        $update_query = "UPDATE products SET 
                        product_title = '$product_title',
                        product_cat = '$product_cat',
                        product_type = '$product_type',
                        product_stock = '$product_stock',
                        product_price = '$product_price',
                        product_expiry = '$product_expiry',
                        product_desc = '$product_desc',
                        product_keywords = '$product_keywords',
                        product_delivery = '$product_delivery',
                        product_image = '$product_image'
                        WHERE product_id = '$product_id'";
    } else {
        // Update without changing image
        $update_query = "UPDATE products SET 
                        product_title = '$product_title',
                        product_cat = '$product_cat',
                        product_type = '$product_type',
                        product_stock = '$product_stock',
                        product_price = '$product_price',
                        product_expiry = '$product_expiry',
                        product_desc = '$product_desc',
                        product_keywords = '$product_keywords',
                        product_delivery = '$product_delivery'
                        WHERE product_id = '$product_id'";
    }

    // Execute query
    $run_query = mysqli_query($con, $update_query);
    
    if ($run_query) {
        echo "<script>alert('Product has been updated successfully!')</script>";
        echo "<script>window.open('MyProducts.php','_self')</script>";
    } else {
        echo "<script>alert('Error updating product: " . mysqli_error($con) . "')</script>";
    }
}

// Get product data if ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    // Verify the product belongs to the logged-in farmer
    $verify_query = "SELECT * FROM products 
                    WHERE product_id = '$product_id' 
                    AND farmer_fk = (
                        SELECT farmer_id FROM farmerregistration 
                        WHERE farmer_phone = '$sessphonenumber'
                    )";
    $run_verify = mysqli_query($con, $verify_query);
    
    if (mysqli_num_rows($run_verify) > 0) {
        $product_data = mysqli_fetch_array($run_verify);
    } else {
        echo "<script>alert('You are not authorized to edit this product!')</script>";
        echo "<script>window.open('MyProducts.php','_self')</script>";
        exit();
    }
} else {
    echo "<script>alert('No product selected!')</script>";
    echo "<script>window.open('MyProducts.php','_self')</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer - Edit Product</title>
    
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
            padding-top: 70px;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-top: 2rem;
            margin-bottom: 2rem;
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
        
        /* Current image preview */
        .current-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            margin-top: 10px;
            border: 1px solid #ddd;
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
            left: 0;
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
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-edit me-2"></i>Edit Your Product</h4>
                    </div>
                    <div class="card-body">
                        <form name="edit-form" action="EditProduct.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="product_id" value="<?php echo $product_data['product_id']; ?>">
                            
                            <div class="form-row-group">
                                <!-- Column 1 -->
                                <div class="form-group">
                                    <label for="product_title" class="form-label">Product Title:</label>
                                    <input type="text" id="product_title" class="form-control" name="product_title" 
                                           value="<?php echo htmlspecialchars($product_data['product_title']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="product_stock" class="form-label">Product Stock (In kg):</label>
                                    <input type="text" id="product_stock" class="form-control" name="product_stock" 
                                           value="<?php echo htmlspecialchars($product_data['product_stock']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="product_cat" class="form-label">Product Categories:</label>
                                    <select id="product_cat" class="form-select" name="product_cat" required>
                                        <option value="">Select a Category</option>
                                        <?php
                                        $get_cats = "SELECT * FROM categories";
                                        $run_cats = mysqli_query($con, $get_cats);
                                        while ($row_cats = mysqli_fetch_array($run_cats)) {
                                            $cat_id = $row_cats['cat_id'];
                                            $cat_title = $row_cats['cat_title'];
                                            $selected = ($cat_id == $product_data['product_cat']) ? 'selected' : '';
                                            echo "<option value='$cat_id' $selected>$cat_title</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="product_type" class="form-label">Product Type:</label>
                                    <input type="text" id="product_type" class="form-control" name="product_type" 
                                           value="<?php echo htmlspecialchars($product_data['product_type']); ?>" required>
                                </div>
                                
                                <!-- Column 2 -->
                                <div class="form-group">
                                    <label for="product_expiry" class="form-label">Product Expiry:</label>
                                    <input type="date" id="product_expiry" class="form-control" name="product_expiry" 
                                           value="<?php echo htmlspecialchars($product_data['product_expiry']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="product_image" class="form-label">Product Image:</label>
                                    <input type="file" id="product_image" class="form-control" name="product_image" accept="image/*">
                                    <?php if (!empty($product_data['product_image'])): ?>
                                        <p class="mt-2">Current Image:</p>
                                        <img src="../Admin/product_images/<?php echo htmlspecialchars($product_data['product_image']); ?>" 
                                             alt="Current Product Image" class="current-image">
                                    <?php endif; ?>
                                </div>
                                
                                <div class="form-group">
                                    <label for="product_price" class="form-label">Product MRP (Per kg):</label>
                                    <input type="text" id="product_price" class="form-control" name="product_price" 
                                           value="<?php echo htmlspecialchars($product_data['product_price']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="product_delivery" class="form-label">Delivery Available:</label>
                                    <div class="radio-group">
                                        <label>
                                            <input type="radio" name="product_delivery" value="yes" 
                                                <?php echo ($product_data['product_delivery'] == 'yes') ? 'checked' : ''; ?>> Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="product_delivery" value="no" 
                                                <?php echo ($product_data['product_delivery'] == 'no') ? 'checked' : ''; ?>> No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mt-4">
                                <label for="product_desc" class="form-label">Product Description:</label>
                                <textarea id="product_desc" class="form-control" name="product_desc" rows="4" required><?php 
                                    echo htmlspecialchars($product_data['product_desc']); 
                                ?></textarea>
                            </div>
                            
                            <div class="form-group mt-4">
                                <label for="product_keywords" class="form-label">Product Keywords:</label>
                                <input type="text" id="product_keywords" class="form-control" name="product_keywords" 
                                       value="<?php echo htmlspecialchars($product_data['product_keywords']); ?>" required>
                            </div>
                            
                            <div class="form-group text-center mt-5">
                                <button type="submit" class="btn btn-primary px-5 py-2" name="update_pro">
                                    <i class="fas fa-save me-2"></i> UPDATE PRODUCT
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
    
    <script>
        // Set minimum date to today for expiry date
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('product_expiry').min = today;
        });
    </script>
</body>
</html>