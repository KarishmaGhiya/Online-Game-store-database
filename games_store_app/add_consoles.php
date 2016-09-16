<?php # add_consoles.php

$page_title = 'Add Console';

include ('mysqli_connect.php');

// Check if the form has been submitted.
if (isset($_POST['submitted'])) {
	$errors = array(); // Initialize error array.
	
	//Check for console id i.e which product
	if (empty($_POST['console_id'])) {
		$errors[] = 'You forgot to enter the product.';
	} else {
		$console_id = $_POST['console_id'];
	}

	// Check for drive type
	if (empty($_POST['drive_type'])) {
		$errors[] = 'You forgot to enter the drive type.';
	} else {
		$drive_type = $_POST['drive_type'];
	}
	
	// Check for the size.
	if (empty($_POST['size'])) {
		$errors[] = 'You forgot to enter the console size.';
	} else {
		$size = $_POST['size'];
	}

	// Check for the details.
	if (empty($_POST['details'])) {
		$errors[] = 'You forgot to enter console details.';
	} else {
		$details = $_POST['details'];
	}
	
	if (empty($errors)) { // If everything's okay.
	
		// Add the movie to the database.
		
		// Make the query.
		$query = "INSERT INTO consoles (console_id, drive_type, size, details) VALUES ($console_id,'$drive_type', $size, '$details')";		
		$result = @mysqli_query ($dbc, $query); // Run the query.
		if ($result) { // If it ran OK.
		
			// Print a message.
			echo '<h1 id="mainhead">Success!</h1>
		<p>You have added:</p>';

		   echo "<table>
		<tr><td>Console id:</td><td>{$console_id}</td></tr>
		<tr><td>Drive Type:</td><td>{$drive_type}</td></tr>
		<tr><td>Size:</td><td>{$size}</td></tr>
		<tr><td>Details:</td><td>{$details}</td></tr>
		</table>";

		$console_id = mysqli_insert_id($dbc); // Retrieve the id number of the newly added record

			
		} else { // If it did not run OK.
			echo '<h1 id="mainhead">System Error</h1>
			<p class="error">The console could not be added due to a system error. We apologize for any inconvenience.</p>'; // Public message.
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
 if (isset($_POST['console_id'])) $this_console=$_POST['console_id'];
 echo '<h2>Add Console</h2>
<form action="add_consoles.php" method="post">';
echo '<p>Console/Product: <select name="console_id">';
// customer drop-down
//SELECT Product_id FROM Product WHERE description ='console' AND Product_id  NOT IN (select console_id FROM consoles) 
$query_sub = "SELECT * FROM Product where description = 'console' AND Product_id  NOT IN (select console_id FROM consoles)";
$result_sub = @mysqli_query ($dbc, $query_sub);

while ($row_sub = mysqli_fetch_array($result_sub, MYSQL_ASSOC))
{
	if ($row_sub['Product_id'] == $this_console) 
	{
		echo '<option value="'.$row_sub['Product_id'].'" 	selected="selected"> #'.$row_sub['Product_id'].$row_sub['pro_name'].'</option>';
	}
	else 
	{
		echo '<option 	value="'.$row_sub['Product_id'].'"> #'.$row_sub['Product_id'].$row_sub['pro_name'].'</option>';
	}
}
echo '</select> </p>';

echo'<p>Drive Type: <input type="text" name="drive_type" size="35" maxlength="35" value="';
 if (isset($_POST['drive_type'])) echo $_POST['drive_type'];
 echo '" required="required"/></p>';
 

echo '<p>Console details: <textarea required="required" name="details" id="details" rows="2" cols="50" value="';
if (isset($_POST['details'])) echo $_POST['details'];
echo '">';
if (isset($_POST['details'])) echo $_POST['details'];
echo '</textarea></p>';

echo '<p> Size in GB:<input id="size" name="size" type ="number" min="1" max="100" value="';
	if (isset($_POST['size'])) {
		echo $_POST['size'];
	}
	
echo '" required="required"/></p>';

@mysqli_close($dbc); // Close the database connection.
echo '<p><input type="submit" name="submit" value="Add Product" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
</form>';
?>
