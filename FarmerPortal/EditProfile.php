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
    'ANDAMAN & NICOBAR ISLANDS' => ['Andamans', 'Nicobars'],
  'ANDHRA PRADESH' => ['Adilabad', 'Nizamabad', 'Karimnagar', 'Medak', 'Hyderabad', 'Rangareddi', 'Mahbubnagar', 'Nalgonda', 'Warangal', 'Khammam', 'Srikakulam', 'Vizianagaram', 'Visakhapatnam', 'East Godavari', 'West Godavari', 'Krishna', 'Guntur', 'Prakasam', 'Nellore', 'Cuddapah', 'Kurnool', 'Anantapur', 'Chittoor'],
  'ASSAM' => ['Kokrajhar', 'Dhubri', 'Goalpara', 'Bongaigaon', 'Barpeta', 'Kamrup', 'Nalbari', 'Darrang', 'Marigaon', 'Nagaon', 'Sonitpur', 'Lakhimpur', 'Dhemaji', 'Tinsukia', 'Dibrugarh', 'Sibsagar', 'Jorhat', 'Golaghat', 'Karbi Anglong', 'North Cachar Hills', 'Cachar', 'Karimganj', 'Hailakandi'],
  'BIHAR' => ['Pashchim Champaran', 'Purba Champaran', 'Sheohar *', 'Sitamarhi', 'Madhubani', 'Supaul *', 'Araria', 'Kishanganj', 'Purnia', 'Katihar', 'Madhepura', 'Saharsa', 'Darbhanga', 'Muzaffarpur', 'Gopalganj', 'Siwan', 'Saran', 'Vaishali', 'Samastipur', 'Begusarai', 'Khagaria', 'Bhagalpur', 'Banka *', 'Munger', 'Lakhisarai *', 'Sheikhpura *', 'Nalanda', 'Patna', 'Bhojpur', 'Buxar *', 'Kaimur (Bhabua) *', 'Rohtas', 'Jehanabad ', 'Aurangabad', 'Gaya', 'Nawada', 'Jamui *'],
  'GUJARAT' => ['Kachchh', 'Banas Kantha', 'Patan  *', 'Mahesana', 'Sabar Kantha', 'Gandhinagar', 'Ahmadabad', 'Surendranagar', 'Rajkot', 'Jamnagar', 'Porbandar  *', 'Junagadh', 'Amreli', 'Bhavnagar', 'Anand  *', 'Kheda', 'Panch Mahals', 'Dohad  *', 'Vadodara', 'Narmada  *', 'Bharuch', 'Surat', 'The Dangs', 'Navsari  *', 'Valsad'],
  'HARYANA' => ['Panchkula *', 'Ambala', 'Yamunanagar', 'Kurukshetra', 'Kaithal', 'Karnal', 'Panipat', 'Sonipat', 'Jind', 'Fatehabad *', 'Sirsa', 'Hisar', 'Bhiwani', 'Rohtak', 'Jhajjar *', 'Mahendragarh', 'Rewari', 'Gurgaon', 'Faridabad'],
  'HIMACHAL PRADESH' => ['Chamba', 'Kangra', 'Lahul & Spiti', 'Kullu', 'Mandi', 'Hamirpur', 'Una', 'Bilaspur', 'Solan', 'Sirmaur', 'Shimla', 'Kinnaur'],
  'JAMMU AND KASHMIR' => ['Kupwara', 'Baramula', 'Srinagar', 'Badgam', 'Pulwama', 'Anantnag', 'Leh (Ladakh)', 'Kargil', 'Doda', 'Udhampur', 'Punch', 'Rajauri', 'Jammu', 'Kathua'],
  'KARNATAKA' => ['Belgaum', 'Bagalkot *', 'Bijapur', 'Gulbarga', 'Bidar', 'Raichur', 'Koppal *', 'Gadag *', 'Dharwad', 'Uttara Kannada', 'Haveri *', 'Bellary', 'Chitradurga', 'Davangere*', 'Shimoga', 'Udupi *', 'Chikmagalur', 'Tumkur', 'Kolar', 'Bangalore', 'Bangalore Rural', 'Mandya', 'Hassan', 'Dakshina Kannada', 'Kodagu', 'Mysore', 'Chamrajnagar*'],
  'KERALA' => ['Kasaragod', 'Kannur', 'Wayanad', 'Kozhikode', 'Malappuram', 'Palakkad', 'Thrissur', 'Ernakulam', 'Idukki', 'Kottayam', 'Alappuzha', 'Pathanamthitta', 'Kollam', 'Thiruvananthapuram'],
  'MADHYA PRADESH' => ['Sheopur *', 'Morena', 'Bhind', 'Gwalior', 'Datia', 'Shivpuri', 'Guna', 'Tikamgarh', 'Chhatarpur', 'Panna', 'Sagar', 'Damoh', 'Satna', 'Rewa', 'Umaria *', 'Shahdol', 'Sidhi', 'Neemuch *', 'Mandsaur', 'Ratlam', 'Ujjain', 'Shajapur', 'Dewas', 'Jhabua', 'Dhar', 'Indore', 'West Nimar', 'Barwani *', 'East Nimar', 'Rajgarh', 'Vidisha', 'Bhopal', 'Sehore', 'Raisen', 'Betul', 'Harda *', 'Hoshangabad', 'Katni *', 'Jabalpur', 'Narsimhapur', 'Dindori *', 'Mandla', 'Chhindwara', 'Seoni', 'Balaghat'],
  'MAHARASHTRA' => ['Nandurbar *', 'Dhule', 'Jalgaon', 'Buldana', 'Akola', 'Washim *', 'Amravati', 'Wardha', 'Nagpur', 'Bhandara', 'Gondiya *', 'Gadchiroli', 'Chandrapur', 'Yavatmal', 'Nanded', 'Hingoli *', 'Parbhani', 'Jalna', 'Aurangabad', 'Nashik', 'Thane', 'Mumbai (Suburban) *', 'Mumbai', 'Raigarh', 'Pune', 'Ahmadnagar', 'Bid', 'Latur', 'Osmanabad', 'Solapur', 'Satara', 'Ratnagiri', 'Sindhudurg', 'Kolhapur', 'Sangli'],
  'TAMIL NADU' => ['Thiruvallur', 'Chennai', 'Kancheepuram', 'Vellore', 'Dharmapuri', 'Tiruvannamalai', 'Viluppuram', 'Salem', 'Namakkal   *', 'Erode', 'The Nilgiris', 'Coimbatore', 'Dindigul', 'Karur  *', 'Tiruchirappalli', 'Perambalur  *', 'Ariyalur  *', 'Cuddalore', 'Nagapattinam  *', 'Thiruvarur', 'Thanjavur', 'Pudukkottai', 'Sivaganga', 'Madurai', 'Theni  *', 'Virudhunagar', 'Ramanathapuram', 'Thoothukkudi', 'Tirunelveli ', 'Kanniyakumari'],
  'PUDUCHERRY' => ['Yanam', 'Pondicherry', 'Mahe', 'Karaikal'],
  'LAKSHADWEEP' => ['Lakshadweep'],
  'GOA' => ['North Goa ', 'South Goa'],
  'DADRA AND NAGAR HAVELI' => ['Dadra & Nagar Haveli'],
  'DAMAN AND DIU' => ['Diu', 'Daman'],
  'CHHATTISGARH' => ['Koriya *', 'Surguja', 'Jashpur *', 'Raigarh', 'Korba *', 'Janjgir - Champa*', 'Bilaspur', 'Kawardha *', 'Rajnandgaon', 'Durg', 'Raipur', 'Mahasamund *', 'Dhamtari *', 'Kanker *', 'Baster', 'Dantewada*'],
  'JHARKAND' => ['Garhwa *', 'Palamu', 'Chatra *', 'Hazaribag', 'Kodarma *', 'Giridih', 'Deoghar', 'Godda', 'Sahibganj', 'Pakaur *', 'Dumka', 'Dhanbad', 'Bokaro *', 'Ranchi', 'Lohardaga', 'Gumla', 'Pashchimi Singhbhum', 'Purbi Singhbhum'],
  'ORISSA' => ['Bargarh  *', 'Jharsuguda  *', 'Sambalpur', 'Debagarh  *', 'Sundargarh', 'Kendujhar', 'Mayurbhanj', 'Baleshwar', 'Bhadrak  *', 'Kendrapara *', 'Jagatsinghapur  *', 'Cuttack', 'Jajapur  *', 'Dhenkanal', 'Anugul  *', 'Nayagarh  *', 'Khordha  *', 'Puri', 'Ganjam', 'Gajapati  *', 'Kandhamal', 'Baudh  *', 'Sonapur  *', 'Balangir', 'Nuapada  *', 'Kalahandi', 'Rayagada  *', 'Nabarangapur  *', 'Koraput', 'Malkangiri  *'],
  'WEST BENGAL' => ['Darjiling ', 'Jalpaiguri ', 'Koch Bihar ', 'Uttar Dinajpur', 'Dakshin Dinajpur *', 'Maldah ', 'Murshidabad ', 'Birbhum', 'Barddhaman ', 'Nadia ', 'North Twenty Four Parganas', 'Hugli ', 'Bankura ', 'Puruliya', 'Medinipur ', 'Haora ', 'Kolkata', 'South  Twenty Four Parganas'],
  'MEGHALAYA' => ['West Garo Hills', 'East Garo Hills', 'South Garo Hills *', 'West Khasi Hills', 'Ri Bhoi  *', 'East Khasi Hills', 'Jaintia Hills'],
  'SIKKIM' => ['North ', 'West', 'South', 'East'],
  'UTTAR PRADESH' => ['Saharanpur', 'Muzaffarnagar', 'Bijnor', 'Moradabad', 'Rampur', 'Jyotiba Phule Nagar *', 'Meerut', 'Baghpat *', 'Ghaziabad', 'Gautam Buddha Nagar *', 'Bulandshahr', 'Aligarh', 'Hathras *', 'Mathura', 'Agra', 'Firozabad', 'Etah', 'Mainpuri', 'Budaun', 'Bareilly', 'Pilibhit', 'Shahjahanpur', 'Kheri', 'Sitapur', 'Hardoi', 'Unnao', 'Lucknow', 'Rae Bareli', 'Farrukhabad', 'Kannauj *', 'Etawah', 'Auraiya *', 'Kanpur Dehat', 'Kanpur Nagar', 'Jalaun ', 'Jhansi', 'Lalitpur', 'Hamirpur', 'Mahoba *', 'Banda', 'Chitrakoot *', 'Fatehpur', 'Pratapgarh', 'Kaushambi *', 'Allahabad ', 'Barabanki', 'Faizabad', 'Ambedkar Nagar *', 'Sultanpur', 'Bahraich', 'Shrawasti *', 'Balrampur *', 'Gonda', 'Siddharthnagar', 'Basti', 'Sant Kabir Nagar *', 'Maharajganj', 'Gorakhpur', 'Kushinagar *', 'Deoria', 'Azamgarh', 'Mau', 'Ballia', 'Jaunpur', 'Ghazipur', 'Chandauli *', 'Varanasi', 'Sant Ravidas Nagar *', 'Mirzapur', 'Sonbhadra'],
  'RAJASTHAN' => ['Ganganagar', 'Hanumangarh *', 'Bikaner', 'Churu', 'Jhunjhunun', 'Alwar', 'Bharatpur', 'Dhaulpur', 'Karauli *', 'Sawai Madhopur', 'Dausa *', 'Jaipur', 'Sikar', 'Nagaur', 'Jodhpur', 'Jaisalmer', 'Barmer', 'Jalor', 'Sirohi', 'Pali', 'Ajmer', 'Tonk', 'Bundi', 'Bhilwara', 'Rajsamand *', 'Udaipur', 'Dungarpur', 'Banswara', 'Chittaurgarh', 'Kota', 'Baran *', 'Jhalawar'],
  'PUNJAB' => ['Gurdaspur', 'Amritsar', 'Kapurthala', 'Jalandhar', 'Hoshiarpur', 'Nawanshahr *', 'Rupnagar', 'Fatehgarh Sahib *', 'Ludhiana', 'Moga *', 'Firozpur', 'Muktsar *', 'Faridkot', 'Bathinda', 'Mansa *', 'Sangrur', 'Patiala'],
  'NAGALAND' => ['Mon', 'Tuensang', 'Mokokchung', 'Zunheboto', 'Wokha', 'Dimapur *', 'Kohima', 'Phek'],
  'MANIPUR' => ['Senapati', 'Tamenglong', 'Churachandpur', 'Bishnupur', 'Thoubal', 'Imphal West', 'Imphal East *', 'Ukhrul', 'Chandel'],
  'TRIPURA' => ['West Tripura ', 'South Tripura ', 'Dhalai  *', 'North Tripura '],
  'MIZORAM' => ['Mamit *', 'Kolasib *', 'Aizawl', 'Champhai *', 'Serchhip *', 'Lunglei', 'Lawngtlai', 'Saiha *'],
  'ARUNACHAL PRADESH' => ['Tawang', 'West Kameng', 'East Kameng', 'Papum Pare *', 'Lower Subansiri', 'Upper Subansiri', 'West Siang', 'East Siang', 'Upper Siang *', 'Dibang Valley', 'Lohit', 'Changlang', 'Tirap'],
  'CHANDIGARH' => ['Chandigarh'],
  'DELHI' => ['North West   *', 'North   *', 'North East   *', 'East   *', 'New Delhi', 'Central  *', 'West   *', 'South West   *', 'South  *'],
  'UTTARAKHAND' => ['Uttarkashi', 'Chamoli', 'Rudraprayag *', 'Tehri Garhwal', 'Dehradun', 'Garhwal', 'Pithoragarh', 'Bageshwar', 'Almora', 'Champawat', 'Nainital', 'Udham Singh Nagar *', 'Hardwar']
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
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Profile updated successfully!'
            ];
            header('Location: FarmerProfile2.php');
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
// try {
//     $stmt = $con->prepare("SELECT * FROM farmerregistration WHERE farmer_phone = ?");
//     $stmt->bind_param("s", $sessphonenumber);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $row = $result->fetch_assoc();
//     $stmt->close();
    
