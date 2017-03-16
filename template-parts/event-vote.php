<?php  



$userId = get_current_user_id();
$postId = get_the_ID();

if (checkIfUserIsParticipant($userId, $postId)){


	// show review box if event post type 
	if ( 'event' === get_post_type() ){
			$vote=NULL;
			$value1 = '';
			$value2 = '';
			$value3 = '';
			$value4 = '';
			$value5 = '';


			
			$result = checkIfVoteExists($userId, $postId);
				//echo '<br>$result'.$result;
			if ($result > 0){
				$yourVote = __( 'Your review on this event:', 'triperone' );
				$vote = getVote($userId, $postId);
				$vote = $vote[0];
				$vote = $vote->rating;
				$vote = $vote[0];	

				if($vote == 1){
					$value1 = 'selected';
					$value2 = '';
					$value3 = '';
					$value4 = '';
					$value5 = '';
				}else if($vote == 2){
					$value1 = 'selected';
					$value2 = 'selected';
					$value3 = '';
					$value4 = '';
					$value5 = '';
				}if($vote == 3){
					$value1 = 'selected';
					$value2 = 'selected';
					$value3 = 'selected';
					$value4 = '';
					$value5 = '';
				}if($vote == 4){
					$value1 = 'selected';
					$value2 = 'selected';
					$value3 = 'selected';
					$value4 = 'selected';
					$value5 = '';
				}if($vote == 5){
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






			<div class="voteBox">
				<h3><?php echo $yourVote ?></h3>
				<section class='rating-widget'>

					<!-- Rating Stars Box -->
					<div class='rating-stars text-center'>
						<ul class='stars'>
							<li class='star <?php echo $value1 ?>' title='Poor' data-value='1' data-user="<?php echo get_current_user_id(); ?>" data-action="vote" data-post="<?php  echo get_the_ID(); ?>">
								<i class='fa fa-star fa-fw'></i>
							</li>
							<li class='star <?php echo $value2 ?>' title='Fair' data-value='2'  data-user="<?php echo get_current_user_id(); ?>" data-action="vote" data-post="<?php  echo get_the_ID(); ?>">
								<i class='fa fa-star fa-fw'></i>
							</li>
							<li class='star <?php echo $value3 ?>' title='Good' data-value='3'  data-user="<?php echo get_current_user_id(); ?>" data-action="vote" data-post="<?php  echo get_the_ID(); ?>">
								<i class='fa fa-star fa-fw'></i>
							</li>
							<li class='star <?php echo $value4 ?>' title='Excellent' data-value='4'  data-user="<?php echo get_current_user_id(); ?>" data-action="vote" data-post="<?php  echo get_the_ID(); ?>">
								<i class='fa fa-star fa-fw'></i>
							</li>
							<li class='star <?php echo $value5 ?>' title='WOW!!!' data-value='5'  data-user="<?php echo get_current_user_id(); ?>" data-action="vote" data-post="<?php  echo get_the_ID(); ?>">
								<i class='fa fa-star fa-fw'></i>
							</li>
						</ul>
					</div>

					<div class='success-box hidden'>
						<div class='clearfix'></div>
						<img alt='tick image' width='32' src='http://i.imgur.com/3C3apOp.png'/>
						<div class='text-message'></div>
						<div class='clearfix'></div>
					</div>

				</section>

			</div>


<?php 
	} 
}
?>