<?php
session_start();
include("../Includes/db.php");

if(!isset($_SESSION['admin_id'])) {
    header("Location: AdminLogin.php");
    exit();
}

// Search functionality
$search = "";
if(isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT p.*, b.buyer_name 
              FROM payments p
              JOIN buyerregistration b ON p.phone_number = b.buyer_phone
              WHERE p.payment_id LIKE '%$search%' OR 
                    p.phone_number LIKE '%$search%' OR 
                    b.buyer_name LIKE '%$search%'";
} else {
    $query = "SELECT p.*, b.buyer_name 
              FROM payments p
              JOIN buyerregistration b ON p.phone_number = b.buyer_phone
              ORDER BY p.created_at DESC";
}

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments | AgroBazaar</title>
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
        
        .badge-success {
            background-color: #28a745;
        }
        
        .badge-warning {
            background-color: #ffc107;
            color: #000;
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
                <a class="nav-link active" href="ManagePayments.php">
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
                <span class="navbar-brand">Payment Transactions</span>
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
                            <input type="text" class="form-control" placeholder="Search payments..." name="search" value="<?php echo $search; ?>">
                            <button class="btn btn-success" type="submit">Search</button>
                            <a href="ManagePayments.php" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Payment ID</th>
                                    <th>Buyer</th>
                                    <th>Phone</th>
                                    <th>Amount</th>
                                    <th>Receipt No</th>
                                    <th>Razorpay ID</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $status = $row['payment_done'] == 'yes' ? 'Success' : 'Pending';
                                        $status_class = $row['payment_done'] == 'yes' ? 'badge-success' : 'badge-warning';
                                        
                                        echo '<tr>
                                            <td>'.$row['payment_id'].'</td>
                                            <td>'.$row['buyer_name'].'</td>
                                            <td>'.$row['phone_number'].'</td>
                                            <td>₹'.$row['amount'].'</td>
                                            <td>'.$row['receipt_no'].'</td>
                                            <td>'.substr($row['razorpay_id'], 0, 15).'...</td>
                                            <td><span class="badge '.$status_class.'">'.$status.'</span></td>
                                            <td>'.date('d M Y', strtotime($row['created_at'])).'</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary action-btn" title="View" data-bs-toggle="modal" data-bs-target="#paymentModal'.$row['id'].'">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                
                                                <!-- Payment Details Modal -->
                                                <div class="modal fade" id="paymentModal'.$row['id'].'" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Payment Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Payment ID:</strong> '.$row['payment_id'].'</p>
                                                                <p><strong>Buyer:</strong> '.$row['buyer_name'].'</p>
                                                                <p><strong>Phone:</strong> '.$row['phone_number'].'</p>
                                                                <p><strong>Amount:</strong> ₹'.$row['amount'].'</p>
                                                                <p><strong>Receipt No:</strong> '.$row['receipt_no'].'</p>
                                                                <p><strong>Razorpay ID:</strong> '.$row['razorpay_id'].'</p>
                                                                <p><strong>Status:</strong> <span class="badge '.$status_class.'">'.$status.'</span></p>
                                                                <p><strong>Date:</strong> '.date('d M Y H:i:s', strtotime($row['created_at'])).'</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="9" class="text-center">No payment records found</td></tr>';
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