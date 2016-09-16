<?php # add_product.php

$page_title = 'Add Product';

include ('mysqli_connect.php');

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
		
		
	if (empty($errors)) { // If everything's okay.
	
		// Add the movie to the database.
		
		// Make the query.
		$query = "INSERT INTO Product (description, pro_name, price) VALUES ('$description', '$name', '$price')";		
		$result = @mysqli_query ($dbc, $query); // Run the query.
		if ($result) { // If it ran OK.
		
			// Print a message.
			echo '<h1 id="mainhead">Success!</h1>
		<p>You have added:</p>';

		   echo "<table>
		<tr><td>Name:</td><td>{$name}</td></tr>
		<tr><td>Description:</td><td>{$description}</td></tr>
		<tr><td>Price:</td><td>{$price}</td></tr>
		</table>";

		$product_id = mysqli_insert_id($dbc); // Retrieve the id number of the newly added record

		//iNVENTORY should also be updated with a record of this product, 
		//so add entry to inventory with count 0
		$query_inv = "INSERT INTO Product_inventory (Product_id, product_count) VALUES ('$product_id', 0)";		
		$result_inv = @mysqli_query ($dbc, $query_inv); // Run the query.
		if ($result_inv) { // If it ran OK.
			echo '<h1 id="mainhead">Success!</h1>
					<p>Inventory record has also been created:</p>';

		   	echo "<table>
					<tr><td>Product Id:</td><td>{$product_id}</td></tr>
					<tr><td>Product Count:</td><td>{0}</td></tr>
					</table>";
			echo "<p><b>Don't forget to update the inventory for the newly added product!</b></p>";
		}
		else{
			echo '<h1 id="mainhead">System Error</h1>
			<p class="error">The product could not be added to the inventory due to a system error. We apologize for any inconvenience.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . 
			$query_inv . '</p>'; // Debugging message.
			

		}

		echo'<a href="update_inventory.php?id=' . $product_id . '">Update inventory for this product</a>';
		
			
		} else { // If it did not run OK.
			echo '<h1 id="mainhead">System Error</h1>
			<p class="error">The product could not be added due to a system error. We apologize for any inconvenience.</p>'; // Public message.
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
 if (isset($_POST['description'])) $this_description=$_POST['description'];
 echo '<h2>Add Product</h2>
<form action="add_product.php" method="post">
	<p>Product Name: <input type="text" name="name" size="35" maxlength="35" value="';
 if (isset($_POST['name'])) echo $_POST['name'];
 echo '" required="required"/></p>';
 echo '<p>Description: <select name="description">';
// Build the query
$description_options = ['games','console','accessories'];
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
@mysqli_close($dbc); // Close the database connection.
echo '<p><input type="submit" name="submit" value="Add Product" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
</form>';
?>
