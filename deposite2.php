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
            $query ="SELECT * FROM `deposite` WHERE team='$team'";
            $stmt=$conn->prepare($query);
            $stmt->execute();
            $resultSet = $stmt->get_result();
            $deposite = $resultSet->fetch_all(MYSQLI_ASSOC);
        
            $conn->close();
            echo json_encode($deposite);
           
     }
     
?>