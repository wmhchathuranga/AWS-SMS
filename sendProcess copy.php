<?php

require "connection.php";

session_start();

if (isset($_POST['tell'])) {
    $tell = $_POST["tell"];
    $_SESSION["tell"] = $tell;  //telephone number add to session....
    $country_code = $_POST["country_code"];
    $_SESSION["country_code"] = $country_code;

    sendProcess();
    
} else {

    if(!isset($_SESSION['tell'])){
        header("location: index.php");
    }else{
        sendProcess();
    }

}


function sendProcess(){

    // imaging logged user s details are in session 
    $_SESSION["user_id"] = "1";
    // imaging logged user s details are in session 

    $time = time();
    $current_time = (date("Y-m-d H:i:s", $time));

    //secure query update//
    Database::setUpConnection();

    $query_3 = "SELECT * FROM `user_status` WHERE  `user_id`=? ";
    $stmt_3 = Database::$connection->prepare($query_3);
    $stmt_3->bind_param("i", $_SESSION["user_id"]);
    $stmt_3->execute();
    $result_3 = $stmt_3->get_result();
    $user = $result_3->fetch_assoc();
    //secure query update//


    if ($user['is_verified'] == 1) {
        echo "You are already verified";
    } else {

        $query_4 = "SELECT * FROM `record` WHERE `user_id`='" . $user['user_id'] . "' ";
        $t4 = Database::$connection->query($query_4);

        if ($t4->num_rows >= 5) {
            echo "You have reached the maximum amount of SMS codes to send. If you are still experiencing issues, please contact support.";
        } else {

            if ($user['country_code'] === $_SESSION['country_code']) {

                $digit = random_int(100000, 999999);
                

                //secure query update//
                $query_5 = "INSERT INTO `record`(`user_id`,`mobile_number`,`verification_code`,`created_time`) VALUES (?,?,?,?) ";
                $stmt_5 = Database::$connection->prepare($query_5);
                $stmt_5->bind_param("isis", $_SESSION["user_id"], $_SESSION['tell'], $digit, $current_time);
                $stmt_5->execute();
                //secure query update//

                echo "success";
            } else {
                echo "It looks like you signed up to TimeBucks from United States, but you are trying to verify with a mobile number from Vietnam. You should live in the country that you signed up with. If you think this is wrong, or if you have recently moved countries, please contact support.";
            }
        }
    }
}
