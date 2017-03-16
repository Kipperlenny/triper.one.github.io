//rate an event AJAX / WP REST call / request
(function ($) {
	var parentVoteBox;
	var onStar;
	var data;

	function getData(vote, postId, userId) {
		data={
			vote: vote,
			post_id: postId,
			user_id: userId
		};
	}

	$(document).ready(function () {

		/* 1. Visualizing things on Hover - See next part for action on click */
		$('.stars li').on('mouseover', function () {
			var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

			// Now highlight all the stars that's not after the current hovered star
			$(this).parent().children('li.star').each(function (e) {
				if (e < onStar) {
					$(this).addClass('hover');
				} else {
					$(this).removeClass('hover');
				}
			});

		}).on('mouseout', function () {
			$(this).parent().children('li.star').each(function (e) {
				$(this).removeClass('hover');
			});
		});


		/* 2. Action to perform on click */
		$('.stars li').one('click', function () {
			onStar = parseInt($(this).data('value'), 10); // The star currently selected
			console.log("this data-post");
			console.log(this.getAttribute('data-post'));
			var stars = $(this).parent().children('li.star');

			for (i = 0; i < stars.length; i++) {
				$(stars[i]).removeClass('selected');
			}

			for (i = 0; i < onStar; i++) {
				$(stars[i]).addClass('selected');
			}

			// JUST RESPONSE (Not needed)
			var ratingValue = parseInt($('.stars li.selected').last().data('value'), 10);
			var msg = "";
			msg = "Thanks! Your review has been saved.";

			parentVoteBox = $(this).parents('.voteBox');
			responseMessage(msg, parentVoteBox);
			
			var postId = this.getAttribute('data-post');
			var userId = this.getAttribute('data-user');
			var vote = this.getAttribute('data-value');
			var action = this.getAttribute('data-action');
			getData(vote, postId, userId);
			console.log("data");
			console.log(data);
			$.ajax({
				method: "POST",
				url: voteObject.root + 'event-voting/v2/votes',
				data: data,
				beforeSend: function (xhr) {
					xhr.setRequestHeader('X-WP-Nonce', voteObject.nonce);
				},
				success: function (response) {
					console.log("post review response:");
					console.log(response);
					console.log("post");
					var html = $(response.post);
					console.log(html);
					//JSON.parse(response);
				},
				fail: function (response) {
					console.log("response: " + response);
					alert(voteObject.failure);
				}

			});

		});

	});

	function responseMessage(msg, parentVoteBox) {
		parentVoteBox.find('.success-box').toggleClass('hidden').fadeIn(200);
		parentVoteBox.find('.success-box div.text-message').html("<span>" + msg + "</span>");
	}



})(jQuery);
