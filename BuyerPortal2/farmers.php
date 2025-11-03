<?php
include("../Includes/db.php");
include("../Functions/functions.php");

// Fetch all farmers from the database
$sql = "SELECT * FROM farmerregistration";
$run_query = mysqli_query($con, $sql);
$farmers = [];
if ($run_query && mysqli_num_rows($run_query) > 0) {
    while ($row = mysqli_fetch_assoc($run_query)) {
        $farmers[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Farmers | AgroTrade</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #28a745;
            --secondary-color: #ffc107;
            --dark-color: #212529;
            --light-bg: #f8f9fa;
            --goldenrod: #daa520;
            --section-padding: 5rem 0;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-color);
            padding-top: 72px; /* For fixed navbar */
        }
        
        .section-title {
            position: relative;
            margin-bottom: 3rem;
            text-align: center;
        }
        
        .section-title h2 {
            font-weight: 700;
            color: var(--primary-color);
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--secondary-color);
        }
        
        .farmer-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            height: 100%;
        }
        
        .farmer-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }
        
        .farmer-img {
            height: 180px;
            background-color: var(--light-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .farmer-img img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .farmer-body {
            padding: 1.5rem;
            text-align: center;
        }
        
        .farmer-name {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .farmer-location {
            color: #6c757d;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .view-profile-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            cursor: pointer;
        }
        
        .view-profile-btn:hover {
            background-color: var(--dark-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        /* Modal styles */
        .profile-modal .modal-content {
            border-radius: 15px;
            overflow: hidden;
            border: none;
        }
        
        .profile-modal .modal-header {
            background-color: var(--primary-color);
            color: white;
            border-bottom: none;
            position: relative;
        }
        
        .profile-modal .modal-header .btn-close {
            filter: invert(1);
            position: absolute;
            right: 20px;
            top: 20px;
        }
        
        .profile-modal .modal-body {
            padding: 2rem;
        }
        
        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin: -100px auto 20px;
            display: block;
            background-color: #f8f9fa;
        }
        
        .profile-name {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .profile-location {
            color: #6c757d;
            margin-bottom: 1.5rem;
        }
        
        .profile-details .detail-item {
            margin-bottom: 1rem;
            display: flex;
        }
        
        .profile-details .detail-icon {
            width: 40px;
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        .profile-details .detail-content {
            flex: 1;
        }
        
        .profile-details h5 {
            font-weight: 600;
            margin-bottom: 0.3rem;
        }
        
        .profile-details p {
            margin-bottom: 0;
            color: #6c757d;
        }
        
        /* Animation classes */
        .animate-card {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .animate-card.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            :root {
                --section-padding: 3rem 0;
            }
            
            .farmer-img {
                height: 150px;
            }
            
            .farmer-img img {
                width: 100px;
                height: 100px;
            }
            
            .profile-modal .modal-body {
                padding: 1.5rem;
            }
            
            .profile-avatar {
                width: 120px;
                height: 120px;
                margin-top: -80px;
            }
        }
    </style>
</head>

<body>
    <?php include("../layout/nav.php"); ?>
    
    <section class="py-5" style="background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center; background-size: cover;">
        <div class="container">
            <div class="section-title">
                <h2>Meet Our Farmers</h2>
                <p class="lead">Directly connect with the people who grow your food</p>
            </div>
            
            <div class="row g-4">
                <?php if (!empty($farmers)): ?>
                    <?php foreach ($farmers as $index => $farmer): ?>
                        <div class="col-md-6 col-lg-4 col-xl-3 animate-card" style="transition-delay: <?= ($index % 4) * 0.1 ?>s">
                            <div class="farmer-card">
                                <div class="farmer-img">
                                    <img src="<?= !empty($farmer['farmer_image']) ? $farmer['farmer_image'] : 'https://ui-avatars.com/api/?name='.urlencode($farmer['farmer_name']).'&background=random&size=200' ?>" alt="<?= htmlspecialchars($farmer['farmer_name']) ?>">
                                </div>
                                <div class="farmer-body">
                                    <h4 class="farmer-name"><?= htmlspecialchars($farmer['farmer_name']) ?></h4>
                                    <div class="farmer-location">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        <?= htmlspecialchars($farmer['farmer_district']) ?>, <?= htmlspecialchars($farmer['farmer_state']) ?>
                                    </div>
                                    
                                    <button class="view-profile-btn" data-bs-toggle="modal" data-bs-target="#profileModal" 
                                        data-farmer-id="<?= $farmer['farmer_id'] ?>"
                                        data-farmer-name="<?= htmlspecialchars($farmer['farmer_name']) ?>"
                                        data-farmer-image="<?= !empty($farmer['farmer_image']) ? $farmer['farmer_image'] : 'https://ui-avatars.com/api/?name='.urlencode($farmer['farmer_name']).'&background=random&size=200' ?>"
                                        data-farmer-phone="<?= htmlspecialchars($farmer['farmer_phone']) ?>"
                                        data-farmer-address="<?= htmlspecialchars($farmer['farmer_address']) ?>"
                                        data-farmer-district="<?= htmlspecialchars($farmer['farmer_district']) ?>"
                                        data-farmer-state="<?= htmlspecialchars($farmer['farmer_state']) ?>"
                                        data-farmer-bio="<?= htmlspecialchars($farmer['farmer_bio'] ?? 'No bio provided') ?>">
                                        <i class="fas fa-user me-2"></i> View Profile
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-info">
                            <h4>No farmers found</h4>
                            <p>Currently there are no registered farmers in our system.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <!-- Farmer Profile Modal -->
    <div class="modal fade profile-modal" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Farmer Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="profile-header">
                        <img id="modalFarmerImage" src="" alt="Farmer Image" class="profile-avatar">
                        <h3 class="profile-name" id="modalFarmerName"></h3>
                        <div class="profile-location">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span id="modalFarmerDistrict"></span>, <span id="modalFarmerState"></span>
                        </div>
                    </div>
                    
                    <div class="profile-details">
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="detail-content">
                                <h5>Phone</h5>
                                <p id="modalFarmerPhone"></p>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="detail-content">
                                <h5>Address</h5>
                                <p id="modalFarmerAddress"></p>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="detail-content">
                                <h5>About</h5>
                                <p id="modalFarmerBio"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <?php include("../layout/footer.php"); ?>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            // Initial animation for cards that are already in view
            const animateCards = document.querySelectorAll('.animate-card');
            
            function checkCards() {
                animateCards.forEach(card => {
                    const cardTop = card.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;
                    
                    if (cardTop < windowHeight - 100) {
                        card.classList.add('show');
                    }
                });
            }
            
            // Check on load
            checkCards();
            
            // Check on scroll
            window.addEventListener('scroll', checkCards);
            
            // Handle profile modal data
            const profileModal = document.getElementById('profileModal');
            if (profileModal) {
                profileModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget; // Button that triggered the modal
                    
                    // Extract farmer data from button data attributes
                    const farmerId = button.getAttribute('data-farmer-id');
                    const farmerName = button.getAttribute('data-farmer-name');
                    const farmerImage = button.getAttribute('data-farmer-image');
                    const farmerPhone = button.getAttribute('data-farmer-phone');
                    const farmerAddress = button.getAttribute('data-farmer-address');
                    const farmerDistrict = button.getAttribute('data-farmer-district');
                    const farmerState = button.getAttribute('data-farmer-state');
                    const farmerBio = button.getAttribute('data-farmer-bio');
                    
                    // Update the modal's content
                    document.getElementById('modalFarmerName').textContent = farmerName;
                    document.getElementById('modalFarmerImage').src = farmerImage;
                    document.getElementById('modalFarmerPhone').textContent = farmerPhone;
                    document.getElementById('modalFarmerAddress').textContent = farmerAddress;
                    document.getElementById('modalFarmerDistrict').textContent = farmerDistrict;
                    document.getElementById('modalFarmerState').textContent = farmerState;
                    document.getElementById('modalFarmerBio').textContent = farmerBio;
                });
            }
        });
    </script>
</body>
</html>