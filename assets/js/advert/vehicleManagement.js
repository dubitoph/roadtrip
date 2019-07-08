//Using a calendar for the building vehicle date

$(document).ready(function() {
    $(".js-datepicker").datepicker({
                viewMode: "years",
                weekStart: 1,
                daysOfWeekHighlighted: "6,0",
                autoclose: true,
                todayHighlight: true,
                startDate: '-30y',
                endDate:'+0d',
                format:  'dd/mm/yyyy'
            });
    
    //$('.js-datepicker').datepicker("setDate", new Date());
/*
    //Vehicle geolocation
    let inputAddress = document.querySelector('#vehicle_situation_street');

    if (inputAddress !== null) 
    {

      let place = Places({

        container: inputAddress
      })

      place.on('change', e => {

        document.querySelector('#vehicle_situation_city').value = e.suggestion.city;
        document.querySelector('#vehicle_situation_zipCode').value = e.suggestion.postcode;
        document.querySelector('#select2-vehicle_situation_country').value = e.suggestion.country;
        document.querySelector('#vehicle_situation_latitude').value = e.suggestion.latlng.lat;
        document.querySelector('#vvehicle_situation_longitude').value = e.suggestion.latlng.lng;

      })
      
    }
*/

var places = require('places.js');
var inputAddress = document.querySelector('#vehicle_situation_street');

if (inputAddress !== null) 
{

  var placesAutocomplete = places({

    appId: 'pl3HG0JAQ7C3',
    apiKey: '1c3a71e4dabb3c07b37e1275f63c154f',
    container: inputAddress

  });

  placesAutocomplete.on('change', e => {

    document.querySelector('#vehicle_situation_city').value = e.suggestion.city;
    document.querySelector('#vehicle_situation_zipCode').value = e.suggestion.postcode;

//    document.querySelector('#select2-vehicle_situation_country').value = e.suggestion.country;

    document.querySelector('#vehicle_situation_latitude').value = e.suggestion.latlng.lat;
    document.querySelector('#vehicle_situation_longitude').value = e.suggestion.latlng.lng;

  })

}

});