<?php
include("../Functions/functions.php");
require "../vendor/autoload.php";
use Razorpay\Api\Api;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page | AgroBazaar</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Razorpay -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
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
    }
    
    .checkout-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .summary-card {
        background-color: var(--secondary-color);
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    
    .section-title {
        color: var(--primary-color);
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .address-textarea {
        min-height: 120px;
        border-radius: 8px;
    }
    
    .product-table {
        border-radius: 8px;
        overflow: hidden;
    }
    
    .product-table thead {
        background-color: var(--primary-color);
        color: white;
    }
    
    .payment-option-card {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .payment-option-card:hover {
        border-color: var(--primary-color);
        background-color: rgba(40, 167, 69, 0.05);
    }
    
    .payment-option-card.active {
        border-color: var(--primary-color);
        background-color: rgba(40, 167, 69, 0.1);
    }
    
    .payment-img {
        height: 30px;
        margin-right: 10px;
    }
    
    .btn-checkout {
        background-color: var(--primary-color);
        color: white;
        padding: 0.75rem 2rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    
    .btn-checkout:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .btn-back {
        background-color: var(--dark-color);
        color: white;
        padding: 0.75rem 2rem;
        font-weight: 600;
        border-radius: 50px;
    }
    
    .btn-back:hover {
        background-color: #23272b;
        color: white;
    }
    
    .grand-total {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    @media (max-width: 768px) {
        .checkout-container {
            padding: 1rem;
        }
        
        .section-title {
            font-size: 1.25rem;
        }
    }
    </style>
</head>
<body>
    <?php include("../layout/nav.php"); ?>
    
    <div class="container py-5">
        <form id="checkoutform" name="checkoutform" action="" method="post">
            <?php
            $buyer_id = $_SESSION['buyer_id'];
            $get_addr = "select buyer_addr from buyerregistration where buyer_id=$buyer_id";
            $run = mysqli_query($con, $get_addr);
            while ($row = mysqli_fetch_array($run)) {
                $buyer_addr = $row['buyer_addr'];
            }
            ?>
            
            <div class="row">
                <div class="col-lg-8">
                    <!-- Address Section -->
                    <div class="checkout-container mb-4">
                        <h2 class="section-title"><i class="fas fa-map-marker-alt me-2"></i>Delivery Address</h2>
                        <div class="form-floating mb-3">
                            <textarea class="form-control address-textarea" id="address" name="address" style="height: 120px"><?php echo $buyer_addr ?></textarea>
                            <label for="address">Your complete delivery address</label>
                        </div>
                    </div>
                    
                    <!-- Products Section -->
                    <div class="checkout-container mb-4">
                        <h2 class="section-title"><i class="fas fa-shopping-basket me-2"></i>Order Summary</h2>
                        <div class="table-responsive">
                            <table class="table product-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Delivery</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    global $con;
                                    if (isset($_SESSION['phonenumber'])) {
                                        $sess_phone_number = $_SESSION['phonenumber'];
                                        $sel_price = "select * from cart where phonenumber = '$sess_phone_number'";
                                        $run_price = mysqli_query($con, $sel_price);
                                        $i = 0;
                                        $allproducts = array();
                                        $allqty = array();
                                        $allsubtotal = array();
                                        $allphones = array();
                                        while ($p_price = mysqli_fetch_array($run_price)) {
                                            $product_id = $p_price['product_id'];
                                            $qty = $p_price['qty'];
                                            $subtotal = $p_price['subtotal'];
                                            array_push($allproducts, $product_id);
                                            array_push($allqty, $qty);
                                            $pro_price = "select * from products where product_id='$product_id'";
                                            $run_pro_price = mysqli_query($con, $pro_price);
                                            while ($pp_price = mysqli_fetch_array($run_pro_price)) {
                                                $product_title = $pp_price['product_title'];
                                                $farmer_fk = $pp_price['farmer_fk'];
                                                $get_phone = "select * from farmerregistration where farmer_id = $farmer_fk";
                                                $run_get_phone = mysqli_query($con, $get_phone);
                                                while ($phones = mysqli_fetch_array($run_get_phone)) {
                                                    $phone = $phones['farmer_phone'];
                                                    array_push($allphones, $phone); ?>
                                                    <tr>
                                                        <td><?php echo $i + 1; ?></td>
                                                        <td><?php echo $product_title; ?></td>
                                                        <td>₹<?php echo $subtotal; ?></td>
                                                        <?php array_push($allsubtotal, $subtotal); ?>
                                                        <td>
                                                            <select class="form-select" name="delivery">
                                                                <option selected value="Farmer">Farmer</option>
                                                                <option value="Buyer">Buyer</option>
                                                                <option value="Courier">Courier</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                    <?php
                                                }
                                            }
                                            $i++;
                                        }
                                    } else {
                                        echo "<h1 align = center>Please Login First!</h1><br><br><hr>";
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <!-- Order Summary -->
                    <div class="checkout-container mb-4">
                        <h2 class="section-title"><i class="fas fa-receipt me-2"></i>Order Total</h2>
                        <div class="summary-card mb-4">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal:</span>
                                <span>₹<?php echo $_SESSION['grandtotal']; ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Delivery:</span>
                                <span>FREE</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Total:</span>
                                <span class="grand-total">₹<?php echo $_SESSION['grandtotal']; ?></span>
                            </div>
                        </div>
                        
                        <!-- Payment Options -->
                        <h2 class="section-title"><i class="fas fa-credit-card me-2"></i>Payment Method</h2>
                        <div class="mb-4">
                            <div class="payment-option-card mb-3" onclick="selectPaymentOption('payment')">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentoption" id="paymentOption1" value="payment">
                                    <label class="form-check-label d-flex align-items-center" for="paymentOption1">
                                        <img src="../Images/Website/paytm1.jpg" alt="Paytm" class="payment-img">
                                        Online Payment (Paytm/Razorpay)
                                    </label>
                                </div>
                            </div>
                            
                            <div class="payment-option-card" onclick="selectPaymentOption('cod')">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentoption" id="paymentOption2" value="cod">
                                    <label class="form-check-label d-flex align-items-center" for="paymentOption2">
                                        <img src="../Images/Website/cod.jpg" alt="COD" class="payment-img">
                                        Cash on Delivery
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="tran_id" id="tran_id" value="">
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="button" onclick="selectpayment()" class="btn btn-checkout btn-lg">
                                <i class="fas fa-lock me-2"></i>Place Order
                            </button>
                            <a href="cartpage.php" class="btn btn-back btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Back to Cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <?php
    $actual_amount = $_SESSION['grandtotal'];
    $keyid = "rzp_test_9cpH9atIqxoN51";
    $keysecret = "Nqw1Vv9nSLYdPPxXsXKCahQj";
    $api = new Api($keyid,$keysecret);
    $currency = "INR";
    $order = $api->order->create(array('receipt'=>'1','amount'=>$actual_amount*100,'currency'=>$currency));
    $order_id = $order['id'];
    $order_receipt = $order['receipt'];
    $order_amount = $order['amount'];
    $order_currency = $order['currency'];
    $order_created_at = $order['created_at'];
    $SESSION['razorpay_order_id'] = $order_id;
    ?>
    
    <?php include("../layout/footer.php"); ?>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function selectPaymentOption(option) {
            document.querySelector(`input[value="${option}"]`).checked = true;
            document.querySelectorAll('.payment-option-card').forEach(card => {
                card.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
        }
        
        function selectpayment(){
            const checkoption = document.getElementsByName('paymentoption');
            let selectedoption = null;
            
            for (const radio of checkoption) {
                if (radio.checked) {
                    selectedoption = radio.value;
                }
            }
            
            if(selectedoption == "payment") {
                paynow();
            } else if(selectedoption == "cod") {
                formsubmit();
            } else {
                alert("Please select a payment option.");
            }
        }
        
        function formsubmit() {
            var form = document.getElementById('checkoutform');
            form.submit();
        }
        
        function paynow(){
            var options = {
                "key": "<?=$keyid?>",
                "amount": "<?=$order_amount?>",
                "currency": "<?=$currency?>",
                "name": "AgroBazaar",
                "description": "Secure Payment",
                "image": "../auth/agro.png",
                "order_id": "<?=$order_id?>",
                "handler": function (response){
                    var paymentid = response.razorpay_payment_id;
                    var orderid = response.razorpay_order_id;
                    
                    $.ajax({
                        type: "POST",   
                        url: "../payment/payment_insert.php",
                        data: {
                            "paymentid": paymentid,
                            "orderid": orderid,
                            "amount": <?=$actual_amount?>
                        },
                        success: function(response) {
                            var extraField = document.getElementById('tran_id');
                            extraField.value = response;
                            formsubmit();
                        },
                        error: function(xhr, status, error) {
                            console.error("Payment processing error:", error);
                            alert("Payment verification failed. Please contact support.");
                        }
                    });
                },
                "prefill": {
                    "name": "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : '' ?>",
                    "email": "<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '' ?>",
                    "contact": "<?php echo isset($_SESSION['phonenumber']) ? $_SESSION['phonenumber'] : '' ?>"
                },
                "theme": {
                    "color": "#28a745"
                }
            };
            
            var rzp1 = new Razorpay(options);
            
            rzp1.on('payment.failed', function (response){
                console.error("Payment failed:", response.error);
                alert("Payment failed: " + response.error.description);
            });
            
            rzp1.open();
        }
    </script>
</body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $address = $_POST['address'];
    $delivery = $_POST['delivery'];
    $payment = $_POST['paymentoption'];
    $total = $_SESSION['grandtotal'];
    $tran_id = $_POST['tran_id'];

    $count = 0;
    while ($count < $i) {
        $product_id = $allproducts[$count];
        $qty = $allqty[$count];
        $total = $allsubtotal[$count];
        $phone = $allphones[$count];
        $query1 = "insert into orders (product_id,qty,address,delivery,phonenumber,total,payment,pay_id,buyer_phonenumber) values ('$product_id','$qty','$address','$delivery','$phone','$total','$payment','$tran_id','$sess_phone_number')";
        $run = mysqli_query($con, $query1);
        $count = $count + 1;
    }
    $clear = "delete from cart where phonenumber = $sess_phone_number";
    $run = mysqli_query($con, $clear);
    if ($run) {
        echo "<script>window.open('Success.php','_self')</script>";
    }
}
?>