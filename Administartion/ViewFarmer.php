<?php
session_start();
include("../Includes/db.php");

if(!isset($_SESSION['admin_id'])) {
    header("Location: AdminLogin.php");
    exit();
}

if(!isset($_GET['id'])) {
    header("Location: ManageFarmers.php");
    exit();
}

$farmer_id = $_GET['id'];
$farmer = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM farmerregistration WHERE farmer_id='$farmer_id'"));

if(!$farmer) {
    header("Location: ManageFarmers.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Farmer | AgroBazaar</title>
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
        
        .detail-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .detail-card-header {
            background-color: var(--primary);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
        }
        
        .detail-card-body {
            padding: 20px;
        }
        
        .detail-label {
            font-weight: 600;
            color: var(--secondary);
        }
        
        .action-btn {
            margin: 0 3px;
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
                <span class="navbar-brand">Farmer Details</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="card detail-card">
                <div class="card-header detail-card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Farmer Information</h5>
                    <div>
                        <a href="EditFarmer.php?id=<?php echo $farmer['farmer_id']; ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="ManageFarmers.php?delete_id=<?php echo $farmer['farmer_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this farmer?')">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </div>
                </div>
                <div class="card-body detail-card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <span class="detail-label">Farmer ID:</span>
                                <p><?php echo $farmer['farmer_id']; ?></p>
                            </div>
                            <div class="mb-3">
                                <span class="detail-label">Name:</span>
                                <p><?php echo $farmer['farmer_name']; ?></p>
                            </div>
                            <div class="mb-3">
                                <span class="detail-label">Phone:</span>
                                <p><?php echo $farmer['farmer_phone']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <span class="detail-label">State:</span>
                                <p><?php echo $farmer['farmer_state']; ?></p>
                            </div>
                            <div class="mb-3">
                                <span class="detail-label">District:</span>
                                <p><?php echo $farmer['farmer_district']; ?></p>
                            </div>
                            <div class="mb-3">
                                <span class="detail-label">PAN Number:</span>
                                <p><?php echo $farmer['farmer_pan']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <span class="detail-label">Bank Account Number:</span>
                                <p><?php echo $farmer['farmer_bank']; ?></p>
                            </div>
                            <div class="mb-3">
                                <span class="detail-label">Address:</span>
                                <p><?php echo $farmer['farmer_address']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="ManageFarmers.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Farmers List
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>