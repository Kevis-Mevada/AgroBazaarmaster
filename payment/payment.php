<?php
include "../connection.php";
session_start();
require "../vendor/autoload.php";
use Razorpay\Api\Api;
?>
<!DOCTYPE html>
<html lang="en">
<?php
include "../layout/head_master.php";
$email=$_SESSION["email"];
    $sql="SELECT * FROM `users` WHERE email='$email'";
    $result = mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
    $id = $row['id'];
    $fname = $row['first_name'];
    $email = $row['email'];
    $phoneno = $row['phone_no'];
    $department_id = $row['department'];
    }
?>  
<div id="main-wrapper">
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">Payment</h4>
                </div>
                <div class="col-md-7 align-self-center text-end">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb justify-content-end">
                            <li class="breadcrumb-item"><a href="degree_index.php">Payment</a></li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-11">
                    <div class="card" style="height: 100%;">
                        <div class="card-body">
                                <center>
                                <h3 style="padding-top: 50px;">Current Outstanding payment</h3>
                                <?php
                                    $department_id = mysqli_query($conn, "SELECT users.department, department.department_fee  FROM users LEFT JOIN  department ON users.department = department.id WHERE users.id = '$id'");
                                    while($department_row = mysqli_fetch_array($department_id)){
                                        $fee = $department_row['department_fee'];
                                    }
                                    $payment_data = mysqli_query($conn,"SELECT SUM(amount) as total FROM `payments` WHERE user_id = '$id'");
                                    $payment_row_data = mysqli_num_rows($payment_data);
                                    if($payment_row_data >=1){
                                    while($payment_row = mysqli_fetch_array($payment_data)){
                                        $amount = $payment_row['total'];
                                    }
                                            $outstanding_amount = $fee-$amount;
                                ?>
                                        <h5><?php echo $outstanding_amount;  ?></h5>
                                <?php
                                }else{
                                    ?>
                                    <h5><?php echo $fee;  ?></h5>
                                    <?php
                                    }
                                    if($outstanding_amount === 0){
                                        $actual_amount = "1";

                                    }else{
                                    ?>
                                    <button type="submit" style="margin-top: 50px;" class="btn btn-info d-none d-lg-block m-l-15" id="rzp-button1" onclick="paynow()">Make Payment</button>
                                    <?php
                                    $actual_amount = "$outstanding_amount";
                                    }
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
                                </center>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                include "../layout/footer_master.php";
            ?>
</body>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    function paynow(){
var options = {
    "key": "<?=$keyid?>",
    "amount":  "<?=$order_amount?>",
    "currency": "<?=$currency?>",
    "name": "Elite Admin",
    "description": "Test Transaction",
    "order_id": "<?=$order_id?>",
    "handler": function (response){
        var paymentid = response.razorpay_payment_id;
        var orderid = response.razorpay_order_id;
        $.ajax({
            type: "POST",   
            url: "payment_insert.php",
            data: {"paymentid": paymentid,
                    "orderid": orderid,
                    "amount": <?=$actual_amount?>
                    },            
        });
        location.reload();
    },
    "prefill": {
        "name": "<?=$fname?>",
        "email": "<?=$email?>",
        "contact": "9000090000"
    },
    "theme": {
        "color": "#3399cc"
    }
};
var rzp1 = new Razorpay(options);
rzp1.on('payment.failed', function (response){
        alert(response.error.code);
        alert(response.error.description);
        alert(response.error.source);
        alert(response.error.step);
        alert(response.error.reason);
        alert(response.error.metadata.order_id);
        alert(response.error.metadata.payment_id);
});
    rzp1.open();

}
</script>
</html>