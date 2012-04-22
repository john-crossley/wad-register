<?php

// Create the database file name.
$db_filename = "members.sqlite";

// This is a more simple way to connect to the database use either this method or the one found in setup.php
$con = sqlite_open($db_filename)
	or die('Unable to connect to the database.');

// Select everything from the database.
$sql = "SELECT * FROM member";

// Perform the query, two ways using foreach or while, use Steves method as hes marking.
// foreach(sqlite_fetch_array(sqlite_query($con,$sql), SQLITE_ASSOC) as $item) {
// 	print_r($item);
// }

// Perform the query, and store the contents in the var.
if ($query = sqlite_query($con, $sql)) {
	// Now iterate using a while through the data.
	while ($item = sqlite_fetch_array($query, SQLITE_ASSOC)) { // Use either SQLITE_ASSOC || SQLITE_NUM
		echo 'USERNAME => ', $item['username'], '<br>',
		'FORENAME => ', $item['forename'], '<br>',
		'SURNAME => ', $item['surname'], '<br>',
		'PASSWORD => ', $item['passhash'], '<br>',
		'EMAIL => ', $item['email'], '<br><br>';
	}
} else {
	die('Hmm, unable to query the database. Please check your settings.');
}
