<?php # view_accessories.php

$page_title = 'View All Accessories';
// Page header.
echo '<h1 id="mainhead" align="center">All Accessories:</h1>';
include ('mysqli_connect.php');
// Number of records to show per page:
$display = 5;
// Determine how many pages there are. 
if (isset($_GET['np'])) { // Already been determined.
	$num_pages = $_GET['np'];
} else { // Need to determine.
 	// Count the number of records
 	$query = "SELECT COUNT(*) FROM accessories ORDER BY accessory_id ASC";
	$result = @mysqli_query ($dbc, $query);
	$row = @mysqli_fetch_array ($result, MYSQL_NUM);
	$num_records = $row[0];
	// Calculate the number of pages.
	if ($num_records > $display) { // More than 1 page.
		$num_pages = ceil ($num_records/$display);	
	} else {
		$num_pages = 1;
		echo $num_pages;
	}

} // End of np IF.


// Determine where in the database to start returning results.
if (isset($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}

// Default column links.
$link0 = "{$_SERVER['PHP_SELF']}?sort=i_a";
$link1 = "{$_SERVER['PHP_SELF']}?sort=n_a";
$link2 = "{$_SERVER['PHP_SELF']}?sort=d_a";
$link3 = "{$_SERVER['PHP_SELF']}?sort=pr_a";
	
// Determine the sorting order.
if (isset($_GET['sort'])) {

	// Use existing sorting order.
	switch ($_GET['sort']) {
		case 'i_a':
			$order_by = 'accessory_id ASC';
			$link0 = "{$_SERVER['PHP_SELF']}?sort=i_d";
			break;
		case 'i_d':
			$order_by = 'accessory_id DESC';
			$link0 = "{$_SERVER['PHP_SELF']}?sort=i_a";
			break;
		case 'n_a':
			$order_by = 'accessory_name ASC';
			$link1 = "{$_SERVER['PHP_SELF']}?sort=n_d";
			break;
		case 'n_d':
			$order_by = 'accessory_name DESC';
			$link1 = "{$_SERVER['PHP_SELF']}?sort=n_a";
			break;
		case 'd_a':
			$order_by = 'details ASC';
			$link2 = "{$_SERVER['PHP_SELF']}?sort=d_d";
			break;
		case 'd_d':
			$order_by = 'details DESC';
			$link2 = "{$_SERVER['PHP_SELF']}?sort=d_a";
			break;
		case 'pr_a':
			$order_by = 'price ASC';
			$link5 = "{$_SERVER['PHP_SELF']}?sort=pr_d";
			break;
		case 'pr_d':
			$order_by = 'price DESC';
			$link5 = "{$_SERVER['PHP_SELF']}?sort=pr_a";
			break;
		default:
			$order_by = 'accessory_id ASC';
			break;
		
	}

	// $sort will be appended to the pagination links.
	$sort = $_GET['sort'];
	
} else { // Use the default sorting order.
	$order_by = 'accessory_id ASC';
	$sort = 'i_a';
}

// Make the query.
$query = "SELECT accessory_id, accessory_name, accessories.details,price FROM accessories, Product WHERE accessories.accessory_id = Product.Product_id ORDER BY $order_by LIMIT $start, $display";

$result = @mysqli_query ($dbc, $query); // Run the query.

// Table header.
echo "<p align='center'><b>Ordered by $order_by </b></p>";
echo '<table align="center" cellspacing="0" cellpadding="5">
<tr>
	<td align="left"><b>Edit</b></td>
	<td align="left"><b><a href="' . $link0 . '">Accessory id</a></b></td>
	<td align="left"><b><a href="' . $link1 . '">Accessory Name</a></b></td>
	<td align="left"><b><a href="' . $link2 . '">Details</a></b></td>
	<td align="left"><b><a href="' . $link3 . '"> Price </a></b></td>					
</tr>
';

$query = "SELECT accessory_id, accessory_name, accessories.details,price FROM accessories, Product WHERE accessories.accessory_id = Product.Product_id ORDER BY $order_by LIMIT $start, $display";

$result = @mysqli_query ($dbc, $query); // Run the query

// Fetch and print all the records.
$bg = '#eeeeee'; // Set the background color.
while ($row = @mysqli_fetch_array($result, MYSQL_ASSOC)) {
	
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the background color.
	echo '<tr bgcolor="' . $bg . '">
		<td align="left"><a href="edit_accessories.php?id=' . $row['accessory_id'] . '">Edit</a></td>		
		<td align="left">' . $row['accessory_id'] . '</td>
		<td align="left">' . $row['accessory_name'] . ' </td>
		<td align="left">' . $row['details'] . '</td>
		<td align="left">' . $row['price'] . '</td>
	</tr>
	';
	
}

echo '</table>';

//@mysqli_free_result ($result); // Free up the resources.	

//@mysqli_close($dbc); // Close the database connection.
//echo $num_pages;
// Make the links to other pages, if necessary.
if ($num_pages > 1) {
	
	echo '<br /><p align="center">';
	// Determine what page the script is on.	
	$current_page = ($start/$display) + 1;
	
	// If it's not the first page, make a First button and a Previous button.
	if ($current_page != 1) {
		echo '<a href="view_accessories.php?s=0&np=' . $num_pages . '&sort=' . $sort .'">First</a> ';
		echo '<a href="view_accessories.php?s=' . ($start - $display) . '&np=' . $num_pages . '&sort=' . $sort .'">Previous</a> ';
	}
	
	// Make all the numbered pages.
	for ($i = 1; $i <= $num_pages; $i++) {
		if ($i != $current_page) {
			echo '<a href="view_accessories.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '&sort=' . $sort .'">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	}
	
	// If it's not the last page, make a Last button and a Next button.
	if ($current_page != $num_pages) {
		echo '<a href="view_accessories.php?s=' . ($start + $display) . '&np=' . $num_pages . '&sort=' . $sort .'">Next</a> ';
		echo '<a href="view_accessories.php?s=' . (($num_pages-1) * $display) . '&np=' . $num_pages . '&sort=' . $sort .'">Last</a>';

	}
	
	echo '</p>';
	
} // End of links section.

$query_sub = "SELECT COUNT(Product_id) FROM Product WHERE description ='accessories' AND Product_id  NOT IN (select accessory_id FROM accessories) ";
$result_sub = @mysqli_query ($dbc, $query_sub);
$row = @mysqli_fetch_array ($result_sub, MYSQL_NUM);
$num_pro = $row[0];
if ($num_pro > 0) {
	echo "<p align='center'><b>You have ".$num_pro." pending products to insert in accessories table. Please Click the link below to do so.</b></p>";
	# code...
	echo '<p align="center"><a href="add_accessories.php">Add a new accessory</a></p>';
}
else{
	echo "<p align='center'><b>You do not have any pending products to insert in accessories table.</b></p>";
}
//while ($row_sub = mysqli_fetch_array($result_sub, MYSQL_ASSOC))


@mysqli_free_result ($result); // Free up the resources.	
@mysqli_close($dbc); // Close the database connection.
?>


