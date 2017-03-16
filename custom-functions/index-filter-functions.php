<?php  

//globalFilter.js registration and localization
function enqueue_global_filter(){
	wp_enqueue_script('triperone-globalfilter', get_template_directory_uri() . '/ajax/globalFilter.js', array(), "1.0.0", true);
    
    
	$globalFilterObject = array(
			'root' => esc_url_raw( rest_url() ),
			'nonce' => wp_create_nonce( 'wp_rest' ),
	);
	wp_localize_script('triperone-globalfilter', 'globalFilterObject', $globalFilterObject );
    
}//enqueue_global_filter

add_action( 'wp_enqueue_scripts', 'enqueue_global_filter'); 
	

function global_filter_activate(){
  flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'global_filter_activate');




function register_global_filter_endpoints(){
  register_rest_route(
    'events/v2',
    '/global-filter/',
    array(
      'methods' => 'GET',
      'callback' => 'global_filter_results',
      'args' => array(
            'place_id' => array(
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				//if($param == 0){return false;}
	  				
  				},
	  			'sanitize_callback' => 'sanitize_text_field',
  			),
            'country' => array(
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				//if($param == 0){return false;}
	  				
  				},
	  			'sanitize_callback' => 'sanitize_text_field',
  			),
            'city' => array(
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
	  			'type'               => 'string',
	  			'validate_callback' => function($param, $request, $key){
	  				//if($param == 0){return false;}
	  				
  				},
	  			'sanitize_callback' => 'sanitize_text_field',
  			),
      )//args
      )//array
  );//register_rest_route
}//register_global_filter_endpoints

		

add_action( 'rest_api_init', 'register_global_filter_endpoints');


function global_filter_results(WP_REST_Request $request){
        $country = $request->get_param('country');
		$place_id = $request->get_param('place_id');
		$region = $request->get_param('region');
		$city = $request->get_param('city');
		$category = $request->get_param('category');
        $categoryID;
        global $args;
        if ($category){
            $categoryID = get_category_by_slug($category);
		    $categoryID = $categoryID->term_id;
        }
        global $filteredEventsResponseArray;
        global $sql;
        global $place_id_string;
        global $category_string;
        if ($category){ $category_string = " AND wp_term_relationships.term_taxonomy_id=%d";} else{$category_string = "";}
        if ($place_id){ $place_id_string = "AND place_id=%s";} else{$place_id_string = "%s";}
    
        function get_events_by_place($place_id, $place_id_string, $categoryID, $category_string){
            global $wpdb;
            global $queryResult;
            global $sql;
            global $args;
            $args = array($place_id, $categoryID);
            $sql = "SELECT to_event.post_id  FROM to_event, wp_posts, wp_term_relationships WHERE wp_posts.post_status='publish' ". $place_id_string ." ". $category_string ." AND to_event.post_id=wp_posts.ID AND wp_term_relationships.object_id=wp_posts.id";
            $sql = $wpdb->prepare($sql,$args);
            $queryResult = $wpdb->get_results($sql);
            return $queryResult;
        }    
    
    
    
        
    
    
        $queryResult = get_events_by_place($place_id, $place_id_string, $categoryID, $category_string);
        $post_ids = array();
        foreach ($queryResult as $object){
            $post_ids[] = absint($object->post_id);
        }
       
        function getNewPostHTML($filteredEventsResponseArray, $post_ids){
			$newEeventQueryOutput;
            global $filteredEventsResponseArray;
			ob_start(); 
            
            
            
            ?> <div id="indexHeader"><h1><?php _e('Filter results:', 'triperone');  ?></h1></div><?php
		     $currentUser  = get_current_user_id();  
			$queryArgs = array(
                'post__in'           => $post_ids,
                'post_type'			=>  array('event'),
				'orderby' 			=> 'date',
				'order'   			=> 'DESC',
				'post_status' 		=> 'publish',
              	'posts_per_page' 	=>  POSTSPERPAGEINDEXPHP,
              	'author' 	        =>  -$currentUser,
			);
			$getFilteredEventsQuery = new WP_Query($queryArgs);
			$filteredEventsResponseArray['$getFilteredEventsQuery'] = $getFilteredEventsQuery;
			if ( $getFilteredEventsQuery->have_posts() ) {
					while ( $getFilteredEventsQuery->have_posts() ) {
							$getFilteredEventsQuery->the_post();
			
                    include(locate_template('template-parts/event-article.php'));


                    } //while have posts
                    $newEeventQueryOutput = ob_get_contents();
                    ob_end_clean();
                    return $newEeventQueryOutput;
                } // if have posts
		wp_reset_postdata();
        } //new-event-HTML-response-function

        
    
        $filteredEventsResponseArray['$args'] = $args;
        $filteredEventsResponseArray['$categoryID'] = $categoryID;
        $filteredEventsResponseArray['$categoryString'] = $category_string;
        $filteredEventsResponseArray['$category'] = $category;
        $filteredEventsResponseArray['found_posts'] = count($post_ids);
        $filteredEventsResponseArray['sql'] = $sql;
        $filteredEventsResponseArray['postids'] = $post_ids;
        $filteredEventsResponseArray['city'] = $city;
		$filteredEventsResponseArray['country'] = $country;
		$filteredEventsResponseArray['region'] = $region;
		$filteredEventsResponseArray['place_id'] = $place_id;
        if(empty($post_ids)){
            //$filteredEventsResponseArray = array();
            $filteredEventsResponseArray['html'] = '<h1 id="nothingFound">Sorry, no events matched your criteria. </h1>';
        } else{
            $filteredEventsResponseArray['html'] =  getNewPostHTML($filteredEventsResponseArray, $post_ids);
        }
        return $filteredEventsResponseArray;
}//global_filter_results