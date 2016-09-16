<?php # Script : edit_orders.php

// This page edits a order.
// This page is accessed through view_orders.php.

$page_title = 'Edit an order';

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
	
	// Check for date
	if (empty($_POST['date_order'])) {
		$errors[] = 'You forgot to enter the date when order was placed.';
	} else {
		$date_order = $_POST['date_order'];
	}
	
	// Check for the product.
	if (empty($_POST['product'])) {
		$errors[] = 'You forgot to select the product.';
	} else {
		$product = $_POST['product'];
	}
	
	// Check for product count.
	if (empty($_POST['product_count'])) {
		$errors[] = 'You forgot to enter the quantity of the product ordered.';
	} else {
		$product_count = $_POST['product_count'];
	}
	// Check for customer.
	if (empty($_POST['customer'])) {
		$errors[] = 'You forgot to select the customer.';
	} else {
		$customer = $_POST['customer'];
	}
	// Check for order status.
	if (empty($_POST['order_status'])) {
		$errors[] = 'You forgot to select the order status.';
	} else {
		$order_status = $_POST['order_status'];
	}
	
	if (empty($errors)) { // If everything's OK.
		$query_check = "SELECT * FROM Product_inventory WHERE Product_id = $product";
		$result_check = @mysqli_query ($dbc, $query_check); // Run the query.
		if(@mysqli_num_rows($result_check) == 1){
				$row = @mysqli_fetch_array($result_check, MYSQL_ASSOC);
	   	//var_dump($row);
	   		if(intval($row['product_count']) < intval($product_count)){
	   			echo "Error: The requested order is more than the availability. There are only ".$row['product_count']." items/pieces available for this product. Place your order accordingly!";
	   		}
	   		else{
	 			//Update
	 			// Make the query.
			$query = "UPDATE customer_orders SET date_order='$date_order', product=$product, product_count=$product_count, customer = $customer, order_status='$order_status' WHERE order_id = $id";
			$result = @mysqli_query ($dbc, $query); // Run the query.
			if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { // If it ran OK.
			
				// Print a message.
				echo '<h1 id="mainhead">Edit an Order</h1>
				<p>The Customer Order record has been edited.</p><p><br /><br /></p>';	
							
			} else { // If it did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The Customer Order record could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>'; // Debugging message.
				exit();
			}



	   		}
		}
		else{
			echo '<h1 id="mainhead">System Error</h1>
						<p class="error">The requested product for the respective order could not be found due to a system error. We apologize for any inconvenience.</p>'; // Public message.
					echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query_check . '</p>'; // Debugging message.
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

// Retrieve the customer_orders's information.
//$query = "SELECT * FROM customer_orders WHERE order_id = $id ";		
$query = "SELECT order_id,date_order, product,product_count,customer,order_status,pro_name,customer_name FROM customer_orders,Product,customer WHERE customer_orders.customer=customer.customer_id AND customer_orders.product=Product.Product_id AND customer_orders.order_id = $id ";
$result = @mysqli_query ($dbc, $query); // Run the query.

if (mysqli_num_rows($result) == 1) { // Valid movie ID, show the form.

	// Get the movie's information.
	$row = mysqli_fetch_array ($result, MYSQL_NUM);
	$this_order_status=$row[5];
	$this_product_id=$row[2];
	$this_customer_id=$row[4];
	// Create the form.


echo '
<form action="edit_orders.php" method="post">

<p>Order Date: <input type="date" name="date_order" value="' . $row[1] . '" required="required"/></p>';
echo '<p>Product: <select name="product">';
// product drop-down
$query_sub = "SELECT * FROM Product";
$result_sub = @mysqli_query ($dbc, $query_sub);

while ($row_sub = mysqli_fetch_array($result_sub, MYSQL_ASSOC))
{
	if ($row_sub['Product_id'] == $this_product_id) 
	{
		echo '<option value="'.$row_sub['Product_id'].'" selected="selected">'.$row_sub['pro_name'].'</option>';
	}
	else 
	{
		echo '<option 	value="'.$row_sub['Product_id'].'">'.$row_sub['pro_name'].'</option>';
	}
}
echo '</select> </p>';
echo '<p> Product count:<input id="product_count" name="product_count" type ="number" min="0" max="10000" value="';
	if (isset($product_count)) {
		echo $product_count;
	}
	else{	
		echo intval($row[3]);
	}

echo '" required="required"/></p>';

echo '<p>Customer: <select name="customer">';
// customer drop-down
$query_sub = "SELECT * FROM customer";
$result_sub = @mysqli_query ($dbc, $query_sub);

while ($row_sub = mysqli_fetch_array($result_sub, MYSQL_ASSOC))
{
	if ($row_sub['customer_id'] == $this_customer_id) 
	{
		echo '<option value="'.$row_sub['customer_id'].'" 	selected="selected">'.$row_sub['customer_name'].'</option>';
	}
	else 
	{
		echo '<option 	value="'.$row_sub['customer_id'].'">'.$row_sub['customer_name'].'</option>';
	}
}
echo '</select> </p>';

echo '<p>Order Status: <select name="order_status">';
$order_status_options = ['ordered','delivered','aborted'];

foreach ($order_status_options as $os) {
	# code...
	if ($os == $this_order_status) 
	{
		echo '<option value="'.$os.'" selected="selected">' . 	$os . '</option>';
	}
	else 
	{
		echo '<option value="'.$os.'">'. $os . '</option>';
	}   
}
echo '</select> </p>';





echo '
<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="id" value="' . $id . '" />
<p><input type="submit" name="submit" value="Submit" /></p>
</form>
';

} else { // Not a valid order ID.
	echo '<h1 id="mainhead">Page Error</h1>
	<p class="error">This page has been accessed in error. Not a valid order ID.</p><p><br /><br /></p>';
}

@mysqli_close($dbc); // Close the database connection.
		
?>