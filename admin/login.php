<?php
        header('Access-Control-Allow-Origin: *');
        include '../configuration.php';
        $conn=new mysqli($server,$origin,$pass,$databasename);
    
        $outp="";
        
        $name=$_POST['name'];
        $mobile=$_POST['mobile'];
        $pass=$_POST['pass'];

        if(mysqli_connect_error()){
           echo mysqli_connect_error();
           exit();
        }
        else{
            $sqlcheckadmin="SELECT * FROM `adminname` WHERE admin_name='$name' AND admin_mobile_no ='$mobile' AND admin_password='$pass' AND permision=1";
            $rescheckadmin = $conn->query($sqlcheckadmin);
            
            if($rescheckadmin->num_rows > 0){
                  $rowcheck = $rescheckadmin->fetch_assoc();
                  $team=$rowcheck['team'];
                  http_response_code(200); 
                  $outp.='{"mobile_no":"'.$mobile.'",';
                  $outp.='"user_name":"'.$name.'",';
                  $outp.='"team":"'.$team.'",';
                  $outp.='"Status":"200"}';
                  echo $outp;
            }
            else{
                http_response_code(202);
                echo $outp;
            }
             
            $conn->close();
        }  
    
?>


