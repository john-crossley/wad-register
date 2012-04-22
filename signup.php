<?php

if ( (isset($_POST['username'])) && 
		 (isset($_POST['forename'])) && 
		 (isset($_POST['surname'])) && 
		 (isset($_POST['email'])) && 
		 isset($_POST['password'])) {

	// Store the SQLite filename
	$db_filename = 'members.sqlite';
	
	// Create the connection to the database.
	$con = sqlite_open($db_filename)
		or die('Unable to connect to the database.');

	// Best practice is to clean the variables, sup to you.
	$username = strip_tags($_POST['username']);
	$forename = strip_tags($_POST['forename']);
	$surname = strip_tags($_POST['surname']);
	$email = strip_tags($_POST['email']);
	$password = strip_tags( sha1($_POST['password']) ); // I have also hashed my password.

	// Make the SQL statement to insert the data.
	$sql = "INSERT INTO member VALUES ('$username', '$forename', '$surname', '$email', '$password')";

	// Now add the shiz to the database.
	if (sqlite_exec($con, $sql)) {
		sqlite_close($con); // Close the connection to the database.
		header('Location: welcome.php'); // Redirect the user to the welcome.php page
		exit; // Not needed as there is nothing below but this will stop anymore of the script executing from this point.
	}

}