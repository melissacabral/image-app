<?php
/*
Convert any Datetime into a human readable format
 */
function convert_date( $timestamp ){
	$date = new DateTime( $timestamp );
	return $date->format('l, F j, Y');
}

/*
Convert any Datetime into a human readable format
 */
function rss_date( $timestamp ){
	$date = new DateTime( $timestamp );
	return $date->format('r');
}

/*
Count the number of comments on any post
$post_id - int. any valid post ID. 
$one - string. text to show if there's one comment
$many - string. text to show if there's many or zero comments
 */
function count_comments( $post_id, $one = ' comment' , $many = ' comments' ){
	//the database connection was defined out in the global scope. go get it. 
	global $db;
	//query
	$query = "SELECT COUNT(*) AS total
	FROM comments
	WHERE post_id = $post_id";
	//run it
	$result = $db->query($query);
	//check it
	if(! $result){
		echo $db->error;
	} 
	if( $result->num_rows >= 1){
		//loop it
		while( $row = $result->fetch_assoc() ){
			//display the count with correct grammar
			if( $row['total'] == 1 ){
				echo $row['total'] . $one;
			}else{
				echo $row['total'] . $many;
			}
			
		}
		$result->free();
	}
	
}
/*
show all the tags for any post
$post_id = int. any valid post
*/
function show_post_tags($post_id){
	global $db;
	$query = "SELECT tags.* 
	FROM tags, post_tags 
	WHERE post_tags.post_id = $post_id
	AND post_tags.tag_id = tags.tag_id";
	$result = $db->query($query);
	if(! $result){
		echo $db->error;
	}
	if($result->num_rows >= 1){
		while($row = $result->fetch_assoc()){
			$tags[] =  '<a href="tag.php?tag_id='. $row['tag_id'] .'">' . $row['name'] . '</a>';
		}
		echo '<span class="tags">tagged: ' . implode(', ', $tags) . '</span>';
		$result->free();
	}
}

/*
Helper function to clean string data before sending it to the DB
 */
function clean_string( $dirty ){
	global $db;
	return mysqli_real_escape_string($db, filter_var( $dirty, FILTER_SANITIZE_STRING ));
}

function clean_email( $dirty ){
	global $db;
	return mysqli_real_escape_string($db, filter_var( $dirty, FILTER_SANITIZE_EMAIL ));
}

function clean_int( $dirty ){
	global $db;
	return mysqli_real_escape_string($db, filter_var( $dirty, FILTER_SANITIZE_NUMBER_INT ));
}

function clean_boolean( $dirty ){
	global $db;
	$clean = mysqli_real_escape_string($db, filter_var( $dirty, FILTER_SANITIZE_NUMBER_INT ));
	//if the value is anything other than 1, change it to ZERO.
	if($clean != 1){
		$clean = 0;
	}
	return $clean;
}


/*
Display the HTML for success or error messages, with a list of errors if needed
 */
function show_feedback( $message = '', $list = array() ){
	if( isset( $message ) ){
		$class='success';
		if(!empty( $list )){
			$class='error';
		}
		?>
		<div class="feedback <?php echo $class; ?>">
			<b><?php echo $message; ?></b>

			<?php //if the list is not empty, show it
			if( !empty( $list ) ){ ?>
			<ul>
				<?php foreach( $list as $item ){ ?>
				<li>
					<?php echo $item; ?>
				</li>
				<?php } //end foreach ?>
			</ul>
			<?php } //end if not empty ?>
		</div>
		<?php
	} //end if 
}

/*
Display a dropdown menu of all categories
$current = int.  the ID of the category that you want to mark "selected" (optional)
 */
function category_dropdown( $current = 0 ){
	global $db;
	$query = "SELECT * FROM categories";
	$result = $db->query($query);
	if(! $result){
		echo $db->error;
	} 
	if( $result->num_rows >= 1 ){
		?>
		<select name="category_id" id="the_cat">
			<?php while( $row = $result->fetch_assoc() ){ ?>
			<option value="<?php echo $row['category_id']; ?>" <?php 
			if( $current == $row['category_id'] ){ 
				echo 'selected'; 
			} ?>>
			<?php echo $row['name']; ?>
		</option>
		<?php 
		} //end while
		$result->free();
		?>
	</select>
	<?php
}else{
	echo 'No Categories to Show';
}
}

