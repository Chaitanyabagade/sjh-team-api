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
       $team=$_POST['team'];
       $lastDate=$_POST['lastDate'];
       $id=$_POST['id'];

     

        $sql1="select * from loan where `id`='$id' AND `user_name`='$name' AND `team`='$team'";
        $res1=mysqli_query($conn,$sql1);
        $res2=mysqli_fetch_array($res1);
       
        $loan_amt=$res2['loan_amt'];
        $loan_amt_returned=$res2['loan_amt_returned'];
        $loan_amt_intrest=$res2['loan_amt_intrest'];
        $loan_amt_intrest_returned=$res2['loan_amt_intrest_returned'];
        $EMI_duration=$res2['EMI_duration'];
        $count=$res2['EMI_count'];
        $EMI_amt=$res2['EMI_amt'];
        $EMI_rate=$res2['EMI_rate'];

        if($loan_amt <= ($loan_amt_returned) || ($loan_amt) <=($loan_amt_returned+5) ){
           echo 'Aclear';
           $conn->close();
           exit();
           
        }
        else{
           // adding the emi to the loan table
           $loan_amt_return_set=$loan_amt/$EMI_duration;
           $setReturnLoan=$loan_amt_returned + $loan_amt_return_set;
           $sql3="update loan set `loan_amt_returned`='$setReturnLoan' where `id`='$id' AND `user_name`='$name' AND `team`='$team'";
           $res3=mysqli_query($conn,$sql3);

           // adding the intrest to loan table
           $loan_amt_intrest_set=$loan_amt_intrest/$EMI_duration;
           $setReturnIntrest=$loan_amt_intrest_returned+$loan_amt_intrest_set;
           $sql4="update loan set `loan_amt_intrest_returned`='$setReturnIntrest' where `id`='$id' AND `user_name`='$name' AND `team`='$team'";
           $res4=mysqli_query($conn,$sql4);
            
           //adding the EMI count
            $setcount=$count+1;
            $sql5="update loan set `EMI_count`='$setcount' where `id`='$id' AND `user_name`='$name' AND `team`='$team'";
            $rsdf=mysqli_query($conn,$sql5);

             //adding last emi paid data
            
             $sql6="update loan set `last_paid_date`='$lastDate' where `id`='$id' AND `user_name`='$name' AND `team`='$team'";
             $rstry=mysqli_query($conn,$sql6);
 


       
            //////////////// dont do anything this is email form////////////////////////////
          $html='<html>
            <body style="font-size:20px;padding:0px;background-color: rgb(231, 248, 227);">
           <div style=""><b>Thank you for Paid '.$EMI_amt.' EMI of Loan Id '.$id.' Of SJH Loan  If not then contact to the manager.</b></div>
           <br/><b><i>Loan Updated details =></i></b><br/> <br>
           <table style="width:100%;font-size:15px;border:10px solid gainsboro ;padding:5px;border-radius: 10px; ">
                <tr>
                  <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">Loan id</td>
                  <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);">'.$id.'</td>
              </tr>
              <tr>
                  <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">User Name</td>
                  <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);">'.$name.'</td>
              </tr>
              <tr>
                  <td style="padding:15px;width:50%;border:5px solid rgb(238, 148, 3)">EMI Paid Date</td>
                  <td style="padding:15px;width:50%;border:5px solid rgb(238, 148, 3);text-align:right;">'.$lastDate.'</td>
              </tr>
              <tr>
                   <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">Loan Amount</td>
                   <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);text-align:right;">'.$loan_amt.'</td>
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
                  <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">Team Name </td>
                  <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);text-align:right;">'.$team.'</td>
              </tr>
              <tr>
                  <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">Loan Duration <br>(In Months)</td>
                  <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);text-align:right;">'.$EMI_duration.'</td>
              </tr>
              
               <tr>
                  <td style="padding:15px;width:60%;border:5px solid rgb(238, 148, 3)">No.of EMI Paid </td>
                  <td style="padding:15px;width:40%;border:5px solid rgb(238, 148, 3);text-align:right;">'.$setcount.'</td>
              </tr>
       
           </table>
            
            </body>
               </html>';
  
         ///////// Check the updated data///////////////
         $sql1="select * from loan where `id`='$id' AND `user_name`='$name' AND `team`='$team'";
         $res1=mysqli_query($conn,$sql1);
         $res2=mysqli_fetch_array($res1);
        
         $loan_amt=$res2['loan_amt'];
         $loan_amt_returned=$res2['loan_amt_returned'];
         $loan_amt_intrest=$res2['loan_amt_intrest'];
         $loan_amt_intrest_returned=$res2['loan_amt_intrest_returned'];
         $EMI_duration=$res2['EMI_duration'];
         $count=$res2['EMI_count'];
      

///////////////////////////////// end of email form ///////////////////////////////////////////////////////////////
      // check updated data loan is clear or not
             if($loan_amt <= ($loan_amt_returned) || ($loan_amt) <=($loan_amt_returned+5) ){
               $sqll="update loan set `status`='Clear' where `id`='$id' AND `user_name`='$name' AND `team`='$team'";
               $r=mysqli_query($conn,$sqll);
              

               $sqlc = "SELECT * FROM `accounts` WHERE user_name = '$name'";
               $result2 = $conn->query($sqlc);
               $email = "chaitanyabagadea07@gmail.com"; // This can be a fallback value if needed
               if ($result2->num_rows > 0) {
                   $row = $result2->fetch_assoc(); // Use $result2 instead of $result
                   $email = $row['email_id'];
               } 

               echo 'Nclear';
               smtp_mailer($email,'You Paid The EMI Of SJH Loan of This month and your loan EMI is Clear Thank you.... ',$html);
               
                $conn->close();
                exit();
               
            }
     ///////////////////////////////////////////////////////////   
       
         $sql9 = "SELECT * FROM `accounts` WHERE user_name = '$name'";
         $result2 = $conn->query($sql9);
        

        $email = "chaitanyabagadea07@gmail.com"; // This can be a fallback value if needed
         if ($result2->num_rows > 0) {
           $row = $result2->fetch_assoc(); // Use $result2 instead of $result
           $email = $row['email_id'];
        } 

        echo 'yes';
        smtp_mailer($email,'You Paid The EMI Of SJH Loan of This month ',$html);
       
      
        $conn->close();
        exit();
       
    }
  
 }


     
     
?>