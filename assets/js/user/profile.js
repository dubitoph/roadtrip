import { deletePhoto } from '../app';
import { autocompleteAddress } from '../app';

$(document).ready(function() {

    $(".js-datepicker").datepicker({

                                    viewMode: "years",
                                    weekStart: 1,
                                    daysOfWeekHighlighted: "6,0",
                                    autoclose: true,
                                    startDate: '-80y',
                                    endDate:'-18y',
                                    format:  'dd/mm/yyyy'

    });

    $('body').on('click','.btn-danger',function(e) {

        e.preventDefault();
        deletePhoto($(this));
    
    });

    autocompleteAddress('profile_address_street', 'profile_address_city', 'profile_address_zipCode', 'profile_address_country', 'profile_address_number', 'profile_address_box', 
                        'profile_address_state', 'profile_address_latitude', 'profile_address_longitude', 'profile_address_defaultUserLocation');

/*
    var places = require('places.js');
    var inputAddress = document.querySelector('#profile_address_street');
    
    if (inputAddress !== null) 
    {
    
      var placesAutocomplete = places({
    
        appId: 'pl3HG0JAQ7C3',
        apiKey: '1c3a71e4dabb3c07b37e1275f63c154f',
        container: inputAddress
    
      });
    
      placesAutocomplete.on('change', e => {
    
        document.querySelector('#profile_address_city').value = e.suggestion.city;
        document.querySelector('#profile_address_zipCode').value = e.suggestion.postcode;
    
    //    document.querySelector('#select2-vehicle_situation_country').value = e.suggestion.country;
    
        document.querySelector('#profile_address_latitude').value = e.suggestion.latlng.lat;
        document.querySelector('#profile_address_longitude').value = e.suggestion.latlng.lng;
    
      })
    
    } 

*/

    //Showing uploaded photos
    $([document]).on( 'change', 'input[type="file"]',function() {

        showPhoto($(this));
        
    }); 

}); 

function showPhoto($element) 
{

    //If they are many changes about the photo choice, previous canvas removing
    var $canvas = $element.siblings('canvas');
    
    if ($canvas.length) 
    {

        $canvas.remove();

    }

    //Showing uploaded photos
    var file = $element;
    var reader = new FileReader;

    reader.onload = function(event) {

        var img = new Image();

        img.onload = function() {

            var ratio = img.width / img.height;
            var width = 100;
            var height = Math.round(width / ratio);
            var $canvas = $('<canvas></canvas>').attr({ width: width, height: height });

            file.after($canvas);

            var context = $canvas[0].getContext('2d');

            context.drawImage(img, 0, 0, width, height);

        };

        img.src = event.target.result;
    };

    reader.readAsDataURL(file[0].files[0]);

}