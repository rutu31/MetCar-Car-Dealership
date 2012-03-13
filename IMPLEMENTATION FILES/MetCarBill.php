
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<!-- THIS FILE CREATES BILL FOR CUSTOMER. --> 
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
<title>MetCar Customer Bill</title>
	<link rel="stylesheet" type="text/css" href="MetCarCSS.css" />
</head>

<body>
	<div class="main_menu_link">
		<a href="MetCarHome.html">Main menu</a>
	</div>

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

		$billPhone = $_POST['bill_Phone'];
		$carModel = $_POST['car_model'];
		
		// FORM VALIDATIONS
		
		if(empty($billPhone) || empty($carModel)){
			echo "<script language=javascript>alert('All the fields are required ! Please re-enter')</script>";
			echo "<a href='MetCarExistingCustomer.php'>Go Back</a>";
			exit(0);
		}
		
		// RETRIEVE CUSTOMER INFO
		
		$sql = "select * from customer where day_phone = '".$billPhone."'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		
		$flag1 = 0;
		if($row){
			//echo 'inside1';
			$custId = $row['cust_id'];

			// CHECK FOR CAR MODEL FOR THE CUSTOMER
			
			$sql1 = "select * from car where cust_id = ".$custId;
			$result1 = mysql_query($sql1);
			while($row1 = mysql_fetch_array($result1)){
				if($row1['car_model'] == $carModel){
					// ENTERED CAR MODEL IS CORRECT
					$flag1 = 1;
				}
			}

			// CAR MODEL IN INCORRECT I.E. CUSTOMER DOESN'T HAVE A CAR OF ENTERED MODEL

			if(!$flag1){
				echo "<script language=javascript>alert('Please re-enter car model')</script>";
				echo "<a href='MetCarExistingCustomer.php'>Go Back</a>";
				exit(0);		
			}						
		}
		
		// CUSTOMER DOESN'T EXIST IN THE DATABASE 
		else if(!$row){
			echo "<script language=javascript>alert('No such customer exsist. Enter Again')</script>";
			echo "<a href='MetCarExistingCustomer.php'>Go Back</a>";
			exit(0);
		}
		
		?>
		
		<!-- DISPLAY CUSTOMER BILL -->
		
		<div class="customer_bill">
		<fieldset><legend><span style="color: white">CUSTOMER BILL</span></legend>
			
			<!-- DISPLAY CUSTOMER INFO -->
			
			<fieldset><legend><span style="color: white">Customer Info</span></legend>
				<span style="color:white">Customer Name: </span><?php echo $row['first_name']; echo' ';echo $row['last_name'];?><br /><br />
				<span style="color:white">Address: </span><?php echo $row['street']; echo ', '; echo $row['city']; echo ' '; echo $row['zip'];?><br /><br />
				<span style="color:white">Phone Number: </span><span style="color:white"> <br /><br />&nbsp;&nbsp;&nbsp;Day Phone :</span> <?php echo $row['day_phone'];?> &nbsp;<span style="color:white">Work Phone :</span> <?php echo $row['work_phone'];?> 
			</fieldset>
			<br /><br />
		<?php
		
		$custId = $row['cust_id'];
		
		$sql = "select * from car where cust_id = ".$custId." and car_model = '".$carModel."'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result)?>
		
		<!-- DISPLAY CAR INFO -->
		
		<fieldset><legend><span style="color: white">Car Info</span></legend>
			<span style="color:white">Car Licence Number:</span> <?php echo $row['licence_no'];?><br /><br />
			<span style="color:white">Car Model:</span> <?php echo $row['car_model'];?>			
		</fieldset>
		<br /><br />
		
		<!-- DISPLAY BILL DETAILS -->
		
		<fieldset><legend><span style="color: white">Bill Details</span></legend>
		<span style="color: white">Repair Problems </span><br /><br />
		<?php  
		
		$licence = $row['licence_no'];
		
		// DISPLAY PROBLEMS REPAIRED & ITS DETAILS 
		
		$sql = "select * from repair_job where car_licence = '".$licence."'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		
		$repairJobId = $row['job_id'];
		$repairCost = $row['total_repair_charges'];
		$serviceFee = $row['service_fee'];
		
		$cnt = 0;
		$flag = 0;
		$sql = "select * from repair_problem where problem_id in (select problem_id from repair where job_id = ".$repairJobId." )";
		$result = mysql_query($sql);?>
				
		<?php 
		while($row = mysql_fetch_array($result)){
			$cnt++;
			$repairProblemId = $row['problem_id'];
			
			// CHECK IF CAR HAD TRANSMISSION PROBLEM
			
			if($row['problem_type'] == "Transmission"){
				$flag = 1;
			}
			
			echo '<span style="color: white">'; echo $cnt; echo '. '; echo $row['problem_type']; echo ' </span><br /> &nbsp; Labor Cost: $ '; echo $row['labor_cost']; 
		?> <br />			
		<?php
			$sql1 = "select * from part where part_id in (select part_id from requires where problem_id = ".$repairProblemId." )";
			$result1 = mysql_query($sql1);	
			$row1 = mysql_fetch_array($result1);
		?> 
			&nbsp;
			Part Changed: <?php echo $row1['part_name'];?> &nbsp;<br />&nbsp;
			Cost of Part: $ <?php  echo $row1['part_cost'];?>
			<br /><br />
		<?php }

		?>
		<!-- DISPLAY MONEY DETAILS -->
		
			<br /><br />
			<span style="color:white">Total Repair Cost: </span> $ <?php echo $repairCost;?><br /><br />
			<span style="color:white">+ Service Fee: </span> $ <?php echo $serviceFee;?><br /><br />
			<?php $BILL = $repairCost + $serviceFee;?>
			<span style="color:white">= Total Repair Charges: </span> $ <?php echo $BILL;?><br /><br />
			
		<?php 
			
		// CALCULATE DISCOUNT IF CAR HAS SERVICE CONTRACT AND IT HAD TRANSMISSION PROBLEM
			
			$sql = "select * from service_contract where car_licence = '".$licence."' and end_date > CURDATE()";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);

			if($row && $flag){?>			
					<span style="color:white">- Service Contract Discount: </span> 20%<br /><br />
					<?php $BILL -= $BILL / 5;?>			
	  <?php }
			
		?>			
		
		<!-- DISPLAY TOTAL BILL AMOUNT -->
		<div class="final_bill_display">
			<span style="color:white; font-size: 20px">TOTAL BILL: </span> $ <?php echo $BILL;?>
		</div>	
		</fieldset>
		
		</fieldset>
		</div>
		<br /><br />

	<?php mysql_close($db_conn);?>
	
</body>
</html>