/*
Display Any user's picture at any size (thumb, med or large)
*/
function show_profile_pic( $user_id, $size = 'thumb' ){
	global $db;
	$query = "SELECT profile_pic FROM users
	WHERE user_id = $user_id
	LIMIT 1";
	$result = $db->query($query);
	if( $result->num_rows == 1 ){
		$row = $result->fetch_assoc();
		
		//show the image
		echo '<img src="uploads/' . $row['profile_pic'] . '_' . $size . '.jpg" alt="Profile Picture" class="profile_pic">';
		
	}
}
/*
checks if user is logged in or not
Added day 14
returns: array containing all user info if logged in
false if not logged in
*/
function check_login( $redirect = '' ){
	global $db;
	if( isset($_SESSION['user_id']) AND isset($_SESSION['secret_key']) ){
		//check for a match in the DB
		$sess_user_id = $_SESSION['user_id'];
		$sess_secret_key = $_SESSION['secret_key'];

		$query = "SELECT * FROM users
		WHERE user_id = $sess_user_id
		AND secret_key = '$sess_secret_key'
		LIMIT 1";
		$result = $db->query($query);

		if( !$result ){
			//query failed. user is not logged in.
			if($redirect != ''){
				header("Location:$redirect");
			}
			return false;

		}

		if($result->num_rows == 1){
			//success - we have a logged in user! return all the info aout this user in an array
			return $result->fetch_assoc();
		}else{
			//credentials don't match. user is not logged in
			if($redirect != ''){
				header("Location:$redirect");
			}
			return false;
		}

	}else{
		//no session data. the user is not logged in
		if($redirect != ''){
			header("Location:$redirect");
		}
		return false;
	}	
}
/**
 * Get the relative URL of any post image in the db
 * Added after image uploader demo
 * @param  integer $post_id any valid post
 * @param  string  $size    any valid image size. default 'medium'
 * @return string           the relative url to the image
 */
function image_url($post_id = 0, $size = 'medium'){
	global $db;
		//get  the image
	$query = "SELECT image FROM posts WHERE post_id = $post_id LIMIT 1";
	$result = $db->query($query);

	if(! $result){
		die($db->error);
	}

	$row = $result->fetch_assoc();

	if($row['image']){
		echo 'uploads/' . $row['image'] . '_' . $size . '.jpg';
	}
}

/*
Count the number of likes on any post
See advanced example below, as well
 */
function count_likes($post_id){
	global $db;

	$query = "SELECT COUNT(*) AS likes 
	FROM likes
	WHERE post_id = $post_id";

	$result = $db->query($query);

	if(!$result) echo $db->error; 
	
	$row = $result->fetch_assoc();
	$total = $row['likes'];
	return  $total == 1 ? "$total like" : "$total likes" ;
}
/**
 * First version of the Likes interface 
 * @param  integer $post_id any valid post id
 * @return html          the markup for the likes button and counter
 */
function basic_likes($post_id){
	//display the interface
	?>		
	<span class="like-counter">
		<div>
			<span class="heart button" data-postid="<?php echo $post_id; ?>">❤</span>
			<?php echo count_likes($post_id); ?>
		</div> 
	</span>
	
	<?php
}
/* this advanced version can tell if a user likes the post, AND tell the total count in one query */
function likes($post_id, $user_id){	
	global $db;

	//did this user like this post?
	$query = "SELECT COUNT(*) AS you_like
	FROM   likes 
	WHERE user_id = $user_id 
	AND post_id = $post_id
	";

	$result = $db->query($query);

	if(!$result) echo $db->error; 
	$row = $result->fetch_assoc();
	$class = $row['you_like'] ? 'you_like' : 'not_liked';
	

	//display the interface
	?>
	<span class="like-counter">
		<div class="<?php echo $class; ?>">
			<span class="heart button" data-postid="<?php echo $post_id; ?>">❤</span>
			<?php echo count_likes($post_id); ?>
		</div> 
	</span>

	<?php
}

//no close php