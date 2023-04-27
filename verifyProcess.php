<?php
session_start();

require "connection.php";

//need already add to session user id and mobile number
$user_id =  $_SESSION["user_id"];
// $user_id =  2;
$tell = $_SESSION["tell"];

//enterd otp number
$otp = $_POST["otp"];

$t =  Database::search("SELECT * FROM `record` WHERE `user_id`='" . $user_id . "' AND `mobile_number`='" . $tell . "' ORDER BY `id` DESC ");
$last_record = $t->fetch_assoc();

// echo $t->num_rows . "---";

if ($t->num_rows >= 5) {

    // Move the result pointer to the 5th row
    mysqli_data_seek($t, 4);

    // Fetch the 5th row
    $fifth_record = $t->fetch_assoc();

    $phpdate_5 = strtotime($fifth_record['created_time']);
    $created_time_5 = date('Y-m-d H:i:s', $phpdate_5);

    $current_time = date('Y-m-d H:i:s', time());
    $time_end_5 = date('Y-m-d H:i:s', strtotime($current_time . ' -1 hours'));

    if ($time_end_5 < $created_time_5) {

        echo "You have reached the maximum amount of SMS codes to send. Please try again in 1 hour. If you are still experiencing issues, please contact support.";
    } else {

        if ($otp == $last_record['verification_code']) {

            $phpdate = strtotime($last_record['created_time']);
            $created_time = date('Y-m-d H:i:s', $phpdate);

            $current_time = date('Y-m-d H:i:s', time());

            $time_end = date('Y-m-d H:i:s', strtotime($current_time . ' -3 minutes'));

            if ($time_end < $created_time) {
                echo "success";

                //verify status update....
                Database::iud("UPDATE `user_status` SET `is_verified` = '1' WHERE `user_id` = '".$user_id."'");
            } else {
                echo "This code has expired. Please click the Resend button to send a new one.";
            }
        } else {
            echo "Invalid OTP";
        }
    }
} else {


    if ($otp == $last_record['verification_code']) {

        $phpdate = strtotime($last_record['created_time']);
        $created_time = date('Y-m-d H:i:s', $phpdate);

        $current_time = date('Y-m-d H:i:s', time());

        $time_end = date('Y-m-d H:i:s', strtotime($current_time . ' -3 minutes'));

        if ($time_end < $created_time) {
            echo "success";

            //verify status update....
            Database::iud("UPDATE `user_status` SET `is_verified` = '1' WHERE `user_id` = '".$user_id."'");

        } else {
            echo "This code has expired. Please click the Resend button to send a new one.";
        }
    } else {
        echo "Invalid OTP";
    }
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
