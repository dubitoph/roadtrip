//Use a calendar for the star and end dates of periods

$([document]).on( 'focus', 'input.js-datepicker-period',function() {
    
    $(".js-datepicker-period").datepicker({
        viewMode: "months",
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
        startDate: '-0m',
        endDate:'+2y',
        format:  'dd/mm/yyyy'
    });
});
//End of the the dates periods management 

//Photos management : permit to add and remove photos

// Keep count of how many elements period have been added
var collectionHolderPeriods;

// setup an "add a period" link
var $addPeriodButton = $ ( '<button type="button" class="add_period_link">Ajouter une période</button>' );
var $newLinkLiPeriod = $ ( '<li></li>' ). append ( $addPeriodButton );

jQuery ( document ). ready ( function () {
    // Get the ul that holds the collection of periods
    collectionHolderPeriods = $ ( 'ul.periods' );
    
     // add a delete link to all of the existing period form li elements
     collectionHolderPeriods . find ( 'li' ). each ( function () {
        addPeriodFormDeleteLink ( $ ( this ));
    });

    // add the "add a period" anchor and li to the periods ul
    collectionHolderPeriods . append ( $newLinkLiPeriod );

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    collectionHolderPeriods . data ( 'index' , collectionHolderPeriods . find ( ':input' ). length );

    $addPeriodButton . on ( 'click' , function ( e ) {
        // add a new period form (see next code block)
        addPeriodForm( collectionHolderPeriods , $newLinkLiPeriod );
    });
});

function addPeriodForm( collectionHolderPeriods , $newLinkLiPeriod ) {
    
    // Get the data-prototype explained earlier
    var prototype = collectionHolderPeriods . data ( 'prototype' );
    
    // get the new index
    var index = collectionHolderPeriods . data ( 'index' );
    
    var newForm = prototype ;
    // You need this only if you didn't set 'label' => false in your photos field in AdvertType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm . replace ( /__name__/g , index );

    // increase the index with one for the next item
    collectionHolderPeriods . data ( 'index' , index + 1 );

    // Display the form in the page in an li, before the "Add a Period" link li
    
    var $newFormLi = $ ( '<li></li>' ). append ( newForm );
    $newLinkLiPeriod . before ( $newFormLi );

    // add a delete link to the new form
    addPeriodFormDeleteLink ( $newFormLi );
}

function addPeriodFormDeleteLink ( $periodFormLi ) {
    var $removeFormButton = $ ( '<button type="button">Supprimer cette période</button>' );
    $periodFormLi . append ( $removeFormButton );

    $removeFormButton . on ( 'click' , function ( e ) {
        // remove the li for the photo form
        $periodFormLi . remove ();
    });
}