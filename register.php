<?php 
error_reporting( E_ALL & ~E_NOTICE ); 
//connect to DB
require('db-config.php');
//load the functions
include_once('functions.php');

//load the parsing logic
include('register-parse.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register for an account</title>
	<link rel="stylesheet" type="text/css" href="styles/login-style.css">

</head>
<body>
<h1>Create an Account</h1>
<p>Sign up and get exclusive stuff</p>

<?php show_feedback( $feedback, $errors ); ?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate>
	<label for="the_username">Choose a Username</label>
	<span class="hint">Username must be under 40 characters</span>
	<input type="text" name="username" maxlength="40" id="the_username" required>

	<label for="the_email">Email Address</label>
	<input type="email" name="email" id="the_email" required>

	<label for="the_password">Password</label>
	<span class="hint">Password must be at least 7 characters long</span>
	<input type="password" name="password" id="the_password" required>

	<label>
		<input type="checkbox" name="policy" value="1">
		Yes, I agree to the <a href="#">terms of service and privacy policy</a>.
	</label>

	<input type="submit" value="Register">
	<input type="hidden" name="did_register" value="1">
</form>

</body>
</html>