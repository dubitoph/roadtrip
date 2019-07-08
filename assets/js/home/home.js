import { setSessionLocation } from '../app';

jQuery( document ).ready( function( $ ) {

  var userAddress = localStorage.getItem("userAddress");
  var userLatitude = localStorage.getItem("userLatitude");
  var userLongitude = localStorage.getItem("userLongitude");
  var userCity = localStorage.getItem("userCity");
  var existsSearchAddress = $('#search_address').val();

  console.log(userCity);
    
  if (userAddress === null || userLatitude === null || userLongitude === null || userCity === null) 
  { 

    if(navigator.geolocation)
    {
      
      navigator.geolocation.getCurrentPosition(function(position) {
            
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
            
        $('#latitude').val(latitude);
        $('#longitude').val(longitude);
                  
        geocode(position.coords.latitude + ', ' + position.coords.longitude);                
            
      });

    }

  }
  else
  {

    $('#latitude').val(localStorage.getItem("userLatitude"));
    $('#longitude').val(localStorage.getItem("userLongitude"));
    $('#search_address').val(userAddress);
    $('#city').val(localStorage.getItem("userCity"));

  }
  
  if (existsSearchAddress.trim() == '')
  {
    
    setSessionLocation($('#search_address').val());

  }

});

function geocode(query) 
{
    
    $.ajax(

      {

        url: 'https://api.opencagedata.com/geocode/v1/json',
        method: 'GET',
        data: {
                'key': 'e603b8a1c9f242028b5c69de78e33877',
                'q': query,
                'no_annotations': 1

              },
        dataType: 'json',
        statusCode: {

                     200: function(response)
                          {  
                              
                            // success
                            var address = response.results[0].formatted;
                            $('#search_address').val(address);
                            $('#city').val(response.results[0].components.village);

                            console.log($('#city').val());

                          },
                     402: function()
                          {

                            console.log('hit free-trial daily limit');
                            console.log('become a customer: https://opencagedata.com/pricing');

                          }
                        
                    }

  });

}