<?php

session_start();
require "connection.php";

$tell = $_SESSION['tell'];
// $user_id = $_SESSION["user_id"];   we get user id from session.

$user_id = "1";  // we imaging logged user id is 1.....

//current time...
$time = time();
$current_time = (date("Y-m-d H:i:s", $time));




//secure query update//
Database::setUpConnection();

$query_1 = "SELECT * FROM `record` WHERE `user_id`=? AND `mobile_number`=? ORDER BY `id` DESC ";
$stmt_1 = Database::$connection->prepare($query_1);
$stmt_1->bind_param("is", $user_id, $tell);
$stmt_1->execute();
$result_1 = $stmt_1->get_result();
$last_record = $result_1->fetch_assoc();
//secure query update//




// $t =  Database::search("SELECT * FROM `record` WHERE `user_id`='" . $user_id . "' AND `mobile_number`='" . $tell . "' ORDER BY `id` DESC ");
// $last_record = $t->fetch_assoc();

if ($result_1->num_rows >= 7) {

    // Move the result pointer to the 5th row
    mysqli_data_seek($result_1, 4);

    // Fetch the 5th row
    $fifth_record = $result_1->fetch_assoc();

    $phpdate_5 = strtotime($fifth_record['created_time']);
    $created_time_5 = date('Y-m-d H:i:s', $phpdate_5);

    $time_end_5 = date('Y-m-d H:i:s', strtotime($current_time . ' -1 hours'));

    if ($time_end_5 > $created_time_5) {
        echo "You have reached the maximum amount of SMS codes to send. Please try again in 1 hour. If you are still experiencing issues, please contact support.";
    } else {
        //digit...
        $digit = random_int(100000, 999999);
        $dest = str_replace("+", "", $tell);
        $url = "https://smsc.txtnation.com:8093/sms/send_sms.php?dst=$dest&msg=$digit&dr=0&type=0&src=Timebucks&user=timebucks&password=jninXiV9";
        // $url = 'https://nie.lk/pdffiles/tg/AL_Syl%20Physics.pdf';

        $res = file_get_contents($url);
        //secure query update//
        $query_2 = "INSERT INTO `record`(`user_id`,`mobile_number`,`verification_code`,`created_time`) VALUES (?,?,?,?) ";
        $stmt_2 = Database::$connection->prepare($query_2);
        $stmt_2->bind_param("isis", $user_id, $tell, $digit, $current_time);
        $stmt_2->execute();
        //secure query update//


        // // record, digit save our database 
        // Database::iud("INSERT INTO `record`(`user_id`,`mobile_number`,`verification_code`,`created_time`) VALUES ('" . $user_id . "','" . $tell . "','" . $digit . "','" . $current_time . "') ");

        echo "success";
    }
} else {
    //digit...
    $digit = random_int(100000, 999999);

    $desc = str_replace("+", "", $tell);
    $request = "https://smsc.txtnation.com:8093/sms/send_sms.php?dst=$desc&msg=$digit&dr=0&type=0&src=Timebucks&user=timebucks&password=jninXiV9";
    $res = file_get_contents($request);
    //secure query update//
    $query_2 = "INSERT INTO `record`(`user_id`,`mobile_number`,`verification_code`,`created_time`) VALUES (?,?,?,?) ";
    $stmt_2 = Database::$connection->prepare($query_2);
    $stmt_2->bind_param("isis", $user_id, $tell, $digit, $current_time);
    $stmt_2->execute();
    //secure query update//


    // // record, digit save our database 
    // Database::iud("INSERT INTO `record`(`user_id`,`mobile_number`,`verification_code`,`created_time`) VALUES ('" . $user_id . "','" . $tell . "','" . $digit . "','" . $current_time . "') ");

    echo "success";
}
