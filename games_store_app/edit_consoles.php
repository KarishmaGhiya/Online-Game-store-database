<?php # Script : edit_consoles.php

// This page edits a console
// This page is accessed through views_consoles.php.

$page_title = 'Edit a console';

// Check for a valid order ID, through GET or POST.
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
	
	if (empty($errors)) { // If everything's OK.
				//Update
	 			// Make the query.
			$query = "UPDATE consoles SET drive_type='$drive_type',  details = '$details', size = $size WHERE console_id = $id";
			$result = @mysqli_query ($dbc, $query); // Run the query.
			if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { // If it ran OK.
			
				// Print a message.
				echo '<h1 id="mainhead">Edit a console</h1>
				<p>The console record has been edited.</p><p><br /><br /></p>';	
							
			} else { // If it did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The console record could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
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

// Retrieve the console record's information.
		
$query = "SELECT console_id, drive_type,details,size FROM consoles  WHERE console_id = $id";
$result = @mysqli_query ($dbc, $query); // Run the query.
//var_dump($result);
if (mysqli_num_rows($result) == 1) { // Valid accessory ID, show the form.

	// Get the accessory's information.
	$row = @mysqli_fetch_array ($result, MYSQL_NUM);
	

	// Create the form.


echo '
<h2>Edit a console</h2>
<form action="edit_consoles.php" method="post">
<p>Name: <input type="text" name="drive_type" value="' ;

if (isset($drive_type)) {
	echo $drive_type;
}
else{
	echo $row[1];
}
echo '" required="required"/></p>';


	/*if (isset($details)) {
		echo $details;
	}
	else{	
		echo $row[2];
	}*/


echo '<p>Console details: <textarea required="required" name="details" id="details" rows="2" cols="50" value="' . $row[2] . '" >' . $row[2] . '</textarea></p>';

echo '<p> Size in GB:<input id="size" name="size" type ="number" min="1" max="100" value="';
	if (isset($size)) {
		echo $size;
	}
	else{	
		echo intval($row[3]);
	}

echo '" required="required"/></p>';
echo '
<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="id" value="' . $id . '" />
<p><input type="submit" name="submit" value="Submit" /></p>
</form>
';

} else { // Not a valid accessory ID.
	echo '<h1 id="mainhead">Page Error</h1>
	<p class="error">This page has been accessed in error. Not a valid accessory ID.</p><p><br /><br /></p>';
}

@mysqli_close($dbc); // Close the database connection.
		
?>