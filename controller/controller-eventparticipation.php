
<?php  

// Hole die ID aus dem Request
// Wurde keine übergeben, setze sie auf 0
global $userIdGet;
global $postIdGet;
global $actionGet;
global $participantCounter;

$userIdGet = isset($_GET['user_id']) ? $_GET['user_id'] : 0;
$postIdGet = isset($_GET['post_id']) ? $_GET['post_id'] : 0;
$actionGet = isset($_GET['action']) ? $_GET['action'] : 0;


//adds an entry in the table to_event_participation
if($actionGet === 'join'){
	joinEvent($userIdGet, $postIdGet);
}

//removes an entry in the table to_event_participation
if($actionGet === 'cancel'){
	cancelEvent($userIdGet, $postIdGet);
}



?>