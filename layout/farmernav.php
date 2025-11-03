<style>
/* Modern Agro Navbar Styles */
.agro-navbar {
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    padding: 0.5rem 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.container {
    max-width: 1200px;
    padding: 0 20px;
}

.navbar-brand img {
    height: 70px;
    width: 70px;
    transition: transform 0.3s ease;
}

.navbar-brand:hover img {
    transform: scale(1.05);
}

/* Main Navigation Items */
.navbar-nav {
    display: flex;
    align-items: center;
    gap: 8px;
}

.nav-item {
    position: relative;
}

.nav-link {
    color: #333 !important;
    font-weight: 500;
    padding: 12px 18px !important;
    transition: all 0.3s ease;
    position: relative;
    display: flex;
    align-items: center;
    border-radius: 6px;
}

.nav-link:hover {
    color: #28a745 !important;
    background: rgba(40, 167, 69, 0.1);
}

.nav-link.active {
    color: #28a745 !important;
    font-weight: 600;
}

.nav-link.active:after {
    content: '';
    position: absolute;
    bottom: 6px;
    left: 18px;
    width: calc(100% - 36px);
    height: 2px;
    background-color: #28a745;
    border-radius: 2px;
}

.nav-link i {
    margin-right: 10px;
    color: #28a745;
    font-size: 15px;
    width: 18px;
    text-align: center;
}

/* User Section */
.user-section {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-left: 15px;
}

.user-name {
    background-color: rgba(40, 167, 69, 0.1);
    padding: 10px 15px;
    border-radius: 6px;
    color: #28a745;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 150px;
}

.login-btn {
    background-color: rgba(40, 167, 69, 0.1);
    padding: 10px 20px;
    border-radius: 6px;
    color: #28a745;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    text-decoration: none !important;
}

.login-btn:hover {
    background-color: rgba(40, 167, 69, 0.2);
    color: #28a745;
}

.login-btn i {
    margin-right: 8px;
}

/* Responsive Adjustments */
@media (max-width: 1199.98px) {
    .navbar-collapse {
        background-color: #fff;
        padding: 15px;
        margin-top: 10px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        display: none; /* Hidden by default */
    }
    
    .navbar-collapse.show {
        display: block; /* Show when toggled */
    }
    
    .navbar-nav {
        flex-direction: column;
        gap: 5px;
        width: 100%;
    }
    
    .nav-link {
        padding: 12px 15px !important;
        width: 100%;
    }
    
    .nav-link.active:after {
        bottom: 6px;
        left: 15px;
        width: calc(100% - 30px);
    }
    
    .user-section {
        flex-direction: column;
        margin-left: 0;
        margin-top: 15px;
        width: 100%;
        gap: 10px;
    }
    
    .user-name {
        max-width: 100%;
        text-align: center;
        margin-top: 10px;
    }
    
    .login-btn {
        width: 100%;
        justify-content: center;
    }
}

/* Toggle Button Styling */
.navbar-toggler {
    border: none;
    padding: 0.6rem;
    cursor: pointer;
}

.navbar-toggler:focus {
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.3);
    outline: none;
}

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(40, 167, 69, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    width: 1.3em;
    height: 1.3em;
    display: inline-block;
    vertical-align: middle;
}
</style>

<nav class="navbar navbar-expand-xl agro-navbar">
    <div class="container">
        <a class="navbar-brand" href="farmerHomepage.php">
            <img src="../auth/agro.png" alt="Agro Logo" width="50px" height="70px">
        </a>
        
        <button class="navbar-toggler" type="button" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Menu Items -->
                <li class="nav-item">
                    <a class="nav-link" href="farmerHomepage.php">
                        <i class="fa fa-home" aria-hidden="true"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="MyProducts.php">
                        <i class="fa fa-leaf" aria-hidden="true"></i> My Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Transactions.php">
                        <i class="fa fa-exchange" aria-hidden="true"></i> Transactions
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="CallCenter.php">
                        <i class="fa fa-phone fa-rotate-vertical" aria-hidden="true"></i> Call Center
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="farmerProfile2.php">
                        <i class="fa fa-user" aria-hidden="true"></i> Profile
                    </a>
                </li>
            </ul>
            
            <div class="user-section">
                <?php if (isset($_SESSION['phonenumber'])): ?>
                    <div class="user-name">
                        <?php
                        if (isset($_SESSION['phonenumber'])) {
                            $phone = $_SESSION['phonenumber'];
                            $query = "SELECT farmer_name FROM farmerregistration WHERE farmer_phone = '$phone'";
                            $result = mysqli_query($con, $query);
                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                echo "Welcome, " . htmlspecialchars($row['farmer_name']);
                            } else {
                                echo "Farmer";
                            }
                        }
                        ?>
                    </div>
                    <a class="login-btn" href="logout.php">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                    </a>
                <?php else: ?>
                    <a class="login-btn" href="../auth/FarmerLogin.php">
                        <i class="fa fa-sign-in" aria-hidden="true"></i> Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>



<script>
// Toggle mobile menu
document.querySelector('.navbar-toggler').addEventListener('click', function() {
    document.querySelector('.navbar-collapse').classList.toggle('show');
});

// Add active class to current page link
document.addEventListener('DOMContentLoaded', function() {
    const currentPage = location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        }
    });
    
    // Close menu when clicking on a link (mobile)
    document.querySelectorAll('.nav-link, .login-btn').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 1199.98) {
                document.querySelector('.navbar-collapse').classList.remove('show');
            }
        });
    });
});
</script>