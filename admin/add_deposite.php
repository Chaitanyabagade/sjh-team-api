<?php
header('Access-Control-Allow-Origin: *');
include '../configuration.php';
include('smtp/PHPMailerAutoload.php');
include 'email.php';
$conn = new mysqli($server, $origin, $pass, $databasename);

if (mysqli_connect_error()) {
  echo mysqli_connect_error();
  exit();
} 
else {
  $name = $_POST['name'];
  $amount = $_POST['amount'];
  $team = $_POST['team'];
  $adminname = $_POST['admin_name'];
  $adminmobile = $_POST['mobile_no'];

  $sqlcheckadmin = "SELECT * FROM `adminname` WHERE admin_name='$adminname' AND admin_mobile_no ='$adminmobile'";
  $rescheckadmin = $conn->query($sqlcheckadmin);
  if ($rescheckadmin->num_rows > 0) {
    $rowcheck = $rescheckadmin->fetch_assoc();
    if ($rowcheck['permision']) {

      // admin operation

      $sql = "UPDATE `deposite` set deposite=('$amount'+(select deposite from `deposite` where user_name='$name' AND team='$team')) where user_name='$name' AND team='$team'";
      $res = mysqli_query($conn, $sql);
        
      //update date
      $sql2 = "UPDATE `deposite` set last_paid_date= Now() where user_name='$name' AND team='$team'";
      $res2 = mysqli_query($conn, $sql2);

      //// for getting the eamil id///////////////////////////

      $sql3 = "SELECT * FROM `accounts` WHERE user_name = '$name'";
      $result2 = $conn->query($sql3);
      $email = "chaitanyabagadea07@gmail.com"; // This can be a fallback value if needed
      if ($result2->num_rows > 0) {
        $row = $result2->fetch_assoc(); // Use $result2 instead of $result
        $email = $row['email_id'];
      }

      $html = '<html>
            <body style="font-size:20px;padding:0px;background-color: rgb(231, 248, 227);">
                <div style=""><b>Thank you for Paid  Rs.' . $amount . ' Deposite of This Month  If not then contact to the manager.</b></div>
            </body>
            </html>';


      smtp_mailer($email, 'Thank You for Paid  Deposite of This Month', $html);


          /////////////////// ending email ///////////////
 
      ///////////////////////////// adding cashbook entry ///////////////////////////////////////////////////////////////////////////////////////////////////////////
     
      $adminNumber = $_POST['mobile_no'];
      $adminName = $_POST['admin_name'];

      $amount_cash = $amount;
      $note="Add Deposite Of Member ".$name." ".$amount." In your Bank Account";

      $sqlcashbook = "INSERT INTO `cashbook` (`id`, `user_name`, `amount`, `note`, `team`) VALUES (NULL, '$adminName', '$amount_cash', '$note', '$team')";
      $result_cashbook = mysqli_query($conn, $sqlcashbook);
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      
      $conn->close();
      http_response_code(200); 
      echo $res;
    }
    else{
      http_response_code(202); 
        echo "you are not authorized please logout and login repeat";

        $conn->close();
    }

   }
    else {
      http_response_code(202); 
      echo "you are not authorized please logout and login repeat";
      $conn->close();
  }

}


?>