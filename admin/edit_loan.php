<?php
     header('Access-Control-Allow-Origin: *');
     include '../configuration.php';
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

        if($loan_amt <= ($loan_amt_returned) || ($loan_amt) <=($loan_amt_returned+5) ){
           echo 'Aclear';
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

             if($loan_amt <= ($loan_amt_returned) || ($loan_amt) <=($loan_amt_returned+5) ){
               $sqll="update loan set `status`='Clear' where `id`='$id' AND `user_name`='$name' AND `team`='$team'";
               $r=mysqli_query($conn,$sqll);
               echo 'Nclear';
               $conn->close();
               exit(0);
            }
     ///////////////////////////////////////////////////////////   

        
          echo 'yes';


        }

        

        // $sql="update loan set loan_status = '$status' where `id`='$id' AND `user_name`='$name' ";
       // echo $loan_amt ."<br/>".$loan_amt_intrest ."<br/>".$loan_amt_intrest_returned ."<br/>".$loan_amt_returned;
        //  $res=mysqli_query($conn,$sql);
          $conn->close();
         // echo $res;
          
     }
     
     
?>