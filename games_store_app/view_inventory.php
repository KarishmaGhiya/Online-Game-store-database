<?php # view_inventory.php

$page_title = 'View Inventory';

// Page header.
echo '<h1 id="mainhead">Inventory for current Product:</h1>';
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // Accessed through view_movies.php
	$id = $_GET['id'];

} else { // No valid ID, kill the script.
	echo '<h1 id="mainhead">Page Error</h1>
	<p class="error">This page has been accessed in error.</p><p><br /><br /></p>';
	exit();
}
include ('mysqli_connect.php');

 	// Count the number of records
	$query = "SELECT * FROM Product_inventory where Product_id=$id";
// Make the query.
		
$result = @mysqli_query ($dbc, $query); // Run the query.

$row = @mysqli_fetch_array($result, MYSQL_ASSOC);
// Table header.
//if($row[])
echo "<p><b>Number of products: &nbsp;". intval($row['product_count'])."</b></p> ";
 //$row['Product_id']
echo'<p><a href="update_inventory.php?id=' . $id . '">Update Inventory</a></p>';
// Fetch and print all the records.
@mysqli_free_result ($result); // Free up the resources.	

@mysqli_close($dbc); // Close the database connection.

?>


