<?php 
error_reporting( E_ALL & ~E_NOTICE ); 
//connect to the db
require('includes/db-config.php');
include_once( 'includes/functions.php' );
//Added DAY 14 (user auth day) check to see if we're logged in or not
session_start();
$logged_in_user = check_login();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>pictuto - Powered by PHP &amp; MySQL</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link href="https://fonts.googleapis.com/css?family=Libre+Franklin:200,400,700" rel="stylesheet">

	<link rel="alternate" type="application/rss+xml" href="rss.php" title="Pictuto Image Feed">
</head>
<body>

	<header class="header">
		<a class="logo" href="index.php"><img src="images/logo.svg" width="198" height="57"></a>
	</header>

	<nav class="main-navigation wrapper">
		<section class="search-bar">
			<form action="search.php" method="get">
				<label class="screen-reader-text">Search:</label>
				<input type="search" name="phrase" value="<?php echo $_GET['phrase']; ?>" placeholder="Search">
				<button type="submit"><img src="images/search.svg" width="22" height="24"></button>
			</form>		
		</section>
		<ul class="menu">
			<!-- stuff anyone can see -->
			<?php if(!$logged_in_user){ ?>
			<li><a href="login.php">Login</a></li>
			<li><a href="register.php">Register</a></li>

			<!-- Stuff only logged in people can see -->
			<?php }else{ ?>
			<li><a href="add-post.php">Add a post</a></li>
			<li><a href="profile.php?user_id=<?php echo $logged_in_user['user_id'] ?>">My Profile</a></li>
			<li><a href="login.php?action=logout">Logout</a></li>
			<?php } ?>
		</ul>
	</nav>
	<div class="wrapper"><!-- closes in footer -->

