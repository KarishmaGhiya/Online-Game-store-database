<?php # mysqli_connect.php

// This file contains the database access information. 
// This file also establishes a connection to MySQL and selects the database.

// Set the database access information as constants.

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', 'Karishma1993');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'online_games');

// Make the connnection.
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

?>