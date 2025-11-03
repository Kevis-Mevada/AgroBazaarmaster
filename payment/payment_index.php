<?php
include "../connection.php";
session_start();
if(!isset($_SESSION["loggedin"])){
    header("Location:../authentication/signin.php");
}
$login_email = $_SESSION["email"];
$access_data = mysqli_query($conn,"SELECT `login_type` FROM `users` WHERE email = '$login_email'");
    while($access=mysqli_fetch_assoc($access_data)){
        $login_type = $access['login_type'];
    }
if($login_type == 2){
    header("Location:../Dashboard/index.php");
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
                                <th>UPDATED_AT</th>
                                <th>ACTION</th>       
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query =mysqli_query($conn,"SELECT * FROM `payments` WHERE deleted_at IS NULL");
                                while($row=mysqli_fetch_array($query))  {
                                    ?>
                                        <tr>
                                            <?php $id = $row['id'];
                                            ?>
                                            <input type="hidden" class="id" value="<?php echo $id;?>">
                                            <td><?php echo $row['id'];?></td>
                                            <td><?php echo $row['degree_id'];?></td>
                                            <td><?php echo $row['department_id'];?></td>
                                            <td><?php echo $row['name'];?></td>
                                            <td><?php echo $row['amount'];?></td>
                                            <td><?php echo $row['payment_type'];?></td>
                                            <td><?php echo $row['payment_id'];?></td>
                                            <td><?php echo $row['razorpay_id'];?></td>
                                            <td><?php echo $row['cheque_no'];?></td>
                                            <td><?php echo $row['bank_name'];?></td>
                                            <td><?php echo $row['payment_done'];?></td>
                                            <td><?php echo $row['created_at'];?></td>
                                            <td><?php echo $row['updated_at'];?></td>
                                            <td><button class="edit"><a href="edit_department.php?id=<?php echo $row['id'];?>"><i class="icon-note"></i></a></button>
                                            <button class="trash" id="trash"><i class="icon-trash"></i></button>
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
$(document).ready(function() {
    $(".trash").click(function(){
        var id = $(this).closest("tr").find('.id').val();
		swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			buttons: true,
			dangerMode: true,
            }).then((willdelete) => {
            if (willdelete){
                $.ajax({
                    type: "POST",
                    url: "delete_department.php",
                    data: {"id": id,},
                    success: function(response){
                        swal("Data Deleted successfully.", {
                            icon: "success",
                        }).then((result) => {
                            location.reload();
                        })
                    }
                })
            }
        })
    })
});
</script>
</body>
</html>