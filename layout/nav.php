<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AgroBazaar</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-green: #28a745;
      --dark-green: #218838;
      --light-gray: #f8f9fa;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding-top: 70px;
    }

    .navbar {
      background-color: white;
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
      padding: 0.75rem 1rem;
      transition: all 0.3s ease;
      z-index: 1030; /* Ensure navbar stays above other content */
    }

    .navbar-brand img {
      transition: transform 0.3s ease;
      height: 50px;
      width: auto;
    }

    .navbar-brand:hover img {
      transform: scale(1.1);
    }

    .search-container {
      position: relative;
      flex-grow: 1;
      max-width: 600px;
      margin: 0 1.5rem;
    }

    .search-form {
      position: relative;
      width: 100%;
    }

    .search-input {
      width: 100%;
      padding: 0.75rem 1rem 0.75rem 3rem;
      border: 1px solid #e0e0e0;
      border-radius: 50px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background-color: var(--light-gray);
      box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .search-input:focus {
      outline: none;
      border-color: var(--primary-green);
      box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.2);
      background-color: white;
    }

    .search-icon {
      position: absolute;
      left: 1.25rem;
      top: 50%;
      transform: translateY(-50%);
      color: #6c757d;
      pointer-events: none;
    }

    .nav-item {
      margin: 0 0.5rem;
    }

    .nav-link {
      color: #495057;
      font-weight: 500;
      padding: 0.5rem 1rem;
      border-radius: 5px;
      transition: all 0.2s ease;
    }

    .nav-link:hover {
      color: var(--primary-green);
      background-color: rgba(40, 167, 69, 0.1);
    }

    .dropdown-menu {
      border: none;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      padding: 0.5rem 0;
      margin-top: 0.5rem;
      z-index: 1031; /* Ensure dropdown appears above navbar */
    }

    .dropdown-item {
      padding: 0.5rem 1.5rem;
      transition: all 0.2s ease;
      color: #495057;
    }

    .dropdown-item:hover {
      background-color: var(--light-gray);
      color: var(--primary-green);
      padding-left: 1.75rem;
    }

    .cart-icon {
      position: relative;
      margin-right: 1.5rem;
      color: var(--primary-green);
      font-size: 1.5rem;
      transition: all 0.3s ease;
    }

    .cart-badge {
      position: absolute;
      top: -8px;
      right: -8px;
      background-color: var(--primary-green);
      color: white;
      border-radius: 50%;
      width: 22px;
      height: 22px;
      font-size: 0.75rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }

    .cart-icon:hover {
      transform: scale(1.1);
    }

    .cart-icon:hover .cart-badge {
      background-color: var(--dark-green);
    }

    .profile-icon {
      color: var(--primary-green);
      font-size: 1.75rem;
      transition: all 0.3s ease;
    }

    .profile-icon:hover {
      color: var(--dark-green);
      transform: scale(1.1);
    }

    /* Fix for mobile menu */
    .navbar-collapse {
      overflow: visible !important;
    }

    @media (max-width: 992px) {
      .search-container {
        margin: 1rem 0;
        width: 100%;
        max-width: 100%;
      }

      .navbar-collapse {
        padding: 1rem 0;
      }

      .nav-item {
        margin: 0.25rem 0;
      }

      .dropdown-menu {
        box-shadow: none;
        margin-top: 0;
      }

      .dropdown-item {
        padding: 0.75rem 1.5rem;
      }
    }

    @media (max-width: 576px) {
      .search-input {
        padding-left: 2.5rem;
        font-size: 0.9rem;
      }

      .search-icon {
        left: 1rem;
      }

      .navbar {
        padding: 0.5rem;
      }

      .navbar-brand img {
        height: 40px;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="bhome.php">
        <img src="../auth/agro.png" alt="AgroBazaar Logo">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContent">
        <div class="search-container">
          <form action="SearchResult.php" method="get" class="search-form">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" name="search" placeholder="Search for fruits, vegetables or crops"
              aria-label="Search">
          </form>
        </div>

        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-cog me-1"></i> Settings
            </a>
            <ul class="dropdown-menu" aria-labelledby="settingsDropdown">
              <?php if (isset($_SESSION['phonenumber'])): ?>
              <li><a class="dropdown-item" href="bhome.php"><i class="fas fa-home me-2"></i> Home</a></li>
              <li><a class="dropdown-item" href="Transaction.php"><i class="fas fa-exchange-alt me-2"></i> Transactions</a></li>
             
              <li><a class="dropdown-item" href="farmers.php"><i class="fas fa-users me-2"></i> Farmers</a></li>
              <?php endif; ?>
            </ul>
          </li>

          <li class="nav-item">
            <a class="nav-link position-relative" href="CartPage.php">
              <i class="fas fa-shopping-cart cart-icon"></i>
              <span class="cart-badge"><?php echo totalItems(); ?></span>
            </a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              <i class="far fa-user-circle profile-icon"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
              <?php if (isset($_SESSION['phonenumber'])): ?>
              <li><a class="dropdown-item" href="BuyerProfile.php"><i class="fas fa-user-edit me-2"></i> Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="../Includes/logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
              <?php else: ?>
              <li><a class="dropdown-item" href="../auth/BuyerLogin.php"><i class="fas fa-sign-in-alt me-2"></i> Login</a></li>
              <?php endif; ?>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize all dropdowns
      var dropdownElements = document.querySelectorAll('.dropdown-toggle');
      dropdownElements.forEach(function(dropdownToggleEl) {
        dropdownToggleEl.addEventListener('click', function(e) {
          e.preventDefault();
          var dropdown = new bootstrap.Dropdown(dropdownToggleEl);
          dropdown.toggle();
        });
      });

      // Change icon color on input focus
      const searchInput = document.querySelector('.search-input');
      const searchIcon = document.querySelector('.search-icon');

      if (searchInput && searchIcon) {
        searchInput.addEventListener('focus', () => {
          searchIcon.style.color = 'var(--primary-green)';
        });

        searchInput.addEventListener('blur', () => {
          searchIcon.style.color = '#6c757d';
        });
      }

      // Navbar scroll shrink
      const navbar = document.querySelector('.navbar');
      if (navbar) {
        window.addEventListener('scroll', () => {
          if (window.scrollY > 20) {
            navbar.style.padding = '0.5rem 1rem';
            navbar.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
          } else {
            navbar.style.padding = '0.75rem 1rem';
            navbar.style.boxShadow = '0 2px 15px rgba(0, 0, 0, 0.1)';
          }
        });
      }

      // Collapse navbar on link click (except dropdowns)
      const navLinks = document.querySelectorAll('.nav-link:not(.dropdown-toggle)');
      const navbarCollapse = document.querySelector('.navbar-collapse');
      
      if (navbarCollapse) {
        const bsCollapse = new bootstrap.Collapse(navbarCollapse, { toggle: false });
        
        navLinks.forEach(link => {
          link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
              bsCollapse.hide();
            }
          });
        });
      }
    });
  </script>
</body>
</html>