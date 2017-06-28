<aside class="sidebar">
	<?php //get the titles of up to 5 recent published posts
	$query 	= "SELECT *
				FROM users
				ORDER BY join_date DESC
				LIMIT 5";
	$result = $db->query($query);
	//check to see if we got any rows
	if( $result->num_rows >= 1 ){
	 ?>
	<section>
		<h2>Newest Users</h2>
		
		<?php while( $row = $result->fetch_assoc() ){ ?>			
			<a class="profile-pic" href="profile.php?user_id=<?php echo $row['user_id']; ?>" title="<?php echo $row['username']; ?>'s Profile"><?php show_profile_pic($row['user_id']); ?></a>
		
		<?php } //end while 
		$result->free();
		?>
		
	</section>
	<?php } //end if there are rows ?>



	<?php //show up to 5 categories, in alphabetical order by name and count the number of posts in each
	$query 	= "SELECT categories.*, COUNT(*) AS total
			FROM categories , posts 
			WHERE categories.category_id = posts.category_id
			GROUP BY categories.category_id
			ORDER BY categories.name ASC
			LIMIT 5";
	$result = $db->query($query);
	//check to see if we got any rows
	if( $result->num_rows >= 1 ){?>
	<section>
		<h2>Categories</h2>
		<ul>
		<?php while( $row = $result->fetch_assoc() ){ ?>
			<li><a href="category.php?cat_id=<?php echo $row['category_id'] ?>"><?php echo $row['name'] ?> </a>
			- <?php echo $row['total']; ?> posts</li>
		<?php }
		$result->free(); ?>
		</ul>
	</section>
	<?php }//end if ?>



	<?php //show all of the tags, in order by popularity of use, and count the number of posts in each
	$query 	= "SELECT tags.*, COUNT(*) AS total
			FROM tags, posts, post_tags 
			WHERE posts.post_id = post_tags.post_id
			AND tags.tag_id = post_tags.tag_id
			GROUP BY tags.tag_id
			ORDER BY total DESC";
	$result = $db->query($query);
	//check to see if we got any rows
	if( $result->num_rows >= 1 ){?>
	<section>
		<h2>Tags</h2>
		<ul>
		<?php while( $row = $result->fetch_assoc() ){ ?>
			<li><a href="tag.php?tag_id=<?php echo $row['tag_id'] ?>"><?php echo $row['name'] ?> </a>
			- <?php echo $row['total']; ?> posts</li>
		<?php }
		$result->free(); ?>
		</ul>
	</section>
	<?php }//end if ?>


</aside>