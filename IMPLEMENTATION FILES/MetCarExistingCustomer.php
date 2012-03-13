
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<!-- 
	THIS FILE ACCEPTS CUSTOMER PHONE NUMBER AND HIS CAR MODEL FOR CREATING A BILL FOR THAT CAR'S REPAIR JOB. 
--> 
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
<title>MetCar Existing Customer</title>
	<link rel="stylesheet" type="text/css" href="MetCarCSS.css" />

	<?php 

		// CREATE DATABASE CONNECTION
		
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
</head>

<body>
	<div class="main_menu_link">
		<a href="MetCarHome.html">Main menu</a>
	</div>
	
	<!-- FORM ACCEPTING CUSTOMER PHONE NUMBER AND CAR MODEL FOR BILL CREATION -->
	
	<form name="cust_bill" method="post" action="MetCarBill.php">
		<div class="bill">
		<fieldset>
		<legend><span style="color: white">Create Customer Bill</span></legend>
			Customer Day-Phone No. <input type="text" name="bill_Phone" id="bill_Phone" /><br /><br />
			Car Model <input type="text" name="car_model" id="car_model" /><br /><br />
			<input type="submit" value="Create Bill"></input>
		</fieldset>
		</div>
	</form>
	
	
	<?php mysql_close($db_conn);?>
</body>
</html>