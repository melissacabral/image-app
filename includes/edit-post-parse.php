<?php 
if($_POST['did_edit']){

	//clean all fields
	//the post that was created in step 1 (from the query string)
	$post_id 		= clean_int($_GET['post_id']);
	$title 			= clean_string($_POST['title']);
	$body 			= clean_string($_POST['body']);
	$category_id 	= clean_int($_POST['category_id']);
	$allow_comments = clean_boolean($_POST['allow_comments']);
	
	//validate
	$valid = true;
		//Post_id from step 1 is invalid
		if(! is_numeric($post_id)){
			$valid = false;
			$errors['post_id'] = 'The Post ID is invalid, go back to step 1';
		}
		//title is blank or longer than 256 chars
		if( $title == '' OR strlen($title) > 256 ){
			$valid = false;
			$errors['title'] = 'Please add a title that is between 1 and 256 characters long.';
		}
		//body is blank
		if( $body == '' ){
			$valid = false;
			$errors['body'] = 'The body of the post cannot be blank.';
		}
		//category id is not blank
		if($category_id == ''){
			$valid = false;
			$errors['category_id'] = 'The category cannot be blank.';
		}
		
		
	//if it's all valid, Update the post with the new details 
	if($valid){
		$query = "UPDATE posts
				SET 
				title  = '$title',
				body = '$body',
				category_id = $category_id,
				is_published = 1,
				allow_comments = $allow_comments
				WHERE post_id = $post_id
				LIMIT 1";
		$result = $db->query($query);
		if(!$result){
			echo $db->error;
		}
		if( $db->affected_rows == 1 ){
			$feedback = 'Success! Your post has been saved.';
		}else{
			$feedback = 'No changes made to the post.';
		}
	}//end if valid
	else{
		$feedback = 'There are problems with the form. Fix them:';
	}
}//end step 2 parser
