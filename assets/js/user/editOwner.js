//import Places from 'places.js';
import { autocompleteAddress } from '../app';

jQuery( document ).ready( function( $ ) {

  autocompleteAddress('owner_billingAddress_street', 'owner_billingAddress_city', 'owner_billingAddress_zipCode', 'owner_billingAddress_country', 
                      'owner_billingAddress_number', 'owner_billingAddress_box', 'owner_billingAddress_state', 'owner_billingAddress_latitude', 
                      'owner_billingAddress_longitude');
});