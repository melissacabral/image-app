<?php 
/*
Ajax demo - this is the interface that the user will see. Normal HTML/CSS/PHP rules apply
*/
require('includes/header.php'); 

//get all the categories for the interface
$query = "SELECT * FROM categories";
$result = $db->query($query);

if(! $result){
	echo  $db->error ;
}
?>

<main class="content">

	<h2>Pick a Category</h2>

	<?php while( $row = $result->fetch_assoc() ){ ?>
		<button class="category-button" data-catid="<?php echo $row['category_id']; ?>">
			<?php echo $row['name']; ?>
		</button>
		<?php } ?>
	

	<div id="display-area">
		Pick a category to see all of the posts in it
	</div>
</main>

<?php include('includes/sidebar.php'); ?>

<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>

<script>
	//when the user clicks on a "tab"
	$('.category-button').click(function(e){
		//which category did they click (uses data-catid attribute)
		var catid = $(this).data('catid');
		//console.log(catid);
		//send this variable to the "handler" file via ajax
		$.ajax({
			method	: 'POST',
			url 	: 'ajax/ajax-category-handler.php',
			data 	: { 'catid' : catid },
			dataType: 'html',
			success	: function(response){
				$('#display-area').html(response);
			}
		});
	});

	//listen for the ajax request to start and stop to show "loading" feedback
	$(document).on({
		ajaxStart 	: function(){
			$('#display-area').addClass('loading');
			console.log('start');
		},
		ajaxStop 	: function(){
			$('#display-area').removeClass('loading');
			console.log('done');
		}
	});
</script>

<?php include('includes/footer.php'); ?>