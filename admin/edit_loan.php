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
        $status=$_POST['status'];
        $id=$_POST['id'];
      
       
       
        
         $sql="update loan set loan_status = '$status' where `id`='$id' AND `user_name`='$name' ";
         
          $res=mysqli_query($conn,$sql);
          $conn->close();
          echo $res;
          
     }
     
     
?>