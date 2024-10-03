<?php
     header('Access-Control-Allow-Origin: *');
     include 'configuration.php';
     $conn=new mysqli($server,$origin,$pass,$databasename);
    
     if(mysqli_connect_error()){
        echo mysqli_connect_error();
        exit();
     }
     else{
        $name=$_POST['name'];
        $mobile=$_POST['mobile'];
        $pass=$_POST['pass'];
        $adminPass=$_POST['adminPass'];
      if($adminPass==='Chaitanya@701'){
        $team="chaitanya";
        $sql="INSERT INTO `accounts` (`id`, `user_name`, `mobile_no`, `pass`,`team`) VALUES (NULL, '$name', '$mobile', '$pass','$team')";
        
        $sql2="INSERT INTO `deposite` (`id`, `mobile_no`, `user_name`, `deposite`, `team`) VALUES (NULL, '$mobile', '$name', 0, '$team');";
        
       
       
        $res=mysqli_query($conn,$sql);
        $res2=mysqli_query($conn,$sql2);
      

        if($res && $res2 ){
            echo "success";
        }
        else{
             echo 'error to create';
        }
      }
      else if($adminPass==='Tushar@303'){
        $team="tushar";
        $sql="INSERT INTO `accounts` (`id`, `user_name`, `mobile_no`, `pass`,`team`) VALUES (NULL, '$name', '$mobile', '$pass','$team')";
        $sql2="INSERT INTO `deposite` (`id`, `mobile_no`, `user_name`, `deposite`, `team`) VALUES (NULL, '$mobile', '$name', 0, '$team');";
        $res2=mysqli_query($conn,$sql2);
        $res=mysqli_query($conn,$sql);

        if($res && $res2){
            echo "success";
        }
        else{
             echo 'error to create';
        }
      }
      else if($adminPass==='Onkar@999'){
        $team="onkar";
        $sql="INSERT INTO `accounts` (`id`, `user_name`, `mobile_no`, `pass`,`team`) VALUES (NULL, '$name', '$mobile', '$pass','$team')";
         $sql2="INSERT INTO `deposite` (`id`, `mobile_no`, `user_name`, `deposite`, `team`) VALUES (NULL, '$mobile', '$name', 0, '$team');";
        $res2=mysqli_query($conn,$sql2);
        $res=mysqli_query($conn,$sql);

        if($res && $res2){
            echo "success";
        }
        else{
             echo 'error to create';
        }
      }
      else{
          echo "Admin Password is Incorrect";
      }
      $conn->close();
     }
?>