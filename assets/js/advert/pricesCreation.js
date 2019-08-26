var index;

jQuery(document).ready(function() {

    //Get the prices number from all seasons
    index = $(document).find('.li_price').length;

    $('.add-price-btn').on('click', function(e) {

        addPriceForm($(this));

    });

    $('.btn-removePrice').on('click', function(e) {
    
        removeForm($(this));

    });

});

/**
 * Add a price form
 * 
 * @param {*} element 
 */
function addPriceForm(element)
{
        
    var idAddButton = element.attr('id');
    var idSeason = idAddButton.substr(-1, 1);

    var collectionHolderPrices = $('#ulPrices_' + idSeason);

    // Get the data-prototype to the price form (only the first ul have the prototype)
    var prototype = $('.ul_prices').first().data('prototype');

    var newForm = prototype ;

    // Replace '__name__' in the form instead be a number based on how many items we have
    newForm = newForm.replace( /__name__/g , index);

    // Display the form in the end of the ul   
    var $newForm = $("<li class='li_price'></li>").append(newForm);

    // Add a delete link to the new form
    addPriceRemoveButton($newForm, idSeason);
        
    collectionHolderPrices.append($newForm);

    //Affectation with right duration and season
    var $seasonInput = $('#prices_advert_prices_' + index + '_season');
    var $durationInput =  $('#prices_advert_prices_' + index + '_duration');

    $seasonInput.val(idSeason);
    $durationInput.val(element.data('duration'));
    $durationInput.addClass('duration-input');

    element.toggle();

    index++;

}

/**
 * Add a remove price button
 * 
 * @param {*} $priceFormLi html to add
 */
function addPriceRemoveButton($priceForm, idSeason) 
{
    
    var $removeButton = $(
                            "<button type='button' class='btn btn-danger btn-removePrice' data-target='ulSeason_" + 
                            idSeason + "'>Remove this duration</button>"
                         )
    ;
    
    $priceForm.append($removeButton);
    
    $removeButton.on('click', function(e) {

            removeForm($(this));
    
    });
    
}

function removeForm($element)
{    
    
    if(confirm("Are you certain to want to remove this duration ?"))
    {
        var target = $element.data('target');
        var idSeason = target.substr(-1, 1);
        var idDuration = $element.parent().find('.duration-input').val();
            
        $element.parent().remove();

        //Showing the add button for the deleted duration
        $('#add_price_btn_' + idDuration + '_' + idSeason).toggle();

    }

}