<?php /*
The first step to upload an image. If successful, the post is saved, and the user is directed to the second step to complete the post title, body, etc

TEACHER NOTES:
Use this to demonstrate image uploads. 
Don't forget enctype attribute on this form
Store the URL to the image in the DB
*/ 
require('header.php');
include('add-post-parse.php'); ?>

<main class="content">
	<h2 class="full-column">Add a Post</h2>

	<?php show_feedback( $feedback, $errors ); ?>

	<!-- don't forget enctype attribute! -->
	<form class="full-column" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
			<label for="the_image">Image</label>
			<input type="file" name="uploadedfile" id="the_image" required>
			

			<input type="submit" value="Next Step: Details &rarr;">
			<input type="hidden" name="did_add_post" value="1">		
	</form>
	
</main>

<?php require('sidebar.php'); ?>
<?php require('footer.php'); ?>