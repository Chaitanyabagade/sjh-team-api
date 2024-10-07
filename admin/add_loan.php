<?php
    
     header('Access-Control-Allow-Origin: *');
     include '../configuration.php';
     include('smtp/PHPMailerAutoload.php');
     $conn=new mysqli($server,$origin,$pass,$databasename);
    
     if(mysqli_connect_error()){
        echo mysqli_connect_error();
        exit();
     }
     else{
        $name=$_POST['name'];
        $amount=$_POST['amount'];
        $team=$_POST['team'];
        $get_date=$_POST['get_date'];
        $EMI_duration=$_POST['duration'];
        $loan_type=$_POST['loan_type'];
 
    
         
        $EMI_rate=0.0;
        if($EMI_duration <= 3){
           $EMI_rate=2.0;
        }
        else if($EMI_duration <= 6){
           $EMI_rate=2.3;
        }
        else if($EMI_duration <= 8){
           $EMI_rate=2.6;
        }
        else if($EMI_duration <= 10){
           $EMI_rate=3.0;
        }
        else if($EMI_duration <= 11){
           $EMI_rate=3.5;
        }
        else{
            $EMI_rate=4.0;
        }
    




        ///count $intrest
       
        $intrest= (($amount/100) *$EMI_rate) *$EMI_duration ;
      
        // count $EMI_amt
        $EMI_amt=($amount+$intrest)/$EMI_duration;
        

       
          $sql="INSERT INTO `loan` (`id`, `user_name`, `team`, `loan_amt`, `loan_amt_returned`, `loan_amt_intrest`, `loan_amt_intrest_returned`, `loan_type`, `EMI_amt`, `EMI_duration`, `EMI_count`, `EMI_rate`, `Loan_date`,`status`) VALUES (NULL, '$name', '$team', '$amount',0, '$intrest',0, '$loan_type', '$EMI_amt', '$EMI_duration',0, '$EMI_rate', '$get_date','Pending..')";
          $res=mysqli_query($conn,$sql);
        
          



         

         $html='<html>
      <body style="font-size:20px;padding:0px;background-color: rgb(231, 248, 227);">
     <div style=""><b>Thank you for getting loan from sjh production, You Have Get The Loan of '.$amount.' Rupees If not then contact to the manager.</b></div>
     <br/><b><i>Loan Details =></i></b><br/> <br>
     <table style="width:100%;font-size:15px;border:10px solid gainsboro ;padding:5px;border-radius: 10px; ">
         <tr>
            <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">User Name</td>
            <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);">'.$name.'</td>
        </tr>
        <tr>
            <td style="padding:15px;width:50%;border:5px solid rgb(238, 148, 3)">Date</td>
            <td style="padding:15px;width:50%;border:5px solid rgb(238, 148, 3);text-align:right;">'.$get_date.'</td>
        </tr>
        <tr>
             <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">Loan Amount</td>
             <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);text-align:right;">'.$amount.'</td>
         </tr>
         <tr>
            <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">Monthly EMI Amount to Pay</td>
            <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);text-align:right;"> '.$EMI_amt.'</td>
        </tr>
        <tr>
            <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">Loan Rate</td>
            <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);text-align:right;">'.$EMI_rate.'</td>
        </tr>
        <tr>
            <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">Loan Duration <br>(In Months)</td>
            <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);text-align:right;">'.$EMI_duration.'</td>
        </tr>
         <tr>
            <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">Team Name </td>
            <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);text-align:right;">'.$team.'</td>
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
          smtp_mailer($email,'You Geted the Loan from sjh',$html);
          $conn->close();
          echo $res;
          
     }

     function smtp_mailer($to,$subject, $msg){
      $mail = new PHPMailer(); 
      $mail->IsSMTP(); 
      $mail->SMTPAuth = true; 
      $mail->SMTPSecure = 'tls'; 
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 587; 
      $mail->IsHTML(true);
      $mail->CharSet = 'UTF-8';
      //$mail->SMTPDebug = 2; 
      $mail->Username = "chaitanyabagade59@gmail.com";
      $mail->Password = "kkog qgca jzcu ixig";
      $mail->SetFrom("chaitanyabagade59@gmail.com");
      $mail->Subject = $subject;
      $mail->Body =$msg;
      $mail->AddAddress($to);
      $mail->SMTPOptions=array('ssl'=>array(
         'verify_peer'=>false,
         'verify_peer_name'=>false,
         'allow_self_signed'=>false
      ));
      if(!$mail->Send()){
         echo $mail->ErrorInfo;
      }else{
         return 'Sent';
      }
   }
     
     
?>