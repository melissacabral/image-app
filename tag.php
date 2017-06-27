<?php
/*
The template for displaying all posts in any tag. Anyone can see this page

TEACHER NOTES:
* Assign this as a "challenge" if there's time. 	
* Requires a more complex join on the "between" table in the main query
 */ 
require('header.php'); 

//which tag are we trying to show
$tag_id = $_GET['tag_id'];
?>

<main class="content">
	<?php 
	//get all the posts in this tag. make sure they are published posts
	$query = "SELECT *
	FROM posts, tags, post_tags, users
	WHERE posts.is_published = 1
	AND tags.tag_id = $tag_id
	AND tags.tag_id = post_tags.tag_id 
	AND posts.post_id = post_tags.post_id
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

			<article class="medium-post">
				<a href="single.php?post_id=<?php echo $row['post_id'] ?>">
				<img src="<?php image_url($row['post_id'], 'medium') ?>" class="post-image">
				</a>
					<h2 class="user-card">
						<a href="profile.php?user_id=<?php echo $row['user_id']; ?>">
							<?php show_profile_pic($row['user_id']); ?>				
							<?php echo $row['username']; ?>	
						</a>
					</h2>
					<h3><?php echo $row['title']; ?></h3>
					<div class="post-info"> 
						<?php echo convert_date($row['date']); ?> 
						<?php show_post_tags($row['post_id']); ?>	
					</div>		
				</article>
			
	
	
	<?php 
		} //end while
	} //end if one post to show
	else{
		echo 'Invalid cate.';
	} 
	?>

</main>

<?php include('sidebar.php'); ?>
<?php include('footer.php'); ?>