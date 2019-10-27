jQuery( document ).ready( function( $ ) {

    $('.questionDiv').on('click', function(e) {
        
        var questionId = $(this).attr('id');
        var id = questionId.substring(questionId.indexOf("_") + 1);

        $('#answer_' + id).toggle();

    });    

});