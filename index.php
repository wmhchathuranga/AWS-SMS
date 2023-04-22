<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tell Send</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/sendpage.css">

 <!-- CSS -->
 <!-- <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet' type='text/css'> -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />
 


    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>


</head>

<body >

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

            <div class="row justify-content-center align-items-center mb-3 gap-1">
                <div class="col-auto px-0">
                    <input class="input1 " type="text" id="phone" value="+94" placeholder="+94787892654"/>
                </div>

                <div class="col-auto px-0 ">
                    <button class="my-3 text-center w-100 sendBtn" onclick="send();">Send</button>
                </div>
            </div>

        </div>

    </div>
</div>


<script src="./javascript/sendpage.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>