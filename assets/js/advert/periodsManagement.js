// Keep count of how many elements period have been added
var collectionHolderPeriods;

// setup an "add a period" link
var $addPeriodButton = $('<button type="button" class="add_period_link">Ajouter une période</button>');
var $newLinkLiPeriod = $('<li></li>').append($addPeriodButton);

//moment.locale(navigator.language);
var localData = moment.localeData();
var localeDateFormat = localData['_longDateFormat']['L'];

jQuery(document).ready(function() {

    //Dates formatting according user's locale
    $('input.js-datepicker-period').each(function () {

        var sDate = $(this).val();
        
        $(this).val(moment(sDate, 'YYYY-MM-DD').format('L'));

    });
    //End date formatting
    
    // Get the ul that holds the collection of periods
    collectionHolderPeriods = $('ul.periods');
    
     // add a delete link to all of the existing period form li elements
     collectionHolderPeriods.find('li').each(function() {

        addPeriodFormDeleteLink ( $ ( this ));

    });

    // add the "add a period" anchor and li to the periods ul
    collectionHolderPeriods.append($newLinkLiPeriod);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    collectionHolderPeriods.data('index', collectionHolderPeriods.find(':input' ).length);

    $addPeriodButton.on('click', function(e) {
        
        // add a new period form (see next code block)
        addPeriodForm(collectionHolderPeriods , $newLinkLiPeriod);

    });
    
    //Use a calendar for the start and end dates of periods
    
    $([document]).on('focus', 'input.js-datepicker-period',function() {
        
        $(".js-datepicker-period").datepicker({
            viewMode: "months",
            weekStart: 1,
            daysOfWeekHighlighted: "6,0",
            autoclose: true,
            todayHighlight: true,
            startDate: '-0m',
            endDate:'+2y',
            format: 'yyyy-mm-dd'
        });
    
    });
    
    $([document]).on('change', 'input.js-datepicker-period',function() {
        
        $(this).val(moment($(this).val(), 'YYYY-MM-DD').format('L'));
    
    });
    
    $("form").submit(function(event) {

        $('input.js-datepicker-period').each(function(e) {

            var sDate = $(this).val();
            var dateTime = moment(sDate, localeDateFormat).toISOString();

            $(this).val(dateTime);

        });

    });

});

function addPeriodForm(collectionHolderPeriods , $newLinkLiPeriod) {
    
    // Get the data-prototype explained earlier
    var prototype = collectionHolderPeriods.data('prototype');
    
    // get the new index
    var index = collectionHolderPeriods.data('index');
    
    var newForm = prototype ;
    // You need this only if you didn't set 'label' => false in your photos field in AdvertType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g , index);

    // increase the index with one for the next item
    collectionHolderPeriods.data('index' , index + 1);

    // Display the form in the page in an li, before the "Add a Period" link li
    
    var $newFormLi = $ ( '<li></li>' ).append(newForm);

    $newLinkLiPeriod.before($newFormLi);
    
    //Assigning the start date
    if(index == 1) 
    {
    
        var today = moment().format('L');
        
        $('#periods_advert_periods_1_start').val(today);

    }
    else
    {
        var idPreviousDate = 'periods_advert_periods_'.concat(index - 1).concat('_end');
        var previousDate = $('#'.concat(idPreviousDate)).val();

        startDate = moment(previousDate, localeDateFormat).add(1, 'days');
        $('#periods_advert_periods_'.concat(index).concat('_start')).val(startDate.format('L'));

    }
    //End of the start date assignation


    //Formatting the end date
    var endDate =  $('#periods_advert_periods_'. concat(index).concat('_end')).val();
    
    $('#periods_advert_periods_'. concat(index).concat('_end')).val(moment(endDate, 'YYYY-MM-DD').locale(navigator.language).format('L'));
    //End of end date formatting

    // add a delete link to the new form
    addPeriodFormDeleteLink($newFormLi);

}

function addPeriodFormDeleteLink($periodFormLi) {

    var $removeFormButton = $('<button type="button">Supprimer cette période</button>');
    $periodFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {

        // remove the li for the photo form
        $periodFormLi . remove ();

    });

}