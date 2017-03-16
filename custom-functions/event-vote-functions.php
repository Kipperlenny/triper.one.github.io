 <?php  

//get the number of all reviews on an event
function countReviews($postId){
		global $wpdb;
		$sql = "SELECT COUNT(*) FROM to_event_ratings WHERE post_id=%d";
		$args = array($postId);
		$sql = $wpdb->prepare($sql,$args);
		$reviewsCount = $wpdb->get_var($sql);
		return $reviewsCount;
}


// checks if the a vote of a user on a post allready exists
function checkIfVoteExists($userId, $postId){
		global $wpdb;
		global $sequell;
		$checkIfVoteExistsResult;
		$args = array($userId, $postId);
		$sql = "SELECT EXISTS(SELECT * FROM to_event_ratings WHERE user_id=%d && post_id=%d)";
		$sql = $wpdb->prepare($sql,$args);
		$sequell = $sql;
		$checkIfVoteExistsResult = $wpdb->get_var($sql);
		return $checkIfVoteExistsResult;
}

//if a vote/review on a event already exists, get the value of the vote/review
function getVote($userId,$postId){
		global $wpdb;
		$sql = "SELECT rating FROM to_event_ratings WHERE user_id=%d && post_id=%d";
		$args = array($userId, $postId);
		$sql = $wpdb->prepare($sql,$args);
		$getVoteResult = $wpdb->get_results($sql);
		return $getVoteResult;
}


function enqueue_rate_event(){
	wp_enqueue_script('triperone-rate-event-js', get_template_directory_uri() . '/ajax/rateEvent.js', array('jquery'), "1.0.0",true);
	$voteObject = array(
			'root' => esc_url_raw( rest_url() ),
			'nonce' => wp_create_nonce( 'wp_rest' ),
			'success' => __( 'Your vote has been added!', 'triperone' ),
			'failure' => __( 'Your vote could not be processed.', 'triperone' ),
			'current_user_id' => get_current_user_id()
	);
	wp_localize_script('triperone-rate-event-js', 'voteObject', $voteObject );
}
add_action( 'wp_enqueue_scripts', 'enqueue_rate_event'); 	



function eventvote_activate(){
  flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'eventvote_activate');

function eventvote_register_endpoints(){
  register_rest_route(
    'event-voting/v2',
    '/votes/',
    array(
      'methods' => 'POST',
      'callback' => 'event_add_vote',
	  'args' => array(
  			'post_id' => array(
  				'required' => true,
	  			'validate_callback' => function($param, $request, $key){
	  				//return is_numeric( $param) and !is_null(get_post($param));
  				},
	  			'sanitize_callback' => 'absint',
  			),
			 'user_id' => array(
  				'required' => true,
	  			'validate_callback' => function($param, $request, $key){
	  				//return is_numeric( $param) and !is_null(get_post($param));
  				},
	  			'sanitize_callback' => 'absint',
  			),
			 'vote' => array(
  				'required' => true,
				'validate_callback' => function($param, $request, $key){
					//return is_numeric( $param) and !is_null(get_post($param));
  				},
	  			'sanitize_callback' => 'absint',
	  		)
  		)
      )
  );
}

add_action( 'rest_api_init', 'eventvote_register_endpoints');


function event_add_vote(WP_REST_Request $request){
	if ( is_user_logged_in() ) {
		$postId = $request->get_param('post_id');
		$vote = $request->get_param('vote');
		$userId = $request->get_param('user_id');

		$checkIfVoteExists = checkIfVoteExists($userId, $postId);



		if($checkIfVoteExists == 1){
				$getVote = getVote($userId,$postId);
				$getVote = $getVote[0];
				$getVote = $getVote->rating;
				if ($getVote == $vote){
					return new WP_Error('vote_error', __('Your vote has already been added'), array('$getVote'.$getVote, '$vote'.$vote));	
				} 
			else {

				global $wpdb;
				global $queryResult;
				$args = array($userId, $postId, $vote, $vote);
				$sql = "INSERT IGNORE INTO to_event_ratings (user_id, post_id, rating) VALUES (%d,%d,%s) ON DUPLICATE KEY UPDATE rating=%s";
				$sql = $wpdb->prepare($sql,$args);
				$queryResult = $wpdb->query($sql);	
			}

		} else {
			global $wpdb;
			global $queryResult;
			$args = array($userId, $postId, $vote, $vote);
			$sql = "INSERT IGNORE INTO to_event_ratings (user_id, post_id, rating) VALUES (%s,%s,%d) ON DUPLICATE KEY UPDATE rating=%d";
			$sql = $wpdb->prepare($sql,$args);
			$queryResult = $wpdb->query($sql);	
		}
		
		global $wpdb;
		global $queryResult;
		$args = array($userId, $postId);
		$sql = "SELECT rating FROM to_event_ratings WHERE user_id=%d && post_id=%d";
		$sql = $wpdb->prepare($sql,$args);
		$queryResult = $wpdb->get_var($sql);	
		return ', review value: '. $queryResult;
	}
}
