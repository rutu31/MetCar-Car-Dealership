<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!-- 
	THIS FILE SHOWS THE LIST OF CURRENT SERVICE CONTRACTS 
-->
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
<title>MetCar List of Service Contracts</title>
	<link rel="stylesheet" type="text/css" href="MetCarCSS.css" />
</head>

<body>

	<!-- CREATE DATABASE CONNECTION -->
	<?php 	
		$db_conn = @mysql_connect("localhost", "root", "");
		if(! $db_conn) {
			echo ("Unable to connect to database.");
			exit();
		}
		
		$db = @mysql_select_db("MetCar",$db_conn);
		if(!$db) {
			echo ("Unable to open tootie database");
			exit();
		}	
	?>
	
	<div class="main_menu_link">
		<a href="MetCarHome.html">Main menu</a>
	</div>
	
	<div class="customer_invoice">
	<fieldset>
		<legend><span style="color: white">List of all Current Service Contracts</span></legend>
		
		<!-- DISPLAY SERVICE CONTRACTS LIST IN TABULAR FORMAT -->
		
		<div class="service_contract">
		<table border="1" cellspacing="2" cellpadding="2">
			<tr><th><h3>Service Contract Id</h3></th><th><h3>Car Licence No.</h3></th><th><h3>Car Model</h3></th><th><h3>Amount Paid</h3></th><th><h3>Contract End Date</h3></th></tr>
			<?php 
				$sql = "select * from service_contract where end_date >= CURDATE()";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)){
					$carLicence = $row['car_licence'];
					$sql1 = "select * from car where licence_no = '".$carLicence."'";
					$result1 = mysql_query($sql1);
					$row1 = mysql_fetch_array($result1);
			?>
			<tr>
			<td><?php echo $row['contract_id']?></td>
			<td><?php echo $row['car_licence']?></td>
			<td><?php echo $row1['car_model']?></td>
			<td><?php echo '$ '; echo $row['amount']?></td>
			<td><?php echo $row['end_date']?></td>
			</tr>
			<?php }?>
			
		</table>	
		</div>	
	
	</fieldset>	
	</div>
	
	<?php mysql_close($db_conn);?>
</body>
</html>