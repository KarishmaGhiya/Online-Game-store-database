<?php # Script : edit_games.php

// This page edits a game
// This page is accessed through view_games.php.

$page_title = 'Edit a game';

// Check for a valid games ID, through GET or POST.
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // Accessed through view_orders.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form has been submitted.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<h1 id="mainhead">Page Error</h1>
	<p class="error">This page has been accessed in error.</p><p><br /><br /></p>';
	exit();
}

include ('mysqli_connect.php');

// Connect to the db.

// Check if the form has been submitted.
if (isset($_POST['submitted'])) {

	$errors = array(); // Initialize error array.
	
	// Check for name
	if (empty($_POST['games_name'])) {
		$errors[] = 'You forgot to enter the game name.';
	} else {
		$games_name = $_POST['games_name'];
	}
	
	// Check for the min_memory_size.
	if (empty($_POST['min_memory_size'])) {
		$errors[] = 'You forgot to select the min_memory_size.';
	} else {
		$min_memory_size = $_POST['min_memory_size'];
	}
	
	// Check for max_no_players.
	if (empty($_POST['max_no_players'])) {
		$errors[] = 'You forgot to enter the max no of players.';
	} else {
		$max_no_players = $_POST['max_no_players'];
	}
	// Check for details.
	if (empty($_POST['details'])) {
		$errors[] = 'You forgot to enter game details.';
	} else {
		$details = $_POST['details'];
	}
	// Check for console_fk.
	if (empty($_POST['console_fk'])) {
		$errors[] = 'You forgot to select the console.';
	} else {
		$console_fk = $_POST['console_fk'];
	}
	
	if (empty($errors)) { // If everything's OK.
				//Update
	 			// Make the query.
			$query = "UPDATE games SET games_name='$games_name', min_memory_size=$min_memory_size, max_no_players=$max_no_players, details = '$details', console_fk=$console_fk WHERE Games_id = $id";
			$result = @mysqli_query ($dbc, $query); // Run the query.
			if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { // If it ran OK.
			
				// Print a message.
				echo '<h1 id="mainhead">Edit a Game</h1>
				<p>The Game record has been edited.</p><p><br /><br /></p>';	
							
			} else { // If it did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The Game record could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>'; // Debugging message.
				exit();
			}
				
	} // End of if (empty($errors)) IF.
	
	else { // Report the errors.
	
		echo '<h1 id="mainhead">Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		} // End of foreach
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	}  // End of report errors else()

} // End of submit conditional.

// Always show the form.

// Retrieve the games record's information.
//$query = "SELECT * FROM customer_orders WHERE order_id = $id ";		
$query = "SELECT Games_id, games_name,min_memory_size, max_no_players, games.details,console_fk, drive_type  FROM games, consoles WHERE games.Games_id = $id  AND consoles.console_id = games.console_fk ";
$result = @mysqli_query ($dbc, $query); // Run the query.

if (mysqli_num_rows($result) == 1) { // Valid movie ID, show the form.

	// Get the movie's information.
	$row = mysqli_fetch_array ($result, MYSQL_NUM);
	
	$this_console=$row[5];
	
	// Create the form.


echo '
<h2>Edit an order</h2>
<form action="edit_games.php" method="post">

<p>Name: <input type="text" name="games_name" value="' . $row[1] . '" required="required"/></p>';
echo '<p>Min Memory size in GB: :<input id="min_memory_size" name="min_memory_size" type ="number" min="3" max="1000" value="';
	if (isset($min_memory_size)) {
		echo $min_memory_size;
	}
	else{	
		echo intval($row[2]);
	}

echo '" required="required"/></p>';
echo '<p>Max no players: :<input id="max_no_players" name="max_no_players" type ="number" min="1" max="100" value="';
	if (isset($max_no_players)) {
		echo $max_no_players;
	}
	else{	
		echo intval($row[3]);
	}

echo '" required="required"/></p>';

echo '<p> Details:<input type ="text" id="details" name="details"  value="';
	if (isset($details)) {
		echo $details;
	}
	else{	
		echo($row[4]);
	}

echo '" required="required"/></p>';

echo '<p>Console: <select name="console_fk">';
// console drop-down
$query_sub = "SELECT * FROM consoles";
$result_sub = @mysqli_query ($dbc, $query_sub);

while ($row_sub = mysqli_fetch_array($result_sub, MYSQL_ASSOC))
{
	if ($row_sub['console_id'] == $this_console) 
	{
		echo '<option value="'.$row_sub['console_id'].'" 	selected="selected">'.$row_sub['drive_type'].'</option>';
	}
	else 
	{
		echo '<option 	value="'.$row_sub['console_id'].'">'.$row_sub['drive_type'].'</option>';
	}
}
echo '</select> </p>';


echo '
<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="id" value="' . $id . '" />
<p><input type="submit" name="submit" value="Submit" /></p>
</form>
';

} else { // Not a valid games ID.
	echo '<h1 id="mainhead">Page Error</h1>
	<p class="error">This page has been accessed in error. Not a valid games ID.</p><p><br /><br /></p>';
}

@mysqli_close($dbc); // Close the database connection.
		
?>