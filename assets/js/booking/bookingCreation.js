//Setup the date format according to navigator locale
var localData = moment.localeData();
var localeDateFormat = localData['_longDateFormat']['L'];

jQuery(document).ready(function() {
    
    //Dates formatting according user's locale
    $('.js-datepicker-date').each(function() {

        if($(this).val())
        {
        
            $(this).val(moment($(this).val(), 'YYYY-MM-DD').format('L'));

        }

    });

    //Use a calendar for the start and end dates of booking        
    $(".js-datepicker-date").datepicker({
        
        viewMode: "months",
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
        startDate: '-0m',
        endDate:'+2y',
        format: localeDateFormat.toLowerCase()
    });
    
    // Avoid end date less than begin
    $("#booking_beginAt").datepicker().on('changeDate', function (selected) {

        $('#booking_endAt').datepicker('setStartDate', selected.date);

    });    
    
    $("#booking_endAt").datepicker().on('changeDate', function (selected) {

        $('#booking_beginAt').datepicker('setEndDate', selected.date);

    });
    
    //Dates formatting to ISO before submit
    $("form").submit(function(event) {

        $('input.js-datepicker-date').each(function(e) {

            var sDate = $(this).val();
            var dateTime = moment(sDate, localeDateFormat).toISOString(true);

            $(this).val(dateTime);

        });

    });

});