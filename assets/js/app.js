/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
//require('../css/app.css');

import '../css/app.scss';

import $ from 'jquery';
global.$ = global.jQuery = $;

import 'bootstrap-datepicker';

import 'slick-carousel'
import 'slick-carousel/slick/slick.css'
import 'slick-carousel/slick/slick-theme.css'

import moment from 'moment';
window['moment'] = moment;
moment.locale(navigator.language);

import intlTelInput from 'intl-tel-input';
import '../../node_modules/intl-tel-input/build/css/intlTelInput.css';
import 'intl-tel-input/build/js/utils.js'
window['intlTelInput'] = intlTelInput;

import select2 from'select2';
window['select2'] = select2;

import 'bootstrap';

jQuery( document ).ready( function( $ ){

  $('[select]').select2();
  
  $('[data-slider]').slick({
  
    dots: true,
    arrows: true
    
  });

  // Display the login modal form if there is an autentication error
  if($('#loginModal').data('visibility') == '1') 
    {

      $('#loginModal').modal('show');
      
    }

});

export function deletePhoto($element) 
{

    if (confirm('Are you sure you want to remove this photo definitively?')) 
    {

        if (! $element.hasClass('btn-dynamically-created')) 
        {

           //Photo suppression from the database

           $.ajax(
                    {
                      url: $element.attr('href'),
                      method: 'POST',
                      data: {},              
                      success: function(response) 
                               {

                                  location.href = $element.data('redirection');

                               }

                    }
                  )
            ;
            
        }
        else
        {

            $element.parent().remove();

        }
         
    }

}

export function autocompleteAddress(idInputAddress, idInputCity, idInputPostcode, idInputCountry, idInputNumber, idInputBox, idInputState, 
                                    IdInputLatitude, idInputLongitude, defaultLocationQuestion, idInputDefaultAddress)
{
  
  var places = require('places.js');
  var inputAddress = document.querySelector('#' + idInputAddress);
  $('#' + idInputCountry).select2();
  
  if (inputAddress !== null) 
  {
  
    var placesAutocomplete = places({
  
      appId: 'pl3HG0JAQ7C3',
      apiKey: '1c3a71e4dabb3c07b37e1275f63c154f',
      container: inputAddress
  
    });
  
    placesAutocomplete.on('change', e => {
      
      document.querySelector('#' + idInputCity).value = e.suggestion.city;
      document.querySelector('#' + idInputPostcode).value = e.suggestion.postcode; 
      document.querySelector('#' + IdInputLatitude).value = e.suggestion.latlng.lat; 
      document.querySelector('#' + idInputLongitude).value = e.suggestion.latlng.lng;

      $('#' + idInputCountry).val(e.suggestion.countryCode.toUpperCase());
      $('#' + idInputCountry).select2().trigger('change'); 

      if (typeof defaultLocationQuestion !== 'undefined')
      {
        
        if (confirm('Would you like this location becomes your default location?'))
        {

          localStorage.setItem('userLatitude', e.suggestion.latlng.lat);
          localStorage.setItem('userLongitude', e.suggestion.latlng.lng);
          localStorage.setItem('userCity', e.suggestion.city);
          localStorage.setItem('userAddress', e.query);

            if (typeof idInputDefaultAddress !== 'undefined') 
            {

              document.querySelector('#' + idInputDefaultAddress).checked = true;
                
            }
              
            setSessionLocation(e.query, e.suggestion.latlng.lat, e.suggestion.latlng.lng, e.suggestion.city);

          }

      }    
  
    })

    placesAutocomplete.on('clear', function() {
      
      document.querySelector('#' + idInputAddress).value = '';
      document.querySelector('#' + idInputCity).value = '';
      document.querySelector('#' + idInputPostcode).value = '';
      document.querySelector('#' + idInputNumber).value = ''; 
      document.querySelector('#' + idInputBox).value = '';
      document.querySelector('#' + idInputState).value = '';   
      document.querySelector('#' + IdInputLatitude).value = '';
      document.querySelector('#' + idInputLongitude).value = '';

      $('#' + idInputCountry).val(-1);
      $('#' + idInputCountry).select2().trigger('change');

      if (typeof idInputDefaultAddress !== 'undefined') 
      {

        document.querySelector('#' + idInputDefaultAddress).checked = false;
        
      }

    });
  
  } 

}

export function setSessionLocation(address, latitude, longitude, city) 
{ 
  
  $.ajax(

      {

        url: $('#urlAjaxSession').val(),
        method: 'POST',
        data: {
                'userLatitude': latitude,
                'userLongitude': longitude,
                'userCity': city,
                'userAddress': address

              },
        dataType: 'json',                 
        success: function(response) 
                {  

                  console.log(response);

                  localStorage.setItem('userLatitude',  latitude);
                  localStorage.setItem('userLongitude',  longitude);
                  localStorage.setItem('userCity',  city);
                  localStorage.setItem('userAddress',  address);

                  sessionStorage.setItem('phpSessionVariablesExist', '1');
                  
                },  
        error : function(response) 
                {  

                  console.log('Error from Ajax call to create session variables');
                  
                }, 

  });

}