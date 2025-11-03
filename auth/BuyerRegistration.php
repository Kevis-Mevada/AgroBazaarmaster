<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Registration | AgroCraft</title>
    <meta name="description" content="Register as a buyer on AgroCraft - Connect directly with farmers. Fair prices. No middlemen.">
    
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
        
        /* Registration Form */
        .registration-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }
        
        .registration-card {
            background-color: var(--section-bg);
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 900px;
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out;
        }
        
        .registration-header {
            background-color: var(--primary-green);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        
        .registration-header h2 {
            font-family: 'Cormorant Infant', serif;
            font-size: 2rem;
            margin-bottom: 0;
            color: var(--light-text);
        }
        
        .registration-body {
            padding: 2rem;
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }
        
        .form-col {
            flex: 0 0 50%;
            padding: 0 15px;
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
            min-width: 20px;
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
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        .btn-register {
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
        
        .btn-register:hover {
            background-color: #1b5e20;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
            .registration-header h2 {
                font-size: 1.8rem;
            }
            
            .registration-body {
                padding: 1.5rem;
            }
            
            .form-col {
                flex: 0 0 100%;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 1rem;
            }
            
            .logo {
                font-size: 1.5rem;
            }
            
            .registration-header h2 {
                font-size: 1.5rem;
            }
            
            .btn-register {
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
                <a href="BuyerLogin.php" style="color: white; text-decoration: none; margin-left: 1.5rem;">Login</a>
            </nav>
        </header>
        
        <div class="registration-container">
            <div class="registration-card">
                <div class="registration-header">
                    <h2>Buyer Registration</h2>
                </div>
                <div class="registration-body">
                    <form name="my-form" action="BuyerRegistration.php" method="post">
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="full_name" class="form-label"><i class="fas fa-user"></i> Full Name</label>
                                    <input type="text" id="full_name" class="form-control" name="name" placeholder="Enter Your Name" required>
                                </div>

                                <div class="form-group">
                                    <label for="phone_number" class="form-label"><i class="fas fa-phone-alt"></i> Phone Number</label>
                                    <input type="text" id="phone_number" class="form-control" name="phonenumber" placeholder="Phone Number" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="email_address" class="form-label"><i class="far fa-envelope"></i> E-Mail Address</label>
                                    <input type="email" id="email_address" class="form-control" name="mail" placeholder="E-Mail ID" required>
                                </div>

                                <div class="form-group">
                                    <label for="present_address" class="form-label"><i class="fas fa-home"></i> Present Address</label>
                                    <textarea id="present_address" class="form-control" rows="4" name="address" placeholder="Address" required></textarea>
                                </div>
                            </div>
                            
                            <div class="form-col">
                                <div class="form-group">
                                    <label for="campany_name" class="form-label"><i class="fas fa-building"></i> Company Name (optional)</label>
                                    <input type="text" id="campany_name" class="form-control" name="company_name" placeholder="Company name">
                                    
                                </div>            

                                <!-- <div class="form-group">
                                    <label for="lisence" class="form-label"><i class="fas fa-id-badge"></i> License</label>
                                    <input type="text" id="lisence" class="form-control" name="license" placeholder="License" required>
                                </div> -->

                                <!-- <div class="form-group">
                                    <label for="account1" class="form-label"><i class="fas fa-university"></i> Bank Account No.</label>
                                    <input type="text" id="account1" class="form-control" name="account" placeholder="Bank Account number" required>
                                </div> -->

                                <!-- <div class="form-group">
                                    <label for="account2" class="form-label"><i class="fas fa-pencil-alt"></i> PAN No.</label>
                                    <input type="text" id="account2" class="form-control" name="pan" placeholder="Pan number" required>
                                </div> -->

                                <div class="form-group">
                                    <label for="user_name" class="form-label"><i class="fas fa-user"></i> User Name</label>
                                    <input type="text" id="user_name" class="form-control" name="username" placeholder="Username" required>
                                </div>

                                <div class="form-group">
                                    <label for="p1" class="form-label"><i class="fas fa-lock"></i> Password</label>
                                    <input id="p1" class="form-control" type="password" name="password" placeholder="Password" required>
                                </div>

                                <div class="form-group">
                                    <label for="p2" class="form-label"><i class="fas fa-lock"></i> Confirm Password</label>
                                    <input id="p2" class="form-control" type="password" name="confirmpassword" placeholder="Confirm Password" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-register" name="register" value="Register">
                            Register
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        <div class="footer-links">
            <a href="../index.html">Home</a>
            <a href="BuyerLogin.php">Login</a>
            <a href="#">Terms of Service</a>
            <a href="#">Privacy Policy</a>
        </div>
        <p>&copy; 2025 AgroCraft. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation can be added here
            const form = document.querySelector('form');
            
            form.addEventListener('submit', function(e) {
                const password = document.getElementById('p1').value;
                const confirmPassword = document.getElementById('p2').value;
                
                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Password and Confirm Password must match');
                    document.getElementById('p2').focus();
                }
            });
        });
    </script>
</body>
</html>

<?php
include("../Includes/db.php");

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $company_name = mysqli_real_escape_string($con, $_POST['company_name']);
    // $license = mysqli_real_escape_string($con, $_POST['license']);
    // $account = mysqli_real_escape_string($con, $_POST['account']);
    // $pan = mysqli_real_escape_string($con, $_POST['pan']);
    $mail = mysqli_real_escape_string($con, $_POST['mail']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirmpassword = mysqli_real_escape_string($con, $_POST['confirmpassword']);

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
        $query = "insert into buyerregistration (buyer_name,buyer_phone,buyer_addr,buyer_comp,
        buyer_license,buyer_bank,buyer_pan,buyer_mail,buyer_username,buyer_password) 
        values ('$name','$phonenumber','$address','$company_name','$license','$account','$pan',
        '$mail','$username','$encryption')";

        $run_register_query = mysqli_query($con, $query);
        echo "<script>alert('Successfully Registered');</script>";
        echo "<script>window.open('BuyerLogin.php','_self')</script>";
    } else {
        echo "<script>alert('Password and Confirm Password Should be same');</script>";
    }
}
?>