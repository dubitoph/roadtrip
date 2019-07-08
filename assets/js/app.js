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

export function setSessionLocation(address) 
{
    
    $.ajax(

      {

        url: $('#urlAjaxSession').val(),
        method: 'POST',
        data: {
                'userLatitude': $('#latitude').val(),
                'userLongitude': $('#longitude').val(),
                'userCity': $('#city').val(),
                'userAddress': address

              },
        dataType: 'json',                 
        success: function(response) 
                {  

                  console.log(response)
                  
                },  
        error : function(response) 
                {  

                  console.log('Error from Ajax call')
                  
                }, 

  });

}