//     if (!$row) {
//         throw new Exception("Profile data not found");
//     }
// } catch (Exception $e) {
//     $error = "Error fetching profile: " . $e->getMessage();
//     $row = [];
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    
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
            /* padding-top: 70px; */
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
    <?php include("../layout/farmernav.php"); 
    $sql = "select * from farmerregistration where farmer_phone = $sessphonenumber";
    $run_query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($run_query)) {
        $name = $row['farmer_name'];
        $pan = $row['farmer_pan'];
        $phone = $row['farmer_phone'];
        $address = $row['farmer_address'];
        $account = $row['farmer_bank'];
        $currentstate = $row['farmer_state'];
        $currentdistrict = $row['farmer_district'];
    }
    print_r($row)
    ?>
    
    <div class="profile-container">
        <div class="profile-header">
            <h2><i class="fas fa-user-edit me-2"></i>Edit Profile</h2>
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
                    <input type="text" id="farmer_name" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
                
                <div class="profile-field">
                    <label class="field-label"><i class="fas fa-phone-alt"></i> Phone Number</label>
                    <input type="text" id="farmer_phone" name="number" class="form-control" value="<?php echo $phone; ?>" readonly>
                </div>
                
                <div class="profile-field">
                    <label class="field-label"><i class="fas fa-home"></i> Address</label>
                    <textarea class="form-control" id="farmer_address" name="address" rows="3"><?php echo $address; ?></textarea>
                </div>
                
                <div class="profile-field">
                    <label class="field-label"><i class="fas fa-map-marker-alt"></i> State</label>
                    <select class="form-select" name="state" id="state">
                        <option value="">Select State</option>
                        <?php foreach ($states as $state => $districts): ?>
                            <option value="<?php echo $state; ?>" 
                                <?php echo (isset($currentstate) && $currentstate == $state) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($state); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="profile-field">
                    <label class="field-label"><i class="fas fa-map-marked-alt"></i> District</label>
                    <select class="form-select" name="district" id="district">
                        <option value="">Select District</option>   
                        <?php 
                        if (isset($currentstate) && array_key_exists($currentstate, $states)) {
                            foreach ($states[$currentstate] as $district) {
                                echo '<option value="' . htmlspecialchars($district) . '" ' . 
                                    ((isset($currentdistrict) && $currentdistrict == $district) ? 'selected' : '') . '>' . 
                                    htmlspecialchars($district) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="profile-field">
                    <label class="field-label"><i class="fas fa-id-card"></i> PAN Number</label>
                    <input type="text" class="form-control" id="farmer_pan" name="pan" value="<?php echo $pan; ?>">
                </div>
                
                <div class="profile-field">
                    <label class="field-label"><i class="fas fa-university"></i> Bank Account Number</label>
                    <input type="text" class="form-control" id="farmer_bank" name="bank" value="<?php echo $account; ?>">
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
                    <a href="FarmerProfile2.php" class="btn btn-cancel">
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