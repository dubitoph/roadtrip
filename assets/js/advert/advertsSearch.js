//import Places from 'places.js';
import { autocompleteAddress } from '../app';

jQuery( document ).ready( function( $ ) {

  autocompleteAddress('profile_address_street', 'profile_address_city', 'profile_address_zipCode', 'profile_address_country', 'profile_address_latitude', 'profile_address_longitude');
/*
  var places = require('places.js');
  var inputAddress = document.querySelector('#search_address');

  if (inputAddress !== null) 
  {

    var placesAutocomplete = places({

      appId: 'pl3HG0JAQ7C3',
      apiKey: '1c3a71e4dabb3c07b37e1275f63c154f',
      container: inputAddress

    });

    placesAutocomplete.on('change', e => {

      document.querySelector('#latitude').value = e.suggestion.latlng.lat;
      document.querySelector('#longitude').value = e.suggestion.latlng.lng;
      document.querySelector('#city').value = e.suggestion.city;

      if (confirm('Would you like this location becomes your default location?'))
      {

        localStorage.setItem('userLatitude', e.suggestion.latlng.lat);
        localStorage.setItem('userLongitude', e.suggestion.latlng.lng);
        localStorage.setItem('userCity', e.suggestion.city);
        localStorage.setItem('userAddress', e.query);
        
        setSessionLocation(e.query);
        
      }

    });

    placesAutocomplete.on('clear', function() {

      document.querySelector('#latitude').value = '';
      document.querySelector('#longitude').value = '';
      document.querySelector('#city').value = '';
      document.querySelector('#search_address').value = '';

    });

  }
*/
});