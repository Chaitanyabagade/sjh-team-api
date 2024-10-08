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
       
        $amount=$_POST['amount'];
        $team=$_POST['team'];
        $note=$_POST['note'];
        $date=$_POST['date'];

       
        
         $sql="INSERT INTO `expendature` (`id`, `expendature`, `team`, `Date`, `note`) VALUES (NULL, '$amount', '$team', '$date', '$note')";
         
         $res=mysqli_query($conn,$sql);



          //// for getting the eamil id///////////////////////////
          $name="Ram Bagade";
          $sql3 = "SELECT * FROM `accounts` WHERE team = '$team'";
          $result2 = $conn->query($sql3);
          $email = "chaitanyabagadea07@gmail.com"; // This can be a fallback value if needed
          $html='<html>
                    <body style="font-size:20px;padding:15px;background-color: rgb(231, 248, 227);">
                         <div style=""><b>The Expendature of Sjh team On Day '.$date.' is Rs.'.$amount.' For '.$note.'</b></div>
                     </body>
                 </html>';
          
          if ($result2->num_rows > 0) {
             while( $row = $result2->fetch_assoc()){
               smtp_mailer($row['email_id'],'The Expendature of Sjh team',$html);
              
             }  
          } 
       
         $conn->close();
         
          
     }
     
     
?>