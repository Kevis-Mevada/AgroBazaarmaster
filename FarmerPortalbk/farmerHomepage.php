<?php
include("../Functions/functions.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Homepage</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #28a745;
            --dark-color: #343a40;
            --text-color: #444;
            --light-bg: #f8f9fa;
            
            /* Spacing */
            --space-xs: 0.5rem;   /* 8px */
            --space-sm: 1rem;     /* 16px */
            --space-md: 1.5rem;   /* 24px */
            --space-lg: 2rem;     /* 32px */
            --space-xl: 3rem;     /* 48px */
            
            /* Typography */
            --text-base: 1rem;    /* 16px */
            --text-sm: 0.875rem;  /* 14px */
            --text-md: 1.125rem;  /* 18px */
            --text-lg: 1.25rem;   /* 20px */
            --text-xl: 1.5rem;    /* 24px */
            --text-2xl: 1.75rem;  /* 28px */
            --text-3xl: 2rem;     /* 32px */
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            font-size: var(--text-base);
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--light-bg);
        }
        
        h1, h2, h3, h4 {
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
            line-height: 1.3;
            color: var(--dark-color);
        }
        
        h1 { font-size: var(--text-3xl); margin-bottom: var(--space-lg); }
        h2 { font-size: var(--text-2xl); margin-bottom: var(--space-md); }
        h3 { font-size: var(--text-xl); margin-bottom: var(--space-sm); }
        h4 { font-size: var(--text-lg); margin-bottom: var(--space-sm); }
        
        /* Layout */
        .section {
            padding: var(--space-xl) 0;
        }
        
        .container-narrow {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 var(--space-md);
        }
        
        /* Navbar */
        .agro-navbar {
            padding: var(--space-sm) 0;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .navbar-brand img {
            height: 42px;
        }
        
        /* Carousel */
        .hero-carousel {
            margin: var(--space-lg) auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 1200px;
        }
        
        .carousel-item {
            height: 400px;
        }
        
        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            height: 40px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.2);
            border-radius: 50%;
            margin: 0 var(--space-sm);
        }
        
        /* Features */
        .feature-card {
            height: 100%;
            padding: var(--space-md);
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto var(--space-md);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .feature-icon img {
            max-width: 100%;
            height: auto;
        }
        
        .section-title {
            position: relative;
            padding-bottom: var(--space-sm);
            margin-bottom: var(--space-xl);
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--primary-color);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .carousel-item {
                height: 350px;
            }
            
            :root {
                --text-3xl: 1.75rem;
                --text-2xl: 1.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .carousel-item {
                height: 300px;
            }
            
            .section {
                padding: var(--space-lg) 0;
            }
            
            :root {
                --text-3xl: 1.5rem;
                --text-2xl: 1.25rem;
                --text-xl: 1.125rem;
            }
        }
        
        @media (max-width: 576px) {
            .carousel-item {
                height: 250px;
            }
            
            .feature-icon {
                width: 60px;
                height: 60px;
            }
        }
        .navigation {
           
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        
    </style>
</head>
<body>
    <div class="navigation">
     <?php include("../layout/farmernav.php"); ?>
    </div>
    
    <!-- Hero Carousel -->
    <div class="container-narrow">
        <div class="hero-carousel">
            <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../Images/Homepage/fruitsbasket.jpg" class="d-block w-100" alt="Fresh Fruits">
                    </div>
                    <div class="carousel-item">
                        <img src="../Images/Website/farm1.jpeg" class="d-block w-100" alt="Farm Fresh">
                    </div>
                    <div class="carousel-item">
                        <img src="../Images/Homepage/vegetables.jpg" class="d-block w-100" alt="Fresh Vegetables">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Features Section -->
    <section class="section bg-white">
        <div class="container-narrow">
            <h2 class="text-center section-title">Standout Features</h2>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <img src="../Images/Homepage/sms.png" alt="SMS System">
                        </div>
                        <h4>SMS System</h4>
                        <p>Upload and edit your products via SMS with our convenient mobile interface.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <img src="../Images/Homepage/handshake.png" alt="Buyer Connection">
                        </div>
                        <h4>Buyer Connection</h4>
                        <p>Get in direct touch with buyers to understand and satisfy their specific needs.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <img src="../Images/Homepage/farmer.png" alt="Farmer Community">
                        </div>
                        <h4>Farmer Community</h4>
                        <p>Connect with other farmers to share knowledge and build a supportive network.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php include("../layout/footer.php"); ?>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Initialize carousel
        const carousel = new bootstrap.Carousel('#mainCarousel', {
            interval: 5000,
            wrap: true
        });
    </script>
</body>
</html>