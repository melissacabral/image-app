<?php 
/**
* Teacher Notes
* Day 14 or 15 demo
* Start from the login form and parser we made on day 3 and add DB check, security key
* Make sure there is a "secret_key" field in users table
* stand-alone login form.
* It does not load the normal site header, 
* so we need to manually include all dependencies here:
 */
//supress Notice: messages
error_reporting( E_ALL & ~E_NOTICE ); 
session_start();
require('includes/db-config.php');
include_once('includes/functions.php');

include('includes/login-parse.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Log in to your account</title>
	<link rel="stylesheet" type="text/css" href="styles/login-style.css">
	<link href="https://fonts.googleapis.com/css?family=Libre+Franklin:200,400,700" rel="stylesheet">
</head>
<body>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<h1>Log in to pictuto</h1>
		<?php show_feedback( $error_message, array() ); ?>
		<label for="the_username">Username</label>
		<input type="text" name="username" id="the_username" required>
		<label for="the_password">Password</label>
		<input type="password" name="password" id="the_password" required>
		<input type="submit" value="Log In">
		<input type="hidden" name="did_login" value="1">
	</form>
	<footer>
		<p>pictuto uses cookies to improve your experience.</p>
		<a href="index.php">&larr; Back to pictuto</a> | <a href="register.php">Register</a>
	</footer>
</body>
</html>