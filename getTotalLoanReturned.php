<?php
     header('Access-Control-Allow-Origin: *');
     include 'configuration.php';
     $conn=new mysqli($server,$origin,$pass,$databasename);
    
     if(mysqli_connect_error()){
        echo mysqli_connect_error();
        exit();
     }
     else{ 
            // $team=$_POST['name'];
             $team='chaitanya';
             http_response_code(200);
             $sql = "SELECT * from `loan` where `team`='$team' AND `loan_status`!='Get'";
             $result = $conn->query($sql);
             $total=0;
             while($row = mysqli_fetch_array($result)){
                 $total+=$row['loan_amt'];
             }
             $conn->close();
             echo $total;
     }
?>