var input = document.querySelector("#phone");
intlTelInput(input, {
  initialCountry: "auto",
  geoIpLookup: function (success, failure) {
    $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
      var countryCode = (resp && resp.country) ? resp.country : "us";
      success(countryCode);
    });
  },
});


var cCode = +94 ;


function send(){
 var tell = document.getElementById("phone").value;

//  const digit = Math.floor(100000 + Math.random() * 900000);

 var form = new FormData();
 form.append("tell", tell);
//  form.append("digit",digit);

 var request = new XMLHttpRequest();
 request.onreadystatechange = function(){
  if(request.readyState==4 && request.status==200){
    alert(request.responseText);
    window.location= "otpPage.php";
  }
 }
 request.open("POST","otpGenerate.php",true);
 request.send(form);


 
}