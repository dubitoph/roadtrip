import ShowCalendar from '../modules/calendar';

jQuery( document ).ready( function( $ ){

    ShowCalendar.init();

    $('#contactButton').on( 'click' , function ( e ) {

        $('#contactForm').show();
        $(this).hide();

    });

});