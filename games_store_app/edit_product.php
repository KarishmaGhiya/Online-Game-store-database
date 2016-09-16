<?php # Script : edit_product.php

// This page edits a product.
// This page is accessed through view_products.php.

$page_title = 'Edit a Product';

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
	if (empty($_POST['name'])) {
		$errors[] = 'You forgot to enter the name of the product.';
	} else {
		$name = $_POST['name'];
	}
	
	// Check for the price.
	if (empty($_POST['price'])) {
		$errors[] = 'You forgot to enter the price of the product.';
	} else {
		$price = $_POST['price'];
	}
	
	// Check for a description.
	if (empty($_POST['description'])) {
		$errors[] = 'You forgot to enter the description of the product.';
	} else {
		$description = $_POST['description'];
	}
	
	if (empty($errors)) { // If everything's OK.
	
			// Make the query.
			$query = "UPDATE Product SET pro_name='$name', description='$description', price=$price WHERE Product_id = $id";
			$result = @mysqli_query ($dbc, $query); // Run the query.
			if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { // If it ran OK.
			
				// Print a message.
				echo '<h1 id="mainhead">Edit a Product</h1>
				<p>The product record has been edited.</p><p><br /><br /></p>';	
							
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
$query = "SELECT * FROM Product WHERE Product_id = $id ";		
$result = @mysqli_query ($dbc, $query); // Run the query.

if (mysqli_num_rows($result) == 1) { // Valid movie ID, show the form.

	// Get the movie's information.
	$row = mysqli_fetch_array ($result, MYSQL_NUM);
	$this_description=$row[2];

	// Create the form.


echo '
<form action="edit_product.php" method="post">

<p>Name: <input type="text" name="name" size="15" maxlength="15" value="' . $row[2] . '" required="required"/></p>';
echo '<p>Description: <select name="description">';
// description drop-down

$description_options = ['games','console','accessories'];
//while ($i < 3)
//{
foreach ($description_options as $des) {
	# code...
	if ($des == $this_description) 
	{
		echo '<option value="'.$des.'" selected="selected">' . 	$des . '</option>';
	}
	else 
	{
		echo '<option value="'.$des.'">'. $des . '</option>';
	}   
}
echo '</select> </p>';

echo '<p> Price:<input id="price" name="price" type ="number" min="0" max="10000" value="';
	if (isset($price)) {
		echo $price;
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
<p><a href="update_inventory.php?id='.$id.'">Update the inventory for this product</a></p>
';

} else { // Not a valid product ID.
	echo '<h1 id="mainhead">Page Error</h1>
	<p class="error">This page has been accessed in error. Not a valid product ID.</p><p><br /><br /></p>';
}

@mysqli_close($dbc); // Close the database connection.		
?>