//Setup the date format according to navigator locale
var localData = moment.localeData();
var localeDateFormat = localData['_longDateFormat']['L'];

//Will use to stock the periods ul
var collectionHolderPeriods;

jQuery(document).ready(function() {
    
    //Dates formatting according user's locale
    $('.js-datepicker-period').each(function () {

        $(this).val(moment($(this).val(), 'YYYY-MM-DD').format('L'));

    });
    
    // Get the periods collection
    collectionHolderPeriods = $('ul.periods');

    var index = collectionHolderPeriods.find('.li_period' ).length;
    
    // Add a remove period button to all existing period forms
    collectionHolderPeriods.find('.li_period').each(function() {

        addPeriodRemoveButton ($(this), index);

    });

    // Get the current form inputs number to use as the new index when inserting a new item
    collectionHolderPeriods.data('index', index);

    $('#add_period_btn').on('click', function(e) {
        
        // Add a new period form
        addPeriodForm();

    });
    
    //Use a calendar for the start and end dates of periods        
    $(".js-datepicker-period").datepicker({
        viewMode: "months",
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
        startDate: '-0m',
        endDate:'+2y',
        format: localeDateFormat.toLowerCase()
    });

    //Make sure the date is not contained in another period
    $(".js-datepicker-period").datepicker().on('changeDate', function (selected) {
        
        if($(this).hasClass('start'))
        {
            
            var minDate = moment($(this).val(), localeDateFormat).format('L').toLowerCase();
            $(this).closest('li').find('.end').datepicker('setStartDate', minDate);  
            
        }
        else
        {
            
            var maxDate = moment($(this).val(), localeDateFormat).format('L').toLowerCase();
            $(this).closest('li').find('.start').datepicker('setEndDate', maxDate);

        }
        
        var thisLiParentId = $(this).closest('li').attr('id');
        var thisMomentDate = moment($(this).val(), localeDateFormat);

        var isBewteen = false;
        var i = 1;

        while (i <= $('.li_period').length && isBewteen == false) 
        {
            
            if(thisLiParentId !== 'li_' + i)
            {
            
                var startDate = moment($('#li_' + i).find('.start').val(), localeDateFormat);
                var endDate = moment($('#li_' + i).find('.end').val(), localeDateFormat);

                if(thisMomentDate.isBetween(startDate, endDate))
                {

                    isBewteen = true;

                }

            }
        
            i++;
        
        }
        
        if (isBewteen) 
        {

            alert("This date is included in another period. So, it can't be used.");
            $(this).focus();
            
        }       

    });
    
    //Dates formatting to ISO before submit
    $("form").submit(function(event) {

        $('input.js-datepicker-period').each(function(e) {

            var sDate = $(this).val();
            var dateTime = moment(sDate, localeDateFormat).toISOString();

            $(this).val(dateTime);

        });

    });

});

/**
 * Add a period
 * 
 * @param {*} $newLinkLiPeriod html to add
 */
function addPeriodForm() 
{
    
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
    
    var $newForm = $("<li class= 'li_period'></li>").append(newForm);

    collectionHolderPeriods.append($newForm);

    // Add a delete link to the new form
    addPeriodRemoveButton($newForm, index + 1);

    // Get the up limit date to create periods
    var upLimiteDate = moment($('#periods_advert_upLimitCreation').val());
   
    // Assigning the start and the end dates
    if(index == 0) 
    {
    
        var today = moment().format('L');
        
        $('#periods_advert_periods_0_start').val(today);

    }
    else
    {
        var previousEndDate = $('#periods_advert_periods_'.concat(index - 1).concat('_end')).val();
        var periodStart = moment(previousEndDate, localeDateFormat).add(1, 'days');
        var idInputEndPeriod = 'periods_advert_periods_'.concat(index).concat('_end');

        if(periodStart.isBefore(upLimiteDate))
        {
            
            $('#periods_advert_periods_'.concat(index).concat('_start')).val(periodStart.format('L'));
            $('#' + idInputEndPeriod).val(moment($('#' + idInputEndPeriod).val()).format('L'));

        }
        else
        {

            $('#' + idInputEndPeriod).val(null);
        }

    }

}

/**
 * Add a remove period button
 * 
 * @param {*} $periodFormLi html to add
 */
function addPeriodRemoveButton($periodForm, index) 
{

    var $removeButton = $('<button class="btn btn-danger">Remove this period</button>');

    $periodForm.append($removeButton);

    $removeButton.on('click', function(e) {

        if(confirm("Are you certain to want to remove this period ?"))
        {
        
            // Remove period form
            $periodForm.remove();

            // Change the collectionHolderPeriods index
            collectionHolderPeriods.data('index', index - 1);

        }

    });

}