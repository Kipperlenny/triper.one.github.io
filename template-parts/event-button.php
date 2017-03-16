

<?php  
	if ( is_user_logged_in() ) {
		 $current_user = wp_get_current_user();
		 if ( 0 !== $current_user->ID ) {


		global $postIdGet;
		global $userIdGet;
		global $actionGet;
		global $queryResult;
		global $countQueryResult;
		global $countSql;
			 
			 
		$postId = get_the_ID(); 
		$participantCounter = countParticipants($postId); 	
		$checkIfUserIsParticipant = checkIfUserIsParticipant(get_current_user_id(), get_the_ID());
	?>




<?php  }?>
<?php  }?>


<div class="info-block">
		<a href="" class="participantsHeader"> <?php  echo 'participants: ' .$participantCounter . '.      '?></a>
	
<?php  if ($checkIfUserIsParticipant == false){
		
			get_template_part('template-parts/event', 'joinbutton');
			
		} else if ( $checkIfUserIsParticipant == true){
	
			get_template_part('template-parts/event', 'cancelbutton');
			
		}
?>
</div>