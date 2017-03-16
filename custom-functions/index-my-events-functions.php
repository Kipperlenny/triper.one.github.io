<?php 

global $globalTestVar;
$globalTestVar = 100;

function enqueue_my_events(){
	wp_enqueue_script('triperone-myeventsindexjs', get_template_directory_uri() . '/ajax/myEvents.js', array('jquery'), "1.0.0",true);

	$myEventsObject = array(
			'root' => esc_url_raw( rest_url() ),
			'nonce' => wp_create_nonce( 'wp_rest' ),
			'failure' => __('The request could not be processed', 'triperone' ),
			'themeUrl' => get_template_directory_uri(),
			'currentUserId' => get_current_user_id(),
			'indexHeader' => __('My Events', 'triperone'),
	);
	wp_localize_script('triperone-myeventsindexjs', 'myEventsObject', $myEventsObject );
}
add_action( 'wp_enqueue_scripts', 'enqueue_my_events');






function my_events_activate(){
  flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'my_events_activate');



function getmyevents_register_endpoints(){
  register_rest_route(
    'events/v2',
    '/my-events/',
    array(
      'methods' => 'GET',
      'callback' => 'get_my_events',
      )
  );
}
		//error message
		/*		if ($getVote == $vote){
					return new WP_Error('vote_error', __('Your vote has already been added'), array('$getVote'.$getVote, '$vote'.$vote));	
		} */
		

add_action( 'rest_api_init', 'getmyevents_register_endpoints');

/* -----------------------------------------------------------REQUEST CALLBACK-----------------------------*/
function get_my_events(WP_REST_Request $request){			
/*------------------------------------------------------------------HTML-RESPONSE------------------------------*/	
	function getNewPostHTML(){
			$currentUser = get_current_user_id();
			$newEeventQueryOutput;
			$userEventsTotal = count_user_posts( $currentUser , 'event' );
			ob_start(); 
			
			$queryArgs = array(
				'post_type'			=>  array('event'),
				'orderby' 			=> 'date',
				'order'   			=> 'DESC',
				'post_status' 		=> 'publish',
              	'posts_per_page' 	=> POSTSPERPAGEINDEXPHP,
				'author' 			=> $currentUser,
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

}// get_my_events function
?>