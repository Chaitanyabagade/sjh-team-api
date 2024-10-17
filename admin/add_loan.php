<?php

header('Access-Control-Allow-Origin: *');
include '../configuration.php';
include('smtp/PHPMailerAutoload.php');
include 'email.php';

$conn = new mysqli($server, $origin, $pass, $databasename);

if (mysqli_connect_error()) {
   echo mysqli_connect_error();
   exit();
} else {
   $name = $_POST['name'];
   $amount = $_POST['amount'];
   $team = $_POST['team'];
   $get_date = $_POST['get_date'];
   $EMI_duration = $_POST['duration'];
   $loan_type = $_POST['loan_type'];

   $adminname = $_POST['admin_name'];
   $adminmobile = $_POST['mobile_no'];
   $sqlcheckadmin = "SELECT * FROM `adminname` WHERE admin_name='$adminname' AND admin_mobile_no ='$adminmobile'";
   $rescheckadmin = $conn->query($sqlcheckadmin);
   if ($rescheckadmin->num_rows > 0) {
      $rowcheck = $rescheckadmin->fetch_assoc();
      if ($rowcheck['permision']) {



         $EMI_rate = 0.0;
         if ($EMI_duration <= 3) {
            $EMI_rate = 2.0;
         } else if ($EMI_duration <= 6) {
            $EMI_rate = 2.3;
         } else if ($EMI_duration <= 8) {
            $EMI_rate = 2.6;
         } else if ($EMI_duration <= 10) {
            $EMI_rate = 3.0;
         } else if ($EMI_duration <= 11) {
            $EMI_rate = 3.5;
         } else {
            $EMI_rate = 4.0;
         }



         ///count $intrest

         $intrest = (($amount / 100) * $EMI_rate) * $EMI_duration;

         // count $EMI_amt
         $EMI_amt = ($amount + $intrest) / $EMI_duration;



         $sql = "INSERT INTO `loan` (`id`, `user_name`, `team`, `loan_amt`, `loan_amt_returned`, `loan_amt_intrest`, `loan_amt_intrest_returned`, `loan_type`, `EMI_amt`, `EMI_duration`, `EMI_count`, `EMI_rate`, `Loan_date`,`status`,`loan_provider`) VALUES (NULL, '$name', '$team', '$amount',0, '$intrest',0, '$loan_type', '$EMI_amt', '$EMI_duration',0, '$EMI_rate', '$get_date','Pending..','$adminname')";
         $res = mysqli_query($conn, $sql);



         ///////////////////////////// adding cashbook entry ///////////////////////////////////////////////////////////////////////////////////////////////////////////

         $adminNumber = $_POST['mobile_no'];
         $adminName = $_POST['admin_name'];
         $amount_cash = -$amount;

         $note = "Substract Loan Of Member " . $name . " " . $amount_cash . " from your Bank Account";

         $sqlcashbook = "INSERT INTO `cashbook` (`id`, `user_name`, `amount`, `note`, `team`,`last_paid_date`) VALUES (NULL, '$adminName', '$amount_cash', '$note','$team',now())";
         $result_cashbook = mysqli_query($conn, $sqlcashbook);
         //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



         /////////////////Email code block/////////////////////////
         $html = '<html>
      <body style="font-size:20px;padding:0px;background-color: rgb(231, 248, 227);">
     <div style=""><b>Thank you for getting loan from sjh production, You Have Get The Loan of ' . $amount . ' Rupees If not then contact to the manager.</b></div>
     <br/><b><i>Loan Details =></i></b><br/> <br>
     <table style="width:100%;font-size:15px;border:10px solid gainsboro ;padding:5px;border-radius: 10px; ">
         <tr>
            <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">User Name</td>
            <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);">' . $name . '</td>
        </tr>
        <tr>
            <td style="padding:15px;width:50%;border:5px solid rgb(238, 148, 3)">Date</td>
            <td style="padding:15px;width:50%;border:5px solid rgb(238, 148, 3);text-align:right;">' . $get_date . '</td>
        </tr>
        <tr>
             <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">Loan Amount</td>
             <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);text-align:right;">' . $amount . '</td>
         </tr>
         <tr>
            <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">Monthly EMI Amount to Pay</td>
            <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);text-align:right;"> ' . $EMI_amt . '</td>
        </tr>
        <tr>
            <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">Loan Rate</td>
            <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);text-align:right;">' . $EMI_rate . '</td>
        </tr>
        <tr>
            <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">Loan Duration <br>(In Months)</td>
            <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);text-align:right;">' . $EMI_duration . '</td>
        </tr>
         <tr>
            <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">Team Name </td>
            <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);text-align:right;">' . $team . '</td>
        </tr>
 
     </table>
     
</body>
</html>';


         $sql3 = "SELECT * FROM `accounts` WHERE user_name = '$name'";
         $result2 = $conn->query($sql3);
         $email = "chaitanyabagadea07@gmail.com"; // This can be a fallback value if needed
         if ($result2->num_rows > 0) {
            $row = $result2->fetch_assoc(); // Use $result2 instead of $result
            $email = $row['email_id'];
         }
         smtp_mailer($email, 'You Geted the Loan from sjh', $html);
         ////////////////////// end email ////////////////////




         http_response_code(200);
         $conn->close();
         echo $res;

      } else {
         http_response_code(202);
         echo "you are not authorized please logout and login repeat";
         $conn->close();
      }
   } else {
      http_response_code(202);
      echo "you are not authorized please logout and login repeat";
      $conn->close();
   }
}

?>