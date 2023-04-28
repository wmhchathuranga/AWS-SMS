var errorMsg = document.getElementById("errorMsg");
var otp = document.getElementById("otp");

function verify() {

  var form = new FormData();
  form.append("otp", otp.value);

  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      if(request.responseText=="success"){
        otp.style.color="#26c66d";
        errorMsg.classList.add("errorMsg_1");
        errorMsg.innerHTML="verification successful";
      
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


// resend part 
function reSend(){
  otp.value="";

  var form = new FormData();

  var request = new XMLHttpRequest();
  request.onreadystatechange = function () { 
    if(request.readyState==4 && request.status == 200){
      if(request.responseText=="success"){
        otp.style.color="#26c66d";
        errorMsg.classList.add("errorMsg_1");
        errorMsg.innerHTML="verification successful";
        alert("Resent verification code. please check your SMS");
      
      }else{

        otp.style.color="#f55b5b";
        errorMsg.innerHTML=request.responseText;
        errorMsg.classList.add("errorMsg_2");
      }
    }
  }
  request.open("POST","reSendProcess.php",true);
  request.send(form);

  // alert("ok");
}