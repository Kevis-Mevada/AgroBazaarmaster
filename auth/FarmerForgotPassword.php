<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | AgroCraft</title>
    <meta name="description" content="Reset your AgroCraft farmer account password - Connect directly with buyers. Fair prices. No middlemen.">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Infant:wght@600;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        :root {
            --primary-green: #2e7d32;
            --light-green: #81c784;
            --accent-gold: #ffab00;
            --dark-text: #263238;
            --light-text: #f5f5f5;
            --section-bg: rgba(255, 255, 255, 0.9);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef') no-repeat center center fixed;
            background-size: cover;
            color: var(--dark-text);
            position: relative;
            line-height: 1.6;
        }
        
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(46, 125, 50, 0.85);
            z-index: 0;
        }
        
        .container {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        /* Header Section */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }
        
        .logo {
            font-family: 'Cormorant Infant', serif;
            font-size: 2rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .logo i {
            margin-right: 0.5rem;
            color: var(--accent-gold);
        }
        
        /* Password Reset Form */
        .reset-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }
        
        .reset-card {
            background-color: var(--section-bg);
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out;
        }
        
        .reset-header {
            background-color: var(--primary-green);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        
        .reset-header h2 {
            font-family: 'Cormorant Infant', serif;
            font-size: 2rem;
            margin-bottom: 0;
            color: var(--light-text);
        }
        
        .reset-body {
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--primary-green);
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .form-label i {
            margin-right: 10px;
            color: var(--primary-green);
        }
        
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            padding: 12px 15px;
            transition: all 0.3s;
            width: 100%;
        }
        
        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
        }
        
        .btn-reset {
            background-color: var(--primary-green);
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 50px;
            transition: all 0.3s;
            display: block;
            width: 100%;
            max-width: 200px;
            margin: 2rem auto 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
        }
        
        .btn-reset:hover {
            background-color: #1b5e20;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .login-link a {
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .login-link a:hover {
            color: var(--light-green);
            text-decoration: underline;
        }
        
        /* Footer */
        footer {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 2rem 0;
            text-align: center;
            margin-top: 2rem;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .footer-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: var(--light-green);
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .reset-header h2 {
                font-size: 1.8rem;
            }
            
            .reset-body {
                padding: 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 1rem;
            }
            
            .logo {
                font-size: 1.5rem;
            }
            
            .reset-header h2 {
                font-size: 1.5rem;
            }
            
            .btn-reset {
                max-width: 100%;
            }
            
            .footer-links {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    
    <div class="container">
        <header>
            <a href="../index.php" class="logo">
                <i class="fas fa-leaf"></i> AgroCraft
            </a>
            <nav>
                <a href="../index.html" style="color: white; text-decoration: none;">Home</a>
                <a href="FarmerLogin.php" style="color: white; text-decoration: none; margin-left: 1.5rem;">Login</a>
            </nav>
        </header>
        
        <div class="reset-container">
            <div class="reset-card">
                <div class="reset-header">
                    <h2>Reset Password</h2>
                </div>
                <div class="reset-body">
                    <form action="FarmerForgotPassword.php" method="post">
                        <div class="form-group">
                            <label for="phonenumber" class="form-label"><i class="fas fa-phone-alt"></i> Phone Number</label>
                            <input type="text" id="phonenumber" class="form-control" name="phonenumber" placeholder="Phone Number" required>
                        </div>

                   

                        <div class="form-group">
                            <label for="password" class="form-label"><i class="fas fa-lock"></i> New Password</label>
                            <input type="password" id="password" class="form-control" name="password" placeholder="New Password" required>
                        </div>

                        <div class="form-group">
                            <label for="confirmpassword" class="form-label"><i class="fas fa-lock"></i> Confirm Password</label>
                            <input type="password" id="confirmpassword" class="form-control" name="confirmpassword" placeholder="Confirm Password" required>
                        </div>

                        <button type="submit" class="btn-reset" name="register" value="Update Password">
                            Update Password
                        </button>
                        
                        <div class="login-link">
                            <a href="FarmerLogin.php"><i class="fas fa-arrow-left"></i> Back to Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        <div class="footer-links">
            <a href="../index.html">Home</a>
            <a href="FarmerLogin.php">Login</a>
            <a href="#">Terms of Service</a>
            <a href="#">Privacy Policy</a>
        </div>
        <p>&copy; 2023 AgroCraft. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Client-side validation
            const form = document.querySelector('form');
            
            form.addEventListener('submit', function(e) {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmpassword').value;
                
                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Password and Confirm Password must match');
                    document.getElementById('confirmpassword').focus();
                }
            });
        });
    </script>
</body>
</html>

<?php
include("../Includes/db.php");
if (isset($_POST['register'])) {
    $phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
    
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirmpassword = mysqli_real_escape_string($con, $_POST['confirmpassword']);

    $query = "select * from farmerregistration where farmer_phone = '$phonenumber'";
    $run_query = mysqli_query($con, $query);
    $count_rows = mysqli_num_rows($run_query);

    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '2345678910111211';
    $encryption_key = "DE";

    $encryption = openssl_encrypt(
        $password,
        $ciphering,
        $encryption_key,
        $options,
        $encryption_iv
    );

    if (strcmp($password, $confirmpassword) == 0) {
        if ($count_rows != 0) {
            $update_query = "update farmerregistration set farmer_password = '$encryption' 
                                 where farmer_phone = '$phonenumber'";

            $run_query = mysqli_query($con, $update_query);

            echo "<script>alert('Password Updated Successfully');</script>";
            echo "<script>window.open('FarmerLogin.php','_self')</script>";
        } else if ($count_rows == 0) {
            echo "<script>alert('Please Enter Valid Details');</script>";
        }
    } else {
        echo "<script>alert('Please Enter Valid Details');</script>";
    }
}
?>