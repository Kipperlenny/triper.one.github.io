<?php
$userId = get_current_user_id();
$postId = get_the_ID();
$count = countReviews($postId);



// show review box if event post type 
if ( 'event' === get_post_type() ) {
	$avarageReview = 3.6;
	$value1 = '';
	$value2 = '';
	$value3 = '';
	$value4 = '';
	$value5 = '';


	$result = checkIfVoteExists( $userId, $postId );
	if ( $result > 0 ) {
		
		
		if ( $avarageReview < 1.5 ) {
			$value1 = 'selected';
			$value2 = '';
			$value3 = '';
			$value4 = '';
			$value5 = '';
		} else if ( $avarageReview < 2.5 && $avarageReview > 1.5 ) {
			$value1 = 'selected';
			$value2 = 'selected';
			$value3 = '';
			$value4 = '';
			$value5 = '';
		}
		if ($avarageReview < 3.5 && $avarageReview > 2.5 ) {
			$value1 = 'selected';
			$value2 = 'selected';
			$value3 = 'selected';
			$value4 = '';
			$value5 = '';
		}
		if ($avarageReview < 4.5 && $avarageReview > 3.5) {
			$value1 = 'selected';
			$value2 = 'selected';
			$value3 = 'selected';
			$value4 = 'selected';
			$value5 = '';
		}
		if ($avarageReview > 4.5 ) {
			$value1 = 'selected';
			$value2 = 'selected';
			$value3 = 'selected';
			$value4 = 'selected';
			$value5 = 'selected';
		}

	} else {
		$yourVote = __( 'Review this event:', 'triperone' );
	}

?>


	<div class="reviewBox">
<!--	<pre><?php var_dump($count) ?></pre>-->
		<h3>Avarage review based on <?php ?> reviews</h3>

		<!-- Rating Stars Box -->
		<div class='avarage-stars text-center'>
			<ul class='avarageStars'>
				<li class='avarageStar <?php echo $value1; ?>'>
					<i class='fa fa-star fa-fw'></i>
				</li>
				<li class='avarageStar <?php echo $value2; ?>'>
					<i class='fa fa-star fa-fw'></i>
				</li>
				<li class='avarageStar <?php echo $value3; ?>'>
					<i class='fa fa-star fa-fw'></i>
				</li>
				<li class='avarageStar <?php echo $value4; ?>'>
					<i class='fa fa-star fa-fw'></i>
				</li>
				<li class='avarageStar <?php echo $value5; ?>'>
				<i class='fa fa-star fa-fw'></i>
				</li>
			</ul>
		</div>
	</div>
<?php } ?>