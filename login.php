<?php 
/*
stand-alone login form.
It does not load the normal site header, 
so we need to manually include all dependencies here:
 */
//supress Notice: messages
error_reporting( E_ALL & ~E_NOTICE ); 
session_start();
require('db-config.php');
include_once('functions.php');

include('login-parse.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Log in to your account</title>
	<link rel="stylesheet" type="text/css" href="styles/login-style.css">
</head>
<body>

	
		<h1>Log in to Imagoo</h1>

		<?php show_feedback( $error_message, array() ); ?>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

			<label for="the_username">Username</label>
			<input type="text" name="username" id="the_username" required>

			<label for="the_password">Password</label>
			<input type="password" name="password" id="the_password" required>

			<input type="submit" value="Log In">

			<input type="hidden" name="did_login" value="1">
		</form>
	

	<footer>
		Imagoo uses cookies to improve your experience. 
	</footer>
</body>
</html>