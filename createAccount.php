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
        $email=$_POST['email'];
        $adminPass=$_POST['adminPass'];
        $team=null;

        if($adminPass==='Chaitanya@701'){
           $team="chaitanya";
        }
        else if($adminPass==='Tushar@303'){
           $team="tushar";
        }
        else if($adminPass==='Onkar@999'){
           $team="onkar";
        }
        else{
          echo "admin password is worng";
          $conn->close();
          exit(0);
        }
        $sql1="INSERT INTO `accounts` (`id`, `user_name`, `mobile_no`, `pass`,`team`,`email_id`) VALUES (NULL, '$name', '$mobile', '$pass','$team','$email')";
        $res1=mysqli_query($conn,$sql1);
        $res2=0;
        if($res1){
            $sql2="INSERT INTO `deposite` (`id`, `mobile_no`, `user_name`, `deposite`, `team`) VALUES (NULL, '$mobile', '$name', 0, '$team');";
            $res2=mysqli_query($conn,$sql2); 
        }
        $conn->close();
        
        if($res1 && $res2){
            echo "success";
        }
        else{
             echo 'error to create';
        }
      } 
    
    
?>