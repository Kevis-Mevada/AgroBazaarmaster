<?php
include "../connection.php";
session_start();
if(!isset($_SESSION["loggedin"])){
    header("Location:../authentication/signin.php");
}
?>
<html>
<?php
$errors = array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(empty($_POST['degree'])){
        $errors['degree'] = "* Degree is required.";
    }
    if(empty($_POST['department'])){
        $errors['department'] = "* Department is required.";
    }
    if(empty($_POST['name'])){
        $errors['name'] = "* Name is required.";
    }
    if(empty($_POST['email'])){
        $errors['email'] = "* email is required.";
    }
    if(empty($_POST['phoneno'])){
        $errors['phoneno'] = "* phoneno is required.";
    }
    if(empty($_POST['amount'])){
        $errors['amount'] = "* amount is required.";
    }
    if(empty($_POST['payment_type'])){
        $errors['payment_type'] = "* payment_type is required.";
    }
    if(count($errors) === 0){
        $createddate = date('Y-m-d h:i:s');
        $name = $_POST['name'];
        $degree = $_POST['degree'];
        $department = $_POST['department'];
        $amount = $_POST['amount'];
        $email = $_POST['email'];
        $data = mysqli_query($conn,"SELECT * FROM `users` WHERE email = '$email'");
        $data_row = mysqli_num_rows($data);
        while($row = mysqli_fetch_array($data)){
            $id = $row['id'];
        }
        if($data_row >=1){
            if($_POST['payment_type'] == 1){
                $insert = mysqli_query($conn,"INSERT INTO `payments`(`user_id`, `degree_id`, `department_id`, `name`, `amount`, `payment_type`, `payment_done`, `created_at`) VALUES('$id','$degree','$department','$name','$amount',2,'done','$createddate')");
            }else{
                $chequeno = $_POST['cheque_no'];
                $bankname = $_POST['bank_name'];
                $insert = mysqli_query($conn,"INSERT INTO `payments`(`user_id`, `degree_id`, `department_id`, `name`, `amount`, `payment_type`, `payment_done`, `cheque_no`, `bank_name`, `created_at`) VALUES('$id','$degree','$department','$name','$amount',2,'done','$chequeno','$bankname','$createddate')");
            }
            if($insert){
                header("Location:payment_index.php");
            }else{
                echo "error";
            }
        }
    }
}
include "../layout/head_master.php";
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
                            <li class="breadcrumb-item"><a href="department_index.php">Payment</a></li>
                            <li class="breadcrumb-item active">Add Payment</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form name="offline_fee" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Degree</label>
                                                <select onChange="getdepartment(this.value);" class="form-control form-select" id="degree" name="degree">
                                                    <option value="">Select Any One</option>
                                                    <?php
                                                        $degree = "SELECT `id`, `degree_name` FROM `degree`";
                                                            $degreeresult = mysqli_query($conn,$degree);
                                                    while($degreerow=mysqli_fetch_assoc($degreeresult)){
                                                        ?>
                                                        <option value="<?php echo $degreerow['id']; ?>"><?php echo $degreerow['degree_name']; ?></option>
                                                        <?php
                                                    }
                                                    ?>  
                                                </select>
                                                <span style="color:red"><?php if(isset($errors['degree'])){echo $errors['degree']; } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Department</label>
                                                <select class="form-control form-select" id="department" name="department">
                                                <option value="">Select Any One</option>
                                                </select>
                                                <span style="color:red"><?php if(isset($errors['department'])){echo $errors['department']; } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter First Name" value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>">
                                                <span style="color:red"><?php if(isset($errors['name'])){echo $errors['name']; } ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Address" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
                                                <span style="color:red"><?php if(isset($errors['email'])){echo $errors['email']; } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">  
                                        <div class="form-floating mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Phone No</label>
                                                <input type="text" class="form-control" id="phoneno" name="phoneno" placeholder="Enter Phone No" value="<?php if(isset($_POST['phoneno'])){echo $_POST['phoneno'];} ?>">
                                                <span style="color:red"><?php if(isset($errors['phoneno'])){echo $errors['phoneno']; } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">  
                                        <div class="form-floating mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Amount</label>
                                                <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount" value="<?php if(isset($_POST['amount'])){echo $_POST['amount'];} ?>">
                                                <span style="color:red"><?php if(isset($errors['amount'])){echo $errors['amount']; } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Payment Type</label>
                                                <select onChange="gettype();" class="form-control form-select" id="payment_type" name="payment_type">
                                                <option value="">Select Any One</option>
                                                <option value="1">Cash</option>
                                                <option value="2">Cheque</option>
                                                </select>
                                                <span style="color:red"><?php if(isset($errors['payment_type'])){echo $errors['payment_type']; } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div name="offline" id="offline" style="display: none;">
                                        <div class="col-md-12">  
                                            <div class="form-floating mb-3">
                                                <div class="form-group">
                                                    <label class="form-label">Cheque No</label>
                                                    <input type="text" class="form-control" id="cheque_no" name="cheque_no" placeholder="Enter cheque_no" value="<?php if(isset($_POST['phoneno'])){echo $_POST['phoneno'];} ?>">
                                                    <span style="color:red"><?php if(isset($errors['phoneno'])){echo $errors['phoneno']; } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">  
                                            <div class="form-floating mb-3">
                                                <div class="form-group">
                                                    <label class="form-label">Bank Name</label>
                                                    <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter bank_name" value="<?php if(isset($_POST['phoneno'])){echo $_POST['phoneno'];} ?>">
                                                    <span style="color:red"><?php if(isset($errors['phoneno'])){echo $errors['phoneno']; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-md-flex align-items-center mt-3">
                                            <div>
                                                <button type="submit"
                                                    class="btn btn-primary text-white">Submit</button>
                                                <a href="department_index.php"><button type="button"
                                                    class="btn btn-primary text-white">cancel</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                include "../layout/footer_master.php";
            ?>
</body>
<script>
    function getdepartment(val) {
	$.ajax({
	type: "POST",
	url: "../getdepartment.php",
	data:'degree='+val,
	success: function(data){
		$("#department").html(data);
	}
	});
}
function gettype() {
    selectedVal = document.getElementById('payment_type').value;
    if(selectedVal == '2')
    {   
        $("#offline").show();
    }else{
        $("#offline").hide();
    }
}
</script>
</html>