<?php
include("../Includes/db.php");
session_start();

// Check if user is logged in
if (!isset($_SESSION['phonenumber'])) {
    header("Location: ../auth/FarmerLogin.php");
    exit();
}

$sessphonenumber = $_SESSION['phonenumber'];
$sql = "SELECT * FROM farmerregistration WHERE farmer_phone = '$sessphonenumber'";
$run_query = mysqli_query($con, $sql);

if ($run_query && mysqli_num_rows($run_query) > 0) {
    $row = mysqli_fetch_array($run_query);
    $name = $row['farmer_name'];
    $phone = $row['farmer_phone'];
    $address = $row['farmer_address'];
    $pan = $row['farmer_pan'];
    $bank = $row['farmer_bank'];
    $state = $row['farmer_state'];
    $district = $row['farmer_district'];
} else {
    // Handle case where farmer data isn't found
    header("Location: ../auth/FarmerLogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Profile</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #28a745;
            --secondary-color: #ffc107;
            --dark-color: #343a40;
            --light-bg: #f8f9fa;
            --goldenrod: #daa520;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-color);
            padding-top: 70px; /* For fixed navbar */
        }
        
        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .profile-header h2 {
            font-weight: 700;
            color: var(--primary-color);
            position: relative;
            display: inline-block;
        }
        
        .profile-header h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--secondary-color);
        }
        
        .profile-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }
        
        .profile-field {
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .field-label {
            min-width: 180px;
            background-color: var(--dark-color);
            color: var(--goldenrod);
            padding: 0.75rem 1rem;
            border-radius: 8px 0 0 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        
        .field-label i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
        
        .field-value {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0 8px 8px 0;
            background-color: white;
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }
        
        .edit-btn {
            background-color: var(--dark-color);
            color: var(--goldenrod);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: block;
            margin: 2rem auto 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .edit-btn:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .navigation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        /* Animations */
        .animate {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .animate.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Delays for staggered animation */
        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        .delay-4 { transition-delay: 0.4s; }
        .delay-5 { transition-delay: 0.5s; }
        .delay-6 { transition-delay: 0.6s; }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .field-label {
                min-width: 100%;
                border-radius: 8px 8px 0 0;
            }
            
            .field-value {
                min-width: 100%;
                border-radius: 0 0 8px 8px;
                border-top: none;
            }
            
            .profile-card {
                padding: 1.5rem;
            }

        }
    </style>
</head>
<body>
    <div class="navigation">
        <?php include("../layout/farmernav.php"); ?>
    </div>
    
    <div class="profile-container">
        <div class="profile-header animate">
            <h2>Your Profile</h2>
        </div>
        
        <div class="profile-card animate delay-1">
            <div class="profile-field">
                <span class="field-label"><i class="fas fa-user"></i> Full Name</span>
                <span class="field-value"><?php echo htmlspecialchars($name); ?></span>
            </div>
            
            <div class="profile-field animate delay-2">
                <span class="field-label"><i class="fas fa-phone-alt"></i> Phone Number</span>
                <span class="field-value"><?php echo htmlspecialchars($phone); ?></span>
            </div>
            
            <div class="profile-field animate delay-3">
                <span class="field-label"><i class="fas fa-home"></i> Address</span>
                <span class="field-value"><?php echo htmlspecialchars($address); ?></span>
            </div>
            
            <div class="profile-field animate delay-4">
                <span class="field-label"><i class="fas fa-globe-americas"></i> State</span>
                <span class="field-value"><?php echo htmlspecialchars($state); ?></span>
            </div>
            
            <div class="profile-field animate delay-5">
                <span class="field-label"><i class="fas fa-globe-americas"></i> District</span>
                <span class="field-value"><?php echo htmlspecialchars($district); ?></span>
            </div>
            
            <div class="profile-field animate delay-1">
                <span class="field-label"><i class="fas fa-pencil-alt"></i> PAN Number</span>
                <span class="field-value"><?php echo htmlspecialchars($pan); ?></span>
            </div>
            
            <div class="profile-field animate delay-2">
                <span class="field-label"><i class="fas fa-university"></i> Bank Account</span>
                <span class="field-value"><?php echo htmlspecialchars($bank); ?></span>
            </div>
        </div>
        
        <a href="EditProfile.php" class="btn edit-btn animate delay-6">
            <i class="fas fa-edit mr-2"></i> Edit Profile
        </a>
    </div>
    
    <?php include("../layout/footer.php"); ?>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('.animate');
            
            // Trigger animations
            setTimeout(() => {
                animateElements.forEach(element => {
                    element.classList.add('show');
                });
            }, 100);
            
            // Intersection Observer for scroll animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                    }
                });
            }, { threshold: 0.1 });
            
            animateElements.forEach(element => {
                observer.observe(element);
            });
        });
    </script>
</body>
</html>