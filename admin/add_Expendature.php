<?php
     header('Access-Control-Allow-Origin: *');
     include '../configuration.php';
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
         $conn->close();
          echo $res;
          
     }
     
     
?>