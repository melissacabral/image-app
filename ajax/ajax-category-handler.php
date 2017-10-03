<?php 
/*
Display output
This file stays on the server and has no doctype/page structure.
It simply runs a query to get all the posts in a category
and gives back the HTML content for the posts
*/
require('../includes/db-config.php');
include_once('../includes/functions.php');

//added at the end of the demo to simulate a slow connection
//put the server to sleep for 5 seconds.
//remove this from the final code!!!
sleep(5);

//the category ID that the user clicked (from the interface file)
$category_id = $_REQUEST['catid'];

//query to get all published posts in a category
$query = "SELECT posts.*, categories.name
		FROM posts, categories
		WHERE posts.category_id = categories.category_id  
		AND posts.category_id = $category_id
		ORDER BY date DESC
		LIMIT 10";
$result = $db->query($query);

if( ! $result ){
	die( $db->error );
}

if($result->num_rows >= 1){
	while( $row = $result->fetch_assoc() ){
?>

<article>
		<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
			<img src="<?php echo $row['image'] ?>" alt="<?php echo $row['title']; ?>">
		</a>

		
		<h3><?php echo $row['title']; ?></h3>
		<p><?php echo $row['body']; ?></p>
		<div class="post-info"> 
			<span class="date">
				<?php echo convert_date($row['date']); ?> 
			</span>
			<span class="comment-count">
				<?php count_comments( $row['post_id'] ); ?>		
			</span>
		</div>		
	</article>

<?php
	} //end while 
}else{
	echo 'No posts in this category';
} ?>