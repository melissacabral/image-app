<?php 
/*
Edit any post as long as ?post_id=X is in the query string and you are logged in as the owner of the image
This is also step 2 of adding a new post - edit the details, like title, body, etc
*/
require('includes/header.php');
include('includes/edit-post-parse.php');
?>

<main class="content">
	<h2>Image Details</h2>
	<img src="<?php image_url($post_id, 'large'); ?>" class="post-image">
	

	<?php show_feedback( $feedback, $errors ); ?>


	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?post_id=<?php echo $_GET['post_id'] ?>" method="post" >


		<label for="the_title">Title</label>
		<input type="text" name="title" id="the_title" value="<?php echo $title; ?>">

		<label for="the_body">Post Body</label>
		<textarea name="body" id="the_body" rows="10"><?php echo $body; ?></textarea>
		

		<label for="the_cat">Category</label>
		<?php category_dropdown( $category_id ); ?>		


		<label>
			<input type="checkbox" name="allow_comments" value="1" <?php 
			if( $allow_comments ){ echo 'checked'; } 
			?>>
			Allow comments on this post
		</label>

		<input type="submit" value="Save Post">
		<input type="hidden" name="did_edit" value="1">
		
	</form>
	
</main>


<?php require('includes/sidebar.php'); ?>

<?php require('includes/footer.php'); ?>