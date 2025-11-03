<?php
include("../Includes/db.php");
session_start();

$payment_id = $_POST['paymentid'];
$order_id = $_POST['orderid'];
$amount = $_POST['amount'];
$phonenumber=$_SESSION["phonenumber"];
    // $sql="SELECT * FROM `users` WHERE email='$email'";
    // $result = mysqli_query($conn,$sql);
    // while($row=mysqli_fetch_assoc($result)){
    // $id = $row['id'];
    // $name = $row['first_name'];
    // $phoneno = $row['phone_no'];
    // $department_id = $row['department'];
    // $degree_id = $row['degree'];
    // }
    $createddate = date('Y-m-d h:i:s');
    $sql = ("INSERT INTO `payments`(`payment_id`, `phone_number`, `amount`, `receipt_no`, `razorpay_id`, `payment_done`, `created_at`) VALUES ('$payment_id','$phonenumber','$amount','','$order_id','Done','$createddate')");
// $sql="INSERT INTO `payments`(`user_id`, `degree_id`, `department_id`, `name`, `amount`, `payment_type`, `payment_id`, `razorpay_id`,`payment_done`, `created_at`) VALUES ('$id','$degree_id','$department_id','$name','$amount', 1,'$payment_id','$order_id','done','$createddate')";
$result = mysqli_query($con,$sql);
if($result){
    $last_id = mysqli_insert_id($con);
    echo $last_id;
}
// else  {
//     echo "error";
// }

?>