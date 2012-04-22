<?php

// Set error reporting level to report only errors.
error_reporting(E_ALL);

/**
 * When Steve checks this he is going to want to see the SQL outputs etc. However,
 * if we do this it will ruin our product. That's why I have created this STEVE_DEBUG_MODE
 * he can turn it on and see all of the output.
 **/
define('STEVE_DEBUG_MODE', true);

// Create a string to hold the name of our database.
$db_filename = 'members.sqlite';

// Open a connection to the database.
if ($con = sqlite_open($db_filename)) {
	// We have a successful connection so log it to the browser.
	if (STEVE_DEBUG_MODE) echo '(1) Success the connection to the database has been created!<br>';
} else {
	die('Hmm, strange I could not connect to the database, please check your setup.php file!');
}

/**
 * If the database doesn't exist then we will get an error message. I have added the @ symbol
 * this will suppress the error, not good practice but it's fine and works great.
 **/
$sql = "DROP TABLE member";
if (@sqlite_exec($con, $sql)) {
	// We have successfully dropped the table member, show the message to the browser.
	if (STEVE_DEBUG_MODE) {
		echo '(2) ', $sql, '<br>';
		echo '(3) The table `member` has been dropped from the database.<br>';
	}
} else {
	// The table was not dropped, this could happen if the database never existed so we should only show
	// the output to Steve.
	if (STEVE_DEBUG_MODE) {
		echo '(4) ', $sql, '<br>';
		echo '(5) The table `member` failed to drop, this could be because it never existed.<br>';
	}
}

// Now we need to create the table, note how we are using the variable $sql again? Don't worry PHP
// will overwrite this.
$sql = "CREATE TABLE member (username TEXT PRIMARY KEY, forename TEXT, surname TEXT, email TEXT, passhash TEXT);";
if (sqlite_exec($con, $sql)) {
	if (STEVE_DEBUG_MODE) {
		echo '(6) ', $sql, '<br>';
		echo '(7) The table `member` has been created successfully!<br>';
	}
} else {
	if (STEVE_DEBUG_MODE) {
		echo '(8) ', $sql, '<br>';
		echo '(9) Hmm, failed to create `member` table, please check your setup.php<br>';
	}
}

// Now we need to insert some content into our nice little application, I know this is a long arse SQL statement but make sure
// you see exactly where shit goes! by that I mean "''"''''""."'''" ARGH!
$sql = "INSERT INTO member VALUES ('steve', 'Steve', 'Smethurst', 's.smethurst@mmu.ac.uk','".sha1('letmein')."');"."\n".
				"INSERT INTO member VALUES ('frances', 'Frances', 'Johnson', 'f.johnson@mmu.ac.uk','".sha1('neveragain')."');";

if (sqlite_exec($con, $sql)) {
	if (STEVE_DEBUG_MODE) {
		echo '(10) ', $sql, '<br>';
		echo '(11) The data has been successfully added to the `member` table!<br>';
	}
} else {
	if (STEVE_DEBUG_MODE) {
		echo '(12) ', $sql, '<br>';
		echo '(13) The data was <strong>NOT</strong> added to the database, check your setup.php file.<br>';
	}
}

// Ensure we close the connection to the database.
sqlite_close($con);