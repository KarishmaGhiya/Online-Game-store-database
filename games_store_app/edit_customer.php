<?php # Script : edit_customer.php

// This page edits a customer.
// This page is accessed through view_customers.php.

$page_title = 'Edit Customer';

// Check for a valid movie ID, through GET or POST.
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // Accessed through view_moives.php
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
	
	// Check for a name.
	if (empty($_POST['customer_name'])) {
		$errors[] = 'You forgot to enter the name of the customer.';
	} else {
		$customer_name = $_POST['customer_name'];
	}
	
	// Check for the phone.
	if (empty($_POST['customer_phone'])) {
		$errors[] = 'You forgot to enter the phone number of the customer.';
	} else {
		$customer_phone = $_POST['customer_phone'];
	}
	
	// Check for address.
	if (empty($_POST['address'])) {
		$errors[] = 'You forgot to enter the address of the customer.';
	} else {
		$address = $_POST['address'];
	}
	
	if (empty($errors)) { // If everything's OK.
	
			// Make the query.
			$query = "UPDATE customer SET customer_name='$customer_name', customer_phone='$customer_phone', address='$address' WHERE customer_id = $id";
			$result = @mysqli_query ($dbc, $query); // Run the query.
			if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { // If it ran OK.
			
				// Print a message.
				echo '<h1 id="mainhead">Edit a Customer</h1>
				<p>The customer record has been edited.</p><p><br /><br /></p>';	
							
			} else { // If it did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The product could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
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

// Retrieve the products's information.
$query = "SELECT * FROM customer WHERE customer_id = $id ";		
$result = @mysqli_query ($dbc, $query); // Run the query.

if (mysqli_num_rows($result) == 1) { // Valid movie ID, show the form.

	// Get the movie's information.
	$row = @mysqli_fetch_array ($result, MYSQL_NUM);
	// Create the form.
//var_dump($row);
echo '<h2>Edit Customer</h2>
<form action="edit_customer.php" method="post">

<p>Customer Name: <input type="text" name="customer_name" size="30" maxlength="30" value="' . $row[1] . '" required="required" /></p>';


echo '<p> Customer Phone:<input id="customer_phone" name="customer_phone" type ="tel" pattern="\d{3}\d{3}\d{4}" title="Phone Number (Format: 9999999999)" value="';
	if (isset($customer_phone)) {
		echo $customer_phone;
	}
	else{	
		echo $row[2];
	}

echo '" required="required"/></p>';

echo '<p>Address: <textarea required="required" name="address" id="address" rows="2" cols="50" value="' . $row[3] . '" >' . $row[3] . '</textarea></p>';

echo '
<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="id" value="' . $id . '" />
<p><input type="submit" name="submit" value="Submit" /></p>
</form>
';

} else { // Not a valid customer ID.
	echo '<h1 id="mainhead">Page Error</h1>
	<p class="error">This page has been accessed in error. Not a valid customer ID.</p><p><br /><br /></p>';
}

@mysqli_close($dbc); // Close the database connection.
		
?>