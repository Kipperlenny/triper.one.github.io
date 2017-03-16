<?php 

/**
* 	Ajax / WP REST Global Activity Posts Request
*/

function enqueue_global_activity(){
	wp_enqueue_script('triperone-globalactivityjs', get_template_directory_uri() . '/ajax/globalActivity.js', array('jquery'), "1.0.0",true);

	wp_enqueue_style('triperone-globalactivitycss', get_template_directory_uri() . '/css/global-activity.css');
	$globalActivityObject = array(
			'root' => esc_url_raw( rest_url() ),
			'nonce' => wp_create_nonce( 'wp_rest' ),
			'failure' => __('The request could not be processed', 'triperone' ),
			'eventReviewMsg' => __( 'Review this event:', 'triperone' ),
			'yourReview' => __( 'Your review on this event:', 'triperone' ),
			'themeUrl' => get_template_directory_uri(),
			'currentUserId' => get_current_user_id(),
			'cancel' => __('cancel', 'triperone'),
			'join' => __('join','triperone'),
			'participantsString' => __('Participants', 'triperone'),
			'commentMessage' => __('Leave a Comment', 'triperone'),
			'host' => __('Host', 'triperone'),
			'categories' => __('Posted in: ', 'triperone'),
            'indexHeader' => __('Global Activity', 'triperone')
	);
	wp_localize_script('triperone-globalactivityjs', 'globalActivityObject', $globalActivityObject );
}
add_action( 'wp_enqueue_scripts', 'enqueue_global_activity');







function global_activity_activate(){
  flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'global_activity_activate');





function getglobalevents_register_endpoints(){
  register_rest_route(
    'events/v2',
    '/global-activity/',
    array(
      'methods' => 'GET',
      'callback' => 'get_global_events',
      )
  );
}
		//error message
		/*		if ($getVote == $vote){
					return new WP_Error('vote_error', __('Your vote has already been added'), array('$getVote'.$getVote, '$vote'.$vote));	
		} */
		

add_action( 'rest_api_init', 'getglobalevents_register_endpoints');

//REQUEST CALLBACK
function get_global_events(WP_REST_Request $request){			
/*------------------------------------------------------------------HTML-RESPONSE------------------------------*/	
	function getNewPostHTML(){
			
			$currentUser = get_current_user_id();
			$newEeventQueryOutput;
			ob_start(); 
		
			$queryArgs = array(
				'post_type'			=>  array('event'),
				'orderby' 			=> 'date',
				'order'   			=> 'DESC',
				'post_status' 		=> 'publish',
              	'posts_per_page' 	=> POSTSPERPAGEINDEXPHP,
				'author' 			=> -$currentUser,
			);
			$globalActivityQuery = new WP_Query($queryArgs);
            $found_posts = absint($globalActivityQuery->found_posts);
				?>
		

			
			<?php 
			if ( $globalActivityQuery->have_posts() ) {
					while ( $globalActivityQuery->have_posts() ) {
							$globalActivityQuery->the_post();
			
			include(locate_template('template-parts/event-article.php'));
						
			
						
			} //while have posts
			
			$newEeventQueryOutput = ob_get_contents();
			ob_end_clean();
			return array($newEeventQueryOutput, $found_posts);
				
		} // if have posts
		
		wp_reset_postdata();

		
	} //new-event-HTML-response-function

		$getNewPostHTML = getNewPostHTML();
		$newEventRequestArray['html'] = $getNewPostHTML[0];
		$newEventRequestArray['found_posts'] = $getNewPostHTML[1];
	
		return $newEventRequestArray;
		

//	}//if is_user_logged_in

}// post_new_event function
