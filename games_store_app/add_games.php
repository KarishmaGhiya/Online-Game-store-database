<?php # add_games.php

$page_title = 'Add Game';

include ('mysqli_connect.php');

// Check if the form has been submitted.
if (isset($_POST['submitted'])) {
	$errors = array(); // Initialize error array.
	
	//Check for Games id i.e which product
	if (empty($_POST['Games_id'])) {
		$errors[] = 'You forgot to enter the product.';
	} else {
		$Games_id = $_POST['Games_id'];
	}
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
	
	if (empty($errors)) { // If everything's okay.
	
		// Add the movie to the database.
		
		// Make the query.
		$query = "INSERT INTO  Games VALUES ($Games_id,'$games_name',$min_memory_size,$max_no_players,'$details',$console_fk)";		
		$result = @mysqli_query ($dbc, $query); // Run the query.
		if ($result) { // If it ran OK.
		
			// Print a message.
			echo '<h1 id="mainhead">Success!</h1>
		<p>You have added:</p>';

		   echo "<table>
		<tr><td>Games id:</td><td>{$Games_id}</td></tr>
		<tr><td>Game Name:</td><td>{$games_name}</td></tr>
		<tr><td>Min Memory Size:</td><td>{$min_memory_size}</td></tr>
		<tr><td>Max no of players:</td><td>{$max_no_players}</td></tr>
		<tr><td>Details:</td><td>{$details}</td></tr>
		<tr><td>Console:</td><td>{$console_fk}</td></tr>
		</table>";

		$Games_id = mysqli_insert_id($dbc); // Retrieve the id number of the newly added record

			
		} else { // If it did not run OK.
			echo '<h1 id="mainhead">System Error</h1>
			<p class="error">The Game could not be added due to a system error. We apologize for any inconvenience.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>'; // Debugging message.
			exit();
		}
		
	} else { // Report the errors.
	
		echo '<h1 id="mainhead">Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.


	
		
} // End of the main Submit conditional.
?>
<?php 
 if (isset($_POST['Games_id'])) $this_game=$_POST['Games_id'];
 if (isset($_POST['console_fk'])) $this_console=$_POST['console_fk'];
 echo '<h2>Add Game</h2>
<form action="add_games.php" method="post">';
echo '<p>Game/Product: <select name="Games_id">';
// drop-down

$query_sub = "SELECT * FROM Product where description = 'games' AND Product_id  NOT IN (select Games_id FROM Games)";
$result_sub = @mysqli_query ($dbc, $query_sub);

while ($row_sub = mysqli_fetch_array($result_sub, MYSQL_ASSOC))
{
	if ($row_sub['Product_id'] == $this_game) 
	{
		echo '<option value="'.$row_sub['Product_id'].'" 	selected="selected"> #'.$row_sub['Product_id'].$row_sub['pro_name'].'</option>';
	}
	else 
	{
		echo '<option 	value="'.$row_sub['Product_id'].'"> #'.$row_sub['Product_id'].$row_sub['pro_name'].'</option>';
	}
}
echo '</select> </p>';


echo'<p>Name: <input type="text" name="games_name" value="';
if (isset($_POST['games_name'])) echo $_POST['games_name'];
 echo '" required="required"/></p>';

echo '<p>Min Memory size in GB: :<input id="min_memory_size" name="min_memory_size" type ="number" min="3" max="1000" value="';
	if (isset($_POST['min_memory_size'])) {
		echo $_POST['min_memory_size'];
	}
	
echo '" required="required"/></p>';
echo '<p>Max no players: :<input id="max_no_players" name="max_no_players" type ="number" min="1" max="100" value="';
	if (isset($_POST['max_no_players'])) {
		echo $_POST['max_no_players'];
	}
	

echo '" required="required"/></p>';

echo '<p> Details:<input type ="text" id="details" name="details"  value="';
	if (isset($_POST['details'])) {
		echo $_POST['details'];
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


 





@mysqli_close($dbc); // Close the database connection.
echo '<p><input type="submit" name="submit" value="Add Product" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
</form>';
?>
