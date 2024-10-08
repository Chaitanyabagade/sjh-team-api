<?php
     header('Access-Control-Allow-Origin: *');
     include '../configuration.php';
     include('smtp/PHPMailerAutoload.php');
     include 'email.php';
     $conn=new mysqli($server,$origin,$pass,$databasename);
    
     if(mysqli_connect_error()){
        echo mysqli_connect_error();
        exit();
     }
     else{
        $name=$_POST['name'];
        $amount=$_POST['amount'];
        $team=$_POST['team'];
        $note=$_POST['note'];
        $date=$_POST['date'];
        
       
        
          
         $sql="INSERT INTO `penalty` (`id`, `user_name`, `penalty`, `team`, `Date`, `note`) VALUES (NULL, '$name', '$amount', '$team', '$date', '$note');";
         
         $res=mysqli_query($conn,$sql);


         $sql3 = "SELECT * FROM `accounts` WHERE user_name = '$name'";
         $result2 = $conn->query($sql3);
         $email = "chaitanyabagadea07@gmail.com"; // This can be a fallback value if needed
         if ($result2->num_rows > 0) {
             $row = $result2->fetch_assoc(); // Use $result2 instead of $result
             $email = $row['email_id'];
         } 
         $html='<html>
         <body style="font-size:20px;padding:0px;background-color: rgb(231, 248, 227);">
             <div style=""><b>Thank you for Paid  Rs.'.$amount.' Penalty for '.$note.', If not then contact to the manager.</b></div>
         </body>
         </html>';
         $subject="You Paid the Penalty $amount of sjh team";
         smtp_mailer($email,$subject,$html);

         $conn->close();
          echo $res;
          
     }
     
     
?>