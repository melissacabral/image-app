<?php 
/*
This file is loaded by single.php and inserts one comment. 
Only logged in users should be able to comment on posts. 
 */

//parse the comment if one was submitted
if( $_POST['did_comment'] ){
	//extract and sanitize  (clean_string() is in our functions file)
	$comment 	= clean_string( $_POST['comment'] );
	$post_id	= clean_int($_POST['post_id']);
	
	//on first version, just set this to $user_id = 1 (we'll add authentication in a later demo)
	$user_id = (int) $logged_in_user['user_id'];

	//validate
	$valid = true;

	//invalid user. note: is_int uses strict datatyping so cast the user_id as (int) above
	if( !is_int($user_id) ){
		$valid = false;
		$errors['name'] = 'You must be logged in to comment.';
	}

	//comment is blank
	if( $comment == '' ){
		$valid = false;
		$errors['comment'] = 'Comment field cannot be left blank.';
	}
	
	//if valid, add to DB
	if( $valid ){
		//TODO: manually storing "is_approved" value as 1 (true). Maybe change in the future when comment moderation features are more fleshed out
		$query = "INSERT INTO comments
				(user_id, date, body, post_id, is_approved)
				VALUES
				($user_id, now(), '$comment', $post_id, 1 )";
		//run it
		$result = $db->query($query);
		//check it
		if( $db->affected_rows == 1 ){
			//success
			$feedback = 'Comment posted successfully';
		}else{
			//error - DB
			$feedback = 'Sorry, Something went wrong, your comment could not be posted.';
		}
	} //end if valid
	else{
		//error - not valid submission
		$feedback = "There are errors in the comment form, Please fix the following:";
	}
	//give user feedback
} //end of comment parser