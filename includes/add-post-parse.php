<?php 
/*
parses step 1 of "add new post" process and redirects to step 2 on success
*/

if($_POST['did_add_post']){
	// echo '<pre>';
	// 	print_r($_FILES);
	// echo '</pre>';
	
	//file uploading stuff begins	
	$target_path = "uploads/";
	
	//list of image sizes to generate. 
	$sizes = array(
		'thumb' => 150,
		'medium' => 200,
		'large' => 400
		);	

	// This is the temporary file created by PHP
	$uploadedfile = $_FILES['uploadedfile']['tmp_name'];
	// Capture the original size of the uploaded image
	list($width,$height) = getimagesize($uploadedfile);
	
	//make sure the width and height exist, otherwise, this is not a valid image
	if($width > 0 AND $height > 0){

	//what kind of image is it
		$filetype = $_FILES['uploadedfile']['type'];

		switch($filetype){
			case 'image/gif':
			// Create an Image from it so we can do the resize
			$src = imagecreatefromgif($uploadedfile);
			break;

			case 'image/pjpeg':
			case 'image/jpg':
			case 'image/jpeg': 
			// Create an Image from it so we can do the resize
			$src = imagecreatefromjpeg($uploadedfile);
			break;

			case 'image/png':
			// Create an Image from it so we can do the resize
			// TODO: why is this not working? pngs can trigger white screen of death... check memory limit math
			$required_memory = Round($width * $height * $size['bits']);
			$new_limit=memory_get_usage() + $required_memory;
			ini_set("memory_limit", $new_limit);
			$src = imagecreatefrompng($uploadedfile);
			ini_restore ("memory_limit");
			break;

			
		}
	//for filename
		$randomsha = sha1(microtime());

	//do it!  resize images
		foreach($sizes as $size_name => $size_width){
			if($width >=  $size_width){
				$newwidth = $size_width;
				$newheight=($height/$width) * $newwidth;
			}else{
				$newwidth=$width;
				$newheight=$height;
			}
			$tmp = imagecreatetruecolor($newwidth,$newheight);
			imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

			$filename = $target_path.$randomsha.'_'.$size_name.'.jpg';
			//variable to track if it worked or not  - imagejpg() returns true or false upon completion of saving the jpg into our uploads folder. 
			$didcreate = imagejpeg($tmp,$filename,70);
			
			//cleanup temp canvas
			imagedestroy($tmp);

		}
		//cleanup original full sized file
		imagedestroy($src);

		//if it successfully saved the file, add the filename to the DB
		if($didcreate){
			$user_id = $logged_in_user['user_id'];			
			$query = "INSERT INTO posts
				(image, date, user_id)
				VALUES 
				('$randomsha', now(), $user_id )";

			$result = $db->query($query);
			//check to see if there was a problem
			if($db->affected_rows != 1){
				$didcreate = false;
			}
			//get the ID of the newly created post for step 2
			$post_id = $db->insert_id;
		}

		
	}else{//width and height not greater than 0
		$didcreate = false;
	}
	
	
	if($didcreate) {
		//it worked - send them to step 2
		header("Location:edit-post.php?post_id=$post_id");
	} else{
		//stay on the page and show some feedback
		$feedback = "There was an error uploading the file, please try again!<br />";
	}		
}//end step 1 parser

