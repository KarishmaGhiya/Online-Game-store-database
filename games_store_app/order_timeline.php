<html>
  <head>
   <?php

     $cssFile = "style.css";
     echo "<link rel='stylesheet' href='" . $cssFile . "'>";
     
   ?>
   </head>
   
</html>

<?php 
$page_title = 'Please select date range for listing orders';
include ('mysqli_connect.php');
// Check if the form has been submitted.
if (isset($_POST['from']) && ($_POST['to'])) {

	
		$from = $_POST['from'];
		$to = $_POST['to'];		
if (date($from) <= date($to)){
$query_1="SELECT order_id, date_order, pro_name, product_count,customer_name,order_status, customer_id,product FROM customer_orders, Product,customer WHERE customer_orders.product = Product.Product_id AND customer_orders.customer = customer.customer_id  AND customer_orders.date_order <= '$to' AND customer_orders.date_order >= '$from' ORDER BY date_order DESC, pro_name ASC, customer_name ASC";

$result_1 = @mysqli_query ($dbc, $query_1); // Run the query.	
		if ($result_1) { // If it ran OK.		
			
echo "<p style='font-style:italic;'></br><b><u>Orders for Selected Timeline :</u></b></p>";
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
	 }//check from <= to
	 else{
	 	echo '<h1 id="mainhead">Input Date Error</h1>
			<p class="error">From date is greater than To date.This is invalid. Please Go back and change your selection.</p>'; // Public message.
			//echo '<p>' . mysqli_error($dbc) . '<br /><br /></p>'; // Debugging message.
			exit();
	 }
	} // End of the main Submit conditional.

echo '<h2>Please select date range for listing orders</h2>
<form action="order_timeline.php" method="POST">';
?>

<p>From Date: <input type="date" name="from" value="<?php if (isset($_POST['from'])) echo $_POST['from']; ?>" required="required"/></p>
<p>To Date: <input type="date" name="to" value="<?php if (isset($_POST['to'])) echo $_POST['to']; ?>" required="required"/></p>

<?php	
	// Build the query

	
	// Build the query
	
echo '<p><input type="submit" name="submit" value="List Orders" />
</p><input type="hidden" name="submitted" value="TRUE" />
</form>';
?>