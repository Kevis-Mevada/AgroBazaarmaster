<?php
session_start();
include("../Includes/db.php");

if(!isset($_SESSION['admin_id'])) {
    header("Location: AdminLogin.php");
    exit();
}

// Delete product
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    mysqli_query($con, "DELETE FROM products WHERE product_id='$delete_id'");
    header("Location: ManageProducts.php");
    exit();
}

// Search functionality
$search = "";
if(isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT p.*, f.farmer_name 
              FROM products p
              JOIN farmerregistration f ON p.farmer_fk = f.farmer_id
              WHERE p.product_title LIKE '%$search%' OR 
                    p.product_cat LIKE '%$search%' OR 
                    f.farmer_name LIKE '%$search%'";
} else {
    $query = "SELECT p.*, f.farmer_name 
              FROM products p
              JOIN farmerregistration f ON p.farmer_fk = f.farmer_id";
}

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products | AgroBazaar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Same styles as AdminDashboard.php */
        :root {
            --primary: #28a745;
            --secondary: #343a40;
            --light: #f8f9fa;
            --dark: #212529;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            background-color: var(--secondary);
            color: white;
            height: 100vh;
            position: fixed;
            width: 250px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
            padding: 0.75rem 1rem;
            margin-bottom: 0.2rem;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,.1);
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }
        
        .table-responsive {
            margin-top: 20px;
        }
        
        .table th {
            background-color: var(--primary);
            color: white;
        }
        
        .navbar {
            background-color: var(--primary) !important;
        }
        
        .search-box {
            max-width: 400px;
        }
        
        .action-btn {
            margin: 0 3px;
        }
        
        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="p-3 text-center">
            <h4>AgroBazaar Admin</h4>
            <hr>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="AdminDashboard.php">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ManageBuyers.php">
                    <i class="fas fa-users"></i> Manage Buyers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ManageFarmers.php">
                    <i class="fas fa-user-tie"></i> Manage Farmers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="ManageProducts.php">
                    <i class="fas fa-shopping-basket"></i> Manage Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ManageOrders.php">
                    <i class="fas fa-shopping-cart"></i> Manage Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ManagePayments.php">
                    <i class="fas fa-money-bill-wave"></i> Payments
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Includes/logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-dark mb-4">
            <div class="container-fluid">
                <span class="navbar-brand">Manage Products</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form class="mb-4">
                        <div class="input-group search-box">
                            <input type="text" class="form-control" placeholder="Search products..." name="search" value="<?php echo $search; ?>">
                            <button class="btn btn-success" type="submit">Search</button>
                            <a href="ManageProducts.php" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Farmer</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>
                                            <td>'.$row['product_id'].'</td>
                                            <td><img src="'.$row['product_image'].'" class="product-img" alt="Product Image"></td>
                                            <td>'.$row['product_title'].'</td>
                                            <td>'.$row['product_cat'].'</td>
                                            <td>'.$row['product_type'].'</td>
                                            <td>₹'.$row['product_price'].'</td>
                                            <td>'.$row['product_stock'].'</td>
                                            <td>'.$row['farmer_name'].'</td>
                                            <td>
                                                <a href="ViewProduct.php?id='.$row['product_id'].'" class="btn btn-sm btn-primary action-btn" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="EditProduct.php?id='.$row['product_id'].'" class="btn btn-sm btn-warning action-btn" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="ManageProducts.php?delete_id='.$row['product_id'].'" class="btn btn-sm btn-danger action-btn" title="Delete" onclick="return confirm(\'Are you sure you want to delete this product?\')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="9" class="text-center">No products found</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>