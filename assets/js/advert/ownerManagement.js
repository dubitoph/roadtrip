import Places from 'places.js';

$(document).ready(function() {  

  $( "#owner_billingAddress_street" ).focus(function() {
  
    if (confirm("Etes-vous certain de vouloir modifier l'adresse de facturation qui sera alors différente de celle où se situe le véhicule?")) 
    {
      
      document.getElementById("address_changed").value = 1;

      //Billing address completion
      var places = require('places.js');
      var inputAddress = document.querySelector('#owner_billingAddress_street');

      if (inputAddress !== null) 
      {

        var placesAutocomplete = places({

          appId: 'pl3HG0JAQ7C3',
          apiKey: '1c3a71e4dabb3c07b37e1275f63c154f',
          container: inputAddress

        });

        placesAutocomplete.on('change', e => {
          
          document.querySelector('#owner_billingAddress_latitude').value = e.suggestion.latlng.lat;
          document.querySelector('#owner_billingAddress_longitude').value = e.suggestion.latlng.lng;

        })

      }
      
        //Billing address geolocation
        if (inputAddress !== null) 
        {

          let place = Places({

            container: inputAddress
          })

          place.on('change', e => {

            document.querySelector('#owner_billingAddress_city').value = e.suggestion.city;
            document.querySelector('#owner_billingAddress_zipCode').value = e.suggestion.postcode;
    //        document.querySelector('#select2-owner_billingAddress_country-container').value = e.suggestion.country;
            document.querySelector('#owner_billingAddress_latitude').value = e.suggestion.latlng.lat;
            document.querySelector('#owner_billingAddress_longitude').value = e.suggestion.latlng.lng;

          })
          
        }
      
      }
      else
      {

        $(this).blur();

      }

  });

});