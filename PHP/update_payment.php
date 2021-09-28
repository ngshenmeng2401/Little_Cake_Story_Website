<?php
error_reporting(0);
include_once("dbconnect.php");

$email = $_GET['email']; //email
$phoneNo = $_GET['phoneNo']; 
$name = $_GET['name']; 
$totalPayment = $_GET['totalPayment']; 
$dateTime = $_GET['dateTime']; 
$message = $_GET['message']; 
$address = $_GET['address']; 
$item_qty = $_GET['item_qty'];
$option = $_GET['option'];

$data = array(
    'id' =>  $_GET['billplz']['id'],
    'paid_at' => $_GET['billplz']['paid_at'] ,
    'paid' => $_GET['billplz']['paid'],
    'x_signature' => $_GET['billplz']['x_signature']
);

$paidstatus = $_GET['billplz']['paid'];

if ($paidstatus=="true"){
  $receiptid = $_GET['billplz']['id'];
  $signing = '';
    foreach ($data as $key => $value) {
        $signing.= 'billplz'.$key . $value;
        if ($key === 'paid') {
            break;
        } else {
            $signing .= '|';
        }
    }
    
  $sqlinsertpurchased = "INSERT INTO tbl_payment(user_email,item,total_payment,message,address,delivery_date_time) VALUES ('$email','$item_qty','$totalPayment','$message','$address','$dateTime')";
  $sqldeletecart = "DELETE FROM tbl_cart WHERE user_email='$email'";
   
  $stmt = $con->prepare($sqlinsertpurchased);
  $stmt->execute();
  $stmtdel = $con->prepare($sqldeletecart);
  $stmtdel->execute();
   
   
      echo '<br><br><body><div><h2><br><br><center>Your Receipt</center>
     </h1>
     <table border=1 width=80% align=center>
     <tr><td>Receipt ID</td><td>'.$receiptid.'</td></tr><tr><td>Email to </td>
     <td>'.$email. ' </td></tr><td>Amount </td><td>RM '.$totalPayment.'</td></tr>
     <tr><td>Items Status </td><td>'.$item_qty.'</td></tr>
     <tr><td>Payment Status </td><td>'.$paidstatus.'</td></tr>
     <tr><td>Address </td><td>'.$address.'</td></tr>
     <tr><td>Option </td><td>'.$option.'</td></tr>
     <tr><td>Message </td><td>'.$message.'</td></tr>
     <tr><td>Date </td><td>'.date("d/m/Y").'</td></tr>
     <tr><td>Time </td><td>'.date("h:i a").'</td></tr>
     </table><br>
     <p><center>Press <a class="cursor-pointer" href="home.php">back</a> button to return to your app</center></p>
     </div></body>';
    
}
else{
     echo 'Payment Failed!';
}
?>