import { setSessionLocation } from '../app';
import { getAjax } from '../app';
import { getCurrentPosition } from '../app';

localStorage.clear();

//Setup the date format according to navigator locale
var localData = moment.localeData();
var localeDateFormat = localData['_longDateFormat']['L'];

var userAddress = localStorage.getItem("userAddress");
var userLatitude = localStorage.getItem("userLatitude");
var userLongitude = localStorage.getItem("userLongitude");
var userCity = localStorage.getItem("userCity");
var userCountryCode = localStorage.getItem("userCountryCode");

jQuery( document ).ready( function( $ ) {

  if (userAddress == null || userLatitude == null || userLongitude == null || userCity == null || userCountryCode == null) 
  { 

    var getUserLocation = async function()
                          {

                            var position = await getCurrentPosition();

                            var latitude = position.coords.latitude;
                            var longitude = position.coords.longitude;

                            var apikey = '49990332282e4e40aa80d8b1481e4152';
                            var api_url = 'https://api.opencagedata.com/geocode/v1/json';

                            var request_url = api_url
                              + '?'
                              + 'key=' + apikey
                              + '&q=' + encodeURIComponent(latitude + ',' + longitude)
                              + '&pretty=1'
                              + '&no_annotations=1'
                            ;
                                
                            var response = await getAjax(request_url);
                            var dataLocation = JSON.parse(response);
                                                                                                                          
                            return dataLocation;
                                                                                                                        
                          }
    ;

    getUserLocation().then(function(dataLocation)
                          {

                              var userAddress = dataLocation.results[0].formatted;
                              var userLatitude = dataLocation.results[0].geometry.lat;
                              var userLongitude = dataLocation.results[0].geometry.lng;
                              var userCity = dataLocation.results[0].components.village;
                              var userCountryCode = dataLocation.results[0].components['ISO_3166-1_alpha-2'];

                              $('#address').val(userAddress);
                              $('#latitude').val(userLatitude);
                              $('#longitude').val(userLongitude);
                              $('#city').val(userCity);

                              setSessionLocation(userAddress, userLatitude, userLongitude, userCity, userCountryCode);

                          }
                              )
                    .catch(function(error)
                            {

                              console.error("Error during the ajax call to get the user's data location", error);

                            }
                          )
    ;

  }
  else
  {

    $('#latitude').val(userLatitude);
    $('#longitude').val(userLongitude);
    $('#address').val(userAddress);
    $('#city').val(userCity);

  }

  if (! sessionStorage.getItem("phpSessionVariablesExist") && userAddress)
  {
    
    setSessionLocation($('#address').val(), $('#latitude').val(), $('#longitude').val(), $('#city').val(), $('#countryCode').val());

  }
  
/*
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
*/

});

/*    
//Dates formatting to ISO before submit
$("form").submit(function(event) {

    $('input.js-datepicker').each(function(e) {

        var sDate = $(this).val();
        var dateTime = moment(sDate, localeDateFormat).toISOString(true);

        $(this).val(dateTime);

    });
*/