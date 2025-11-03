<?php
session_start();
include("../Includes/db.php");

if(!isset($_SESSION['admin_id'])) {
    header("Location: AdminLogin.php");
    exit();
}

if(!isset($_GET['id'])) {
    header("Location: ManageBuyers.php");
    exit();
}

$buyer_id = $_GET['id'];
$query = "SELECT * FROM buyerregistration WHERE buyer_id='$buyer_id'";
$result = mysqli_query($con, $query);
$buyer = mysqli_fetch_assoc($result);

if(!$buyer) {
    header("Location: ManageBuyers.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Buyer | AgroBazaar</title>
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
        
        .navbar {
            background-color: var(--primary) !important;
        }
        
        .buyer-card {
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        
        .buyer-header {
            background-color: var(--primary);
            color: white;
            border-radius: 10px 10px 0 0;
        }
        
        .detail-label {
            font-weight: 600;
            color: var(--secondary);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <!-- Same sidebar as AdminDashboard.php -->
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
                <span class="navbar-brand">Buyer Details</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="card buyer-card mb-4">
                <div class="card-header buyer-header">
                    <h5 class="card-title mb-0">Buyer Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="detail-label">Buyer ID</p>
                            <p><?php echo $buyer['buyer_id']; ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="detail-label">Name</p>
                            <p><?php echo $buyer['buyer_name']; ?></p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="detail-label">Phone Number</p>
                            <p><?php echo $buyer['buyer_phone']; ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="detail-label">Email</p>
                            <p><?php echo $buyer['buyer_mail']; ?></p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="detail-label">Company</p>
                            <p><?php echo $buyer['buyer_comp']; ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="detail-label">License Number</p>
                            <p><?php echo $buyer['buyer_license']; ?></p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="detail-label">Bank Account</p>
                            <p><?php echo $buyer['buyer_bank']; ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="detail-label">PAN Number</p>
                            <p><?php echo $buyer['buyer_pan']; ?></p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <p class="detail-label">Address</p>
                            <p><?php echo $buyer['buyer_addr']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="ManageBuyers.php" class="btn btn-secondary">Back to List</a>
                    <a href="EditBuyer.php?id=<?php echo $buyer['buyer_id']; ?>" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>