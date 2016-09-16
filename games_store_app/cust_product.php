<html>
  <head>
   <?php

     $cssFile = "style.css";
     echo "<link rel='stylesheet' href='" . $cssFile . "'>";


   ?>
   </head>
   
</html>

<?php 
$page_title = 'Please select a customer and product';
include ('mysqli_connect.php');
// Check if the form has been submitted.
if (isset($_POST['customer']) && ($_POST['product'])) {

	// Check for the customer & product
		$cust_id = $_POST['customer'];
		$product_id = $_POST['product'];		

$query_1="SELECT order_id, date_order, pro_name, product_count,customer_name,order_status, customer_id,product FROM customer_orders, Product,customer WHERE customer_orders.product = Product.Product_id AND customer_orders.customer = customer.customer_id AND customer.customer_id =$cust_id AND customer_orders.product = $product_id ORDER BY date_order DESC, pro_name ASC, customer_name ASC";

$result_1 = @mysqli_query ($dbc, $query_1); // Run the query.	
		if ($result_1) { // If it ran OK.		
			
echo "<p style='font-style:italic;'></br><b><u>Orders of Selected Customer for selected Product :</u></b></p>";
echo '<table style="border:1px solid black;"><tr><td>Order id &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> <td>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> <td> Product</td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> <td> Product Count</td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> <td> Customer</td>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> <td> Order Status</td></tr>';
          
          if($result_1->num_rows == 0 )
          {
          	echo "<tr><td colspan='6' align='center'>No results for this combination</td></tr>";
          }
			while($row= @mysqli_fetch_array($result_1, MYSQL_ASSOC))
			{
				echo "<tr><td> <b>" . $row['order_id']. "</b></td>". 
				"<td><b> " . $row['date_order']. "</b></td>". 
				"<td> <b>" . $row['pro_name']."</b></td>".
				"<td> <b>" . $row['product_count']."</b></td>".
				"<td> <b>" . $row['customer_name']."</b></td>".
				"<td> <b>" . $row['order_status']."</b></td></tr>";				
			}			
		    	echo '</table></br>';
										
		} 
		else { // If it did not run OK.
			echo '<h1 id="mainhead">System Error</h1>
			<p class="error">Your query could not run due to a system error. We apologize for any inconvenience.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query_1 . '</p>'; // Debugging message.
			exit();
		}
	} // End of the main Submit conditional.

echo '<h2>Please select a customer and product</h2>
<form action="cust_product.php" method="POST">
	<p>Customer: <select name="customer">';
	
	// Build the query
$query = "SELECT customer_id, customer_name FROM customer ORDER BY customer_name";
$result = @mysqli_query ($dbc, $query);

while ($row = mysqli_fetch_array($result, MYSQL_ASSOC))
{

	if ($row['customer_id']==$cust_id)
	{
	echo'<option value="'.$row['customer_id'].'" selected="selected">'.$row['customer_name'].'</option>';	
	}
	else
	{
	echo'<option value="'.$row['customer_id'].'" >'.$row['customer_name'].'</option>';
	
	}

}	
echo '</select>	
	Product: 	
	<select name="product">';
	
	// Build the query
$query1 = "SELECT Product_id, pro_name FROM Product ORDER BY pro_name";
$result1 = @mysqli_query ($dbc, $query1);

while ($row = @mysqli_fetch_array($result1, MYSQL_ASSOC))
{
	if ($row['Product_id']==$product_id)
	{
	echo'<option value="'.$row['Product_id'].'"selected="selected">'.$row['pro_name'].'  #'.$row['Product_id'].
	'</option>';	
	}
	else
	{
		echo'<option value="'.$row['Product_id'].'">'.$row['pro_name'].' #'.$row['Product_id'].
	'</option>';
	
	}	
}
echo '</select></p>';	
echo '<p><input type="submit" name="submit" value="List Orders" />
</p><input type="hidden" name="submitted" value="TRUE" />
</form>';
?>