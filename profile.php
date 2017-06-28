<?php 
/*
The template for a single user's profile - displays the  users' most recent published images. 

Anyone can view this page. 

TEACHER NOTES:
====
This file demonstrates a slightly more advanced loop handling with a LEFT Join plus a counter:
* The first iteration of the loop shows the user's info as the heading of the page
* subsequent iterations show smaller images

*/
require('includes/header.php'); 

//whose profile?
$user_id = $_GET['user_id'];
?>

<main class="content grid">
	<?php 
	//get this user's public posts. 
	//we use a LEFT JOIN so that the query will still return one row (the user's data) if this user has no posts yet
	$query = 	"SELECT users.username, users.user_id, users.bio, posts.title, posts.post_id,  posts.date, posts.image
				FROM users
				LEFT JOIN posts ON (posts.user_id = users.user_id)
				WHERE users.user_id = $user_id
				ORDER BY posts.date DESC
				LIMIT 10";
	//run the query on the DB
	$result = $db->query($query);
	if(! $result){
		echo $db->error;
	} 
	//check to see if the query returned any rows
	if( $result->num_rows >= 1 ){
		$counter = 1;
		?>

		<?php 
		//loop through all the rows
		while( $row = $result->fetch_assoc() ){
			if($counter == 1){
				//first iteration. show user's info before the article
				?>
				<div class="profile-header full-column">
				<h2 class="user-card">						
					<?php show_profile_pic($row['user_id'], 'large'); ?>		
					<?php echo $row['username']; ?>						
				</h2>

				<div class="bio">
					<?php echo $row['bio']; ?>
				</div>
				</div>
			<?php if ($row['post_id']){ ?>				
			
				<article class="first-post full-column">
					<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
						<img  src="<?php image_url($row['post_id'], 'large') ?>" class="post-image">
					</a>
					<h3><?php echo $row['title']; ?></h3>
					
					<div class="post-info"> 
						<?php echo convert_date($row['date']); ?> 
						<br>
						<?php echo $row['name']; ?>
						<br>
						<?php count_comments( $row['post_id'], ' comment on this post', 
						' comments on this post' ); ?>
					</div>
				</article>
				<?php }//end if there is a post
				else{
					echo 'This user hasn\'t posted anything yet!';
					} ?>
				<?php
			}else{
				?>
				<article class="thumbnail-post">
					<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
						<img src="<?php image_url($row['post_id'], 'thumb') ?>" class="post-image small">
					</a>
				</article>

				<?php
			}//end if $counter
			?>
			
			<?php 
			//counter goes up 1
			$counter++;
		} //end while
		//clean up after we're done with these results
		$result->free();
	}else{
		echo 'This user hasn\'t posted anything.';
	} ?>

</main>

<?php include('includes/sidebar.php'); ?>

<?php include('includes/footer.php'); ?>