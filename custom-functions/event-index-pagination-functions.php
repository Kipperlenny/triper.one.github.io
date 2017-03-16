<?php  

add_action ( 'wp_head', 'index_js_vars' );
function index_js_vars(){ ?>
  <script type="text/javascript">

     FOUNDPOSTSLIMIT = <?php echo FOUNDPOSTSLIMIT; ?>;
      
      
  </script><?php
}



function pagination_activate(){
  flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'pagination_activate');





function pagination_register_endpoints(){
  register_rest_route(
    'events/v2',
    '/index-pagination/',
    array(
      'methods' => 'POST',
      'callback' => 'get_more_results',
         'args' => array(
            'offset' => array(
                'required'          => true,
	  	        'type'              => 'integer',
	  			'validate_callback' => function($param, $request, $key){
	  				//return is_numeric($param);
  				},
	  			'sanitize_callback' => 'absint',
  			),
      )//args
      )
  );
}

		

add_action( 'rest_api_init', 'pagination_register_endpoints');

/* -----------------------------------------------------------REQUEST CALLBACK-----------------------------*/
function get_more_results(WP_REST_Request $request){			
/*------------------------------------------------------------------HTML-RESPONSE------------------------------*/	
	$currentUser = get_current_user_id();
	$count_user_posts = count_user_posts( $currentUser , 'event' );
	$count_user_posts = absint($count_user_posts);
	$moreIndexEventsAjaxResponseArray = array();
	global $found_posts;
	function getNewPostHTML($request){
			global $found_posts;
			$offset = $request->get_param("offset");
			$newEeventQueryOutput;
			$currentUser = get_current_user_id();
			ob_start(); 
		
			$queryArgs = array(
				'post_type'			=>  array('event'),
				'orderby' 			=> 'date',
				'order'   			=> 'DESC',
				'post_status' 		=> 'publish',
              	'posts_per_page' 	=> POSTSPERPAGEINDEXPHP,
				'offset'			=> $offset,
				'author' 			=> $currentUser,
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
		
	$moreIndexEventsAjaxResponseArray['html'] = getNewPostHTML($request);
	$moreIndexEventsAjaxResponseArray['offset'] = $request->get_param("offset");
	$moreIndexEventsAjaxResponseArray['count_user_posts'] = $count_user_posts;
	$moreIndexEventsAjaxResponseArray['found_posts'] = $found_posts;
	return $moreIndexEventsAjaxResponseArray;

//	}//if is_user_logged_in

}// get_more_results function
?>