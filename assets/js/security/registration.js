$(document).ready(function() {

    var inputTel = document.querySelector('#user_phoneNumber');
  
    //Plugin intl-tel-input initialisation
    var iti = window.intlTelInput(inputTel, {
  
      initialCountry: "auto",
      geoIpLookup: function(callback) 
                   {
  
                      $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) 
                                                                                {
  
                                                                                  var countryCode = (resp && resp.country) ? resp.country : "";
                                                                                  callback(countryCode);
  
                                                                                });
                                      },
      initialDialCode: true,
      utilsScript: 'utils.js'
  
    });
  
    var form = document.querySelector("form");
  
    // Set the user phone number with the right format
    form.addEventListener("submit", function(e) { 
  
      inputTel.value = iti.getNumber();
  
    }, false);

});