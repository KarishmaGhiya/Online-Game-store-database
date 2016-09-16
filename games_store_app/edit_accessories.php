<?php # Script : edit_accessories.php

// This page edits an accessory
// This page is accessed through view_accessories.php.

$page_title = 'Edit an accessory';

// Check for a valid accessory ID, through GET or POST.
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
	if (empty($_POST['accessory_name'])) {
		$errors[] = 'You forgot to enter the accessory name.';
	} else {
		$accessory_name = $_POST['accessory_name'];
	}
	
	// Check for the details.
	if (empty($_POST['details'])) {
		$errors[] = 'You forgot to enter accessory details.';
	} else {
		$details = $_POST['details'];
	}
	
	if (empty($errors)) { // If everything's OK.
				//Update
	 			// Make the query.
			$query = "UPDATE accessories SET accessory_name='$accessory_name',  details = '$details' WHERE accessory_id = $id";
			$result = @mysqli_query ($dbc, $query); // Run the query.
			if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { // If it ran OK.
			
				// Print a message.
				echo '<h1 id="mainhead">Edit an accessory</h1>
				<p>The accessory record has been edited.</p><p><br /><br /></p>';	
							
			} else { // If it did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The accessory record could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
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

// Retrieve the accessory record's information.
		
$query = "SELECT accessory_id, accessory_name,details FROM accessories  WHERE accessory_id = $id";
$result = @mysqli_query ($dbc, $query); // Run the query.

if (mysqli_num_rows($result) == 1) { // Valid accessory ID, show the form.

	// Get the accessory's information.
	$row = @mysqli_fetch_array ($result, MYSQL_NUM);
	

	// Create the form.


echo '
<h2>Edit an accessory</h2>
<form action="edit_accessories.php" method="post">
<p>Name: <input type="text" name="accessory_name" value="' ;

if (isset($accessory_name)) {
	echo $accessory_name;
}
else{
	echo $row[1];
}
echo '" required="required"/></p>';

echo '<p> Accessory details:<input type ="text" id="details" name="details"  value="';
	if (isset($details)) {
		echo $details;
	}
	else{	
		echo $row[2];
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