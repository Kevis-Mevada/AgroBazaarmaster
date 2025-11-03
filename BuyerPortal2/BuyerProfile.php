<?php
include("../Includes/db.php");
session_start();
$sessphonenumber = $_SESSION['phonenumber'];

// Handle form submission for profile updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    // Sanitize and validate input data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $address = mysqli_real_escape_string($con, $_POST['address']);


    $comp = mysqli_real_escape_string($con, $_POST['comp']);

    $mail = mysqli_real_escape_string($con, $_POST['mail']);
    
    // Update query
    $update_sql = "UPDATE buyerregistration SET 
                  buyer_name = '$name',
                  buyer_addr = '$address',
                  
                  
                  buyer_comp = '$comp',
                  
                  buyer_mail = '$mail'
                  WHERE buyer_phone = '$sessphonenumber'";
    
    if (mysqli_query($con, $update_sql)) {
        $success_message = "Profile updated successfully!";
    } else {
        $error_message = "Error updating profile: " . mysqli_error($con);
    }
}

// Fetch current profile data
$sql = "SELECT * FROM buyerregistration WHERE buyer_phone = '$sessphonenumber'";
$run_query = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($run_query)) {
    $name = $row['buyer_name'];
    $phone = $row['buyer_phone'];
    $address = $row['buyer_addr'];
    $pan = $row['buyer_pan'];
    $bank = $row['buyer_bank'];
    $comp = $row['buyer_comp'];
    $license = $row['buyer_license'];
    $mail = $row['buyer_mail'];
    $user = $row['buyer_username'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Buyer Profile</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        .main-content {
            flex: 1;
            padding: 2rem 0;
        }
        
        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding-top: 20px;
        }
        
        .profile-card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 2rem;
            margin-top: 20px;
        }
        
        .profile-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 1.5rem;
        }
        
        .profile-body {
            padding: 2rem;
        }
        
        .profile-field {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }
        
        .profile-field:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .field-label {
            font-weight: 600;
            color: #28a745;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .field-value {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 0.8rem 1rem;
            border-left: 4px solid #28a745;
            font-size: 1rem;
            word-break: break-word;
        }
        
        .btn-edit {
            background-color: #20c997;
            border: none;
            padding: 0.8rem 2rem;
            font-weight: 600;
            transition: all 0.3s;
            border-radius: 50px;
            font-size: 1rem;
            margin-top: 1rem;
        }
        
        .btn-edit:hover {
            background-color: #1aa179;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .edit-mode .field-value {
            background-color: white;
            padding: 0;
            border-left: none;
        }
        
        .edit-mode input, .edit-mode textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        
        .edit-buttons {
            display: none;
        }
        
        .edit-mode .edit-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }
        
        /* Success modal */
        .success-modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 1050;
            display: none;
            max-width: 400px;
            width: 90%;
            text-align: center;
        }
        
        .success-modal.show {
            display: block;
            animation: fadeIn 0.3s;
        }
        
        .success-modal .checkmark {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 1rem;
        }
        
        .success-modal h3 {
            color: #28a745;
            margin-bottom: 1rem;
        }
        
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
        }
        
        .overlay.show {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @media (max-width: 768px) {
            .profile-header {
                padding: 1rem;
            }
            
            .profile-header h2 {
                font-size: 1.5rem;
            }
            
            .profile-body {
                padding: 1.5rem;
            }
            
            .field-value {
                padding: 0.6rem 0.8rem;
                font-size: 0.9rem;
            }
            
            .btn-edit {
                padding: 0.6rem 1.5rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
   

    <div class="main-content">
        <div class="container profile-container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="profile-card" id="profileCard">
                        <div class="profile-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="mb-0"><i class="fas fa-user-circle me-2"></i> BUYER PROFILE</h2>
                                <a href="../BuyerPortal2/bhome.php" class="btn btn-light">
                                    <i class="fas fa-home me-1"></i> Back to Home
                                </a>
                            </div>
                        </div>
                        
                        <div class="profile-body">
                            <form id="profileForm" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="profile-field">
                                            <div class="field-label">Name</div>
                                            <div class="field-value">
                                                <span class="display-value"><?php echo htmlspecialchars($name); ?></span>
                                                <input type="text" name="name" class="edit-value form-control" value="<?php echo htmlspecialchars($name); ?>" style="display: none;">
                                            </div>
                                            <div class="edit-buttons">
                                                <button type="button" class="btn btn-sm btn-outline-secondary cancel-edit">Cancel</button>
                                            </div>
                                        </div>
                                        
                                        <div class="profile-field">
                                            <div class="field-label">User Name</div>
                                            <div class="field-value"><?php echo htmlspecialchars($user); ?></div>
                                        </div>
                                        
                                        <div class="profile-field">
                                            <div class="field-label">Phone Number</div>
                                            <div class="field-value"><?php echo htmlspecialchars($phone); ?></div>
                                        </div>
                                        
                                        <div class="profile-field">
                                            <div class="field-label">Address</div>
                                            <div class="field-value">
                                                <span class="display-value"><?php echo htmlspecialchars($address); ?></span>
                                                <textarea name="address" class="edit-value form-control" style="display: none;"><?php echo htmlspecialchars($address); ?></textarea>
                                            </div>
                                            <div class="edit-buttons">
                                                <button type="button" class="btn btn-sm btn-outline-secondary cancel-edit">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                       
                                        
                                        
                                        <div class="profile-field">
                                            <div class="field-label">Company(optional)</div>
                                            <div class="field-value">
                                                <span class="display-value"><?php echo htmlspecialchars($comp); ?></span>
                                                <input type="text" name="comp" class="edit-value form-control" value="<?php echo htmlspecialchars($comp); ?>" style="display: none;">
                                            </div>
                                            <div class="edit-buttons">
                                                <button type="button" class="btn btn-sm btn-outline-secondary cancel-edit">Cancel</button>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="profile-field">
                                            <div class="field-label">Email</div>
                                            <div class="field-value">
                                                <span class="display-value"><?php echo htmlspecialchars($mail); ?></span>
                                                <input type="email" name="mail" class="edit-value form-control" value="<?php echo htmlspecialchars($mail); ?>" style="display: none;">
                                            </div>
                                            <div class="edit-buttons">
                                                <button type="button" class="btn btn-sm btn-outline-secondary cancel-edit">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center mt-4">
                                    <button type="button" id="editProfileBtn" class="btn btn-edit btn-lg">
                                        <i class="fas fa-edit me-2"></i> Edit Profile
                                    </button>
                                    <button type="submit" name="update_profile" id="saveProfileBtn" class="btn btn-success btn-lg" style="display: none;">
                                        <i class="fas fa-save me-2"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="overlay" id="overlay"></div>
    <div class="success-modal" id="successModal">
        <div class="checkmark">
            <i class="fas fa-check-circle"></i>
        </div>
        <h3>Success!</h3>
        <p><?php echo isset($success_message) ? $success_message : 'Profile updated successfully!'; ?></p>
        <button class="btn btn-success" onclick="hideSuccessModal()">OK</button>
    </div>

    
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Enable edit mode
        document.getElementById('editProfileBtn').addEventListener('click', function() {
            const profileCard = document.getElementById('profileCard');
            profileCard.classList.add('edit-mode');
            document.getElementById('editProfileBtn').style.display = 'none';
            document.getElementById('saveProfileBtn').style.display = 'inline-block';
            
            // Show all edit inputs
            document.querySelectorAll('.edit-value').forEach(input => {
                input.style.display = 'block';
            });
            
            // Hide all display values
            document.querySelectorAll('.display-value').forEach(span => {
                span.style.display = 'none';
            });
            
            // Show all edit buttons
            document.querySelectorAll('.edit-buttons').forEach(div => {
                div.style.display = 'flex';
            });
        });
        
        // Cancel edit buttons
        document.querySelectorAll('.cancel-edit').forEach(button => {
            button.addEventListener('click', function() {
                const fieldContainer = this.closest('.profile-field');
                const displayValue = fieldContainer.querySelector('.display-value');
                const editValue = fieldContainer.querySelector('.edit-value');
                
                // Revert to original value
                editValue.value = displayValue.textContent;
                
                // Hide edit input and show display value
                editValue.style.display = 'none';
                displayValue.style.display = 'inline';
                
                // Hide edit buttons
                fieldContainer.querySelector('.edit-buttons').style.display = 'none';
            });
        });
        
        // Show success modal if there's a success message
        <?php if (isset($success_message)): ?>
        window.onload = function() {
            showSuccessModal();
        };
        <?php endif; ?>
        
        function showSuccessModal() {
            document.getElementById('overlay').classList.add('show');
            document.getElementById('successModal').classList.add('show');
        }
        
        function hideSuccessModal() {
            document.getElementById('overlay').classList.remove('show');
            document.getElementById('successModal').classList.remove('show');
        }
    </script>
</body>
</html>