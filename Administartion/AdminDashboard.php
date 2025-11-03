<?php
session_start();
include("../Includes/db.php");

if(!isset($_SESSION['admin_id'])) {
    header("Location: AdminLogin.php");
    exit();
}

// Get counts for dashboard
$buyers_count = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM buyerregistration"))['count'];
$farmers_count = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM farmerregistration"))['count'];
$products_count = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM products"))['count'];
$orders_count = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM orders"))['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | AgroBazaar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
        
        .card-counter {
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
            margin: 5px;
            padding: 20px 10px;
            background-color: #fff;
            height: 100%;
            border-radius: 5px;
            transition: .3s linear all;
        }
        
        .card-counter:hover {
            box-shadow: 4px 4px 20px rgba(0,0,0,0.1);
            transition: .3s linear all;
        }
        
        .card-counter.primary {
            background-color: #007bff;
            color: #FFF;
        }
        
        .card-counter.success {
            background-color: #28a745;
            color: #FFF;
        }
        
        .card-counter.warning {
            background-color: #fd7e14;
            color: #FFF;
        }
        
        .card-counter.danger {
            background-color: #dc3545;
            color: #FFF;
        }
        
        .card-counter i {
            font-size: 5em;
            opacity: 0.3;
        }
        
        .card-counter .count-numbers {
            position: absolute;
            right: 35px;
            top: 20px;
            font-size: 32px;
            display: block;
        }
        
        .card-counter .count-name {
            position: absolute;
            right: 35px;
            top: 65px;
            font-style: italic;
            text-transform: capitalize;
            opacity: 0.8;
            display: block;
            font-size: 18px;
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
                <a class="nav-link active" href="AdminDashboard.php">
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
                <a class="nav-link" href="ManageProducts.php">
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
                <span class="navbar-brand">Welcome, <?php echo $_SESSION['admin_name']; ?></span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <div class="container-fluid">
            <h2 class="mb-4">Dashboard Overview</h2>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="card-counter success">
                        <i class="fas fa-users"></i>
                        <span class="count-numbers"><?php echo $buyers_count; ?></span>
                        <span class="count-name">Buyers</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-counter primary">
                        <i class="fas fa-user-tie"></i>
                        <span class="count-numbers"><?php echo $farmers_count; ?></span>
                        <span class="count-name">Farmers</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-counter warning">
                        <i class="fas fa-shopping-basket"></i>
                        <span class="count-numbers"><?php echo $products_count; ?></span>
                        <span class="count-name">Products</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-counter danger">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="count-numbers"><?php echo $orders_count; ?></span>
                        <span class="count-name">Orders</span>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">Recent Orders</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            $recent_orders = mysqli_query($con, "SELECT * FROM orders ORDER BY order_id DESC LIMIT 5");
                            if(mysqli_num_rows($recent_orders) > 0) {
                                echo '<ul class="list-group">';
                                while($order = mysqli_fetch_assoc($recent_orders)) {
                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                                        Order #'.$order['order_id'].'
                                        <span class="badge bg-primary rounded-pill">'.$order['total'].'</span>
                                    </li>';
                                }
                                echo '</ul>';
                            } else {
                                echo '<p>No recent orders found</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Recent Products</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            $recent_products = mysqli_query($con, "SELECT * FROM products ORDER BY product_id DESC LIMIT 5");
                            if(mysqli_num_rows($recent_products) > 0) {
                                echo '<ul class="list-group">';
                                while($product = mysqli_fetch_assoc($recent_products)) {
                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                                        '.$product['product_title'].'
                                        <span class="badge bg-success rounded-pill">₹'.$product['product_price'].'</span>
                                    </li>';
                                }
                                echo '</ul>';
                            } else {
                                echo '<p>No products found</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>