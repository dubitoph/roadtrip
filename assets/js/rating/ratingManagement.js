//Using a calendar for dates

$(document).ready(function() {
    
    $(".js-datepicker").datepicker({
                viewMode: "years",
                weekStart: 1,
                daysOfWeekHighlighted: "6,0",
                autoclose: true,
                todayHighlight: true,
                startDate: '-365y',
                endDate:'+0d',
                format:  'yyyy/mm/dd'
            });

});