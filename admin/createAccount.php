<?php
header('Access-Control-Allow-Origin: *');
include '../configuration.php';
$conn = new mysqli($server, $origin, $pass, $databasename);

if (mysqli_connect_error()) {
   echo mysqli_connect_error();
   exit();
} else {
   $name = $_POST['name'];
   $mobile = $_POST['mobile'];
   $pass = $_POST['pass'];
   $email = $_POST['email'];
   $adminPass = $_POST['adminPass'];
   $adminName = $_POST['adminName'];
   $adminMobil = $_POST['adminMobile'];
   $teamName = $_POST['teamName'];
   $team = null;

   $sql3 = "SELECT * FROM `adminname` WHERE admin_password = '$adminPass' AND admin_name='$adminName' AND admin_mobile_no='$adminMobil' AND team='$teamName' ";
   $result2 = $conn->query($sql3);
   if ($result2->num_rows > 0) {
      $row = $result2->fetch_assoc(); // Use $result2 instead of $result
      if ($row['permision'] == 1) {
         $sql1 = "INSERT INTO `accounts` (`id`, `user_name`, `mobile_no`, `pass`,`team`,`email_id`) VALUES (NULL, '$name', '$mobile', '$pass','$team','$email')";
         $res1 = mysqli_query($conn, $sql1);
         $res2 = 0;
         if ($res1) {
            $sql2 = "INSERT INTO `deposite` (`id`, `mobile_no`, `user_name`, `deposite`, `team`) VALUES (NULL, '$mobile', '$name', 0, '$team');";
            $res2 = mysqli_query($conn, $sql2);
         }
         $conn->close();

         if ($res1 && $res2) {
            echo "Account Created successfuly..";
         } else {
            echo 'error to create..';
         }
      } else {
         http_response_code(202);
         echo "you are not authorized please logout and login repeat  status code 1";
         $conn->close();
      }

   } else {
      http_response_code(202);
      echo "you are not authorized please logout and login repeat Status code 2";
      $conn->close();
   }


}


?>