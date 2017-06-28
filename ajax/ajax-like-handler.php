<?php
/**
 * DISPLAY OUTPUT
 * This file gets triggered by the ajax request
 * It is identical whether using jquery or pure ajax
 * note that it has no doctype and is not intended as a standalone file.
 * This file never leaves the server. its display output (echo) is passed back to the browser via ajax 
 */
require('../includes/db-config.php');

//data coming from jquery .ajax() call
$post_id = $_REQUEST['post_id'];
$user_id = $_REQUEST['user_id'];

//add the rating to the db
$query = "INSERT INTO likes 
		(post_id, user_id)
		VALUES 
		($post_id, $user_id)";
//run it
$result = $db->query($query);

//check
if($db->affected_rows == 1){
	//calculate the new  number of likes
	
	$query = "SELECT COUNT(*) AS likes 
			FROM likes
			WHERE post_id = $post_id";
	$result_likes = $db->query($query);
	$row_likes = $result_likes->fetch_assoc();
	echo $row_likes['likes'];
	
}else{
	echo 'Sorry, the rating did not work';
}