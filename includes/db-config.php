<?php
$database 	= 'melissa_image_app';
$username 	= 'melissa_blog0517';
$password 	= 'YA2p6Q7EwDLTuY9Y';
$db_host 	= 'localhost';

//connect to the database
$db = new mysqli( $db_host, $username, $password, $database );

//check to make sure it worked
if( $db->connect_errno > 0 ){
	die('Error connecting to database');
}

//store our security salt in a constant - these are for strengthening out login system. If you change the salt, every password becomes invalid.
define( 'SALT', 'tgbfy786ibnv35t#&)revgnbjk4657#679565bvsfd5rfwhn34e6' );



//no close php