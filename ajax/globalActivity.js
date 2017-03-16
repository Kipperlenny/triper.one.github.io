//rate an event AJAX / WP REST call / request
(function ($) {	
	$(document).ready(function () {

		$('#globalActivityTab').on('click', function () {
               
				$('#loadMoreAjaxLoaderGlobal').show();
				$('.ajax-loader.global-activity').show();
					pageMyevents = 1;
				
				$.ajax({
					method: "GET",
					url: globalActivityObject.root + 'events/v2/global-activity/',
					beforeSend: function (xhr) {
						xhr.setRequestHeader('X-WP-Nonce', globalActivityObject.nonce);
					},
					}).done(function(response){
                                 $('body').removeClass("myEvents");
								$('#newEventFormDiv').addClass('none');
								$('.ajax-loader.global-activity').hide();
								$('#indexHeader h1').text(globalActivityObject.indexHeader);
								$('#loadMoreLinkIndex').addClass('none');
								$('#loadMoreLinkMyEvents').addClass('none');
								$('#loadMoreLinkGlobal').removeClass('none');
								$('#loadMoreLinkGlobal').attr('style','');
								console.log("response done:");
								console.dir(response);

								$('#main').empty();
								$('#main').prepend(response.html);

								$('#loadMoreAjaxLoaderGlobal').hide();
								$('#globalActivityTab').addClass('active');
								$('#myEventsTab').removeClass('active');
                                
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




