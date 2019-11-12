require('../css/app.scss');

require('babel-polyfill');

const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
Routing.setRoutingData(routes);
window['Routing'] = Routing;

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

import 'bootstrap';

/*
import './polyfill/svg.js'
*/
import './actions/select/init.js'
import './actions/range/init.js'

jQuery( document ).ready( function( $ ){
  // stickybar scrollspy
  $(window).scroll(function () {
     if ($(this).scrollTop() > 80) {
        $('.topbar').addClass('topbar-sticky');
     }
     if ($(this).scrollTop() < 80) {
        $('.topbar').removeClass('topbar-sticky');
     }
  });

<<<<<<< HEAD
  $('[data-slider]').slick({

    dots: true,
    arrows: true

  });
  $( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 500,
      values: [ 75, 300 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range" ).slider( "values", 1 ) );
  } );
=======
>>>>>>> 0844e279ac067b3b4796d3bf71ee20dc86ca5e9a
  // Display the login modal form if there is an autentication error
  var $loginDiv = $('#loginModal');

  if($loginDiv.data('visibility') == '1')
  {

    $loginDiv.modal('show');

  }

  // Display the login modal form if there is an autentication error
  var $registrationDiv = $('#registartionModal');

  if($registrationDiv.data('visibility') == '1')
  {

    $registrationDiv.modal('show');

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

  $('#' + idInputCountry);

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
      $('#' + idInputCountry).trigger('change');

      if (typeof defaultLocationQuestion !== 'undefined')
      {

        if (confirm('Would you like this location becomes your default location?'))
        {

          localStorage.setItem('userLatitude', e.suggestion.latlng.lat);
          localStorage.setItem('userLongitude', e.suggestion.latlng.lng);
          localStorage.setItem('userCity', e.suggestion.city);
          localStorage.setItem('userAddress', e.query);
          localStorage.setItem('userCountryCode', e.suggestion.countryCode);

          if (typeof idInputDefaultAddress !== 'undefined')
          {

            document.querySelector('#' + idInputDefaultAddress).checked = true;

          }

          setSessionLocation(e.query, e.suggestion.latlng.lat, e.suggestion.latlng.lng, e.suggestion.city, e.suggestion.countryCode.toUpperCase());

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
      $('#' + idInputCountry).trigger('change');

      if (typeof idInputDefaultAddress !== 'undefined')
      {

        document.querySelector('#' + idInputDefaultAddress).checked = false;

      }

    });

  }

}

export function setSessionLocation(address, latitude, longitude, city, countryCode)
{

  var setSessionVariables = async function()
                                  {

<<<<<<< HEAD
                          var response = await getAjax(Routing.generate(
                                                                                    'user.geolocation.session',
                                                                                    {
=======
                                      var response = await getAjax(Routing.generate(
                                                                                      'user.geolocation.session', 
                                                                                      {
>>>>>>> 0844e279ac067b3b4796d3bf71ee20dc86ca5e9a
                                                                                        userLatitude: latitude,
                                                                                        userLongitude: longitude,
                                                                                        userCity: city,
                                                                                        userAddress: address,
                                                                                        userCountryCode: countryCode
                                                                                      }
                                                                                  )
                                                                  )
                                      ;

                                      return response;

                                  }
  ;

  setSessionVariables().then(function(response)
                        {

                          localStorage.setItem('userLatitude',  latitude);
                          localStorage.setItem('userLongitude',  longitude);
                          localStorage.setItem('userCity',  city);
                          localStorage.setItem('userAddress',  address);
                          localStorage.setItem('userCountryCode',  countryCode);
                          sessionStorage.setItem('phpSessionVariablesExist', '1');

                          console.log(localStorage.getItem('userCountryCode'));

                        }
                            )
                  .catch(function(error)
                          {

                            console.error("Error during the ajax call to get the set session user's location variables", error);

                          }
                        )
  ;

}

export function getAjax(url)
{

  return new Promise(function(resolve, reject)
                     {

                        var req = new XMLHttpRequest();

                        req.onreadystatechange = function() {

                          if (req.readyState === 4)
                          {

<<<<<<< HEAD
                            if (req.status === 200)
=======
                            if (req.status === 200) 
>>>>>>> 0844e279ac067b3b4796d3bf71ee20dc86ca5e9a
                            {

                              resolve(req.responseText);

                            }
                            else
                            {

<<<<<<< HEAD
=======
                              console.log('Error');
                      
>>>>>>> 0844e279ac067b3b4796d3bf71ee20dc86ca5e9a
                              reject(req);

                            }

                          }

                        }

                        req.open('GET', url, true);
                        req.send();

                     }
                    )
  ;

}

export function getCurrentPosition(options = {})
{

  return new Promise((resolve, reject) => {

      navigator.geolocation.getCurrentPosition(resolve, reject, options);

  });

}
