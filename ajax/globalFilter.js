var globalFilter ={};
globalFilter.place_id = "";
var getFilteredEvents;
var theResponse;
var autocompleteFilter;
var autocompleteNewEvent;


/*----------------------------------------AUTOCOMPLETE INIT --------------------------------------*/
function initAutocomplete() {
    // Create the autocomplete object, restricting the search to cities.
    autocompleteFilter = new google.maps.places.Autocomplete((document.getElementById('filterPlaceInput')),{ types: ['(cities)']});

    // When the user selects an address from the dropdown, populate the address fields in the form.
    autocompleteFilter.addListener('place_changed', filterAutocompleteCallback);
    
    
    autocompleteNewEvent =  new google.maps.places.Autocomplete((document.getElementById('newEventPlace')), {
		types: ['(cities)']
	});
}



/*----------------------------------------FILTER AUTOCOMPLETE INIT CALLBACK---------------------*/
function filterAutocompleteCallback(){
    var place = autocompleteFilter.getPlace();
    globalFilter = getPlaceData(place);
    console.log("place");
    console.log(place);
    console.log("globalFilter");
    console.log(globalFilter);
    
    var getFilterPlaceData = getPlaceData(place);
    //call filter function for displaying events with selected place:
    getFilteredEvents(getFilterPlaceData);
      // a result has multiple address components
    //console.log(place.address_components); 
}

/*----------------------------------------GET DATA FROM AUTOCOMPLETE PLACE OBJECT---------------------*/
function getPlaceData(place){
    var autoCompleteData = {};
    place.address_components.forEach(function(c) {
        switch(c.types[0]){
            case "administrative_area_level_1":
                autoCompleteData.region = c.long_name;
                break;
            case 'locality':
                autoCompleteData.city = c.long_name;
                break;
            case 'country':
                autoCompleteData.country = c.long_name;
                break;
        }
    });
    autoCompleteData.place_id = place.place_id;
    autoCompleteData.formatted_address = place.formatted_address;
    
    return autoCompleteData;
}

    
// POST NEW EVENT: set event listener on focus on the filterPlaceInput and trigger the place object on tabulator
if(document.getElementById("newEventPlace")) {
	document.getElementById("newEventPlace").addEventListener('focusin', function(){  
	    var that = this;
	
	    that.addEventListener('keyup',function(e){
	        if(e.keyCode === 9){
	            //google.maps.event.trigger(this, 'focus');
	            google.maps.event.trigger(this, 'keydown', {
	                keyCode: 13
	            });
	            newEventPlace = autocompleteNewEvent.getPlace();
	            console.log("newEventPlace");
	            console.log(newEventPlace);
	            console.log("autocompleteNewEvent");
	            console.log(autocompleteNewEvent);
	            autoCompleteData = getPlaceData(newEventPlace);
	        }
	    },false);
	
	    google.maps.event.addDomListener(that, 'keydown', function(e) { 
	        if (e.keyCode == 13) { 
	            e.preventDefault(); 
	            setTimeout(function(){
	                newEventPlace = autocompleteNewEvent.getPlace();
	                console.log("newEventPlace");
	                console.log(newEventPlace);
	                console.log("autocompleteNewEvent");
	                console.log(autocompleteNewEvent);
	                autoCompleteData = getPlaceData(newEventPlace);
	            },500);
	        }
	      }); 
	},false);//focusin listener
}


window.addEventListener('load',function(){
    var searchEventForm = document.getElementById("searchEventForm");
    if(!searchEventForm) return;
    searchEventForm.addEventListener("submit", function(e){
        e.preventDefault();
        var category = jQuery( '#selectCategorySearchForm' ).val();
        
        getFilteredEvents(globalFilter.place_id, category);
        
    },false); // on submit
},false); // on load


/*--------------------------------------------------------------AJAX--------------------------------*/

(function($){

getFilteredEvents = function(getFilterPlaceData, category){
    if(getFilterPlaceData || category){
        
            //get filtered events 
                (function ($) {	
                    $('#loadMoreAjaxLoaderFilterResults').show();
				    $('.ajax-loader.global-activity').show(); 
                    var data = {};
                     if(getFilterPlaceData){
                            data.place_id = getFilterPlaceData.place_id || getFilterPlaceData;
                            data.country = getFilterPlaceData.country;
                            data.city = getFilterPlaceData.city;
                            data.region = getFilterPlaceData.region;
                            globalFilter.place_id = getFilterPlaceData.place_id || getFilterPlaceData;
                     } 
                    if(category){
                        data.category = category;
                    }
                        console.log("data");
                        console.log(data);
                        $.ajax({
                            method: "GET",
                            url: globalActivityObject.root + 'events/v2/global-filter/',
                            data: data,
                            beforeSend: function (xhr) {
                                xhr.setRequestHeader('X-WP-Nonce', globalActivityObject.nonce);
                            },
                            }).done(function(response, object){
                                        $('.ajax-loader.global-activity').hide();
                                        $('#main').empty();
                                        $('#main').prepend(response.html);
                                        $('#loadMoreAjaxLoaderFilterResults').hide();
                                        $('#loadMoreLinkGlobal').addClass('none');
                                        $('#loadMoreLinkMyEvents').addClass('none');
                                        $('#loadMoreLinkIndex').addClass('none');
                                        $('#loadMoreLinkFilterResults').removeClass('none');
                                                
                                        //reset pagination 
                                        pageFilter = 1;
                                        console.log("response done:");
                                        console.dir(response);
                                        theResponse = response;
                                    if (response.found_posts <= FOUNDPOSTSLIMIT || response.found_posts === null){
                                        $(".loadMoreLink").addClass('none');
                                    }

                            }).fail(function(jqXHR, textStatus ) {
                                        console.log( "Request failed: " );
                                        console.log( jqXHR );

                            }).always(function(){

                            });
                })(jQuery);
    }// if place
};//getEventsByPlace


//
    
}(jQuery));