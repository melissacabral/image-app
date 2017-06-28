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

//check to see if this user has already liked this post
$query = "SELECT * FROM likes 
WHERE user_id = $user_id
AND post_id = $post_id
LIMIT 1";
$result = $db->query($query);
if($result->num_rows != 1){
	$like = true;
}else{
	$like = false; //un-like
}
//is this a like or an un-like?
if($like){
	//LIKE. add the like to the db
	$query = "INSERT INTO likes 
	(post_id, user_id)
	VALUES 
	($post_id, $user_id)";
	//run it
	$result = $db->query($query);
}else{
	//UN-LIKE. delete their like
	$query = "DELETE FROM likes 
	WHERE user_id = $user_id
	AND post_id = $post_id
	LIMIT 1";
	//run it
	$result = $db->query($query);
}
//check if either query worked
if($db->affected_rows == 1){
	//calculate the new  number of likes
	
	$query = "SELECT COUNT(*) AS likes 
	FROM likes
	WHERE post_id = $post_id";
	$result_likes = $db->query($query);
	$row_likes = $result_likes->fetch_assoc();
	echo $row_likes['likes'] . ' likes';
	
}else{
	echo 'Sorry, the rating did not work';
}