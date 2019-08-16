import { autocompleteAddress } from '../app';

var localData = moment.localeData();
var localeDateFormat = localData['_longDateFormat']['L'];


$(document).ready(function() {

    //Formatting manufacture date if it exists  
    var $manufactureDateInput = $("#vehicle_manufactureDate");
    var sDate = $manufactureDateInput.val();
        
    if (sDate) 
    {

      $manufactureDateInput.val(moment(sDate, 'YYYY-MM-DD').format('L'));
      
    }    
    //End manufacture date formatting

    //Using a calendar for the building vehicle date
    $(".js-datepicker").datepicker({

      viewMode: "years",
      weekStart: 1,
      daysOfWeekHighlighted: "6,0",
      autoclose: true,
      todayHighlight: true,
      startDate: '-30y',
      endDate:'+0d',
      format:  'yyyy-mm-dd'

    });
    
    $manufactureDateInput.on('change', e => {
        
      $manufactureDateInput.val(moment($manufactureDateInput.val(), 'YYYY-MM-DD').format('L'));
    
    });
    
    $("form").submit(function(event) {

      var $mamufactureDateInput = $("#vehicle_manufactureDate");
      var sDate = $mamufactureDateInput.val();
      var dateTime = moment(sDate, localeDateFormat).toISOString();

      $mamufactureDateInput.val(dateTime);

    });

    autocompleteAddress('vehicle_situation_street', 'vehicle_situation_city', 'vehicle_situation_zipCode', 'vehicle_situation_country', 
                        'vehicle_situation_number', 'vehicle_situation_box', 'vehicle_situation_state', 'vehicle_situation_latitude', 
                        'vehicle_situation_longitude');

});