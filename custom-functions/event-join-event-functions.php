<?php
//   inserts an entry into to_event_participation
function joinEvent($userId, $postId){
	if ( is_user_logged_in() ) {
		global $wpdb;
		global $queryResult;
		$args = array($userId, $postId);
		$sql = "INSERT IGNORE INTO to_event_participation (user_id, post_id) VALUES (%s,%s)";
		$sql = $wpdb->prepare($sql,$args);
		$queryResult = $wpdb->query($sql);
		return $queryResult;
	}
}

// deletes the entry from to_event_participation
function cancelEvent($userId, $postId){
	if ( is_user_logged_in() ) {
		global $wpdb;
		global $queryResult;
		$args = array($userId, $postId);
		$sql = "DELETE FROM to_event_participation WHERE user_id=%d && post_id=%d";
		$sql = $wpdb->prepare($sql,$args);
		$queryResult = $wpdb->query($sql);
		return $queryResult;
	}
}
// counts participants of the event with the $postId 
function countParticipants($postId){
		global $wpdb;
		global $countQueryResult;
		global $countSql;
		$sql = "SELECT COUNT(post_id) AS total FROM to_event_participation WHERE post_id=%d";
		$sql = $wpdb->prepare($sql,$postId);
		$countSql = $sql;
		$countQueryResult = $wpdb->get_var($sql);
		return $countQueryResult;
}

// checks if the user with the $userId is participand of the event with the $postId
function checkIfUserIsParticipant($userId, $postId){
		global $wpdb;
		global $checkParticipantResult;
		global $countSql;
		$args = array($userId, $postId);
		$sql = "SELECT EXISTS(SELECT * FROM to_event_participation WHERE user_id=%d && post_id=%d)";
		$sql = $wpdb->prepare($sql,$args);
		$checkParticipantResult = $wpdb->get_var($sql);
		return $checkParticipantResult;
}