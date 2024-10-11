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

   $amount = $_POST['amount'];
   $team = $_POST['team'];
   $note = $_POST['note'];
   $date = $_POST['date'];

   $adminname = $_POST['admin_name'];
   $adminmobile = $_POST['mobile_no'];
   $sqlcheckadmin = "SELECT * FROM `adminname` WHERE admin_name='$adminname' AND admin_mobile_no ='$adminmobile'";
   $rescheckadmin = $conn->query($sqlcheckadmin);
   if ($rescheckadmin->num_rows > 0) {
      $rowcheck = $rescheckadmin->fetch_assoc();
      if ($rowcheck['permision']) {


         $sql = "INSERT INTO `remuneration` (`id`, `remuneration`, `team`, `Date`, `note`) VALUES (NULL, '$amount', '$team', '$date', '$note')";

         $res = mysqli_query($conn, $sql);
         echo $res;
         ///////////////////////////// adding cashbook entry ///////////////////////////////////////////////////////////////////////////////////////////////////////////

         $adminNumber = $_POST['mobile_no'];
         $adminName = $_POST['admin_name'];
         $amount_cash = -$amount;

         $note = "Substract " . $amount . " remuneration  for " . $note . " From your Bank Account";

         $sqlcashbook = "INSERT INTO `cashbook` (`id`, `user_name`, `amount`, `note`, `team`) VALUES (NULL, '$adminName', '$amount_cash', '$note','$team')";
         $result_cashbook = mysqli_query($conn, $sqlcashbook);
         //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


         //// for getting the eamil id///////////////////////////
         $name = "Ram Bagade";
         $sql3 = "SELECT * FROM `accounts` WHERE team = '$team'";
         $result2 = $conn->query($sql3);
         $email = "chaitanyabagadea07@gmail.com"; // This can be a fallback value if needed
         $html = '<html>
                    <body style="font-size:20px;padding:15px;background-color: rgb(231, 248, 227);">
                         <div style=""><b>The remuneration of Sjh team On Day ' . $date . ' is Rs.' . $amount . ' For ' . $note . '</b></div>
                     </body>
                 </html>';

         if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
               smtp_mailer($row['email_id'], 'The remuneration of Sjh team', $html);
            }
         }
         ///////////////// end of email//////////////////////////////
         http_response_code(200);
         $conn->close();


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