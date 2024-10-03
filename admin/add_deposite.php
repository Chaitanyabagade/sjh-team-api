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
       
        
         $sql="UPDATE `deposite` set deposite=('$amount'+(select deposite from `deposite` where user_name='$name' AND team='$team')) where user_name='$name' AND team='$team'";
          $res=mysqli_query($conn,$sql);
          $conn->close();
          echo $res;
          
     }
     
     
?>