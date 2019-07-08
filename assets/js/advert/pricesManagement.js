// Keep count of how many elements price have been added

$('.btn-add') . on ( 'click' , function ( e ) {
    
    var collectionHolderPrices = $( this ).parent();

    // Get the data-prototype explained earlier
    var prototype = $( 'ul.prices' ) . data ( 'prototype' );

    var lastId = $( "select:last" ).attr('id');
    var _position = lastId.lastIndexOf("_");
    var lastIndex = lastId.substr(_position - 1, 1); 

    // get the new index
    //var index = $( 'ul.prices' ) . data ( 'index' );
    var index = parseInt(lastIndex) + 1;

    var newForm = prototype ;
    
    // You need this only if you didn't set 'label' => false in your photos field in AdvertType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm . replace ( /__name__/g , index );

    // increase the index with one for the next item
    collectionHolderPrices . data ( 'index' , index + 1 );

    // Display the form in the page in an li, before the "Add a photo" link li
    var $newFormLi = $ ( '<li></li>' ). append ( newForm );
    var $deletePriceButton = $ ( '<button type="button" class="btn-remove" >Supprimer cette durée</button>' );
    $newFormLi. append ( $deletePriceButton );
    
    collectionHolderPrices.append($newFormLi);

    //Affectation with right duration and season 
    var idParent = $(this).parent().attr('id');
    var idSeason = idParent.substr(-1);
    var idButton = $(this).attr('id');
    var position = idButton.lastIndexOf("_");
    var duration = idButton.substring(position + 1);
    var seasonInput = $ ( "#" + idParent + " li:last select" );
    var durationInput =  seasonInput.parent().prev('div').find( "select" );

    seasonInput.val(idSeason);
    durationInput.val(duration);

    $( this ).toggle();

    //Id's affectation to the remove button
    var idButtonRemove = idButton.replace('add', 'remove');
    var btnRemove = $ ( "#" + idParent + " li:last button" );
    btnRemove.attr('id', idButtonRemove);

});

// If certain durations are not used, the user can remove them

$('body').on('click',".btn-remove",function(){

    $( this ).parent().remove();

    //Showing the add button for the deleted duration
    var idButtonAdd = $( this ).attr('id').replace('remove', 'add');

    $( '#' + idButtonAdd + '' ).toggle();

});

//Id creation for remove buttons : it will be used to create the add button when the duration is removed
$(document).ready(function() {

    $('.desactivated').prop('disabled', 'disabled');
    
    $(document) . find ( ".btn-remove" ). each ( function () {

        var idDiv = $( this ).closest("ul").attr('id');
        var durationValue = $(this).prevAll('input').val();
        var idButtonRemove = 'btn-remove_' + idDiv.substr(-1) + '_' + durationValue;
        
        $(this).attr('id', idButtonRemove);

    });

});