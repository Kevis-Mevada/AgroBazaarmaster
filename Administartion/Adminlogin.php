<?php
session_start();
include("../Includes/db.php");

if(isset($_POST['admin_login'])) {
    $admin_username = $_POST['admin_username'];
    $admin_password = $_POST['admin_password'];
    
    // In a real application, use prepared statements and password hashing
    $query = "SELECT * FROM admin WHERE admin_username='$admin_username' AND admin_password='$admin_password'";
    $result = mysqli_query($con, $query);
    
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['admin_name'] = $row['admin_name'];
        header("Location: AdminDashboard.php");
    } else {
        echo "<script>alert('Invalid Credentials')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | AgroBazaar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container bg-white">
            <h2 class="text-center mb-4">Admin Login</h2>
            <form method="post">
                <div class="mb-3">
                    <label for="admin_username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="admin_username" name="admin_username" required>
                </div>
                <div class="mb-3">
                    <label for="admin_password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="admin_password" name="admin_password" required>
                </div>
                <button type="submit" name="admin_login" class="btn btn-success w-100">Login</button>
            </form>
        </div>
    </div>
</body>
</html>