<?php

require "connection.php";

session_start();

$tell = $_POST["tell"];
$_SESSION["tell"] = $tell;  //telephone number add to session

// imaging logged user s details are in session 
$_SESSION["user_id"] = "1";
// imaging logged user s details are in session 

$time = time();
$current_time = (date("Y-m-d H:i:s", $time));

$country_code = $_POST["country_code"];


$t = Database::search("SELECT * FROM `user_status` WHERE  `user_id`='" . $_SESSION["user_id"] . "' ");
$user = $t->fetch_assoc();

if ($user["country_code"] === $country_code) {


    $t =  Database::search("SELECT * FROM `record` WHERE `user_id`='" . $_SESSION["user_id"] . "' AND `mobile_number`='" . $tell . "' ORDER BY `id` DESC ");
    $last_record = $t->fetch_assoc();

    // echo $t->num_rows . "---";

    if ($t->num_rows >= 5) {

        // Move the result pointer to the 5th row
        mysqli_data_seek($t, 4);

        // Fetch the 5th row
        $fifth_record = $t->fetch_assoc();

        $phpdate_5 = strtotime($fifth_record['created_time']);
        $created_time_5 = date('Y-m-d H:i:s', $phpdate_5);

        $time_end_5 = date('Y-m-d H:i:s', strtotime($current_time . ' -1 hours'));

        if ($time_end_5 < $created_time_5) {

            echo "You have reached the maximum amount of SMS codes to send. Please try again in 1 hour. If you are still experiencing issues, please contact support.";
        } else {
            $digit = random_int(100000, 999999);

            // record, digit save our database temporarlis

            Database::iud("INSERT INTO `record`(`user_id`,`mobile_number`,`verification_code`,`created_time`) 
        VALUES ('" . $_SESSION["user_id"] . "','" . $tell . "','" . $digit . "','" . $current_time . "') ");

            echo "success";
        }
    } else {
        $digit = random_int(100000, 999999);

        // record, digit save our database temporarlis

        Database::iud("INSERT INTO `record`(`user_id`,`mobile_number`,`verification_code`,`created_time`) 
    VALUES ('" . $_SESSION["user_id"] . "','" . $tell . "','" . $digit . "','" . $current_time . "') ");

        echo "success";
    }
} else {

    echo 'error';
}
