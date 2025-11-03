<?php
session_start();
include("../Includes/db.php");

// Check if user is logged in
if (!isset($_SESSION['phonenumber'])) {
    header("Location: ../auth/FarmerLogin.php");
    exit();
}

$sess_phone_number = $_SESSION['phonenumber'];

// Handle delete action if requested
if (isset($_GET['delete_id'])) {
    $product_id = $_GET['delete_id'];
    
    // Verify the product belongs to the logged-in farmer
    $verify_stmt = $con->prepare("SELECT product_id FROM products 
                                WHERE product_id = ? 
                                AND farmer_fk = (
                                    SELECT farmer_id FROM farmerregistration 
                                    WHERE farmer_phone = ?
                                )");
    $verify_stmt->bind_param("is", $product_id, $sess_phone_number);
    $verify_stmt->execute();
    $verify_result = $verify_stmt->get_result();
    
    if ($verify_result->num_rows > 0) {
        // First get the image path to delete it from server
        $img_stmt = $con->prepare("SELECT product_image FROM products WHERE product_id = ?");
        $img_stmt->bind_param("i", $product_id);
        $img_stmt->execute();
        $img_result = $img_stmt->get_result();
        $img_row = $img_result->fetch_assoc();
        $image_path = "../Admin/product_images/".$img_row['product_image'];
        
        // Delete the product
        $delete_stmt = $con->prepare("DELETE FROM products WHERE product_id = ?");
        $delete_stmt->bind_param("i", $product_id);
        
        if ($delete_stmt->execute()) {
            // Delete the image file if it exists
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            $success_msg = "Product deleted successfully!";
        } else {
            $error_msg = "Error deleting product: " . $con->error;
        }
    } else {
        $error_msg = "You don't have permission to delete this product or it doesn't exist.";
    }
}

// Function to get farmer's products with all details
function getFarmerProducts($con, $phone) {
    // Using prepared statement to prevent SQL injection
    // $stmt = $con->prepare("SELECT * FROM products 
    //                       WHERE farmer_fk = (
    //                           SELECT farmer_id FROM farmerregistration 
    //                           WHERE farmer_phone = ?
    //                       ) ORDER BY product_id DESC");
    // $stmt->bind_param("s", $phone);
    // $stmt->execute();
    // $result = $stmt->get_result();

    $query = "select * from products where farmer_fk in (select farmer_id from farmerregistration where farmer_phone=$phone) ";
    $result = mysqli_query($con, $query);
    
    if (!$result) {
        echo '<div class="alert alert-danger">Error fetching products: ' . $con->error . '</div>';
        return;
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="productbox animate">';
            echo '<img src="../Admin/product_images/'.htmlspecialchars($row['product_image']).'" 
                 alt="'.htmlspecialchars($row['product_title']).'"
                 onerror="this.src=\'../Admin/product_images/default_product.jpg\'">';
            
            echo '<div class="product-details">';
            echo '<h5>'.htmlspecialchars($row['product_title']).'</h5>';
            
            // Product details
            echo '<div class="product-info">';
            echo '<p><strong>Category:</strong> '.getCategoryName($con, $row['product_cat']).'</p>';
            echo '<p><strong>Type:</strong> '.htmlspecialchars($row['product_type']).'</p>';
            echo '<p><strong>Price:</strong> ₹'.htmlspecialchars($row['product_price']).'/kg</p>';
            echo '<p><strong>Stock:</strong> '.htmlspecialchars($row['product_stock']).' kg</p>';
            echo '<p><strong>Expiry:</strong> '.htmlspecialchars($row['product_expiry']).'</p>';
            echo '<p><strong>Delivery:</strong> '.($row['product_delivery'] == 'yes' ? 'Available' : 'Not Available').'</p>';
            echo '</div>';
            
            // Product description with read more functionality
            echo '<div class="product-description">';
            echo '<p><strong>Description:</strong> '.nl2br(htmlspecialchars(truncateDescription($row['product_desc'], 100))).'</p>';
            echo '</div>';
            
            // Keywords
            echo '<div class="product-keywords">';
            echo '<small><strong>Keywords:</strong> '.htmlspecialchars($row['product_keywords']).'</small>';
            echo '</div>';
            
            // Action buttons
            echo '<div class="product-actions mt-3">';
            echo '<a href="EditProduct.php?id='.$row['product_id'].'" class="btn btn-sm btn-primary">Edit</a>';
            echo '<a href="?delete_id='.$row['product_id'].'" class="btn btn-sm btn-danger ms-2" 
                 onclick="return confirmDelete()">Delete</a>';
            echo '</div>';
            
            echo '</div>'; // Close product-details
            echo '</div>'; // Close productbox
        }
    } else {
        echo '<div class="alert alert-info animate">No products found. Add your first product!</div>';
    }
}

// Helper function to get category name
function getCategoryName($con, $cat_id) {
    $stmt = $con->prepare("SELECT cat_title FROM categories WHERE cat_id = ?");
    $stmt->bind_param("i", $cat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return htmlspecialchars($row['cat_title']);
    }
    return "Uncategorized";
}

// Helper function to truncate long descriptions
function truncateDescription($text, $length) {
    if (strlen($text) > $length) {
        $text = substr($text, 0, $length) . '...';
    }
    return $text;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer - My Products</title>
    
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
        
        .content_item {
            text-align: center;
            margin: 2rem 0;
        }
        
        .content_item label {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        /* Alert messages */
        .alert {
            margin: 1rem;
            margin-top: 35px;
            border-radius: 8px;
        }
        
        /* Product Grid */
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 0 2rem;
            margin: 2rem 0;
        }
        
        .productbox {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .productbox:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }
        
        .productbox img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
            transition: transform 0.3s ease;
        }
        
        .productbox:hover img {
            transform: scale(1.03);
        }
        
        .product-details {
            padding: 1.5rem;
        }
        
        .productbox h5 {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .product-info p {
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .product-description {
            margin: 1rem 0;
            font-size: 0.9rem;
        }
        
        .product-keywords {
            color: #6c757d;
            font-size: 0.8rem;
        }
        
        .product-actions {
            display: flex;
            justify-content: center;
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate {
            animation: fadeIn 0.6s ease forwards;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .products {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                padding: 0 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .products {
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
    <div class="container">
        <!-- Display success/error messages -->
        <?php if (isset($success_msg)): ?>
            <div class="alert alert-success"><?php echo $success_msg; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_msg)): ?>
            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
        <?php endif; ?>
        
        <div class="content_item animate">
            <label><b>My Products</b></label>
            <a href="InsertProduct.php" class="btn btn-warning btn-lg p-3 m-3 font-weight-bold">
                Add New Product <i class="fas fa-plus-square p-2 fa-1x"></i>
            </a>
        </div>

        <main>
            <div class="products">
                <?php getFarmerProducts($con, $sess_phone_number); ?>
            </div>
        </main>
    </div>
    
    <?php include("../layout/footer.php"); ?>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('.animate');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });
            
            animateElements.forEach(element => {
                element.style.opacity = 0;
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(element);
            });
        });
        
        // Delete confirmation
        function confirmDelete() {
            return confirm("Are you sure you want to delete this product?\nThis action cannot be undone!");
        }
    </script>
</body>
</html>