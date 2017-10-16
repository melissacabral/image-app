<?php
/*
The template for displaying single posts
Anyone can see this page

TEACHER NOTES:
* Build this file in 3 phases
	* Phase 1:  Display the info about the current post
	* Phase 2: build and parse the comment form
	* phase 3: display a list of the comments on this post
	* phase 4: after edit-post demo, add the edit button if this is your post	
 */ 
require('includes/header.php'); 
include('includes/comment-parse.php');

//which post are we trying to show
$post_id = $_GET['post_id'];
?>

<main class="content">
	<?php 
	//get all the info about THIS post. make sure it is a published post
	$query = "SELECT posts.*, users.username, users.user_id, users.profile_pic, categories.*
		FROM posts, categories, users
		WHERE posts.is_published = 1
		AND posts.post_id = $post_id
		AND categories.category_id = posts.category_id
		AND users.user_id = posts.user_id
		ORDER BY posts.date DESC
		LIMIT 10";
	$result = $db->query($query);
	//check it
	if( !$result ){
		echo $db->error;
	}
	if( $result->num_rows >= 1 ){
		while( $row = $result->fetch_assoc() ){
			?>

			<article class="post">
				<img src="<?php image_url($post_id, 'large') ?>" class="post-image">


				<?php 
			//if this is a post made by the logged in user, show the edit button
				if( $row['user_id'] == $logged_in_user['user_id'] ){
					?>
					<br>
					<a href="edit-post.php?post_id=<?php echo $post_id ?>">Edit</a>
					<?php } ?>

					<h2 class="user-card">
						<a href="profile.php?user_id=<?php echo $row['user_id']; ?>">
							<?php show_profile_pic($row['user_id']); ?>				
							<?php echo $row['username']; ?>	
						</a>
					</h2>
					<h3><?php echo $row['title']; ?></h3>
					<?php echo $row['body']; ?>
					<div class="post-info"> 
						<?php echo convert_date($row['date']); ?> 
						<br>
						<?php echo $row['name']; ?>			
					</div>		
				</article>

				<?php 
//get all the approved comments on THIS post, newest last
				$query_comments = "SELECT comments.user_id, comments.body, comments.date, users.username, users.user_id, users.profile_pic
				FROM comments, users
				WHERE comments.post_id = $post_id
				AND users.user_id = comments.user_id
				AND comments.is_approved = 1
				ORDER BY comments.date ASC
				LIMIT 20";
				$result_comments = $db->query($query_comments);
				if( $result_comments->num_rows >= 1 ){
					?>
					<section class="comments-list">
						<h2>Comments:</h2>

						<ul>
							<?php while( $row_comments = $result_comments->fetch_assoc() ){ ?>
							<li class="one-comment">
								<h2 class="user-card">
									<a href="profile.php?user_id=<?php echo $row_comments['user_id']; ?>">
										<?php show_profile_pic($row_comments['user_id']); ?>			
										<?php echo $row_comments['username']; ?>	
									</a>
								</h2>
								<p><?php echo $row_comments['body']; ?></p>
								<div class="date"><?php echo convert_date( $row_comments['date'] ); ?></d
									iv>
								</li>
			<?php } //end while
			$result_comments->free(); ?>
		</ul>
	</section>
	<?php } //end if comments ?>
	<section class="comment-form">
		<?php 
	//add this after user authentication demo
		if ($logged_in_user['user_id']){ ?>	

		<h2>Leave a Comment</h2>

		<?php show_feedback( $feedback, $errors ); ?>

		<form action="single.php?post_id=<?php echo $post_id; ?>" method="post" novalidate>
			<label for="the_comment">Comment:</label>
			<textarea name="comment" id="the_comment" required></textarea>

			<input type="submit" value="Post Comment">
			<input type="hidden" name="did_comment" value="1">

			<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
		</form>

		<?php }else{
			echo 'You must be logged in to comment.';
		} ?>
	</section>
	<?php 
		} //end while
	} //end if one post to show
	else{
		echo 'Invalid post.';
	} 
	?>

</main>

<?php include('includes/sidebar.php'); ?>
<?php include('includes/footer.php'); ?>