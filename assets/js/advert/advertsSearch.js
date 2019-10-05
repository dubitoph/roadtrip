import { autocompleteAddress } from '../app';

//Setup the date format according to navigator locale
var localData = moment.localeData();
var localeDateFormat = localData['_longDateFormat']['L'];

jQuery( document ).ready( function( $ ) {

  //Dates formatting according user's locale
  $('.js-datepicker').each(function() {

      if($(this).val())
      {
      
          $(this).val(moment($(this).val(), 'YYYY-MM-DD').format('L'));

      }

      //Use a calendar for the start and end dates of booking 
      $(".js-datepicker").datepicker({
    
        viewMode: "years",
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
        startDate: '-0d',
        endDate:'+2y',
        format: localeDateFormat.toLowerCase()
    
      });
        
      // Avoid end date less than begin date
      $("#beginAt").datepicker().on('changeDate', function (selected) {
    
          $('#endAt').datepicker('setStartDate', selected.date);
    
      });    
      
      $("#endAt").datepicker().on('changeDate', function (selected) {
    
          $('#beginAt').datepicker('setEndDate', selected.date);
    
      });

  });
    
  //Dates formatting to ISO before submit
  $("form").on('submit', function(e) {

    var beginAt = $('#beginAt').val();
    var dateTimeBeginAt = moment(beginAt, localeDateFormat).toISOString(true);

    var endAt = $('#endAt').val();
    var dateTimeEndAt = moment(endAt, localeDateFormat).toISOString(true);

    $('#beginAt').val(dateTimeBeginAt);
    $('#endAt').val(dateTimeEndAt);

  });

  autocompleteAddress('profile_address_street', 'profile_address_city', 'profile_address_zipCode', 'profile_address_country', 
                      'profile_address_latitude', 'profile_address_longitude');

});