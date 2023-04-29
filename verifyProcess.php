<?php
session_start();

require "connection.php";

//need already add to session user id and mobile number
$user_id =  $_SESSION["user_id"];
// $user_id =  2;
$tell = $_SESSION["tell"];

//enterd otp number
$otp = $_POST["otp"];



//secure query update//
Database::setUpConnection();

$query_1 = "SELECT * FROM `record` WHERE `user_id`=? AND `mobile_number`=? ORDER BY `id` DESC  ";
$stmt_1 = Database::$connection->prepare($query_1);
$stmt_1->bind_param("is", $user_id, $tell);
$stmt_1->execute();
$result_1 = $stmt_1->get_result();
$last_record = $result_1->fetch_assoc();
//secure query update//



// $t =  Database::search("SELECT * FROM `record` WHERE `user_id`='" . $user_id . "' AND `mobile_number`='" . $tell . "' ORDER BY `id` DESC ");
// $last_record = $t->fetch_assoc();


if ($otp == $last_record['verification_code']) {

    $phpdate = strtotime($last_record['created_time']);
    $created_time = date('Y-m-d H:i:s', $phpdate);

    $current_time = date('Y-m-d H:i:s', time());

    $time_end = date('Y-m-d H:i:s', strtotime($current_time . ' -3 minutes'));

    if ($time_end < $created_time) {
        echo "success";

        //secure query update//
        $query_2 = "UPDATE `user_status` SET `is_verified` = '1', `verified_mobile`=? WHERE `user_id` =?  ";
        $stmt_2 = Database::$connection->prepare($query_2);
        $stmt_2->bind_param("si", $tell , $user_id);
        $stmt_2->execute();
        //secure query update//

        //verify status update....
        // Database::iud("UPDATE `user_status` SET `is_verified` = '1', `verified_mobile`='" . $tell . "' WHERE `user_id` = '" . $user_id . "'");
    } else {
        echo "This code has expired. Please click the Resend button to send a new one.";
    }
} else {
    echo "Invalid OTP";
}








// if ($otp == $last_record['verification_code']) {

//     $phpdate = strtotime($last_record['created_time']);
//     $created_time = date('Y-m-d H:i:s', $phpdate);

//     $current_time = date('Y-m-d H:i:s', time());

//     $time_end = date('Y-m-d H:i:s', strtotime($current_time . ' -3 minutes'));

//     if ($time_end < $created_time) {
//         echo "success";
//     } else {
//         echo "This code has expired. Please click the Resend button to send a new one.";
//     }
// } else {
//     echo "Invalid OTP";
// }
