<?php
/*
The template for displaying all posts in any category. Anyone can see this page

TEACHER NOTES:
* Assign this as a "challenge" if there's time. 	
 */ 
require('includes/header.php'); 


//which category are we trying to show
$category_id = $_GET['cat_id'];
?>

<main class="content grid">
	<?php 
	//get all the posts in  THIS category. make sure they're published posts
	$query = "SELECT posts.*, users.username, users.user_id, users.profile_pic, categories.*
	FROM posts, categories, users
	WHERE posts.is_published = 1
	AND categories.category_id = $category_id
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
					<br>
					<?php echo $row['name']; ?>			
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

<?php include('includes/sidebar.php'); ?>
<?php include('includes/footer.php'); ?>