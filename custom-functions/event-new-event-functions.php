<?php 
/**
* 	Ajax / WP REST post new event Request
*/

//postEvent.js registration and localization
function enqueue_post_new_event(){
	wp_enqueue_script('triperone-posteventjs', get_template_directory_uri() . '/ajax/postEvent.js', array('jquery'), "1.0.0",true);
	
	$ajaxObject = array(
			'root' => esc_url_raw( rest_url() ),
			'nonce' => wp_create_nonce( 'wp_rest' ),
			'success' => __( 'Your event has been added!', 'triperone' ),
			'successImageUpload' => __( 'Your Image has been added!', 'triperone' ),
			'failure' => __( 'Your submission could not be processed.', 'triperone' ),
			'current_user_id' => get_current_user_id()
	);
	wp_localize_script('triperone-posteventjs', 'ajaxObject', $ajaxObject );
}
add_action( 'wp_enqueue_scripts', 'enqueue_post_new_event'); 
	

function postnewevent_activate(){
  flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'postnewevent_activate');


global $newEventRequestArray;
global $newEeventQueryOutput;

/*---------------------------------------------------- ENDPOINT DEFINITION --------------------------------	*/
function postnewevent_register_endpoints(){
  register_rest_route(
    'events/v2',
    '/newpost/',
    array(
      'methods' => 'POST',
      'callback' => 'post_new_event',
	  'args' => array(
	  		'title' => array(
	  			'required'			=> true,
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				//if($param == 0){ return false}
  				},
	  			'sanitize_callback' => 'sanitize_text_field',
	  			//'sanitize_callback' => 'absint',
  			),
  			'content' => array(
	  			'required'			=> true,
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				//if($param == 0){return false;}
	  				
  				},
	  			'sanitize_callback' => 'wp_strip_all_tags',
  			),
	  		'country' => array(
	  			'required'			=> true,
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				//if($param == 0){return false;}
	  				
  				},
	  			'sanitize_callback' => 'sanitize_text_field',
  			),
            'place_id' => array(
	  			'required'			=> true,
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				//if($param == 0){return false;}
	  				
  				},
	  			'sanitize_callback' => 'sanitize_text_field',
  			),
            'region' => array(
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				//if($param == 0){return false;}
	  				
  				},
	  			'sanitize_callback' => 'sanitize_text_field',
  			),
	  		'category' => array(
	  			'required'			=> true,
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				
  				},
	  			'sanitize_callback' => 'sanitize_text_field',
  			),
	  		'city' => array(
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				
  				},
	  			'sanitize_callback' => 'sanitize_text_field',
  			),
	  		'dateStart' => array(
	  			'required'			=> true,
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				//if($param == 0){return false;}

  				},
	  			'sanitize_callback' => 'sanitize_text_field',
  			),
	  		'timeStart' => array(
	  			'required'			=> true,
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				//if($param == 0){return false;}
	  				
  				},
	  			'sanitize_callback' => 'sanitize_text_field',
  			),
	  		'maxParticipants' => array(
	  			'type'               => 'integer',
	  			'validate_callback' => function($param, $request, $key){
	  				//return is_numeric($param);
  				},
	  			'sanitize_callback' => 'absint',
  			),
			'featuredImageId' => array(
	  			'type'               => 'integer',
	  			'validate_callback' => function($param, $request, $key){
	  				// some validation if neccassary
  				},
	  			'sanitize_callback' => 'absint',
  			),
  		)
      )
  );
}
		//error message
		/*		if ($getVote == $vote){
					return new WP_Error('vote_error', __('Your vote has already been added'), array('$getVote'.$getVote, '$vote'.$vote));	
		} */
		

add_action( 'rest_api_init', 'postnewevent_register_endpoints');

