<?php
     header('Access-Control-Allow-Origin: *');
     include 'configuration.php';
     $conn=new mysqli($server,$origin,$pass,$databasename);
     if(mysqli_connect_error()){
        echo mysqli_connect_error();
        exit();
     }
     else{
            $team=$_POST['name'];
           
             http_response_code(200);
            $query ="SELECT id,user_name,loan_amt,get_date,r_date,loan_type,loan_status, team FROM `loan` WHERE team='$team'";
            
            $stmt=$conn->prepare($query);
            $stmt->execute();
            $resultSet = $stmt->get_result();
            $deposite = $resultSet->fetch_all(MYSQLI_ASSOC);
            
            echo json_encode($deposite);
     }
?>