<?php
session_start();
include("../Includes/db.php");

if(!isset($_SESSION['admin_id'])) {
    header("Location: AdminLogin.php");
    exit();
}

// Update order status
if(isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    mysqli_query($con, "UPDATE orders SET delivery='$status' WHERE order_id='$order_id'");
    header("Location: ManageOrders.php");
    exit();
}

// Search functionality
$search = "";
if(isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT o.*, p.product_title, b.buyer_name 
              FROM orders o
              JOIN products p ON o.product_id = p.product_id
              JOIN buyerregistration b ON o.buyer_phonenumber = b.buyer_phone
              WHERE o.order_id LIKE '%$search%' OR 
                    p.product_title LIKE '%$search%' OR 
                    b.buyer_name LIKE '%$search%'";
} else {
    $query = "SELECT o.*, p.product_title, b.buyer_name 
              FROM orders o
              JOIN products p ON o.product_id = p.product_id
              JOIN buyerregistration b ON o.buyer_phonenumber = b.buyer_phone";
}

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders | AgroBazaar</title>
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
        
        .badge-processing {
            background-color: #ffc107;
            color: #000;
        }
        
        .badge-shipped {
            background-color: #17a2b8;
            color: #fff;
        }
        
        .badge-delivered {
            background-color: #28a745;
            color: #fff;
        }
        
        .badge-cancelled {
            background-color: #dc3545;
            color: #fff;
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
                <a class="nav-link" href="ManageProducts.php">
                    <i class="fas fa-shopping-basket"></i> Manage Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="ManageOrders.php">
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
                <span class="navbar-brand">Manage Orders</span>
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
                            <input type="text" class="form-control" placeholder="Search orders..." name="search" value="<?php echo $search; ?>">
                            <button class="btn btn-success" type="submit">Search</button>
                            <a href="ManageOrders.php" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product</th>
                                    <th>Buyer</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $status_class = '';
                                        switch($row['delivery']) {
                                            case 'Processing': $status_class = 'badge-processing'; break;
                                            case 'Shipped': $status_class = 'badge-shipped'; break;
                                            case 'Delivered': $status_class = 'badge-delivered'; break;
                                            case 'Cancelled': $status_class = 'badge-cancelled'; break;
                                            default: $status_class = 'badge-secondary';
                                        }
                                        
                                        echo '<tr>
                                            <td>#'.$row['order_id'].'</td>
                                            <td>'.$row['product_title'].'</td>
                                            <td>'.$row['buyer_name'].'</td>
                                            <td>'.$row['qty'].'</td>
                                            <td>₹'.$row['total'].'</td>
                                            <td>'.$row['payment'].'</td>
                                            <td>
                                                <span class="badge '.$status_class.'">'.$row['delivery'].'</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary action-btn" title="View" data-bs-toggle="modal" data-bs-target="#orderModal'.$row['order_id'].'">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <a href="ManageOrders.php?delete_id='.$row['order_id'].'" class="btn btn-sm btn-danger action-btn" title="Delete" onclick="return confirm(\'Are you sure you want to delete this order?\')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                
                                                <!-- Order Details Modal -->
                                                <div class="modal fade" id="orderModal'.$row['order_id'].'" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Order #'.$row['order_id'].' Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Product:</strong> '.$row['product_title'].'</p>
                                                                <p><strong>Buyer:</strong> '.$row['buyer_name'].'</p>
                                                                <p><strong>Quantity:</strong> '.$row['qty'].'</p>
                                                                <p><strong>Total:</strong> ₹'.$row['total'].'</p>
                                                                <p><strong>Payment Method:</strong> '.$row['payment'].'</p>
                                                                <p><strong>Delivery Address:</strong> '.$row['address'].'</p>
                                                                <hr>
                                                                <form method="POST">
                                                                    <input type="hidden" name="order_id" value="'.$row['order_id'].'">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Update Status</label>
                                                                        <select class="form-select" name="status">
                                                                            <option value="Processing" '.($row['delivery'] == 'Processing' ? 'selected' : '').'>Processing</option>
                                                                            <option value="Shipped" '.($row['delivery'] == 'Shipped' ? 'selected' : '').'>Shipped</option>
                                                                            <option value="Delivered" '.($row['delivery'] == 'Delivered' ? 'selected' : '').'>Delivered</option>
                                                                            <option value="Cancelled" '.($row['delivery'] == 'Cancelled' ? 'selected' : '').'>Cancelled</option>
                                                                        </select>
                                                                    </div>
                                                                    <button type="submit" name="update_status" class="btn btn-success">Update Status</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="8" class="text-center">No orders found</td></tr>';
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