<?php
include "../Functions/functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .main-content {
            flex: 1;
            padding: 2rem 0;
        }
        
        .orders-header {
            border-bottom: 2px solid #28a745;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .table-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
            overflow-x: auto;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead {
            background-color: #28a745;
            color: white;
        }
        
        .table th {
            padding: 12px 15px;
            font-weight: 600;
        }
        
        .table td {
            padding: 12px 15px;
            vertical-align: middle;
        }
        
        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .table tbody tr:hover {
            background-color: rgba(40, 167, 69, 0.1);
        }
        
        @media (max-width: 768px) {
            .table-container {
                padding: 10px;
            }
            
            .table th, .table td {
                padding: 8px 10px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <?php include "../layout/nav.php"; ?>
    
    <div class="main-content">
        <div class="container">
            <div class="orders-header">
                <h3><i class="fas fa-clipboard-list me-2"></i> Your Orders</h3>
            </div>
            
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-success">
                            <tr>
                                <th>Order ID</th>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Delivery Address</th>
                                <th>Delivery Mode</th>
                                <th>Farmer Name</th>
                                <th>Farmer Phone</th>
                                <th>Buyer Phone</th>
                                <th>Payment Mode</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            global $con;
                            if (isset($_SESSION['phonenumber'])) {
                                $sess_phone_number = $_SESSION['phonenumber'];
                                $query = "SELECT o.*, p.product_title, f.farmer_name, f.farmer_phone 
                                    FROM orders o
                                    JOIN products p ON o.product_id = p.product_id
                                    JOIN farmerregistration f ON p.farmer_fk = f.farmer_id
                                    WHERE o.buyer_phonenumber = '$sess_phone_number'";
                                $run_query = mysqli_query($con, $query);
                                while ($row = mysqli_fetch_array($run_query)) {
                                    $order_id = $row['order_id'];
                                    $product_id = $row['product_id'];
                                    $product_title = $row['product_title'];
                                    $qty = $row['qty'];
                                    $address = $row['address'];
                                    $delivery = $row['delivery'];
                                    $farmer_name = $row['farmer_name'];
                                    $farmer_phone = $row['farmer_phone'];
                                    $buyer_phonenumber = $row['buyer_phonenumber'];
                                    $payment = $row['payment'];
                                    $total = $row['total'];
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($order_id); ?></td>
                                        <td><?php echo htmlspecialchars($product_id); ?></td>
                                        <td><?php echo htmlspecialchars($product_title); ?></td>
                                        <td><?php echo htmlspecialchars($qty); ?></td>
                                        <td><?php echo htmlspecialchars($address); ?></td>
                                        <td><?php echo htmlspecialchars($delivery); ?></td>
                                        <td><?php echo htmlspecialchars($farmer_name); ?></td>
                                        <td><?php echo htmlspecialchars($farmer_phone); ?></td>
                                        <td><?php echo htmlspecialchars($buyer_phonenumber); ?></td>
                                        <td><?php echo htmlspecialchars($payment); ?></td>
                                        <td>₹<?php echo htmlspecialchars($total); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="11" class="text-center py-4"><h4>Please Login First!</h4></td></tr>';
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <?php include "../layout/footer.php"; ?>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
