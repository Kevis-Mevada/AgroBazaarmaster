<?php
include("../Includes/db.php");

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['phonenumber'])) {
    header("Location: ../auth/FarmerLogin.php");
    exit();
}

$sessphonenumber = $_SESSION['phonenumber'];
$error = '';

// Sample states and districts data (replace with your actual data source)
$states = [
    'California' => ['Los Angeles', 'San Francisco', 'San Diego'],
    'Texas' => ['Houston', 'Dallas', 'Austin'],
    'New York' => ['New York City', 'Buffalo', 'Rochester']
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    try {
        // Get form data
        $name = $_POST['name'];
        $address = $_POST['address'];
        $state = $_POST['state'];
        $district = $_POST['district'];
        $pan = $_POST['pan'];
        $bank = $_POST['bank'];
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

        // Prepare update query
        if ($password) {
            $stmt = $con->prepare("UPDATE farmerregistration SET 
                                farmer_name = ?,
                                farmer_address = ?,
                                farmer_state = ?,
                                farmer_district = ?,
                                farmer_pan = ?,
                                farmer_bank = ?,
                                farmer_password = ?
                                WHERE farmer_phone = ?");
            $stmt->bind_param("ssssssss", $name, $address, $state, $district, $pan, $bank, $password, $sessphonenumber);
        } else {
            $stmt = $con->prepare("UPDATE farmerregistration SET 
                                farmer_name = ?,
                                farmer_address = ?,
                                farmer_state = ?,
                                farmer_district = ?,
                                farmer_pan = ?,
                                farmer_bank = ?
                                WHERE farmer_phone = ?");
            $stmt->bind_param("sssssss", $name, $address, $state, $district, $pan, $bank, $sessphonenumber);
        }
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Profile updated successfully!";
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Profile updated successfully!',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    window.location.href = 'FarmerProfile.php';
                });
            </script>";
            exit();
        } else {
            $error = "Error updating profile: " . $stmt->error;
        }
        
        $stmt->close();
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Get current profile data
try {
    $stmt = $con->prepare("SELECT * FROM farmerregistration WHERE farmer_phone = ?");
    $stmt->bind_param("s", $sessphonenumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    
    if (!$row) {
        throw new Exception("Profile data not found");
    }
} catch (Exception $e) {
    $error = "Error fetching profile: " . $e->getMessage();
    $row = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Farmer Profile</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary-color: #28a745;
            --secondary-color: #ffc107;
            --dark-color: #343a40;
            --light-bg: #f8f9fa;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-color);
            padding-top: 70px;
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
        }
        
        .field-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }
        
        .field-label i {
            margin-right: 10px;
            font-size: 1.1rem;
            color: var(--primary-color);
        }
        
        .form-control, .form-select {
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
        }
        
        .btn-update {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: block;
            margin: 2rem auto 0;
        }
        
        .btn-update:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-cancel {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: block;
            margin: 1rem auto 0;
        }
        
        .btn-cancel:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .password-wrapper {
            position: relative;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .profile-card {
                padding: 1.5rem;
            }
        }
        
        .alert {
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <?php include("../layout/farmernav.php"); ?>
    
    <div class="profile-container">
        <div class="profile-header">
            <h2><i class="fas fa-user-edit me-2"></i>Edit Farmer Profile</h2>
        </div>
        
        <?php if (!empty($error)): ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '<?php echo addslashes($error); ?>',
                    confirmButtonColor: '#dc3545'
                });
            </script>
        <?php endif; ?>
        
        <div class="profile-card">
            <form method="POST" action="" id="profileForm">
                <div class="profile-field">
                    <label class="field-label"><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($row['farmer_name'] ?? ''); ?>" required>
                </div>
                
                <div class="profile-field">
                    <label class="field-label"><i class="fas fa-phone-alt"></i> Phone Number</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['farmer_phone'] ?? ''); ?>" readonly>
                </div>
                
                <div class="profile-field">
                    <label class="field-label"><i class="fas fa-home"></i> Address</label>
                    <textarea class="form-control" name="address" rows="3" required><?php echo htmlspecialchars($row['farmer_address'] ?? ''); ?></textarea>
                </div>
                
                <div class="profile-field">
                    <label class="field-label"><i class="fas fa-map-marker-alt"></i> State</label>
                    <select class="form-select" name="state" id="state" required>
                        <option value="">Select State</option>
                        <?php foreach ($states as $state => $districts): ?>
                            <option value="<?php echo htmlspecialchars($state); ?>" 
                                <?php echo (isset($row['farmer_state']) && $row['farmer_state'] == $state) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($state); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="profile-field">
                    <label class="field-label"><i class="fas fa-map-marked-alt"></i> District</label>
                    <select class="form-select" name="district" id="district" required>
                        <option value="">Select District</option>
                        <?php 
                        if (isset($row['farmer_state']) && array_key_exists($row['farmer_state'], $states)) {
                            foreach ($states[$row['farmer_state']] as $district) {
                                echo '<option value="' . htmlspecialchars($district) . '" ' . 
                                    ((isset($row['farmer_district']) && $row['farmer_district'] == $district) ? 'selected' : '') . '>' . 
                                    htmlspecialchars($district) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="profile-field">
                    <label class="field-label"><i class="fas fa-id-card"></i> PAN Number</label>
                    <input type="text" class="form-control" name="pan" value="<?php echo htmlspecialchars($row['farmer_pan'] ?? ''); ?>" required>
                </div>
                
                <div class="profile-field">
                    <label class="field-label"><i class="fas fa-university"></i> Bank Account Number</label>
                    <input type="text" class="form-control" name="bank" value="<?php echo htmlspecialchars($row['farmer_bank'] ?? ''); ?>" required>
                </div>
                
                <div class="profile-field">
                    <label class="field-label"><i class="fas fa-lock"></i> New Password (leave blank to keep current)</label>
                    <div class="password-wrapper">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter new password">
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                </div>
                
                <div class="text-center">
                    <button type="submit" name="update_profile" class="btn btn-update">
                        <i class="fas fa-save me-2"></i> Update Profile
                    </button>
                    <a href="FarmerProfile.php" class="btn btn-cancel">
                        <i class="fas fa-times me-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <?php include("../layout/footer.php"); ?>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // State and district dropdown interaction
        const stateSelect = document.getElementById('state');
        const districtSelect = document.getElementById('district');
        
        // Sample districts data (replace with your actual data structure)
        const districtsData = {
            <?php
            $stateEntries = [];
            foreach ($states as $state => $districts) {
                $stateEntries[] = json_encode($state) . ': ' . json_encode($districts);
            }
            echo implode(",\n", $stateEntries);
            ?>
        };
        
        stateSelect.addEventListener('change', function() {
            const selectedState = this.value;
            districtSelect.innerHTML = '<option value="">Select District</option>';
            
            if (selectedState && districtsData[selectedState]) {
                districtsData[selectedState].forEach(district => {
                    const option = document.createElement('option');
                    option.value = district;
                    option.textContent = district;
                    districtSelect.appendChild(option);
                });
            }
        });
        
        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
        
        // Form validation
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            if (password && password.length < 8) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Password Too Short',
                    text: 'Password must be at least 8 characters long',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
        
        // Show success message if exists
        <?php if (isset($_SESSION['success'])): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?php echo addslashes($_SESSION['success']); ?>',
                confirmButtonColor: '#28a745'
            });
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
    </script>
</body>
</html>