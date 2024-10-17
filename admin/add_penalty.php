<?php
header('Access-Control-Allow-Origin: *');
include '../configuration.php';
include('smtp/PHPMailerAutoload.php');
include 'email.php';
$conn = new mysqli($server, $origin, $pass, $databasename);

if (mysqli_connect_error()) {
    echo mysqli_connect_error();
    exit();
} else {

    $name = $_POST['name'];
    $amount = $_POST['amount'];
    $team = $_POST['team'];
    $note = $_POST['note'];
    $date = $_POST['date'];

    $adminname = $_POST['admin_name'];
    $adminmobile = $_POST['mobile_no'];
    $sqlcheckadmin = "SELECT * FROM `adminname` WHERE admin_name='$adminname' AND admin_mobile_no ='$adminmobile'";
    $rescheckadmin = $conn->query($sqlcheckadmin);
    if ($rescheckadmin->num_rows > 0) {
        $rowcheck = $rescheckadmin->fetch_assoc();
        if ($rowcheck['permision']) {


            $sql = "INSERT INTO `penalty` (`id`, `user_name`, `penalty`, `team`, `Date`, `note` ,`last_paid_date`) VALUES (NULL, '$name', '$amount', '$team', '$date', '$note',now());";

            $res = mysqli_query($conn, $sql);

/////////////////////////////////// email //////////////////////////////////////////////////////
            $sql3 = "SELECT * FROM `accounts` WHERE user_name = '$name'";
            $result2 = $conn->query($sql3);
            $email = "chaitanyabagadea07@gmail.com"; // This can be a fallback value if needed
            if ($result2->num_rows > 0) {
                $row = $result2->fetch_assoc(); // Use $result2 instead of $result
                $email = $row['email_id'];
            }
        
            $html = '<html>
         <body style="font-size:20px;padding:0px;background-color: rgb(231, 248, 227);">
             <div style=""><b>Thank you for Paid  Rs.' . $amount . ' Penalty for ' . $note . ', If not then contact to the manager.</b></div>
         </body>
         </html>';
            $subject = "You Paid the Penalty $amount of sjh team";
            smtp_mailer($email, $subject, $html);
            ///////////////////////// Email send ends////////////////////////////////////////

            ///////////////////////////// adding cashbook entry ///////////////////////////////////////////////////////////////////////////////////////////////////////////

            $adminNumber = $_POST['mobile_no'];
            $adminName = $_POST['admin_name'];
            $amount_cash = $amount;

            $note = "Add penalty " . $amount . " of Member ".$name." In your Bank Account";

            $sqlcashbook = "INSERT INTO `cashbook` (`id`, `user_name`, `amount`, `note`, `team`,`last_paid_date`) VALUES (NULL, '$adminName', '$amount_cash', '$note','$team',now())";
            $result_cashbook = mysqli_query($conn, $sqlcashbook);
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            http_response_code(200);
            $conn->close();
            echo $res;

        } else {
            http_response_code(202);
            echo "you are not authorized please logout and login repeat";
            $conn->close();
        }

    } else {
        http_response_code(202);
        echo "you are not authorized please logout and login repeat";
        $conn->close();
    }

}

?>