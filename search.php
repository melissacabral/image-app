<?php 
/*
template to show keyword search results
Anyone can see this page
*/
require('includes/header.php');

//Search configuration
$per_page = 4;

//sanitize the phrase
$phrase = clean_string( $_GET['phrase'] );

//parse the search form if the phrase is not blank
if( $phrase != '' ){
	//get all the posts that contain the phrase
	$query = "SELECT posts.*, users.username, users.user_id, users.profile_pic
				FROM posts, users
				WHERE ( title LIKE '%$phrase%'
				OR body LIKE '%$phrase%' )
				AND is_published = 1
				AND posts.user_id = users.user_id
				ORDER BY date DESC";
	$result = $db->query($query);

	$total = $result->num_rows;

	//figure out how many pages we need
	$max_page = ceil( $total / $per_page );
	
	//figure out what page we are on. 
	//query string will look like search.php?phrase=bla&page=2
	if($_GET['page']){
		$current_page = $_GET['page'];
	}else{
		$current_page = 1;
	}

	//check for out of bounds page
	if($current_page > $max_page){
		//change it to the last page if it is out of bounds
		$current_page = $max_page;
	}
	
} //end search parser
?>

<main class="content grid">
	
	<?php 
	//if there are rows in the results, show them
	if( $total >= 1 ){ 
	?>
	
	<div class="search-header full-column">
		<h1>Search Results for <i><?php echo $phrase; ?></i></h1>
		<h2><?php echo $total; ?> posts found.</h2>
		<h3>Showing page <?php echo $current_page; ?> of <?php echo $max_page; ?></h3>
		</div>
		<?php 
		//figure out the offset of this page
		$offset = ( $current_page - 1 ) * $per_page;
		$query .= " LIMIT $offset, $per_page";
		//run the query again with a LIMIT
		$result = $db->query($query);

		while( $row = $result->fetch_assoc() ){ ?>
		<article class="medium-post">
		
		<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
			<img src="<?php image_url($row['post_id'], 'medium'); ?>" class="post-image">
		</a>

		<h2 class="user-card">
			<a href="profile.php?user_id=<?php echo $row['user_id']; ?>">
			<?php show_profile_pic($row['user_id']); ?>			
			<?php echo $row['username']; ?>	
			</a>
		</h2>
		<h3><?php echo $row['title'] ?></h3>
		
		<div class="post-info"> 
			<?php echo convert_date($row['date']); ?> 
			<br>
			<?php echo $row['name']; ?>
			<br>
			<?php show_post_tags($row['post_id']); ?>
			<br>
			<?php count_comments( $row['post_id'], ' comment on this post', 
			' comments on this post' ); ?>
		</div>

		
	</article>
		<?php 
		} //end while 
		$result->free();
		?>



	<section class="pagination full-column">
		<?php 
		$previous 	= $current_page - 1;
		$next 		= $current_page + 1;
		

		if( $current_page != 1 ){ ?>
	<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $previous; ?>">
		&larr; Previous Page</a>
		<?php } 

		//loop for numbered pagination
		for ($i = 1; $i <= $max_page; $i++) { 
			?>
			<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $i; ?>">
				<?php echo $i; ?>
			</a>
			<?php
		}

		//show the next button if we're not on the last page
		if( $current_page != $max_page ){ ?>
		<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $next; ?>">
		Next Page &rarr;</a>
		<?php } ?>

	</section>

	<?php 
	}else{
		echo 'No posts found matching ' . $phrase ;
	} 
	?>
</main>

<?php include('includes/sidebar.php'); ?>
<?php include('includes/footer.php'); ?>