/* -----------------------------------------------------------REQUEST CALLBACK-----------------------------*/
function post_new_event(WP_REST_Request $request){
if(is_user_logged_in()){
		$content = $request->get_param('content');
		$title = $request->get_param('title');
		$category = $request->get_param('category');
		$city = $request->get_param('city');
		$country = $request->get_param('country');
		$place_id = $request->get_param('place_id');
		$region = $request->get_param('region');
		$timeStart = $request->get_param('timeStart');
		$dateStart = $request->get_param('dateStart');
		$dateStartString = $dateStart.' '.$timeStart;
		$dateStart = strtotime($dateStart.$timeStart);
		$maxParticipants = $request->get_param('maxParticipants');
		//get category ID by slug:
		$categoryID = get_category_by_slug($category);
		$categoryID = $categoryID->term_id;
		$author =get_current_user_id();
		$featured_image_id = $request->get_param('featuredImageId');
		
		//arguments for post insert
		$newEventArgs = array(
			'post_title'    => wp_strip_all_tags( $title ),
			'post_content'  =>  wp_strip_all_tags($content),
			'post_status'   => 'publish',
			'post_author'   => $author,
			//must be passed as array, even there is only one category
			'post_category' => array($categoryID),
			'post_type' 	=> 'event',
		);
		
		// Insert the post into the database
		$newPostId = wp_insert_post( $newEventArgs );
		
		$post_meta_id = set_post_thumbnail( $newPostId, $featured_image_id );
		
	//insert form data into to_event 
	function set_event_data($region, $place_id, $country, $city, $newPostId, $author, $maxParticipants, $dateStart,$dateStartString){
		global $wpdb;
		global $queryResult;
		$args = array($region, $place_id, $country, $city, $newPostId, $author, $maxParticipants, $dateStart, $dateStartString);
		$sql = "INSERT INTO to_event (region, place_id, country, city, post_id, author_id, max_participants, date_start, date_start_string) VALUES (%s,%s,%s,%s,%d,%d,%d,%d,%s)";
		$sql = $wpdb->prepare($sql,$args);
		$queryResult = $wpdb->query($sql);
		return 'queryResult: '.$queryResult.' sql: '.$sql;
	}
	$queryResult = set_event_data($region, $place_id, $country, $city, $newPostId, $author, $maxParticipants, $dateStart, $dateStartString);
    
	//get data from to_event 
	function get_event_start_date($postId){
		global $wpdb;
		global $queryResult;
		$args = array($postId);
		$sql = "SELECT date_start FROM to_event WHERE post_id=%d";
		$sql = $wpdb->prepare($sql,$args);
		$queryResult = $wpdb->get_var($sql);
		return $queryResult;
	}
	
		$newEventRequestArray['content'] = $content;
		$newEventRequestArray['title'] = $title;
		$newEventRequestArray['category'] = $category;
		$newEventRequestArray['city'] = $city;
		$newEventRequestArray['country'] = $country;
		$newEventRequestArray['region'] = $region;
		$newEventRequestArray['place_id'] = $place_id;
		$newEventRequestArray['timeStart'] = $timeStart;
		$newEventRequestArray['dateStart'] = $dateStart;
		$newEventRequestArray['maxParticipants'] = $maxParticipants;
		$newEventRequestArray['newPostId'] = $newPostId;
		$newEventRequestArray['categoryID'] = $categoryID;
		$newEventRequestArray['$queryResult'] = $queryResult;
		$newEventRequestArray['eventStartDate'] = get_event_start_date($newPostId);
		$newEventRequestArray['date_start_string'] = $dateStartString;
		$newEventRequestArray['permalink'] = get_permalink($newPostId);
		$newEventRequestArray['featured_image_id'] = $featured_image_id;
		$newEventRequestArray['post_meta_id'] = $post_meta_id;
	
	
		//get_template_part('template-parts/ajax-response', 'new-event');
	
/*------------------------------------------------------------------HTML-RESPONSE------------------------------*/	
		function getNewPostHTML($newEventRequestArray, $newPostId){
			$newEeventQueryOutput;

			ob_start(); 
		
			$queryArgs = array(
			  'p'         => $newPostId, 
			  'post_type' => 'any'
			);
			$newEventQuery = new WP_Query($queryArgs);
			
			if ( $newEventQuery->have_posts() ) {
					while ( $newEventQuery->have_posts() ) {
							$newEventQuery->the_post();
			
			include(locate_template('template-parts/event-article.php'));


			$newEeventQueryOutput = ob_get_contents();
			ob_end_clean();
			return $newEeventQueryOutput;
			} //while have posts
		} // if have posts
		wp_reset_postdata();
} //new-event-HTML-response-function

		
		$newEventRequestArray['html'] = getNewPostHTML($newEventRequestArray, $newPostId);
	
		return $newEventRequestArray;
		

	}//if is_user_logged_in

}// post_new_event function
