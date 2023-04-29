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



//secure query update//
Database::setUpConnection();

$query_1 = "SELECT * FROM `user_status` WHERE `verified_mobile`=? ";
$stmt_1 = Database::$connection->prepare($query_1);
$stmt_1->bind_param("s", $tell);
$stmt_1->execute();
$user_status_t = $stmt_1->get_result();
//secure query update//




// $user_status_t = Database::search("SELECT * FROM `user_status` WHERE `verified_mobile`='".$tell."' ");

if ($user_status_t->num_rows > 0) {

    echo "This number has been previously used before. You can only have one TimeBucks account. If you think this is an error, please contact support.";
} else {


    //secure query update//
    Database::setUpConnection();

    $query_3 = "SELECT * FROM `user_status` WHERE  `user_id`=? ";
    $stmt_3 = Database::$connection->prepare($query_3);
    $stmt_3->bind_param("i", $_SESSION["user_id"]);
    $stmt_3->execute();
    $result_3 = $stmt_3->get_result();
    $user = $result_3->fetch_assoc();
    //secure query update//


    // $t = Database::search("SELECT * FROM `user_status` WHERE  `user_id`='" . $_SESSION["user_id"] . "' ");
    // $user = $t->fetch_assoc();

    if ($user["country_code"] === $country_code) {


        //secure query update//
        Database::setUpConnection();

        $query_2 = "SELECT * FROM `record` WHERE `user_id`=? AND `mobile_number`=? ORDER BY `id` DESC ";
        $stmt_2 = Database::$connection->prepare($query_2);
        $stmt_2->bind_param("is", $_SESSION["user_id"], $tell);
        $stmt_2->execute();
        $result_2 = $stmt_2->get_result();
        $last_record = $result_2->fetch_assoc();
        //secure query update//



        // $t =  Database::search("SELECT * FROM `record` WHERE `user_id`='" . $_SESSION["user_id"] . "' AND `mobile_number`='" . $tell . "' ORDER BY `id` DESC ");
        // $last_record = $t->fetch_assoc();

        if ($result_2->num_rows >= 5) {

            // Move the result pointer to the 5th row
            mysqli_data_seek($result_2, 4);

            // Fetch the 5th row
            $fifth_record = $result_2->fetch_assoc();

            $phpdate_5 = strtotime($fifth_record['created_time']);
            $created_time_5 = date('Y-m-d H:i:s', $phpdate_5);

            $time_end_5 = date('Y-m-d H:i:s', strtotime($current_time . ' -1 hours'));

            if ($time_end_5 < $created_time_5) {

                echo "You have reached the maximum amount of SMS codes to send. Please try again in 1 hour. If you are still experiencing issues, please contact support.";
            } else {
                $digit = random_int(100000, 999999);


                //secure query update//
                $query_2 = "INSERT INTO `record`(`user_id`,`mobile_number`,`verification_code`,`created_time`) VALUES (?,?,?,?) ";
                $stmt_2 = Database::$connection->prepare($query_2);
                $stmt_2->bind_param("isis", $_SESSION["user_id"], $tell, $digit, $current_time);
                $stmt_2->execute();
                //secure query update//


                //         // record, digit save our database temporarlis
                //         Database::iud("INSERT INTO `record`(`user_id`,`mobile_number`,`verification_code`,`created_time`) 
                // VALUES ('" . $_SESSION["user_id"] . "','" . $tell . "','" . $digit . "','" . $current_time . "') ");

                echo "success";
            }
        } else {
            $digit = random_int(100000, 999999);


            //secure query update//
            $query_2 = "INSERT INTO `record`(`user_id`,`mobile_number`,`verification_code`,`created_time`) VALUES (?,?,?,?) ";
            $stmt_2 = Database::$connection->prepare($query_2);
            $stmt_2->bind_param("isis", $_SESSION["user_id"], $tell, $digit, $current_time);
            $stmt_2->execute();
            //secure query update//


            //         // record, digit save our database temporarlis
            //         Database::iud("INSERT INTO `record`(`user_id`,`mobile_number`,`verification_code`,`created_time`) 
            // VALUES ('" . $_SESSION["user_id"] . "','" . $tell . "','" . $digit . "','" . $current_time . "') ");

            echo "success";
        }
    } else {

        echo 'error';
    }
}
