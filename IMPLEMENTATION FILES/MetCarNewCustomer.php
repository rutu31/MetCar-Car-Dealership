
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<!-- 
	THIS IS EMPTY INVOICE FORM WHICH ACCEPTS CUTOMER'S PERSONAL INFO, CAR INFO, REPAIR PROBLEMS, SERVICE CONTRACT INFO,
	 SERVICE FEE, AND SUPERVISOR ASSIGNED TO THE NEW REPAIR JOB 
-->

 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
<title>MetCar Customer Invoice</title>
	<link rel="stylesheet" type="text/css" href="MetCarCSS.css" />
</head>

<body>
	<form id="customer_invoice" class="customer_invoice" method="post" action="Invoice.php">
	
		<!-- CREATE DATABSE CONNECTION -->
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
		
		<!-- MAIN MENU LINK -->
		
		<div class="main_menu_link">
			<a href="MetCarHome.html">Main menu</a>
		</div>
		
		<!-- EMPTY INVOICE FORM -->
		
			<fieldset>
				<legend><span style="color: white">New Customer Invoice</span></legend>
				<div class=customer_invoice">
				<br />
				<fieldset>
					<legend><span style="color: white">Customer Info</span></legend>
					FIRST NAME <input type="text" id="first_name" name="first_name" />
					&nbsp; &nbsp; &nbsp; &nbsp;
					LAST NAME  <input type="text" id="last_name" name="last_name" />
					<br /><br />
					STREET <input type="text" id="street" name="street" />
					&nbsp; &nbsp; &nbsp; &nbsp;
					CITY  <input type="text" id="city" name="city" />
					&nbsp; &nbsp; &nbsp; &nbsp;
					ZIP  <input type="text" id="zip" name="zip" />
					<br /><br />
					WORK PHONE NO <input type="text" id="work_phone" name="work_phone" />
					&nbsp; &nbsp; &nbsp; &nbsp;
					DAY PHONE NO <input type="text" id="day_phone" name="day_phone" />
				</fieldset>
				<br /><br />
				
				<fieldset>
					<legend><span style="color: white">Car Info</span></legend>
					LICENCE NO. <input type="text" id="car_licence" name="car_licence" />
					&nbsp; &nbsp; &nbsp; &nbsp;
					CAR MODEL <input type="text" id="car_model" name="car_model" />
					<br /><br />
					REPAIR PROBLEMS
					<br /> <br />&nbsp;
						<?php 
							$sql = "SELECT * FROM REPAIR_PROBLEM";
							//$count = 0;
							$result = mysql_query($sql);
							//$row = @mysql_fetch_array($result);
							
							while($row = mysql_fetch_array($result)){?>
							<input type="checkbox" name="repair_problem[]" value="<?php echo $row['problem_type']?>" />	
							<?php echo $row['problem_type'] ?>
							<br /> &nbsp;	
							<?php }?>
					<br /><br />
					&nbsp;&nbsp;&nbsp;
					Total Service Fee $ <input type="text" id="service_fee" name="service_fee" />
					<br /><br />

					SERVICE CONTRACT
					<input type="radio" name="service_contract" value="YES" />YES
					<input type="radio" name="service_contract" value="NO" />NO
					&nbsp;&nbsp;&nbsp;
					Contract Amount Paid $ <input type="text" id="contract_amount" name="contract_amount"></input>
					<br /><br />					
				</fieldset>
				<br /><br />
				<fieldset>
					<legend><span style="color: white">Supervisor Assigned</span></legend>
					SUPERVISOR NAME 
					<select name="supervisor_name">
						<?php 
							$sql = "SELECT * FROM SUPERVISOR";
							
							$result = mysql_query($sql);
							//$row = @mysql_fetch_array($result);
							
							while($row = mysql_fetch_array($result)){?>
								<option><?php echo $row['first_name']?></option>	
							<?php }?>
					</select> 
					
				</fieldset>
				
				<div class="cust_submit">
					<input type="submit" id="customer_submit" name="customer_submit"value="Submit" />
				</div>
				<br />
				</div>		
			</fieldset>
			<?php mysql_close($db_conn); ?>
	</form>
</body>
</html>
