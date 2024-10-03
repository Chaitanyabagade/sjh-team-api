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
        $r_date=$_POST['r_date'];
        $loan_type=$_POST['loan_type'];
        
       
         $sql="INSERT INTO `loan` (`id`, `user_name`, `mobile_no`, `team`, `loan_amt`, `loan_type`, `get_date`, `r_date`, `loan_status`) VALUES (NULL, '$name','', '$team', '$amount', '$loan_type', '$get_date', '$r_date', 'Get')";
         
          $res=mysqli_query($conn,$sql);
          $conn->close();
          echo $res;
          
     }
     
     
?>