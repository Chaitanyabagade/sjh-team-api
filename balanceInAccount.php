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
            $team='chaitanya';
            $balanceAtAccount=(  (getTotalDeposite($team,$conn) + getTotalIntrest($team,$conn) + getTotalPenalty($team,$conn)  )-  (getTotalGetedLoan($team,$conn)+getTotalExpendature($team,$conn) ) );
            $conn->close();
            echo $balanceAtAccount;
             
     }

     function getTotalDeposite($team,$conn){
        $sql = "SELECT * from `deposite` where `team`='$team'";
        $result = $conn->query($sql);
        $total=0;
        while($row = mysqli_fetch_array($result)){
            $total+=$row['deposite'];
        }
        return $total;
     }

     function getTotalIntrest($team,$conn){
        $sql = "SELECT * from `intrest` where `team`='$team'";
        $result = $conn->query($sql);
        $total=0;
        while($row = mysqli_fetch_array($result)){
            $total+=$row['intrest'];
        }
        return $total;
     }

     function getTotalPenalty($team,$conn){
        $sql = "SELECT * from `penalty` where `team`='$team'";
        $result = $conn->query($sql);
        $total=0;
        while($row = mysqli_fetch_array($result)){
            $total+=$row['penalty'];
        }
        return $total;
     }

     function getTotalGetedLoan($team,$conn){
        $sql = "SELECT * from `loan` where `team`='$team' AND `loan_status`='Get'";
        $result = $conn->query($sql);
        $total=0;
        while($row = mysqli_fetch_array($result)){
            $total+=$row['loan_amt'];
        }
        return $total;
     }
   function getTotalExpendature($team,$conn){
     $sql = "SELECT * from `expendature` where `team`='$team'";
     $result = $conn->query($sql);
     $total=0;
     while($row = mysqli_fetch_array($result)){
         $total+=$row['expendature'];
     }
     
     return $total;
    }
?>