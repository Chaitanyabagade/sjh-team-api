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
          $conn->close();
          echo $res;
          
     }
     
     
?>