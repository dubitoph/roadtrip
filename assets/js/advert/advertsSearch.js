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

      pricesceSlider();
      distanceSlider();
        
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

  $("#minimumPrice").on('change', function(e) {

    pricesceSlider();

  });

  $("#maximumPrice").on('change', function(e) {

    pricesceSlider();

  });

  $("#distance").on('change', function(e) {

    distanceSlider();

  });

});

function pricesceSlider()
{

  var $minPriceInput = $("#minimumPrice");
  var $maxPriceInput = $("#maximumPrice");
  var $pricesSliderDiv = $("#pricesSlider");
    
  var minPrice = parseInt($minPriceInput.val());
  var maxPrice = parseInt($maxPriceInput.val());
    
  var minPriceParameter = parseInt($pricesSliderDiv.attr('data-minPriceParameter'));
  var maxPriceParameter = parseInt($pricesSliderDiv.attr('data-maxPriceParameter'));

  $pricesSliderDiv.slider({
                            range: true,
                            min: minPriceParameter,
                            max: maxPriceParameter,
                            values: [minPrice, maxPrice],
                            slide: function() 
                                  {

                                      $minPriceInput.val($pricesSliderDiv.slider("values", 0));
                                      $maxPriceInput.val($pricesSliderDiv.slider("values", 1));
                                                  
                                  }
  });

}

function distanceSlider()
{

  var $distanceInput = $("#distance");
  var $distanceSliderDiv = $("#distanceSlider");
    
  var distance = parseInt($distanceInput.val());
    
  var minDistanceParameter = parseInt($distanceSliderDiv.attr('data-minDistanceParameter'));
  var maxDistanceParameter = parseInt($distanceSliderDiv.attr('data-maxDistanceParameter'));

  $distanceSliderDiv.slider({
                              min: minDistanceParameter,
                              max: maxDistanceParameter,
                              step: 5,
                              value: distance,
                              slide: function() 
                                     {

                                        $distanceInput.val($distanceSliderDiv.slider("value"));
                                                    
                                     }
  });

}