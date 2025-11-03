<?php
 if (isset($_POST['submit'])) {
        $address = $_POST['address'];
        $delivery = $_POST['delivery'];
        $payment = $_POST['paymentoption'];
        $total = $_SESSION['grandtotal'];
    
        $count = 0;
        while ($count < $i) {
            $product_id = $allproducts[$count];
            $qty = $allqty[$count];
            $total = $allsubtotal[$count];
            $phone = $allphones[$count];
            $query1 = "insert into orders (product_id,qty,address,delivery,phonenumber,total,payment,buyer_phonenumber) values ('$product_id','$qty','$address','$delivery','$phone','$total','$payment','$sess_phone_number')";
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