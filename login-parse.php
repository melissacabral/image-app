<?php
//Logout Action
if( $_GET['action'] == 'logout' ){
	//close the session and the associated cookie. this snippet is from php.net
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
			);
	}
	session_destroy();
	
	//erase all session vars and cookies
	$_SESSION['user_id'] = '';
	setcookie( 'user_id', '', time() -9999999 );

	$_SESSION['secret_key'] = '';
	setcookie( 'secret_key', '', time() -9999999 );
}//end of logout action

//if the form was submitted, parse it
if( $_POST['did_login'] ){
	//extract the data
	$username = clean_string($_POST['username']);
	$password = clean_string($_POST['password']);
	
	// validate the data
	$valid = true;

	if( $username == '' OR strlen($username) > 40 ){
		$valid = false;
		$errors['username'] = 'Username is the wrong length';
	}

	if( strlen( $password ) < 7 ){
		$valid = false;
		$errors['password'] = 'Password too short';
	}
	//if valid, check the credentials against the DB
	if( $valid ){
		$password = sha1( $password . SALT );
		$query = "SELECT user_id
					FROM users
					WHERE username = '$username'
					AND password = '$password'
					LIMIT 1";
		$result = $db->query($query);

		//send the user to the admin panel if they got it right, or show an error
		if( $result->num_rows == 1 ){
			//success - remember the user for 1 day and then redirect to secret page
			$secret_key = sha1( microtime() . SALT );

			$row = $result->fetch_assoc();
			$user_id = $row['user_id'];

			//store the key in the DB for THIS user
			$query = "UPDATE users
						SET secret_key = '$secret_key'
						WHERE user_id = $user_id
						LIMIT 1";
			$result = $db->query($query);

			//make sure the query worked
			if( $db->affected_rows == 1 ){	
				$expiration = time() + 60 * 60 * 24;
				setcookie( 'secret_key', $secret_key, $expiration );
				$_SESSION['secret_key'] = $secret_key;

				setcookie('user_id', $user_id, $expiration);
				$_SESSION['user_id'] = $user_id;

				//redirect to home page
				header('Location:index.php');
			} //end if affected rows
			else{
				$error_message = 'no rows affected';
			}
		}else{
			//error - user feedback
			$error_message = 'Sorry, your username/password combo is incorrect. Try again.';
		}
	} //end if valid
	else{
		$error_message = 'Sorry, your username/password combo is incorrect. Try again.';
	}
} //end of login parser	