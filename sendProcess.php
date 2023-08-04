<?php
require_once(__DIR__ . '/vendor/autoload.php');

use TextMagic\Models\SendMessageInputObject;
use TextMagic\Api\TextMagicApi;
use TextMagic\Configuration;

require "connection.php";

session_start();

if (isset($_POST['tell'])) {
    $tell = $_POST["tell"];
    $tell = filter_var($tell, FILTER_SANITIZE_NUMBER_INT);
    $_SESSION["tell"] = $tell;  //telephone number add to session....
    $country_code = $_POST["country_code"];
    $_SESSION["country_code"] = $country_code;

    sendProcess();
} else {

    if (!isset($_SESSION['tell'])) {
        header("location: index.php");
    } else {
        sendProcess();
    }
}

function get_client_ip()
{
    $ip = $_SERVER['REMOTE_ADDR'];

    // Check for custom header 'X-Forwarded-For' to get the real client IP
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $real_ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim(end($real_ip));
    }

    return $ip;
}
function sendProcess()
{

    // imaging logged user s details are in session 
    $_SESSION["user_id"] = "3";
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

        $remote_ip = get_client_ip();
        $query_4 = "SELECT * FROM `record` WHERE `user_id`='" . $user['user_id'] . "' ";
        $query_5 = "SELECT * FROM `record` WHERE `ip_addr`='" . $remote_ip . "' ";
        $query_6 = "SELECT * FROM `record` WHERE `mobile_number`='" . $_SESSION['tell'] . "' ";
        $t4 = Database::$connection->query($query_4);
        $t5 = Database::$connection->query($query_5);
        $t6 = Database::$connection->query($query_6);

        if ($t4->num_rows >= 10 || $t5->num_rows > 5 || $t6->num_rows > 5) {
            echo 1;
        } else {


            if ($user['country_code'] === $_SESSION['country_code']) {


                $digit = random_int(100000, 999999);


                $config = Configuration::getDefaultConfiguration()
                    ->setUsername('anthonylipari')
                    ->setPassword('kDFNusoRp3zm9zD4oMlXrHAK2lxGuC');

                $api = new TextMagicApi(
                    new GuzzleHttp\Client(),
                    $config
                );

                $input = new SendMessageInputObject();

                // Required parameters
                $input->setText("Your Timebucks OTP is " . $digit);
                $input->setPhones($_SESSION['tell']);
                // $input->setPhones('94788292094');

                try {
                    // SendMessageResponse class object
                    $result = $api->sendMessage($input);
                    // ...
                } catch (Exception $e) {
                    echo 'Exception when calling TextMagicApi->sendMessage: ', $e->getMessage(), PHP_EOL;
                }
                //secure query update//
                $query_5 = "INSERT INTO `record`(`user_id`,`mobile_number`,`verification_code`,`created_time`,`ip_addr`) VALUES (?,?,?,?,?) ";
                $stmt_5 = Database::$connection->prepare($query_5);
                $stmt_5->bind_param("isiss", $_SESSION["user_id"], $_SESSION['tell'], $digit, $current_time, $remote_ip);
                $stmt_5->execute();
                //secure query update//

                echo "success";
            } else {
                echo 2;
            }
        }
    }
}
