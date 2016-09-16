<?php # view_products.php

$page_title = 'View Products';

// Page header.
echo '<h1 id="mainhead" align="center">Products currently available in the Game Store:</h1>';

include ('mysqli_connect.php');

// Number of records to show per page:
$display = 5;

// Determine how many pages there are. 
if (isset($_GET['np'])) { // Already been determined.
	$num_pages = $_GET['np'];
} else { // Need to determine.

 	// Count the number of records
	$query = "SELECT COUNT(*) FROM Product ORDER BY pro_name ASC";
	$result = @mysqli_query ($dbc, $query);
	$row = @mysqli_fetch_array ($result, MYSQL_NUM);
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
$link1 = "{$_SERVER['PHP_SELF']}?sort=n_d";
$link2 = "{$_SERVER['PHP_SELF']}?sort=d_a";
$link3 = "{$_SERVER['PHP_SELF']}?sort=p_a";
/*$link4 = "{$_SERVER['PHP_SELF']}?sort=l_a";
$link5 = "{$_SERVER['PHP_SELF']}?sort=y_a";*/

// Determine the sorting order.
if (isset($_GET['sort'])) {

	// Use existing sorting order.
	switch ($_GET['sort']) {
		case 'n_a':
			$order_by = 'pro_name ASC';
			$link1 = "{$_SERVER['PHP_SELF']}?sort=n_d";
			break;
		case 'n_d':
			$order_by = 'pro_name DESC';
			$link1 = "{$_SERVER['PHP_SELF']}?sort=n_a";
			break;
		case 'd_a':
			$order_by = 'description ASC';
			$link2 = "{$_SERVER['PHP_SELF']}?sort=d_d";
			break;
		case 'd_d':
			$order_by = 'description DESC';
			$link2 = "{$_SERVER['PHP_SELF']}?sort=d_a";
			break;
		case 'p_a':
			$order_by = 'price ASC';
			$link3 = "{$_SERVER['PHP_SELF']}?sort=p_d";
			break;
		case 'p_d':
			$order_by = 'price DESC';
			$link3 = "{$_SERVER['PHP_SELF']}?sort=p_a";
			break;
		/*case 'c_a':
			$order_by = ' ASC';
			$link3 = "{$_SERVER['PHP_SELF']}?sort=c_d";
			break;
		case 'c_d':
			$order_by = ' DESC';
			$link3 = "{$_SERVER['PHP_SELF']}?sort=c_a";
			break;*/
		default:
			$order_by = 'pro_name ASC';
			break;
	}
	
	// $sort will be appended to the pagination links.
	$sort = $_GET['sort'];
	
} else { // Use the default sorting order.
	$order_by = 'pro_name ASC';
	$sort = 't_a';
}

// Make the query.
$query = "SELECT Product_id, description, pro_name, price FROM Product
ORDER BY $order_by LIMIT $start, $display";		
$result = @mysqli_query ($dbc, $query); // Run the query.
//echo $result;
// Table header.
echo "<p align='center'><b>Ordered by $order_by </b></p>";
echo '<table align="center" cellspacing="0" cellpadding="5">
<tr>
	<td align="left"><b>Edit</b></td>
	<td align="left"><b>Delete</b></td>
	<td align="left"><b><a href="' . $link2 . '">Description </a></b></td>
	<td align="left"><b><a href="' . $link1 . '">Product name</a></b></td>
	<td align="left"><b><a href="' . $link3 . '">Price</a></b></td>
	
</tr>
';


// Fetch and print all the records.
$bg = '#eeeeee'; // Set the background color.
while ($row = @mysqli_fetch_array($result, MYSQL_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the background color.
	
	echo '<tr bgcolor="' . $bg . '">
		<td align="left"><a href="edit_product.php?id=' . $row['Product_id'] . '">Edit</a></td>
		<td align="left"><a href="delete_product.php?id=' . $row['Product_id'] . '">Delete</a></td>
		<td align="left">' . $row['description'] . '</td>
		<td align="left">' . $row['pro_name'] .'</td>
		<td align="left">' . $row['price'] . '</td>
				<td align="left"><a href="view_orders.php?id=' . $row['Product_id'] . '">View Orders</a></td>
		<td align="left"><a href="view_inventory.php?id=' . $row['Product_id'] . '">View Availability</a></td>

	</tr>
	';
}

echo '</table>';

@mysqli_free_result ($result); // Free up the resources.	

@mysqli_close($dbc); // Close the database connection.

// Make the links to other pages, if necessary.
if ($num_pages > 1) {
	
	echo '<br /><p align="center">';
	// Determine what page the script is on.	
	$current_page = ($start/$display) + 1;
	
	// If it's not the first page, make a First button and a Previous button.
	if ($current_page != 1) {
		echo '<a href="view_products.php?s=0&np=' . $num_pages . '&sort=' . $sort .'">First</a> ';
		echo '<a href="view_products.php?s=' . ($start - $display) . '&np=' . $num_pages . '&sort=' . $sort .'">Previous</a> ';
	}
	
	// Make all the numbered pages.
	for ($i = 1; $i <= $num_pages; $i++) {
		if ($i != $current_page) {
			echo '<a href="view_products.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '&sort=' . $sort .'">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	}
	
	// If it's not the last page, make a Last button and a Next button.
	if ($current_page != $num_pages) {
		echo '<a href="view_products.php?s=' . ($start + $display) . '&np=' . $num_pages . '&sort=' . $sort .'">Next</a> ';
		echo '<a href="view_products.php?s=' . (($num_pages-1) * $display) . '&np=' . $num_pages . '&sort=' . $sort .'">Last</a>';

	}
	
	echo '</p>';
	echo "<p align='center'>";
	echo "<h2>Product Categories:</h2>";
	echo "<ul><li><a href='view_games.php'>Games</a></li>";
	echo "<li><a href='view_accessories.php'>Accessories</a></li>";
	echo "<li><a href='view_consoles.php'>Consoles</a></li>";
	echo "</p>";
	
} // End of links section.

?>


