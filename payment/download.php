<?php
include "../connection.php";
session_start();
if(!isset($_SESSION["loggedin"])){
    header("Location:../authentication/signin.php");
}
require "../vendor/autoload.php";
use Dompdf\Dompdf;
$dompdf = new dompdf();
?>
    <?php
        $id = $_GET["id"];
        $receipt_data = mysqli_query($conn,"SELECT * FROM `payments` WHERE id = $id");
    while($receipt_row = mysqli_fetch_array($receipt_data)){
        $enrollmentno = $receipt_row["user_id"];
        $receipt_date = $receipt_row["created_at"];
        $name = $receipt_row["name"];
        $receipt_no = $receipt_row["payment_id"];
        $degree_n = $receipt_row['degree_id'];
        $degree_data = mysqli_query($conn,"SELECT `degree_name` FROM `degree` WHERE id = '$degree_n'");
        while($degree_row=mysqli_fetch_array($degree_data)){
            $degree = $degree_row['degree_name'];
        }
        $department_n = $receipt_row['department_id'];
        $department_data = mysqli_query($conn,"SELECT `department_name` FROM `department` WHERE id = '$department_n'");
        while($department_row=mysqli_fetch_array($department_data)){
            $department = $department_row['department_name'];
        }
        $amount = $receipt_row["amount"];

        $payment_mode= ($receipt_row["payment_type"] == 1 )?"online":"offline";
    }
    function convertNumber($num = false)
{
    $num = str_replace(array(",", ""), "" , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array("", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", "eleven",
        "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eighteen", "nineteen"
    );
    $list2 = array("", "ten", "twenty", "thirty", "forty", "fifty", "sixty", "seventy", "eighty", "ninety", "hundred");
    $list3 = array("", "thousand", "million", "billion", "trillion", "quadrillion", "quintillion", "sextillion", "septillion",
        "octillion", "nonillion", "decillion", "undecillion", "duodecillion", "tredecillion", "quattuordecillion",
        "quindecillion", "sexdecillion", "septendecillion", "octodecillion", "novemdecillion", "vigintillion"
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr("00" . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? " " . $list1[$hundreds] . " hundred" . ( $hundreds == 1 ? "" : "" ) . " " : "");
        $tens = (int) ($num_levels[$i] % 100);
        $singles = "";
        if ( $tens < 20 ) {
            $tens = ($tens ? " and " . $list1[$tens] . " " : "" );
        } elseif ($tens >= 20) {
            $tens = (int)($tens / 10);
            $tens = " and " . $list2[$tens] . " ";
            $singles = (int) ($num_levels[$i] % 10);
            $singles = " " . $list1[$singles] . " ";
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? " " . $list3[$levels] . " " : "" );
    }
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    $words = implode(" ",  $words);
    $words = preg_replace("/^\s\b(and)/", "", $words );
    $words = trim($words);
    $words = ucfirst($words);
    $words = "ONLY ".$words ." RUPEES" .".";
    return $words;
}
$html = '<html>
<head>
<style>
.col-md-6 {
    width: 45%;
    margin-left:3%;

  }
  .col-md-12 {
    width: 100%;
  }
.row h4{
    display: inline-block;
    margin-top:0;
    margin-down:0;
}
  .card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    border: 1px solid black;
    background-color:#f5f5f7;
  }
  .table td, .table th {    
    border: 1px solid black;
    padding: 8px;
    width: 32%;
}
.table {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 96%;
    text-align:center;
    margin-left:2%;
    margin-right:2;
  }
</style> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>   
    </head>
    <body>
        <div class="card">
            <h1 style="text-align:center;">Elite Admin</h1><hr>
            <h2 style="text-align:center;">Fee Receipt</h2><hr>';
            
$html .= '  <div class="row">
            <h4 class="col-md-6">Enrollment No:&nbsp;&nbsp;'. $enrollmentno .'</h4>
            <h4 class="col-md-6">Receipt Date:&nbsp;&nbsp;'. $receipt_date .'</h4>
            <h4 class="col-md-6">Student Name:&nbsp;&nbsp;'. $name .'</h4>
            <h4 class="col-md-6">Payment Id:&nbsp;&nbsp;'. $receipt_no .'</h4>
            <h4 class="col-md-6">Degree:&nbsp;&nbsp;'. $degree .'</h4>
            <h4 class="col-md-6">Department:&nbsp;&nbsp;'. $department .'</h4>
            </div>';
            
$html.='<hr>
        <table class="table">
            <tr>
                <th>Sr.No</th>
                <th>Fee Name</th>
                <th>Amount</th>
            </tr>
            <tr>
                <td>1</td>
                <td>TUITION FEES</td>
                <td><span style="font-family: DejaVu Sans; sans-serif;">&#8377;&nbsp;</span>'. $amount .'</td>  
                
            </tr>
            <tr>
                <td colspan="2">AMOUNT IN WORDS:&nbsp;'. strtoupper(convertNumber($amount)) .'</td>
                <td>TOTAL AMOUNT:&nbsp;&nbsp;<span style="font-family: DejaVu Sans; sans-serif;">&#8377;&nbsp;</span>'. $amount .'</td>
            </tr>
        </table>
        <h4 class="col-md-6">Payment Status:&nbsp;&nbsp; Paid</h4>
        <h4 class="col-md-6">Payment Type:&nbsp;&nbsp; '. $payment_mode .'</h4><hr>
        <h4 style="text-align:center;">© Copyright 2023 - Elite Admin | All rights reserved.</h4>
        </div>
        </body>
        </html>';

$dompdf->loadhtml($html);
$dompdf->setpaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($name.'feereceipt');
?>