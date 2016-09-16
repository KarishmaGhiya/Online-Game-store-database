<?php # view_orders.php

$page_title = 'View Orders';

// Page header.
// Check for a valid order ID, through GET.
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // Accessed through view_movies.php
	$id = $_GET['id'];

} 
else 
{ // No valid ID, kill the script.
	echo '<h1 id="mainhead">Page Error</h1>
	<p class="error">This page has been accessed in error.</p><p><br /><br /></p>';
	exit();
}



include ('mysqli_connect.php');

// Number of records to show per page:
$display = 2;
// Determine how many pages there are. 
if (isset($_GET['np'])) { // Already been determined.
	$num_pages = $_GET['np'];
} 
else { // Need to determine.

 	// Count the number of records
	$query = "SELECT COUNT(*) FROM customer_orders WHERE product=$id";
	$result = @mysqli_query ($dbc, $query);
	//echo $query;

	$row = mysqli_fetch_array ($result, MYSQL_NUM);
	$num_records = $row[0];
	
	// Calculate the number of pages.
	if ($num_records > $display) { // More than 1 page.
		$num_pages = ceil ($num_records/$display);
	} else {
		$num_pages = 1;
	}

} // End of np IF.


// Determine where in the database to start returning results.
if (isset($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}

// Default column links.
$link0 = "{$_SERVER['PHP_SELF']}?id=$id&sort=o_a";
$link1 = "{$_SERVER['PHP_SELF']}?id=$id&sort=d_a";
$link2 = "{$_SERVER['PHP_SELF']}?id=$id&sort=pc_d";
$link3 = "{$_SERVER['PHP_SELF']}?id=$id&sort=cn_a";
$link4 = "{$_SERVER['PHP_SELF']}?id=$id&sort=os_a";


// Determine the sorting order.
if (isset($_GET['sort'])) {

	// Use existing sorting order.
	switch ($_GET['sort']) {
		case 'o_a':
			$order_by = 'order_id ASC';
			$link0 = "{$_SERVER['PHP_SELF']}?id=$id&sort=o_d";
			break;
		case 'o_d':
			$order_by = 'order_id DESC';
			$link0 = "{$_SERVER['PHP_SELF']}?id=$id&sort=o_a";
			break;
		case 'd_a':
			$order_by = 'date_order ASC';
			$link1 = "{$_SERVER['PHP_SELF']}?id=$id&sort=d_d";
			break;
		case 'd_d':
			$order_by = 'date_order DESC';
			$link1 = "{$_SERVER['PHP_SELF']}?id=$id&sort=d_a";
			break;
		case 'pc_a':
			$order_by = 'product_count ASC';
			$link2 = "{$_SERVER['PHP_SELF']}?id=$id&sort=pc_d";
			break;
		case 'pc_d':
			$order_by = 'product_count DESC';
			$link2 = "{$_SERVER['PHP_SELF']}?id=$id&sort=pc_a";
			break;
		case 'cn_a':
			$order_by = 'customer_name ASC';
			$link3 = "{$_SERVER['PHP_SELF']}?id=$id&sort=cn_d";
			break;
		case 'cn_d':
			$order_by = 'customer_name DESC';
			$link3 = "{$_SERVER['PHP_SELF']}?id=$id&sort=cn_a";
			break;
		case 'os_a':
			$order_by = 'order_status ASC';
			$link4 = "{$_SERVER['PHP_SELF']}?id=$id&sort=os_d";
			break;
		case 'os_d':
			$order_by = 'order_status DESC';
			$link4 = "{$_SERVER['PHP_SELF']}?id=$id&sort=os_a";
			break;
	}
	
	// $sort will be appended to the pagination links.
	$sort = $_GET['sort'];
	
} else { // Use the default sorting order.
	$order_by = 'order_id ASC';
	$sort = 'o_a';
}

// Make the query.
$query = "SELECT order_id, date_order,product_count, customer_id ,customer_name,order_status,Product FROM customer, customer_orders WHERE customer_orders.product= Product.Product_id AND customer_orders.customer = customer.customer_id AND customer_orders.product=$id ORDER BY $order_by LIMIT $start, $display";		
$result = @mysqli_query ($dbc, $query); // Run the query.

$row = @mysqli_fetch_array($result, MYSQL_ASSOC);

// Page header.
echo '<h1 id="mainhead" align="center">Orders for the selected Product:'. $row['title'] . '</h1>';

// Table header.
echo "<p align='center'>Ordered by $order_by</p>";
echo '<table align="center" cellspacing="0" cellpadding="5">
<tr>
	<td align="left"><b>Edit</b></td>
	<td align="left"><b>Delete</b></td>
	<td align="left"><b><a href="' . $link0 . '">Order id</a></b></td>
	<td align="left"><b><a href="' . $link1 . '">Date</a></b></td>
	<td align="left"><b><a href="' . $link2 . '">Product count</a></b></td>
	<td align="left"><b><a href="' . $link3 . '">Customer name</a></b></td>
	<td align="left"><b><a href="' . $link4 . '"> Order Status</a></b></td>
</tr>
';

// Make the query.
$query = "SELECT order_id, date_order,product_count, customer_id ,customer_name,order_status FROM customer, customer_orders, Product WHERE customer_orders.product= Product.Product_id AND customer_orders.customer = customer.customer_id AND customer_orders.product=$id ";
$result = @mysqli_query ($dbc, $query); // Run the query.

// Fetch and print all the records.
$bg = '#eeeeee'; // Set the background color.
$id = $_GET['id'];
while ($row = @mysqli_fetch_array($result, MYSQL_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the background color.
	$o_id = $row['order_id'];
	echo '<tr bgcolor="' . $bg . '">
		<td align="left"><a href="edit_orders.php?id=' . $o_id. '">Edit</a></td>
		<td align="left"><a href="delete_orders.php?id='.$o_id.'">Delete</a></td>
		<td align="left">' . $row['order_id'] . '</td>
		<td align="left">' . $row['date_order'] . ' </td>
		<td align="left">' . $row['product_count'] . '</td>
		<td align="left">' . $row['customer_name'] . '</td>
		<td align="left">' . $row['order_status'] . '</td>
	</tr>
	';
}

echo '</table>';
if($num_records == 0)
		echo "<p align='center'><b>No orders for this product</b></p>";

@mysqli_free_result ($result); // Free up the resources.	

@mysqli_close($dbc); // Close the database connection.

// Make the links to other pages, if necessary.
if ($num_pages > 1) {
	
	echo '<br /><p>';
	// Determine what page the script is on.	
	$current_page = ($start/$display) + 1;
	
	// If it's not the first page, make a First button and a Previous button.
	if ($current_page != 1) {
		echo '<a href="view_orders.php?s=0&np=' . $num_pages . '&id=' . $id . '&sort=' . $sort .'">First</a> ';
		echo '<a href="view_orders.php?s=' . ($start - $display) . '&np=' . $num_pages . '&id=' . $id . '&sort=' . $sort .'">Previous</a> ';
	}
	
	// Make all the numbered pages.
	for ($i = 1; $i <= $num_pages; $i++) {
		if ($i != $current_page) {
			echo '<a href="view_orders.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '&id=' . $id . '&sort=' . $sort .'">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	}
	
	// If it's not the last page, make a Last button and a Next button.
	if ($current_page != $num_pages) {
		echo '<a href="view_orders.php?s=' . ($start + $display) . '&np=' . $num_pages . '&id=' . $id . '&sort=' . $sort .'">Next</a> ';
		echo '<a href="view_orders.php?s=' . (($num_pages-1) * $display) . '&np=' . $num_pages . '&id=' . $id . '&sort=' . $sort .'">Last</a>';

	}
	
	echo '</p>';
	
} // End of links section.
$id=$_GET["id"];

echo '<p align="center"><a href="add_order.php">Place a new order.</a></p>';

?>





