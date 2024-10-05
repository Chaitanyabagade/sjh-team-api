<?php
     header('Access-Control-Allow-Origin: *');
     include 'configuration.php';
     $conn=new mysqli($server,$origin,$pass,$databasename);
     $outp="";
     if(mysqli_connect_error()){
        echo mysqli_connect_error();
        exit();
     }
     else{
         
        $name=$_POST['name'];
        $mobile=$_POST['mobile'];
        $pass=$_POST['pass'];
          
        $content=$name."   ".$mobile."\n";
        file_put_contents("user_login_log_file.txt", $content, FILE_APPEND); 
     
        $sql="SELECT * FROM `accounts` WHERE user_name='$name' AND mobile_no ='$mobile' AND pass='$pass'";
        $res=mysqli_query($conn,$sql);

        if($res){
            http_response_code(200);
            $rs=mysqli_fetch_array($res);
            $outp.='{"mobile_no":"'.$rs['mobile_no'].'",';
            $outp.='"user_name":"'.$rs['user_name'].'",';
            $outp.='"team":"'.$rs['team'].'",';
            $outp.='"Status":"200"}';
            echo $outp;
        }
        else{
              $outp.='"Status":"202"}';
              echo $outp;
        }
        $conn->close();
     }
?>