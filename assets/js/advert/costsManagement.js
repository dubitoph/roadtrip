jQuery ( document ). ready ( function () {
    
    showing_hiding_insurancePrices();
    
    if ($('#costs_cleaning_includedCleaning').get(0).checked) {

        $('.divPriceCleaning').hide();
        
    }

});

$('#costs_insurance_included') . on ( 'click' , function ( e ) {
    
    showing_hiding_insurancePrices();

});

$('#costs_cleaning_includedCleaning') . on ( 'click' , function ( e ) {
    
    $('.divPriceCleaning').toggle();

});

function showing_hiding_insurancePrices() {

    if ($('#costs_insurance_included').get(0).checked) {

        $('.divNotIncludedPrice').children('div').children('input').prop('required',false);
        $('.divNotIncludedPrice').hide();
        $('.divIncludedPrice').show();
        
    }
    else {

        $('.divNotIncludedPrice').children('div').children('input').prop('required',true);
        $('.divIncludedPrice').hide();
        $('.divNotIncludedPrice').show();
        
    }

}