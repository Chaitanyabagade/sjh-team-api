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
    $admin1 = $_POST['admin1'];
    $admin2 = $_POST['admin2'];
    $amount = $_POST['amount'];
    $team = $_POST['team'];
    $gadminpass = $_POST['gadminpass'];

    if ($gadminpass === 'Janaki123456789') {

        ///////////////////////////// add substarct  amount cashbook entry ///////////////////////////////////////////////////////////////////////////////////////////////////////////

        $amount_cash = -$amount;
        $note = "Transfered amount " . $amount . " To " . $admin2 . " From In your Bank Account";

        $sqlcashbook = "INSERT INTO `cashbook` (`id`, `user_name`, `amount`, `note`, `team`) VALUES (NULL, '$admin1', '$amount_cash', '$note', '$team')";
        $result_cashbook = mysqli_query($conn, $sqlcashbook);
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        ///////////////////////////// add  amount cashbook entry ///////////////////////////////////////////////////////////////////////////////////////////////////////////

        $amount_cash = $amount;
        $note = "Get amount " . $amount . " From " . $admin1 . " In your Bank Account";

        $sqlcashbook = "INSERT INTO `cashbook` (`id`, `user_name`, `amount`, `note`, `team`) VALUES (NULL, '$admin2', '$amount_cash', '$note', '$team')";
        $result_cashbook = mysqli_query($conn, $sqlcashbook);
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        http_response_code(200);
        echo "yes";
        $conn->close();
    } else {
        http_response_code(202);
        echo "no";
        $conn->close();
    }
}


?>