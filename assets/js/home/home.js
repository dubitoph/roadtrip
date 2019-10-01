import { setSessionLocation } from '../app';

//Setup the date format according to navigator locale
var localData = moment.localeData();
var localeDateFormat = localData['_longDateFormat']['L'];

jQuery( document ).ready( function( $ ) {

  var userAddress = localStorage.getItem("userAddress");
  var userLatitude = localStorage.getItem("userLatitude");
  var userLongitude = localStorage.getItem("userLongitude");
  var userCity = localStorage.getItem("userCity");
    
  if (userAddress == null || userLatitude == null || userLongitude == null || userCity == null) 
  { 

    if(navigator.geolocation)
    {
      
      navigator.geolocation.getCurrentPosition(function(position) {
            
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        $('#latitude').val(latitude);
        $('#longitude').val(longitude);
                  
        geocode(latitude + ', ' + longitude);                
            
      });

    }

  }
  else
  {

    $('#latitude').val(userLatitude);
    $('#longitude').val(userLongitude);
    $('#search_address').val(userAddress);
    $('#city').val(userCity);

  }

  if (! sessionStorage.getItem("phpSessionVariablesExist") && userAddress)
  {
    
    setSessionLocation($('#search_address').val(), $('#latitude').val(), $('#longitude').val(), $('#city').val());

  }

  //Use a calendar for the start and end dates of booking 
  $(".js-datepicker").datepicker({

    viewMode: "years",
    weekStart: 1,
    daysOfWeekHighlighted: "6,0",
    autoclose: true,
    todayHighlight: true,
    startDate: '-0d',
    endDate:'+2y',
    format: localeDateFormat.toLowerCase()

  });
    
  // Avoid end date less than begin date
  $("#beginAt").datepicker().on('changeDate', function (selected) {

      $('#endAt').datepicker('setStartDate', selected.date);

  });    
  
  $("#endAt").datepicker().on('changeDate', function (selected) {

      $('#beginAt').datepicker('setEndDate', selected.date);

  });
    
  //Dates formatting to ISO before submit
  $("form").submit(function(event) {

      $('input.js-datepicker').each(function(e) {

          var sDate = $(this).val();
          var dateTime = moment(sDate, localeDateFormat).toISOString(true);

          $(this).val(dateTime);

      });

  });

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
                            var city = response.results[0].components.village;
                            var latitude = response.results[0].geometry.lat;
                            var longitude = response.results[0].geometry.lng;

                            $('#search_address').val(address);
                            $('#city').val(response.results[0].components.village);

                            setSessionLocation($('#search_address').val(), latitude, longitude, city);

                          },
                     402: function()
                          {

                            console.log('hit free-trial daily limit');
                            console.log('become a customer: https://opencagedata.com/pricing');

                          }
                        
                    }

  });

}