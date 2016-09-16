<?php # update_inventory.php

$page_title = 'Update Inventory';
//$inventory_Num;
// Page header.
echo '<h1 id="mainhead">Inventory for current Product:</h1>';
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // Accessed through view_inventory.php
	$id = $_GET['id'];

} else { // No valid ID, kill the script.
	echo '<h1 id="mainhead">Page Error</h1>
	<p class="error">This page has been accessed in error.</p><p><br /><br /></p>';
	exit();
}
include ('mysqli_connect.php');
	
if (isset($_POST['inventory']))
{
	
$inventory_Num = intval($_POST['inventory']);

	$query1 = "UPDATE Product_inventory SET product_count=$inventory_Num WHERE Product_id=$id";
	
	$result1 = @mysqli_query ($dbc, $query1); // Run the query.
}

$query = "SELECT * FROM Product_inventory where Product_id=".$id;
	$result = @mysqli_query ($dbc, $query); // Run the query.
	$row = @mysqli_fetch_array($result, MYSQL_ASSOC);

echo("<p><b>Count of this product :");
//echo(intval($row[]));
echo($row["product_count"]);
echo "</b></p>";
echo '<h2>Select number of products in Inventory:</h2>
<form action="update_inventory.php?id=' . $id . '" method="POST">
	<input id="inventory" name="inventory" type ="number" min="0" max="100" value="';
	if (isset($inventory_Num)) {
		echo $inventory_Num;
	}
	else{	
		echo intval($row['product_count']);
	}

echo '"/><br />
<input type="submit" value="Submit">
</form>'; 	

@mysqli_free_result ($result); // Free up the resources.	

@mysqli_close($dbc); // Close the database connection.

?>


