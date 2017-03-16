// this script is not beeing used anymore

function callNewEvent($, object){
	

	//print out category classes of the event
	function slugsToString(object){
		var string= '';
		var length = object.category_slug.length;
		for (var i = 0; i < length; i++){
			string += 'category-' + object.category_slug[i] +' ';
		}
		return string;
	}


	
	
	function getCatImages(object){
			var output = '';
			var length = object.category_slug.length;
			for (var i = 0; i < length; i++){
				if(object.category_slug[i] === 'art-design'){
					output += '<a href="http://dev.triper.one/category/art-design"><img src="http://dev.triper.one/wp-content/themes/triperone/images/cat_art.png"></a>';
				}
				if(object.object.category_slug[i] === 'fun-nightlife'){
					output += '<a href="http://dev.triper.one/category/fun-nightlife"><img src="http://dev.triper.one/wp-content/themes/triperone/images/cat_music.png"></a>';
				}
				if(object.object.category_slug[i] === 'outdoor-sport'){
					output += '<a href="http://dev.triper.one/category/outdoor-sport"><img src="http://dev.triper.one/wp-content/themes/triperone/images/cat_outdoor.png"></a>';
				}
				if(object.object.category_slug[i] === 'history-architecture'){
					output += '<a href="http://dev.triper.one/category/history-architecture"><img src="http://dev.triper.one/wp-content/themes/triperone/images/cat_architecture.png"></a>';
				}
				if(object.object.category_slug[i] === 'cooking-dining'){
					output += '<a href="http://dev.triper.one/category/cooking-dining"><img src="http://dev.triper.one/wp-content/themes/triperone/images/cat_cooking.png"></a>';
				}
			}
		return output;
	}

/*------------------------------------------------------------------------------------------AJAX---------------------------------------------------------------------------------*/	
		/*	$.ajax({
				dataType: 'json',
				method: "GET",
				url: callNewEventObject.root + callNewEventObject.endpoint,
				beforeSend: function (xhr) {
					xhr.setRequestHeader('X-WP-Nonce', callNewEventObject.nonce);
				},*/
		
/*------------------------------------------------------------------------------------------.done()-------------------------------------------------------------------------------*/	

	var postType = 'event';
	var postId = object.id;
	var commentMessage = callNewEventObject.commentMessage;


	var article = '<article id="" class="event event-'+ postId +' type-'+ postType +' status- hentry '+ slugsToString(object) +'">';

	var header =	'<header class="entry-header">' +
						'<h2 class="entry-title"><a href="'+ object.link +'" rel="bookmark">'+ object.title.rendered + '</a></h2>	' +
					'<span>'+ callNewEventObject.host+ ': </span><a class="hostLink" href="'+ object.author_image_src +'"><span class="hostName">'  + '' +'</span></a>'+
					'</header>';

	var catImages = '<div class="catImages">'+
						getCatImages(object) +
					'</div>';

	var featuredImage = '';
	if(object.featured_media == 0){} else{
		featuredImage = '<div class=featured-image>'+
						'<a href="'+ object.link +'"><img src="' + object.featured_image_src + '"></a>'+
						'</div>';
	}
	var content =   '<div class="entry-content">' + object.content.rendered +'</div>'; 

	var comments = '<footer class="entry-footer">' +
							'<span class="comments-link">' +
								'<a href="'+ object.link +'#respond">'+ commentMessage + '</a>' +
							'</span>' +
						'</footer>';
	var articleEnd = '</article>';
	
	
	$('#newEventFormDiv').removeClass('visible');
	$('#main').prepend(article + header  + catImages + featuredImage + content + comments + articleEnd).hide().fadeIn(500);	

	/*				
		}).done(function(response, object){
		}).fail(function(jqXHR, textStatus ) {
			console.log( "Request failed: " );
			console.log( jqXHR );

		}).always(function(){
		*/
}


