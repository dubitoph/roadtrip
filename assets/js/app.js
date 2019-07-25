/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
//require('../css/app.css');

import '../css/app.css';
import Map from './modules/map';
import $ from 'jquery';
import 'slick-carousel'
import 'slick-carousel/slick/slick.css'
import 'slick-carousel/slick/slick-theme.css'

import '@fullcalendar/core/main.css';
import '@fullcalendar/daygrid/main.css';
import '@fullcalendar/timegrid/main.css';
import '@fullcalendar/list/main.css';
/*
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
*/
global.$ = global.jQuery = $;

require('select2');

jQuery( document ).ready( function( $ ){

  $('select').select2();
  
  $('[data-slider]').slick({
  
    dots: true,
    arrows: true
    
  });
/*
  var calendarEl = document.getElementById('calendar-holder');

  var calendar = new Calendar(calendarEl, {
    defaultView: 'dayGridMonth',
    editable: true,
    eventSources: [
        {
            url: "/fc-load-events",
            type: "POST",
            data: {
                filters: {},
            },
            error: () => {
                // alert("There was an error while fetching FullCalendar!");
            },
        },
    ],
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay',
    },
    plugins: [ dayGridPlugin, timeGridPlugin, listPlugin ], // https://fullcalendar.io/docs/plugin-index
    timeZone: 'UTC',
  });

  calendar.render();
 */   
});

//Map.init();

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

export function autocompleteAddress(idInputAddress, idInputCity, idInputPostcode, idInputCountry, idInputNumber, idInputBox, idInputState, IdInputLatitude, idInputLongitude, 
                                    idInputDefaultAddress)
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
  
    })

    placesAutocomplete.on('clear', function() {
      
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
    
  console.log($('#urlAjaxSession').val()); 
  
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
/*
function deletePhoto($element) 
{

    if (confirm('Etes-vous certain de vouloir supprimer cette photo définitivement?')) 
    {

        if (! $element.hasClass('btn-dynamically-created')) 
        {

           //Photo suppression from the database

           var path = $element.attr('href'); 
            
            $.post(path,
                   {
                        file: $('#photos_advert_mainPhotoFile').val()           
                   }, 
                   function() 
                   {

                        $element.parent().remove();

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
*/