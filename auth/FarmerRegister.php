<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Registration Portal</title>
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
            padding: 3rem; /* Increased padding */
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
            padding: 3rem; /* Increased padding */
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px; /* Adjusted margin */
        }

        .form-col {
            flex: 0 0 50%;
            padding: 0 15px; /* Adjusted padding */
        }

        .form-group {
            margin-bottom: 2rem; /* Increased margin for better spacing */
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
            margin: 2rem auto 0; /* Adjusted margin */
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
                padding: 1.5rem; /* Adjusted padding */
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
    <script>
        function state() {
            var a = document.getElementById('states').value;
            if (a === 'ANDAMAN & NICOBAR ISLANDS') {
                var array = ['Andamans', 'Nicobars'];
            } else if (a === 'ANDHRA PRADESH') {
                var array = ['Adilabad', 'Nizamabad', 'Karimnagar', 'Medak', 'Hyderabad', 'Rangareddi', 'Mahbubnagar', 'Nalgonda', 'Warangal', 'Khammam', 'Srikakulam', 'Vizianagaram', 'Visakhapatnam', 'East Godavari', 'West Godavari', 'Krishna', 'Guntur', 'Prakasam', 'Nellore', 'Cuddapah', 'Kurnool', 'Anantapur', 'Chittoor'];
            } else if (a === 'ASSAM') {
                var array = ['Kokrajhar', 'Dhubri', 'Goalpara', 'Bongaigaon', 'Barpeta', 'Kamrup', 'Nalbari', 'Darrang', 'Marigaon', 'Nagaon', 'Sonitpur', 'Lakhimpur', 'Dhemaji', 'Tinsukia', 'Dibrugarh', 'Sibsagar', 'Jorhat', 'Golaghat', 'Karbi Anglong', 'North Cachar Hills', 'Cachar', 'Karimganj', 'Hailakandi'];
            } else if (a === 'BIHAR') {
                var array = ['Pashchim Champaran', 'Purba Champaran', 'Sheohar *', 'Sitamarhi', 'Madhubani', 'Supaul *', 'Araria', 'Kishanganj', 'Purnia', 'Katihar', 'Madhepura', 'Saharsa', 'Darbhanga', 'Muzaffarpur', 'Gopalganj', 'Siwan', 'Saran', 'Vaishali', 'Samastipur', 'Begusarai', 'Khagaria', 'Bhagalpur', 'Banka *', 'Munger', 'Lakhisarai *', 'Sheikhpura *', 'Nalanda', 'Patna', 'Bhojpur', 'Buxar *', 'Kaimur (Bhabua) *', 'Rohtas', 'Jehanabad ', 'Aurangabad', 'Gaya', 'Nawada', 'Jamui *'];
            } else if (a === 'GUJARAT') {
                var array = ['Kachchh', 'Banas Kantha', 'Patan  *', 'Mahesana', 'Sabar Kantha', 'Gandhinagar', 'Ahmadabad', 'Surendranagar', 'Rajkot', 'Jamnagar', 'Porbandar  *', 'Junagadh', 'Amreli', 'Bhavnagar', 'Anand  *', 'Kheda', 'Panch Mahals', 'Dohad  *', 'Vadodara', 'Narmada  *', 'Bharuch', 'Surat', 'The Dangs', 'Navsari  *', 'Valsad'];
            } else if (a === 'HARYANA') {
                var array = ['Panchkula *', 'Ambala', 'Yamunanagar', 'Kurukshetra', 'Kaithal', 'Karnal', 'Panipat', 'Sonipat', 'Jind', 'Fatehabad *', 'Sirsa', 'Hisar', 'Bhiwani', 'Rohtak', 'Jhajjar *', 'Mahendragarh', 'Rewari', 'Gurgaon', 'Faridabad'];
            } else if (a === 'HIMACHAL PRADESH') {
                var array = ['Chamba', 'Kangra', 'Lahul & Spiti', 'Kullu', 'Mandi', 'Hamirpur', 'Una', 'Bilaspur', 'Solan', 'Sirmaur', 'Shimla', 'Kinnaur'];
            } else if (a === 'JAMMU AND KASHMIR') {
                var array = ['Kupwara', 'Baramula', 'Srinagar', 'Badgam', 'Pulwama', 'Anantnag', 'Leh (Ladakh)', 'Kargil', 'Doda', 'Udhampur', 'Punch', 'Rajauri', 'Jammu', 'Kathua'];
            } else if (a === 'KARNATAKA') {
                var array = ['Belgaum', 'Bagalkot *', 'Bijapur', 'Gulbarga', 'Bidar', 'Raichur', 'Koppal *', 'Gadag *', 'Dharwad', 'Uttara Kannada', 'Haveri *', 'Bellary', 'Chitradurga', 'Davangere*', 'Shimoga', 'Udupi *', 'Chikmagalur', 'Tumkur', 'Kolar', 'Bangalore', 'Bangalore Rural', 'Mandya', 'Hassan', 'Dakshina Kannada', 'Kodagu', 'Mysore', 'Chamrajnagar*'];
            } else if (a === 'KERALA') {
                var array = ['Kasaragod', 'Kannur', 'Wayanad', 'Kozhikode', 'Malappuram', 'Palakkad', 'Thrissur', 'Ernakulam', 'Idukki', 'Kottayam', 'Alappuzha', 'Pathanamthitta', 'Kollam', 'Thiruvananthapuram'];
            } else if (a === 'MADHYA PRADESH') {
                var array = ['Sheopur *', 'Morena', 'Bhind', 'Gwalior', 'Datia', 'Shivpuri', 'Guna', 'Tikamgarh', 'Chhatarpur', 'Panna', 'Sagar', 'Damoh', 'Satna', 'Rewa', 'Umaria *', 'Shahdol', 'Sidhi', 'Neemuch *', 'Mandsaur', 'Ratlam', 'Ujjain', 'Shajapur', 'Dewas', 'Jhabua', 'Dhar', 'Indore', 'West Nimar', 'Barwani *', 'East Nimar', 'Rajgarh', 'Vidisha', 'Bhopal', 'Sehore', 'Raisen', 'Betul', 'Harda *', 'Hoshangabad', 'Katni *', 'Jabalpur', 'Narsimhapur', 'Dindori *', 'Mandla', 'Chhindwara', 'Seoni', 'Balaghat'];
            } else if (a === 'MAHARASHTRA') {
                var array = ['Nandurbar *', 'Dhule', 'Jalgaon', 'Buldana', 'Akola', 'Washim *', 'Amravati', 'Wardha', 'Nagpur', 'Bhandara', 'Gondiya *', 'Gadchiroli', 'Chandrapur', 'Yavatmal', 'Nanded', 'Hingoli *', 'Parbhani', 'Jalna', 'Aurangabad', 'Nashik', 'Thane', 'Mumbai (Suburban) *', 'Mumbai', 'Raigarh', 'Pune', 'Ahmadnagar', 'Bid', 'Latur', 'Osmanabad', 'Solapur', 'Satara', 'Ratnagiri', 'Sindhudurg', 'Kolhapur', 'Sangli'];
            } else if (a === 'TAMIL NADU') {
                var array = ['Thiruvallur', 'Chennai', 'Kancheepuram', 'Vellore', 'Dharmapuri', 'Tiruvannamalai', 'Viluppuram', 'Salem', 'Namakkal   *', 'Erode', 'The Nilgiris', 'Coimbatore', 'Dindigul', 'Karur  *', 'Tiruchirappalli', 'Perambalur  *', 'Ariyalur  *', 'Cuddalore', 'Nagapattinam  *', 'Thiruvarur', 'Thanjavur', 'Pudukkottai', 'Sivaganga', 'Madurai', 'Theni  *', 'Virudhunagar', 'Ramanathapuram', 'Thoothukkudi', 'Tirunelveli ', 'Kanniyakumari'];
            } else if (a === 'PUDUCHERRY') {
                var array = ['Yanam', 'Pondicherry', 'Mahe', 'Karaikal'];
            } else if (a === 'LAKSHADWEEP') {
                var array = ['Lakshadweep'];
            } else if (a === 'GOA') {
                var array = ['North Goa ', 'South Goa'];
            } else if (a === 'DADRA AND NAGAR HAVELI') {
                var array = ['Dadra & Nagar Haveli'];
            } else if (a === 'DAMAN AND DIU') {
                var array = ['Diu', 'Daman'];
            } else if (a === 'CHHATTISGARH') {
                var array = ['Koriya *', 'Surguja', 'Jashpur *', 'Raigarh', 'Korba *', 'Janjgir - Champa*', 'Bilaspur', 'Kawardha *', 'Rajnandgaon', 'Durg', 'Raipur', 'Mahasamund *', 'Dhamtari *', 'Kanker *', 'Baster', 'Dantewada*'];
            } else if (a === 'JHARKAND') {
                var array = ['Garhwa *', 'Palamu', 'Chatra *', 'Hazaribag', 'Kodarma *', 'Giridih', 'Deoghar', 'Godda', 'Sahibganj', 'Pakaur *', 'Dumka', 'Dhanbad', 'Bokaro *', 'Ranchi', 'Lohardaga', 'Gumla', 'Pashchimi Singhbhum', 'Purbi Singhbhum', 'ORISSA', 'Bargarh  *', 'Jharsuguda  *', 'Sambalpur', 'Debagarh  *', 'Sundargarh', 'Kendujhar', 'Mayurbhanj', 'Baleshwar', 'Bhadrak  *', 'Kendrapara *', 'Jagatsinghapur  *', 'Cuttack', 'Jajapur  *', 'Dhenkanal', 'Anugul  *', 'Nayagarh  *', 'Khordha  *', 'Puri', 'Ganjam', 'Gajapati  *', 'Kandhamal', 'Baudh  *', 'Sonapur  *', 'Balangir', 'Nuapada  *', 'Kalahandi', 'Rayagada  *', 'Nabarangapur  *', 'Koraput', 'Malkangiri  *'];
            } else if (a === 'WEST BENGAL') {
                var array = ['Darjiling ', 'Jalpaiguri ', 'Koch Bihar ', 'Uttar Dinajpur', 'Dakshin Dinajpur *', 'Maldah ', 'Murshidabad ', 'Birbhum', 'Barddhaman ', 'Nadia ', 'North Twenty Four Parganas', 'Hugli ', 'Bankura ', 'Puruliya', 'Medinipur ', 'Haora ', 'Kolkata', 'South  Twenty Four Parganas'];
            } else if (a === 'MEGHALAYA') {
                var array = ['West Garo Hills', 'East Garo Hills', 'South Garo Hills *', 'West Khasi Hills', 'Ri Bhoi  *', 'East Khasi Hills', 'Jaintia Hills'];
            } else if (a === 'SIKKIM') {
                var array = ['North ', 'West', 'South', 'East'];
            } else if (a === 'UTTAR PRADESH') {
                var array = ['Saharanpur', 'Muzaffarnagar', 'Bijnor', 'Moradabad', 'Rampur', 'Jyotiba Phule Nagar *', 'Meerut', 'Baghpat *', 'Ghaziabad', 'Gautam Buddha Nagar *', 'Bulandshahr', 'Aligarh', 'Hathras *', 'Mathura', 'Agra', 'Firozabad', 'Etah', 'Mainpuri', 'Budaun', 'Bareilly', 'Pilibhit', 'Shahjahanpur', 'Kheri', 'Sitapur', 'Hardoi', 'Unnao', 'Lucknow', 'Rae Bareli', 'Farrukhabad', 'Kannauj *', 'Etawah', 'Auraiya *', 'Kanpur Dehat', 'Kanpur Nagar', 'Jalaun ', 'Jhansi', 'Lalitpur', 'Hamirpur', 'Mahoba *', 'Banda', 'Chitrakoot *', 'Fatehpur', 'Pratapgarh', 'Kaushambi *', 'Allahabad ', 'Barabanki', 'Faizabad', 'Ambedkar Nagar *', 'Sultanpur', 'Bahraich', 'Shrawasti *', 'Balrampur *', 'Gonda', 'Siddharthnagar', 'Basti', 'Sant Kabir Nagar *', 'Maharajganj', 'Gorakhpur', 'Kushinagar *', 'Deoria', 'Azamgarh', 'Mau', 'Ballia', 'Jaunpur', 'Ghazipur', 'Chandauli *', 'Varanasi', 'Sant Ravidas Nagar *', 'Mirzapur', 'Sonbhadra'];
            } else if (a === 'RAJASTHAN') {
                var array = ['Ganganagar', 'Hanumangarh *', 'Bikaner', 'Churu', 'Jhunjhunun', 'Alwar', 'Bharatpur', 'Dhaulpur', 'Karauli *', 'Sawai Madhopur', 'Dausa *', 'Jaipur', 'Sikar', 'Nagaur', 'Jodhpur', 'Jaisalmer', 'Barmer', 'Jalor', 'Sirohi', 'Pali', 'Ajmer', 'Tonk', 'Bundi', 'Bhilwara', 'Rajsamand *', 'Udaipur', 'Dungarpur', 'Banswara', 'Chittaurgarh', 'Kota', 'Baran *', 'Jhalawar'];
                //check
            } else if (a === 'PUNJAB') {
                var array = ['Gurdaspur', 'Amritsar', 'Kapurthala', 'Jalandhar', 'Hoshiarpur', 'Nawanshahr *', 'Rupnagar', 'Fatehgarh Sahib *', 'Ludhiana', 'Moga *', 'Firozpur', 'Muktsar *', 'Faridkot', 'Bathinda', 'Mansa *', 'Sangrur', 'Patiala'];
            } else if (a === 'NAGALAND') {
                var array = ['Mon', 'Tuensang', 'Mokokchung', 'Zunheboto', 'Wokha', 'Dimapur *', 'Kohima', 'Phek', 'MANIPUR', 'Senapati', 'Tamenglong', 'Churachandpur', 'Bishnupur', 'Thoubal', 'Imphal West', 'Imphal East *', 'Ukhrul', 'Chandel'];
            } else if (a === 'TRIPURA') {
                var array = ['West Tripura ', 'South Tripura ', 'Dhalai  *', 'North Tripura '];
            } else if (a === 'MIZORAM') {
                var array = ['Mamit *', 'Kolasib *', 'Aizawl', 'Champhai *', 'Serchhip *', 'Lunglei', 'Lawngtlai', 'Saiha *'];
            } else if (a === 'ARUNACHAL PRADESH') {
                var array = ['Tawang', 'West Kameng', 'East Kameng', 'Papum Pare *', 'Lower Subansiri', 'Upper Subansiri', 'West Siang', 'East Siang', 'Upper Siang *', 'Dibang Valley', 'Lohit', 'Changlang', 'Tirap'];
            } else if (a === 'CHANDIGARH') {
                var array = ['Chandigarh'];
            } else if (a === 'DELHI') {
                var array = ['North West   *', 'North   *', 'North East   *', 'East   *', 'New Delhi', 'Central  *', 'West   *', 'South West   *', 'South  *'];
            } else if (a === 'DELHI') {
                var array = ['Uttarkashi', 'Chamoli', 'Rudraprayag *', 'Tehri Garhwal', 'Dehradun', 'Garhwal', 'Pithoragarh', 'Bageshwar', 'Almora', 'Champawat', 'Nainital', 'Udham Singh Nagar *', 'Hardwar'];
            }


            var string = "";
            for (let i = 0; i < array.length; i++) {
                string = string + "<option>" + array[i] + "</option>";

            }
            string = "<select nmae = 'lol'>" + string + "</select>"
            document.getElementById('district').innerHTML = string;
        }
    </script>
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
                    <h2>Farmer Registration</h2>
                </div>
                <div class="registration-body">
                    <form name="my-form" action="FarmerRegister.php" method="post">
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
                                    <label for="present_address" class="form-label"><i class="fas fa-home"></i> Present Address</label>
                                    <textarea id="present_address" class="form-control" rows="4" name="address" placeholder="Address" required></textarea>
                                </div>
                            </div>

                            <div class="form-col">
                                <div class="form-group">
                                    <label for="states" class="form-label"><b><i class="fas fa-globe-americas"></i>State</b></label>
                                    <select name="statevalue" id="states" onchange="state()" class="form-control" style="height: 40px;padding:0px;" required>
                                        <option value="0">--Select State--</option>
                                        <option value="ANDAMAN & NICOBAR ISLANDS">ANDAMAN & NICOBAR ISLANDS</option>
                                        <option value="ANDHRA PRADESH">ANDHRA PRADESH</option>
                                        <option value="ARUNACHAL PRADESH">ARUNACHAL PRADESH</option>
                                        <option value="ASSAM">ASSAM</option>
                                        <option value="BIHAR">BIHAR</option>
                                        <option value="CHANDIGARH">CHANDIGARH</option>
                                        <option value="CHHATTISGARH">CHHATTISGARH</option>
                                        <option value="DADRA AND NAGAR HAVELI">DADRA AND NAGAR HAVELI</option>
                                        <option value="DAMAN AND DIU">DAMAN AND DIU</option>
                                        <option value="DELHI">DELHI</option>
                                        <option value="GOA">GOA</option>
                                        <option value="GUJARAT">GUJARAT</option>
                                        <option value="HARYANA">HARYANA</option>
                                        <option value="HIMACHAL PRADESH">HIMACHAL PRADESH</option>
                                        <option value="JAMMU AND KASHMIR">JAMMU AND KASHMIR</option>
                                        <option value="JHARKAND">JHARKAND</option>
                                        <option value="KARNATAKA">KARNATAKA</option>
                                        <option value="KERALA">KERALA</option>
                                        <option value="LAKSHADWEEP">LAKSHADWEEP</option>
                                        <option value="MADHYA PRADESH">MADHYA PRADESH</option>
                                        <option value="MAHARASHTRA">MAHARASHTRA</option>
                                        <option value="MANIPUR">MANIPUR</option>
                                        <option value="MEGHALAYA">MEGHALAYA</option>
                                        <option value="MIZORAM">MIZORAM</option>
                                        <option value="NAGALAND">NAGALAND</option>
                                        <option value="ODISHA">ODISHA</option>
                                        <option value="PUDUCHERRY">PUDUCHERRY</option>
                                        <option value="PUNJAB">PUNJAB</option>
                                        <option value="RAJASTHAN">RAJASTHAN</option>
                                        <option value="SIKKIM">SIKKIM</option>
                                        <option value="TAMIL NADU">TAMIL NADU</option>
                                        <option value="TELANGANA">TELANGANA</option>
                                        <option value="TRIPURA">TRIPURA</option>
                                        <option value="UTTAR PRADESH">UTTAR PRADESH</option>
                                        <option value="UTTARAKHAND">UTTARAKHAND</option>
                                        <option value="UTTARANCHAL">UTTARANCHAL</option>
                                        <option value="WEST BENGAL">WEST BENGAL</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="district" class="form-label"><b><i class="fas fa-globe-americas"></i>District</b></label>
                                    <select name="district" id="district" class="form-control" style="height: 40px;padding:0px;" required>
                                        <option>Select District</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="account2" class="form-label"><i class="fas fa-pencil-alt"></i><b>PAN No.</b></label>
                                    <input type="text" id="account2" class="form-control" name="pan" placeholder="Pan number" required>
                                </div>

                                <div class="form-group">
                                    <label for="account1" class="form-label"><i class="fas fa-university"></i><b>Bank Account No.</b></label>
                                    <input type="text" id="account1" class="form-control" name="account" placeholder="Bank Account number" required>
                                </div>

                                <div class="form-group">
                                    <label for="p1" class="form-label"><i class="fas fa-lock"></i><b>Password</b></label>
                                    <input id="p1" class="form-control" type="password" name="password" placeholder="Password" required>
                                </div>

                                <div class="form-group">
                                    <label for="p2" class="form-label"><i class="fas fa-lock"></i><b>Confirm Password</b></label>
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

$ciphering = "AES-128-CTR";
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
$encryption_iv = '2345678910111211';
$encryption_key = "DE";

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $account = mysqli_real_escape_string($con, $_POST['account']);
    $pan = mysqli_real_escape_string($con, $_POST['pan']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirmpassword = mysqli_real_escape_string($con, $_POST['confirmpassword']);
    $district = mysqli_real_escape_string($con, $_POST['district']);
    $state = mysqli_real_escape_string($con, $_POST['statevalue']);

    $encryption = openssl_encrypt(
        $password,
        $ciphering,
        $encryption_key,
        $options,
        $encryption_iv
    );
    // echo $encryption;

    if (strcmp($password, $confirmpassword) == 0) {

        $query = "insert into farmerregistration (farmer_name,farmer_phone,
                farmer_address, farmer_state, farmer_district,
                farmer_pan,farmer_bank,farmer_password) 
                values ('$name','$phonenumber','$address',
                '$state','$district','$pan','$account',
                '$encryption')";

        $run_register_query = mysqli_query($con, $query);
        echo "<script>console.log('SucessFully Inserted');</script>";
        echo "<script>window.open('FarmerLogin.php','_self')</script>";
    } else if (strcmp($password, $confirmpassword) != 0) {
        echo "<script>
				alert('Password and Confirm Password Should be same');
			</script>";
    }
}

?>