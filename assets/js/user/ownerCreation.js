import { autocompleteAddress } from '../app';

var changeConfirmed = false;

$(document).ready(function() {
  
  // Billing address autocompletion
  autocompleteAddress(
                      'owner_billingAddress_street', 'owner_billingAddress_city', 'owner_billingAddress_zipCode', 'sowner_billingAddress_country', 
                      'owner_billingAddress_number', 'owner_billingAddress_box', 'owner_billingAddress_state', 'owner_billingAddress_latitude', 
                      'owner_billingAddress_longitude'
                     )
  ; 

  // Make sure the user wants the billing address to be different from the vehicle situation
  $("#owner_billingAddress_street").click(function(event) {
  
    if(! changeConfirmed)
    {

      if (confirm("Are you sure you want to change the billing address which will be different from the one where the vehicle is located?")) 
      {

        changeConfirmed = true;

        $(this).focus();
        
      }
      else
      {

        $(this).blur();

      }

    }

  });

  var inputTel = document.querySelector('#owner_user_phoneNumber');

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