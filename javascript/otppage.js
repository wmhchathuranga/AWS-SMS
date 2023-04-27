function verify() {
  var otp = document.getElementById("otp");
  var errorMsg = document.getElementById("errorMsg");

  var form = new FormData();
  form.append("otp", otp.value);

  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      if(request.responseText=="success"){
        otp.style.color="#26c66d";
        errorMsg.classList.add("errorMsg_1");
        errorMsg.innerHTML="verify successful";
        alert(request.responseText);
      
      }else{

        otp.style.color="#f55b5b";
        errorMsg.innerHTML=request.responseText;
        errorMsg.classList.add("errorMsg_2");
      }
    }
  };
  request.open("POST", "verifyProcess.php", true);
  request.send(form);
}

function reSend(){
  alert("resent OTP number");
}
