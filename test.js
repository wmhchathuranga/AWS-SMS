var input = document.querySelector("#phone");
var iti = intlTelInput(input, {
  initialCountry: "auto",
  geoIpLookup: function (success, failure) {
    $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
      var countryCode = (resp && resp.country) ? resp.country : "us";
      success(countryCode);
    });
  },
});
var flagContainer = document.querySelector("#flag-container");
iti.setFlagContainer(flagContainer);

// Add an event listener to the send button
var sendButton = document.querySelector("#send-button");
sendButton.addEventListener("click", function () {
  // Get the input value and selected country code number
  var phoneNumber = input.value;
  var countryCode = iti.getSelectedCountryData().dialCode;

  // Alert the values
  alert("Phone number: " + phoneNumber + "\nCountry code: " + countryCode);
});

