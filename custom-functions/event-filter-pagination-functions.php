<?php  


function activate_filter_pagination(){
  flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'activate_filter_pagination');



function register_filter_pagination_endpoint(){
  register_rest_route(
    'events/v2',
    '/filter-pagination/',
    array(
      'methods' => 'GET',
      'callback' => 'filter_global_events',
      'args' => array(
            'place_id' => array(
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				//if($param == 0){return false;}
	  				
  				},
	  			'sanitize_callback' => 'sanitize_text_field',
  			),
            'offset' => array(
	  	        'type'              => 'integer',
	  			'validate_callback' => function($param, $request, $key){
	  				//return is_numeric($param);
  				},
	  			'sanitize_callback' => 'absint',
  			),
            'from' => array(
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				//if($param == 0){return false;}
	  				
  				},
	  			'sanitize_callback' => 'sanitize_text_field',
  			),
            'to' => array(
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				//if($param == 0){return false;}
	  				
  				},
	  			'sanitize_callback' => 'sanitize_text_field',
  			),
            'category' => array(
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				//if($param == 0){return false;}
	  				
  				},
	  			'sanitize_callback' => 'sanitize_text_field',
  			),
            'globalFilterEventsCount' => array(
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				//if($param == 0){return false;}
	  				
  				},
	  			'sanitize_callback' => 'sanitize_text_field',
  			),
      )//args
    )//array
  );
}
add_action( 'rest_api_init', 'register_filter_pagination_endpoint');

/* -----------------------------------------------------------REQUEST CALLBACK-----------------------------*/
function filter_global_events(WP_REST_Request $request){			
/*------------------------------------------------------------------HTML-RESPONSE------------------------------*/	
    $place_id = $request->get_param("place_id");
    global $globalFilterPostIdsCount;
    
    
    function get_events_by_place($place_id){
            global $wpdb;
            global $queryResult;
            $args = array($place_id);
            $sql = "SELECT post_id  FROM to_event, wp_posts WHERE wp_posts.post_status='publish' AND place_id=%s AND post_id=wp_posts.ID";
            $sql = $wpdb->prepare($sql,$args);
            $queryResult = $wpdb->get_results($sql);
            return $queryResult;
        }
    $queryResult = get_events_by_place($place_id);
    $post_ids = array();
    foreach ($queryResult as $object){
        $post_ids[] = absint($object->post_id);
    }
        
    $globalFilterEventsCount = count($post_ids);
    
    
    //is being reduced each call by the offset value, so if there are no more events left, the "load more" button dissapears
	global $found_posts;
    

	
	$moreGlobalEventsRequestArray = array();
	function getNewPostHTML($request, $post_ids){
			global $found_posts;
			$offset = $request->get_param("offset");
			$newEeventQueryOutput;
			$currentUser = get_current_user_id();
			ob_start(); 
		
			$queryArgs = array(
				'post_type'			=>  array('event'),
                'post__in'          => $post_ids,
				'orderby' 			=> 'date',
				'order'   			=> 'DESC',
				'post_status' 		=> 'publish',
              	'posts_per_page' 	=> POSTSPERPAGEINDEXPHP,
				'offset'			=> $offset,
				//'author' 			=> -$currentUser,
			);
			$globalActivityQuery = new WP_Query($queryArgs);
			?>
			
			<?php 
			if ( $globalActivityQuery->have_posts() ) {
					while ( $globalActivityQuery->have_posts() ) {
							$globalActivityQuery->the_post();

						include(locate_template('template-parts/event-article.php'));
			
					$found_posts  = $globalActivityQuery->found_posts - $offset;	
			
					} //while have posts

			$newEeventQueryOutput = ob_get_contents();
			ob_end_clean();
			return array($newEeventQueryOutput);

			} // if have posts

			wp_reset_postdata();
		
	} //new-event-HTML-response-function
		
	$moreGlobalEventsRequestArray['$post_ids'] = $post_ids;
	$moreGlobalEventsRequestArray['$place_id'] = $place_id;
	$moreGlobalEventsRequestArray['html'] = getNewPostHTML($request, $post_ids);
	$moreGlobalEventsRequestArray['offset'] = $request->get_param("offset");
	$moreGlobalEventsRequestArray['globalFilterEventsCount'] = $globalFilterEventsCount;
	$moreGlobalEventsRequestArray['found_posts'] = $found_posts;

	return $moreGlobalEventsRequestArray;

//	}//if is_user_logged_in

}// get_more_results function
?>