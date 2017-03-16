<?php 

function getEventData($postId){
		global $wpdb;
		$sql = "SELECT author_id, country, city, max_participants, date_start FROM to_event WHERE post_id=%d";
		$args = array($postId);
		$sql = $wpdb->prepare($sql,$args);
		$getVoteResult = $wpdb->get_results($sql);
		return $getVoteResult[0];
}


function iterateSlugs($postId){
		$tempUrl = get_template_directory_uri();
		$getTheCategory = get_the_category($postId);
		$categories = '';
		$output = '<div class="catImages">';
		$length = count($getTheCategory);
		for($x = 0; $x < $length; $x++){
			
			$categories .= $getTheCategory[$x]->slug .', ';
		}
		foreach($getTheCategory as $value){
			$output .= '<a href="'.get_bloginfo('url').'/category/'.$value->slug.'"><img title='.$value->name.' src="'.$tempUrl.'/images/'.$value->slug.'.png"></a>';
		}		
	
		$output .= '</div>';
	
		return $output;
}

?>