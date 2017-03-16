var newEventButton = document.getElementById('newEventHeading');

//New Event Form Animation on click
newEventButton.addEventListener("click", function(){
		var newEventFormDiv = document.getElementById("newEventFormDiv");
		newEventFormDiv.classList.toggle("closed");
});
	

//prevents calling ajax request on multiple click unless the first request is finished and the form was made empty
var newEventFlag = false;

var imageUploadResponse;
//post a new event AJAX / WP REST Request
jQuery( document ).ready( function ( $ ) {
	var globalData;
	
	//post text
	function postNewEvent(featuredImageId, featuredMedia, data){
								data.featuredMedia = featuredMedia;
								data.featuredImageId = featuredImageId;
                                
								$.ajax({
									method: "POST",
									url: ajaxObject.root + 'events/v2/newpost',
									data: data,
									beforeSend: function ( xhr ) {
										xhr.setRequestHeader( 'X-WP-Nonce', ajaxObject.nonce );
									},
									success : function( response ) {
										console.log("post response:");
										console.log(response);
										console.log("response.$queryResult)");
										console.log(response.$queryResult);

										//deletes input values and closes the new event form
										$('#newEventFormDiv input').not('#newEventSubmit').val('');
										$('#newEventFormDiv textarea').val('');
										$('#main').prepend(response.html);
										$('#newEventFormDiv').removeClass('visible');
										$('#newEventFormMessage').text("");

										alert( ajaxObject.success );
										newEventFlag = false;
									},
									error: function(xhr, status, error) {
										console.log("xhr");
										console.log(xhr);
										console.log("status");
										console.log(status);
										console.log("error");
										console.log(error);
									}
								}); // second ajax call
		}// postNewEvent function


	
    $( '#cancelNewEvent' ).on( 'click', function(e) {
		$('#newEventFormDiv input').not('#newEventSubmit').val('');
		$('#newEventFormDiv textarea').val('');
		$('.requiredInput').removeClass('requiredInput');
		$('#newEventFormDiv').addClass('closed');
		$('#newEventFormMessage').text("");
	});
    $( '#newEventForm' ).on( 'submit', function(e) {
        e.preventDefault();
		if (newEventFlag === false){
            var country;
            var city;
            var region;
            var place_id;
			newEventFlag = true;
			var title = $( '#newEventTitle' ).val();
			var content = $( '#newEventDescription' ).val();
			var category = $( '#newEventCategorySelection' ).val();
			var filterPlaceInput = $( '#newEventPlace' ).val();
         
            if (autoCompleteData){
                console.log("postevent.js 80");
                console.log(autoCompleteData.place_id);
                country = autoCompleteData.country;
                city = autoCompleteData.city;
                region = autoCompleteData.region;
                place_id = autoCompleteData.place_id;
            }
			var maxParticipants = $('#newEventParticipants').val();
			var dateStart = $('#newEventDateStart').val();
			var timeStart = $('#newEventTimeStart').val();
			var featuredImageLength = $('#image-input').val();
				featuredImageLength = featuredImageLength.length;
			//var featuredImage = $('#file').val();
			
			var data = {};
			var required  = [];
		
			//media file upload
			var fileInput = $('#image-input'),
			formData = new FormData(); 
  	
			
			if(title.length === 0 ){
				$( '#newEventTitle' ).addClass('requiredInput');
				required.push(' Title');
			} else {data.title = title;}
			if(content.length === 0 ){
				required.push(' Description');
				$( '#newEventDescription' ).addClass('requiredInput');
			} else {data.content = content;}
			if(category === null || category.length === 0 ){
				required.push(' Category');
				$( '#newEventCategory' ).addClass('requiredInput');
			} else {data.category = category;}
		/*	if(country.length === 0 ){
				required.push(' Country');
				$('#newEventCountry').addClass('requiredInput');
			} else {data.country = country;}*/
            
			/*if(city.length === 0 ){
				required.push(' City');
				$('#newEventCity').addClass('requiredInput');
			} else {data.city = city;}*/
			if(maxParticipants.length === 0 ){data.maxParticipants = 0;} else {data.maxParticipants = maxParticipants;}
			if(dateStart.length === 0 ){
				required.push(' Date');
				$('#newEventDateStart').addClass('requiredInput');
			} else {data.dateStart = dateStart;}
			if(timeStart.length === 0 ){
				required.push(' Time');
				$('#newEventTimeStart').addClass('requiredInput');
			} else {data.timeStart = timeStart;}
            if(filterPlaceInput.length === 0){
                        required.push(" Place");
                        $('#newEventPlace').addClass('requiredInput');
			} else if(!place_id){
                var string = ' Place (please select a google autocomplete suggestion; only these are accepted)';
                required.push(string);
                $('#newEventPlace').addClass('requiredInput');
            } else if(place_id && place_id.length > 0){
                data.place_id = place_id;
                data.country = country;
                data.city = city;
                data.region = region;
            }
			
			globalData = data;
			if(required.length > 0){
				$('#newEventFormMessage').text("Please fill out these fields:" + required);
				newEventFlag = false;
				required = [];
					$('.requiredInput').on('focusin',function(){
						$(this).removeClass('requiredInput');
					} );
			}else{
					if(featuredImageLength > 0){
						formData.append( 'file', fileInput[0].files[0] ); 
					   $.ajax({ 
							url: 'http://dev.triper.one/wp-json/wp/v2/media', 
							method: 'POST', 
							data: formData,
							contentType: false, 
							processData: false, 
							beforeSend: function ( xhr ) {
								xhr.setRequestHeader( 'X-WP-Nonce', ajaxObject.nonce );
							},
							success: function( data ) { 
                                
								imageUploadResponse = data;
								console.log( data ); 
								postNewEvent(imageUploadResponse.id, 1, globalData);
								alert( ajaxObject.successImageUpload );
							}, 
							error: function( error ) { 
								console.log( error ); 
								console.log( "globalData" ); 
								console.log( globalData ); 
							} 
						}); 
					console.log("data");
					console.dir(data);
				}//if featuredImageLength > 0
				else{
					console.log("data");
                                console.log(data);
					//second ajax call for posting an event without featured image
					postNewEvent(0, 0, data);
					
				}
				
				
				
			} // if required length = 0
		}// if (newEventFlag === false)
	}); //click Event

} ); //on ready