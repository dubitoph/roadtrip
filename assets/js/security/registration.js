/*

$(document).ready(function() {

    var inputTel = document.querySelector('#user_phoneNumber');
    var access_key = '55fa64477541d7840caf1e605e1359cc';
  
    //Plugin intl-tel-input initialisation
    var iti = window.intlTelInput(inputTel, {
  
      initialCountry: "auto",
      geoIpLookup: function(callback) 
                   {

                      $.ajax(Routing.generate('user.IP'), function() {}, "jsonp").always(function(response) {

                        var ip = response.IP;
                    
                        $.ajax('http://api.ipstack.com/' + ip + '?access_key=' + access_key, function() {}, "jsonp").always(function(json) {
                          
                          var countryCode = (json && json.country_code) ? json.country_code : "";
                          callback(countryCode);
  
                        });
                        
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

*/