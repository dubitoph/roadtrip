//Use a calendar for the star and end dates of booking

$([document]).on( 'focus', 'input.js-datepicker-date',function() {
    
    $(".js-datepicker-date").datepicker({
        viewMode: "months",
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
        startDate: '-0m',
        endDate:'+2y',
        format:  'yyyy/mm/dd'
    });
});
//End of the the dates booking management 