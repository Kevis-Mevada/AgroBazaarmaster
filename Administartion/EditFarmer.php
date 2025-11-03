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

// Update farmer details
if(isset($_POST['update_farmer'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    $district = mysqli_real_escape_string($con, $_POST['district']);
    $pan = mysqli_real_escape_string($con, $_POST['pan']);
    $bank = mysqli_real_escape_string($con, $_POST['bank']);

    $query = "UPDATE farmerregistration SET 
              farmer_name='$name', 
              farmer_phone='$phone', 
              farmer_address='$address', 
              farmer_state='$state', 
              farmer_district='$district', 
              farmer_pan='$pan', 
              farmer_bank='$bank' 
              WHERE farmer_id='$farmer_id'";

    if(mysqli_query($con, $query)) {
        $success = "Farmer details updated successfully!";
        $farmer = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM farmerregistration WHERE farmer_id='$farmer_id'"));
    } else {
        $error = "Error updating farmer: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Farmer | AgroBazaar</title>
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
        
        .form-label {
            font-weight: 600;
            color: var(--secondary);
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
                <span class="navbar-brand">Edit Farmer</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <div class="container-fluid">
            <?php if(isset($success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card detail-card">
                <div class="card-header detail-card-header">
                    <h5 class="mb-0">Edit Farmer Details</h5>
                </div>
                <div class="card-body detail-card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Farmer Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $farmer['farmer_name']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $farmer['farmer_phone']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control" id="state" name="state" value="<?php echo $farmer['farmer_state']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="district" class="form-label">District</label>
                                    <input type="text" class="form-control" id="district" name="district" value="<?php echo $farmer['farmer_district']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pan" class="form-label">PAN Number</label>
                                    <input type="text" class="form-control" id="pan" name="pan" value="<?php echo $farmer['farmer_pan']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="bank" class="form-label">Bank Account Number</label>
                                    <input type="text" class="form-control" id="bank" name="bank" value="<?php echo $farmer['farmer_bank']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required><?php echo $farmer['farmer_address']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" name="update_farmer" class="btn btn-success me-2">
                                <i class="fas fa-save"></i> Update Farmer
                            </button>
                            <a href="ViewFarmer.php?id=<?php echo $farmer['farmer_id']; ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>