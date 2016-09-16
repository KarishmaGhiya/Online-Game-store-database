<?php # delete_customer.php

// This page deletes a customer
// This page is accessed through view_customers.php.

$page_title = 'Delete a customer';

// Check for a valid customer ID, through GET or POST.
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // Accessed through view_customers.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form has been submitted.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<h1 id="mainhead">Page Error</h1>
	<p class="error">This page has been accessed in error.</p><p><br /><br /></p>';
	include ('./includes/footer.html'); 
	exit();
}

include ('mysqli_connect.php'); // Connect to the db.

// Check if the form has been submitted.
if (isset($_POST['submitted'])) {

	if ($_POST['sure'] == 'Yes') { // Delete them.

		// Make the query.
	   $query = "SELECT customer_id, customer_name,customer_phone, address FROM customer WHERE customer_id=$id";		
	   $result = @mysqli_query ($dbc, $query); // Run the query.
	
	   if (mysqli_num_rows($result) == 1) { // Valid product ID, show the result.

		// Get the product information.
		$row = @mysqli_fetch_array ($result, MYSQL_NUM);	
		
		$query_del = "DELETE FROM customer WHERE customer_id=$id";		
		$result_del = @mysqli_query ($dbc, $query_del); // Run the query.

		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.


		// Get the customer information.
		$row_del = @mysqli_fetch_array ($result_del, MYSQL_NUM);
		//$row_del returns NULL
		// customer information is in $row
		// Create the result page.
		echo '<h1 id="mainhead">Delete a customer</h1>
		<p>The customer <b>'.$row[1].'</b> with id <b>'.$row[0].'</b> who has phone: <b>'.$row[2].' </b> and address <b>'.$row[3].'</b> has been deleted.</p><p><br /><br /></p>';	
	} else { // Did not run OK.
			echo '<h1 id="mainhead">System Error</h1>
			<p class="error">The requested customer could not be deleted due to a system error.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' .
			$query_del . '</p>'; // Debugging message.
	}


	}		
	 else { // Not a valid customer ID.
					echo '<h1 id="mainhead">Page Error</h1>
		<p class="error">This page has been accessed in error.</p><p><br /><br /></p>';
		} //End of else.
	
	} // End of $_POST['sure'] == 'Yes' if().
	else { // Wasn't sure about deleting the customer.
		echo '<h1 id="mainhead">Delete a Customer</h1>';

	$query = "SELECT * FROM customer WHERE customer_id=$id";		
	$result = @mysqli_query ($dbc, $query); // Run the query.
	
	if (mysqli_num_rows($result) == 1) { // Valid customer ID, show the result.

		// Get the customer information.
		$row = mysqli_fetch_array ($result, MYSQL_NUM);
		
		// Create the result page.
  echo'
		<p>The customer <b>#'.$row[0].'</b> named  <b>'.$row[1].'</b> has NOT been deleted.</p><p><br /><br /></p>';	
	} else { // Not a valid customer ID.
		echo '<h1 id="mainhead">Page Error</h1>
		<p class="error">This page has been accessed in error.</p><p><br /><br /></p>';
	}


} // End of wasn’t sure else().

} // End of main submit conditional.

else { // Show the form.

	// Retrieve the customer's information.
	$query = "SELECT * FROM customer WHERE customer_id=$id";		
	$result = @mysqli_query ($dbc, $query); // Run the query.
	
	if (mysqli_num_rows($result) == 1) { // Valid customer ID, show the form.

		// Get the customer information.
		$row = @mysqli_fetch_array ($result, MYSQL_NUM);
		
		// Draw the form.
		echo '<h2>Delete a Customer</h2>
	<form action="delete_customer.php" method="post">
	<h3>ID: '.$row[0].'</h3>
	<h3>Name: ' . $row[1] . '</h3>
	<h3>Phone: ' . $row[2] .'</h3>
	<h3>Address: ' . $row[3] . '</h3>

	<p>Are you sure you want to delete this customer?<br />
	<input type="radio" name="sure" value="Yes" /> Yes 
	<input type="radio" name="sure" value="No" checked="checked" /> No</p>
	<p><input type="submit" name="submit" value="Submit" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
	<input type="hidden" name="id" value="' . $id . '" />
	</form>';
	
	} //End of valid customer ID if().
	else { // Not a valid customer ID.
		echo '<h1 id="mainhead">Page Error</h1>
		<p class="error">This page has been accessed in error.</p><p><br /><br /></p>';
	}

} // End of the main Submit conditional.

@mysqli_close($dbc); // Close the database connection.

?>