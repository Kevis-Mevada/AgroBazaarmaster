<?php
include "../connection.php";
session_start();
if(!isset($_SESSION["loggedin"])){
    header("Location:../authentication/signin.php");
}
$login_email = $_SESSION["email"];
$access_data = mysqli_query($conn,"SELECT `id` FROM `users` WHERE email = '$login_email'");
    while($access=mysqli_fetch_assoc($access_data)){
        $user_id = $access['id'];
    }
?>
<!DOCTYPE html>
<html lang="en">    
<?php
include "../layout/head_master.php";
?>
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Payment</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item active">Payment</li>
                    </ol>
                    <a href="offline_payment.php" aria-expanded="false"><button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="icon-plus"></i> Create New</button></a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="paymentdatalist" class="table table-striped border">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>DEGREE NAME</th>
                                <th>DEPARTMENT NAME</th>
                                <th>NAME</th>
                                <th>AMOUNT</th>
                                <th>PAYMENT TYPE</th>
                                <th>PAYMENT ID</th>
                                <th>RAZORPAY ID</th>
                                <th>CHEQUE NO</th>
                                <th>BANK NAME</th>
                                <th>PAYMENT DONE</th>
                                <th>CREATED_AT</th>
                                <th>ACTION</th>       
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query =mysqli_query($conn,"SELECT * FROM `payments` WHERE user_id = '$user_id'");
                                while($row=mysqli_fetch_array($query))  {
                                    ?>
                                        <tr>
                                            <?php $id = $row['id'];
                                            ?>
                                            <input type="hidden" class="id" value="<?php echo $id;?>">
                                            <td><?php echo $row['id'];?></td>
                                            <td><?php $degree_n = $row['degree_id'];
                                                    $degree_data = mysqli_query($conn,"SELECT `degree_name` FROM `degree` WHERE id = '$degree_n'");
                                                    while($degree_row=mysqli_fetch_array($degree_data)){
                                                        $degree_name = $degree_row['degree_name'];
                                                    }
                                                    echo $degree_name;?></td>
                                            <td><?php $department_n = $row['department_id'];
                                                    $department_data = mysqli_query($conn,"SELECT `department_name` FROM `department` WHERE id = '$department_n'");
                                                    while($department_row=mysqli_fetch_array($department_data)){
                                                        $department_name = $department_row['department_name'];
                                                    }
                                                    echo $department_name;?></td>
                                            <td><?php echo $row['name'];?></td>
                                            <td><?php echo $row['amount'];?></td>
                                            <td><?php $payment_type= ($row['payment_type'] == 1 )?'online':'offline';
                                            echo $payment_type;?></td>
                                            <td><?php echo $row['payment_id'];?></td>
                                            <td><?php echo $row['razorpay_id'];?></td>
                                            <td><?php echo $row['cheque_no'];?></td>
                                            <td><?php echo $row['bank_name'];?></td>
                                            <td><?php echo $row['payment_done'];?></td>
                                            <td><?php echo $row['created_at'];?></td>
                                            <td>
                                            <a href="download.php?id=<?php echo $id; ?>"><button class="download" id="download"><i class=" ti-import"></i></button></a>
                                            </td>
                                        </tr>
                                    <?php
                                }   
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
            include "../layout/footer_master.php";
            ?>
<script>
$(document).ready(function(){
    $('#paymentdatalist').DataTable({
    });
});
</script>
</body>
</html>