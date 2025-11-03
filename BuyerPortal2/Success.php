<?php
include("../Functions/functions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success | AgroBazaar</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #28a745;
            --secondary-color: #f8f9fa;
            --accent-color: #ffc107;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .success-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        
        .success-card {
            width: 100%;
            max-width: 600px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
            overflow: hidden;
        }
        
        .success-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem;
            text-align: center;
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .success-body {
            padding: 2.5rem;
            text-align: center;
        }
        
        .success-icon {
            font-size: 5rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }
        
        .success-title {
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }
        
        .success-text {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: var(--dark-color);
        }
        
        .success-btn {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            border: none;
            font-size: 1.1rem;
        }
        
        .success-btn:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            color: white;
        }
    </style>
</head>

<body>
    <?php include("../layout/nav.php"); ?>
    
    <div class="success-container">
        <div class="success-card">
            <div class="success-header">
                Success
            </div>
            <div class="success-body">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 class="success-title">Product Successfully Orderd</h3>
                <p class="success-text">Thank you for shopping with us. Your item has been added to your cart.</p>
                <a href="bhome.php" class="btn success-btn">
                    <i class="fas fa-home me-2"></i> Go To Home
                </a>
            </div>
        </div>
    </div>
    
    <?php include("../layout/footer.php"); ?>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>