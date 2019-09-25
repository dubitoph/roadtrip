jQuery( document ).ready( function( $ ){

    $('#contactButton').on( 'click' , function ( e ) {

        $('#contactForm').show();
        $(this).hide();

    });

});