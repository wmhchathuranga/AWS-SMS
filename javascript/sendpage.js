const input = document.querySelector("#phone");
const errorMsg = document.querySelector("#error-msg");
const validMsg = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
const errorMap = [
  "Invalid number",
  "Invalid country code",
  "Too short",
  "Too long",
  "Invalid number"
];

// initialise plugin
const iti = window.intlTelInput(input, {
  utilsScript: "/intl-tel-input/js/utils.js?1681516311936"
});

const reset = () => {
  input.classList.remove("error");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
  validMsg.classList.add("hide");
};

// on blur: validate
input.addEventListener("keyup", () => {
  // alert(1);
  reset();
  if (input.value.trim()) {
    if (iti.isValidNumber()) {
      validMsg.classList.remove("hide");
      document.getElementById("sendBtn").innerText = "Send";
      document.getElementById("sendBtn").removeAttribute("disabled");
    } else {
      document.getElementById("sendBtn").setAttribute("disabled", "");
      document.getElementById("sendBtn").innerText = "Invalid";
      input.classList.add("error");
      const errorCode = iti.getValidationError();
      errorMsg.innerHTML = errorMap[errorCode];
      errorMsg.classList.remove("hide");
    }
  }
});

// on keyup / change flag: reset
input.addEventListener("change", reset);
// input.addEventListener("keyup", reset);

function send() {
  var tell = document.getElementById("phone").value;
  var flag_div = document.querySelector('[role="combobox"]');
  var country_title = flag_div.getAttribute("title");

  var country_code = country_title.substring(country_title.indexOf("+"));

  var form = new FormData();
  form.append("tell", tell);
  form.append("country_code", country_code);

  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      if (request.responseText == "success") {
        document.getElementById("sendBtn").style.display = "none";
        document.getElementById("loadingBtn").style.display = "block";
        // alert(request.responseText);

        setTimeout(locationChange, 1000);
      } else {
        if (
          request.responseText ==
          "You have reached the maximum amount of SMS codes to send. Please try again in 1 hour. If you are still experiencing issues, please contact support."
        ) {
          document.getElementById("sendBtn").style.background = "red";
          document.getElementById("errorMsgRow").style.display = "block";
          document.getElementById("errorMsg").innerHTML = request.responseText;
          // alert(request.responseText);
        } else {
          document.getElementById("errorMsgRow").style.display = "block";
          document.getElementById("errorMsg").innerHTML =
            "It looks like you signed up to TimeBucks from [United States], but you are trying to verify with a mobile number from ]. You should live in the country that you signed up with. If you think this is wrong, or if you have recently moved countries, please contact support.";
          // alert(request.responseText);
        }
      }
    }
  };
  request.open("POST", "sendProcess.php", true);
  request.send(form);
}

function locationChange() {
  window.location = "otpPage.php";
}
