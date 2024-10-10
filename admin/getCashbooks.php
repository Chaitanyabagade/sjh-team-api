<?php
     header('Access-Control-Allow-Origin: *');
     include '../configuration.php';
     $conn=new mysqli($server,$origin,$pass,$databasename);
    
     if(mysqli_connect_error()){
        echo mysqli_connect_error();
        exit();
     }
     else{ 
            $team=$_POST['team'];
            $admin_name = $_POST['admin_name'];

           // $team='chaitanya';
           // $admin_name ='ram bagade';
            
            http_response_code(200);
            $query ="SELECT * FROM `cashbook` WHERE team='$team' AND  user_name ='$admin_name' ";
            $stmt=$conn->prepare($query);
            $stmt->execute();
            $resultSet = $stmt->get_result();
            $data = $resultSet->fetch_all(MYSQLI_ASSOC);
        
            $conn->close();
            echo json_encode($data);
     }
?>