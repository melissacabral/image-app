<?php //connect to DB
require('db-config.php');
include_once('functions.php');

//for compatibility because of the <?  symbols
echo '<?xml version="1.0"?>';

//get 10 of  the recent published posts out of the DB
$query = "SELECT posts.title, posts.image, posts.post_id, posts.date, posts.body, users.username, users.email
			FROM posts, users
			WHERE posts.user_id = users.user_id
			AND posts.is_published = 1
			ORDER BY date DESC
			LIMIT 10";
//run it
$result = $db->query($query);
//check it
if(! $result){
	die($db->error);
}
if( $result->num_rows >= 1 ){
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>Melissa's Blog Feed</title>
		<!-- Update this link when the site goes live! -->
		<link>http://localhost/melissa-php-0517/blog/siteroot</link>
		<atom:link href="http://localhost/melissa-php-0517/blog/siteroot/rss.php" rel="self" type="application/rss+xml" />

		<description>Subscribe for updates to my posts!</description>

		<?php while( $row = $result->fetch_assoc() ){ ?>
		<item>
			<title><?php echo $row['title']; ?></title>
			<link>http://localhost/melissa-php-0517/blog/siteroot/single.php?post_id=<?php echo $row['post_id']; ?></link>
			<guid>http://localhost/melissa-php-0517/blog/siteroot/single.php?post_id=<?php echo $row['post_id']; ?></guid>
			<author><?php echo $row['email']; ?> (<?php echo $row['username']; ?>)</author>
			<pubDate><?php echo rss_date($row['date']); ?></pubDate>
			<description><![CDATA[
				<img src="<?php image_url($row['post_id'], 'large'); ?>">
				<br>
				<h2>Posted by <?php echo $row['username']; ?></h2>
				<p><?php echo $row['body']; ?></p>]]></description>
		</item>
		<?php 
		}//end while
		$result->free(); ?>

	</channel>
</rss>
<?php } //end if there are rows ?>