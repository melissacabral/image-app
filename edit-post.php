<?php 
/*
Edit any post as long as ?post_id=X is in the query string
This is also step 2 of adding a new post - edit the details, like title, body, etc
*/
require('includes/header.php');
include('includes/edit-post-parse.php');


//which post are we editing?
$post_id = $_GET['post_id'];

//check for invalid post_id in Query string:
if(! $post_id){
	die('invalid post id. go back to step 1');
}

//get the current data about this post - we'll UPDATE it when they submit this form. this also allows us to make the form "sticky"
$query = "SELECT * FROM posts WHERE post_id = $post_id LIMIT 1";
$result = $db->query($query);
if(!$result){
	echo $db->error;
}
$row = $result->fetch_assoc();
?>

<main class="content">
	<h2>Image Details</h2>
	<img src="<?php image_url($post_id, 'large'); ?>" class="post-image">
	

	<?php show_feedback( $feedback, $errors ); ?>


	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?post_id=<?php echo $_GET['post_id'] ?>" method="post" >
			

			<label for="the_title">Title</label>
			<input type="text" name="title" id="the_title" value="<?php echo $row['title'] ?>">

			<label for="the_body">Post Body</label>
			<textarea name="body" id="the_body" rows="10"><?php echo $row['body'] ?></textarea>
		

			<label for="the_cat">Category</label>
			<?php category_dropdown($row['category_id']); ?>		
	

			<label>
				<input type="checkbox" name="allow_comments" value="1" <?php 
				if( $row['allow_comments'] ){ echo 'checked'; } 
						?>>
				Allow comments on this post
			</label>

			<input type="submit" value="Save Post">
			<input type="hidden" name="did_edit" value="1">
		
	</form>
	
</main>
<?php $result->free(); ?>

<?php require('includes/sidebar.php'); ?>

<?php require('includes/footer.php'); ?>