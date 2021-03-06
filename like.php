<?php 
/**
* An AJAX "Like" demo

* TEACHER's NOTES:  
* This is an intermediate demo - for use in classes where you go through the material quickly. If you don't have a chance to demo this, curious students can get sample code here:
* https://github.com/melissacabral/ratings
* https://github.com/melissacabral/php-ajax

* This example is built as a standalone file for demonstration purposes - When you demo this in class, add the Interface and Javascript to the existing index. in reality, this functionality would be incorporated into every page of the site that shows posts

* Add the "likes table" first, put some dummy data in it
* +----------+---------+---------+
* | like_id* | user_id | post_id |
* +----------+---------+---------+
* 

* Start from Index.php. Add the "like button" (line 51-ish) and the scripts at the bottom of the page. 
 */
require('includes/header.php');
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
			
				<div class="likes">
					<?php 
					//do basic_likes($post_id) first, then  likes() if desired
					likes($row['post_id'], $logged_in_user['user_id']) ?>
				</div>

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


<?php 
//only load the JS for LIKES if the user is logged in
if($logged_in_user){ 
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript">
	/*====LIKES=====*/

	//bind with "on" because .click won't work since the like button is added to the DOM by the ajax response
	$(".likes").on( "click", ".button", function() {

	//what thing did they like or dislike?
	var post_id = $(this).data("postid"); 
	var user_id = <?php echo $logged_in_user['user_id'] ?>;

	console.log(post_id, user_id);

	//get the parent ".likes" container of the button that was pushed
	var display =  $(this).parents('.likes');  

	//create an ajax request to update the likes count and display the updated count
	$.ajax({   
		type: "GET",
		url: "ajax/ajax-like-handler.php",  
		data: { 
			'user_id': user_id, 
			'post_id' : post_id 
		},   
		dataType: "html",   //expect html to be returned
		success: function(response){
			display.html(response);
		}
	});
});

</script>
<?php } //logged in?>

<?php include('includes/footer.php'); ?>
