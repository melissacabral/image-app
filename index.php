<?php 
/*
The main 'feed' of all users' most recent published images. 
Anyone can view this page. 
*/

include('includes/header.php'); 
?>

<main class="content grid">
	<?php 
	//get the most recent posts for the main feed page
	$query = 	"SELECT posts.*, users.username, users.user_id, users.profile_pic, categories.*
				FROM posts, categories, users
				WHERE posts.is_published = 1
				AND categories.category_id = posts.category_id
				AND users.user_id = posts.user_id
				ORDER BY posts.date DESC
				LIMIT 10";
	//run the query on the DB
	$result = $db->query($query);
	if(! $result){
		echo $db->error;
	} 
	//check to see if the query returned any rows
	if( $result->num_rows >= 1 ){
		//loop through all the rows
		while( $row = $result->fetch_assoc() ){
	?>
	<article>
		<h2 class="user-card">
			<a href="profile.php?user_id=<?php echo $row['user_id']; ?>">
			<?php show_profile_pic($row['user_id']) ?>	
			<span class="username">		
			<?php echo $row['username']; ?>	
			</span>
			</a>
		</h2>

		<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
			<img src="<?php image_url($row['post_id'], 'large'); ?>" class="post-image">
		</a>

		
		<h3><?php echo $row['title']; ?></h3>
		<?php echo $row['body']; ?>
		<div class="post-info"> 
			<?php echo convert_date($row['date']); ?> 
			<br>
			<?php echo $row['name']; ?>
			<br>
			<?php show_post_tags( $row['post_id'] ); ?>
			
			<?php count_comments( $row['post_id'], ' comment on this post', 
			' comments on this post' ); ?>
		</div>
		
	</article>
	<?php 
		} //end while
		//clean up after we're done with these results
		$result->free();
	}else{
		echo 'No Posts found.';
	} ?>
</main>

<?php include('includes/sidebar.php'); ?>

<?php include('includes/footer.php'); ?>