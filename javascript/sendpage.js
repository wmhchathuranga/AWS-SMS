const input = document.querySelector("#phone");
intlTelInput(input, {
  initialCountry: "auto",
  geoIpLookup: function (success, failure) {
    $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
      const countryCode = (resp && resp.country) ? resp.country : "us";
      success(countryCode);
    });
  },
});


function send() {
  const number1 = document.getElementById("phone").value;
  alert(number1);
}
