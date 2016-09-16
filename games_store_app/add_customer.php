<?php # add_customer.php

$page_title = 'Add Customer';

include ('mysqli_connect.php');

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
	
		
	if (empty($errors)) { // If everything's okay.
	
		// Add the movie to the database.
		
		// Make the query.
		$query = "INSERT INTO customer (customer_name, customer_phone, address) VALUES ('$customer_name', '$customer_phone', '$address')";		
		$result = @mysqli_query ($dbc, $query); // Run the query.
		if ($result) { // If it ran OK.
		
			// Print a message.
			echo '<h1 id="mainhead">Success!</h1>
		<p>You have added:</p>';

		   echo "<table>
		<tr><td>Customer Name:</td><td>{$customer_name}</td></tr>
		<tr><td>Customer Phone:</td><td>{$customer_phone}</td></tr>
		<tr><td>Address:</td><td>{$address}</td></tr>
		</table>";

		$customer_id = mysqli_insert_id($dbc); // Retrieve the id number of the newly added record

		//exit();
			
		} else { // If it did not run OK.
			echo '<h1 id="mainhead">System Error</h1>
			<p class="error">The customer could not be added due to a system error. We apologize for any inconvenience.</p>'; // Public message.
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
 //if (isset($_POST['description'])) $this_description=$_POST['description'];
 ?>
<h2>Add Customer</h2>
<form action="add_customer.php" method="post">
	<p>Customer Name: <input type="text" name="customer_name" size="30" maxlength="30" value="<?php if (isset($_POST['customer_name'])) echo $_POST['customer_name']; ?>" required="required"/></p>
	
<?php 
echo '<p> Customer Phone:<input id="customer_phone" name="customer_phone" type ="tel" pattern="\d{3}\d{3}\d{4}" title="Phone Number (Format: 9999999999)" value="';
	if (isset($_POST['customer_phone'])) {
		echo $_POST['customer_phone'];
	}
	
echo '" required="required"/></p>';

//echo '<p>Address: <textarea required="required" name="address" id="address" rows="2" cols="50" value="' . $_POST['address'])) {
echo '<p>Address: <textarea required="required" name="address" id="address" rows="2" cols="50" value ="';
if (isset($_POST['address'])) {
		echo $_POST['address'];
	}
echo '" required="required">';
if (isset($_POST['address'])) {
		echo $_POST['address'];
	}
echo '</textarea></p>';
@mysqli_close($dbc); // Close the database connection.
?>

	<p><input type="submit" name="submit" value="Add Customer" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
</form>
