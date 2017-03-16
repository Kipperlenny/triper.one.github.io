//get my events WP REST API AJAX Request

(function ($) {	
	$(document).ready(function () {

	$('#myEventsTab').on('click', function () {
                    
					$('#loadMoreAjaxLoaderMyEvents').show();
					$('.ajax-loader.global-activity').show();
	
					$.ajax({
						method: "GET",
						url: myEventsObject.root + 'events/v2/my-events/',
						beforeSend: function (xhr) {
							xhr.setRequestHeader('X-WP-Nonce', myEventsObject.nonce);
						},
						}).done(function(response, object){
                                    $('body').addClass('myEvents');
                                    $('#newEventFormDiv').removeClass('none');
                                    $('#indexHeader h1').text(myEventsObject.indexHeader);
									$('.ajax-loader.global-activity').hide();
									$('#loadMoreLinkMyEvents').removeClass('none');
									$('#loadMoreLinkFilterResults').addClass('none');
									$('#loadMoreLinkMyEvents').attr('style','');
									$('#loadMoreLinkGlobal').addClass('none');
									console.log("response done:");
									console.dir(response);

									$('#main').empty();
									$('#main').prepend(response.html);

									$('#loadMoreAjaxLoaderMyEvents').hide();
									$('#globalActivityTab').removeClass('active');
									$('#myEventsTab').addClass('active');
                                    if (response.found_posts <= FOUNDPOSTSLIMIT || response.found_posts === null){
                                        $(".loadMoreLink").addClass('none');
                                    }
						}).fail(function(jqXHR, textStatus ) {
									console.log( "Request failed: " );
									console.log( jqXHR );

						}).always(function(){

						});
		});

	});

})(jQuery);


