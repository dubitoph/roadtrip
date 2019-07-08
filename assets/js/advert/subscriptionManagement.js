$(document).ready(function(e) {

    $('body').on('click',".btn",function(){

        var btnId = $(this).attr('id');
        var _position = btnId.lastIndexOf("_");
        var subscriptionIndex = btnId.substr(_position + 1); 

        alert(subscriptionIndex);
    
    });

});