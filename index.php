<?php

session_start();

require "connection.php";

// who logged and user id from session.....

$conn =  new mysqli("localhost","root","root","aws_sms","3306");
// $t = $conn->query("SELECT * FROM `user_status` WHERE `user_id`='1' ");

// who logged and their country code....
$t =  $conn->query("SELECT * FROM `user_status` WHERE `user_id`='1' ");
$t_rs = $t->fetch_assoc();



// $userCountryCode = $_POST["userCountryCode"];
$userCountryCode = $t_rs["country_code"];


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tell Send</title>

    <link rel="stylesheet" href="./css/sendpage.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://intl-tel-input.com/examples/css/validation.css?1681516311936">
    <link rel="stylesheet" href="https://intl-tel-input.com/intl-tel-input/css/intlTelInput.css?1681516311936">



</head>

<body>

    <div class="container-fluid vh-100 background">
        <div class="row vh-100 d-flex justify-content-center align-items-center">

            <div class="col-md-5 col-11  bg-white box">

                <div class="row d-flex justify-content-center">
                    <div class="col-10 img1" style="background-image: url('./images/sendimg.jpg'); height: 200px;"></div>
                </div>

                <div class="row">
                    <p class="text-center mb-0 fw-bolder" style="font-size: large; color: #685ff4;">Verify Number</p>
                </div>

                <div class="row">
                    <p class="text-center text-secondary opacity-50" style="font-size: small;">Please enter your country & <br> your phone number</p>
                </div>

                <div id="errorMsgRow" class="row justify-content-center " style="height: auto;display: none;">
                    <p id="errorMsg" class=" text-center text-danger m-0 opacity-50" style="font-size: x-small;"></p>
                </div>

                <div class="row justify-content-center align-items-center mb-2 gap-1">
                    <div class="col-auto px-0 d-flex flex-column justify-content-end align-items-end">
                        <input id="phone" type="tel" value="<?php echo $userCountryCode ?>">
                        <span id="valid-msg" class="hide " style="font-size: small;">✓ Valid</span>
                        <span id="error-msg" class="hide " style="font-size: small;"></span>

                        <!-- <input class="input1 " type="text" id="phone" value="+94" placeholder="+94787892654" /> -->
                    </div>
                </div>


                <div class="col-auto px-0 d-flex justify-content-center text-center mb-5">
                    <button data-bs-toggle="modal" data-bs-target="#exampleModal" id="sendBtn" class="my-3 text-center w-25 sendBtn" onclick="send();" disabled>Send</button>

                    <button id="loadingBtn" class="btn my-3 text-center w-25 loadingBtn" type="button" style="display: none;" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Sending...
                    </button>

                </div>

                <!-- Modal -->
                <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="  top: 40vh;right: 5vw;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p id="message" class="text-center"></p>
                            </div>
                            <div class="py-3 d-flex justify-content-center ">
                                <button class="btn loadingBtn" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Sending...
                                </button>
                            </div>
                        </div>
                    </div>
                </div> -->



            </div>

        </div>
    </div>


    <!-- <script src="./javascript/sendpage.js"></script> -->
    <script src="https://intl-tel-input.com/intl-tel-input/js/utils.js?1681516311936"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://intl-tel-input.com/intl-tel-input/js/intlTelInput.js?1681516311936"></script>
    <script src="./javascript/sendPage.js"></script>
</body>

</html>