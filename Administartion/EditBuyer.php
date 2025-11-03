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

// Fetch buyer data
$query = "SELECT * FROM buyerregistration WHERE buyer_id='$buyer_id'";
$result = mysqli_query($con, $query);
$buyer = mysqli_fetch_assoc($result);

if(!$buyer) {
    header("Location: ManageBuyers.php");
    exit();
}

// Update buyer
if(isset($_POST['update_buyer'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $company = mysqli_real_escape_string($con, $_POST['company']);
    $license = mysqli_real_escape_string($con, $_POST['license']);
    $bank = mysqli_real_escape_string($con, $_POST['bank']);
    $pan = mysqli_real_escape_string($con, $_POST['pan']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    
    $update_query = "UPDATE buyerregistration SET 
                    buyer_name='$name',
                    buyer_phone='$phone',
                    buyer_mail='$email',
                    buyer_comp='$company',
                    buyer_license='$license',
                    buyer_bank='$bank',
                    buyer_pan='$pan',
                    buyer_addr='$address'
                    WHERE buyer_id='$buyer_id'";
    
    if(mysqli_query($con, $update_query)) {
        header("Location: ViewBuyer.php?id=$buyer_id");
        exit();
    } else {
        $error = "Error updating buyer: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buyer | AgroBazaar</title>
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
        
        .edit-card {
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        
        .edit-header {
            background-color: var(--primary);
            color: white;
            border-radius: 10px 10px 0 0;
        }
        
        .form-label {
            font-weight: 600;
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
                <span class="navbar-brand">Edit Buyer</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="card edit-card mb-4">
                <div class="card-header edit-header">
                    <h5 class="card-title mb-0">Edit Buyer Information</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <form method="post">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $buyer['buyer_name']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $buyer['buyer_phone']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $buyer['buyer_mail']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="company" class="form-label">Company</label>
                                <input type="text" class="form-control" id="company" name="company" value="<?php echo $buyer['buyer_comp']; ?>">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="license" class="form-label">License Number</label>
                                <input type="text" class="form-control" id="license" name="license" value="<?php echo $buyer['buyer_license']; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="bank" class="form-label">Bank Account</label>
                                <input type="text" class="form-control" id="bank" name="bank" value="<?php echo $buyer['buyer_bank']; ?>">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="pan" class="form-label">PAN Number</label>
                                <input type="text" class="form-control" id="pan" name="pan" value="<?php echo $buyer['buyer_pan']; ?>">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3"><?php echo $buyer['buyer_addr']; ?></textarea>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <a href="ViewBuyer.php?id=<?php echo $buyer_id; ?>" class="btn btn-secondary">Cancel</a>
                            <button type="submit" name="update_buyer" class="btn btn-primary">Update Buyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>