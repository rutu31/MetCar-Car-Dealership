<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!-- 
	 THIS FILE CREATES A NEW CUSTOMER ACCOUNT IN THE DATABASE, RECORDS CAR INFO, SERVICE CONTRACT INFO,
	 AND CREATES A NEW REPAIR JOB FOR THAT CAR. IF CUSTOMER ALREADY EXISTS IN THE DATABASE, A NEW CAR GETS ADDED FOR HIS ACCOUNT  
-->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>MetCar Customer Invoice</title>
	<link rel="stylesheet" type="text/css" href="MetCarCSS.css" />
</head>

<body>


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
	
	// CUSTOMER RECORD
	
	$oldCust = 0;
	$firstName= $_POST['first_name'];
	$lastName= $_POST['last_name'];
	$street=$_POST['street'];
	$city=$_POST['city'];
	$zip=$_POST['zip'];
	$workPhone=$_POST['work_phone'];
	$dayPhone=$_POST['day_phone'];
	
	// FORM VALIDATIONS
	
	if(empty($lastName) || empty($firstName) || empty($street) || empty($city) || empty($zip) || empty($workPhone) || empty($dayPhone)){
		echo "<script language=javascript>alert('All the fields are required ! Please re-enter')</script>";
		echo "<a href='MetCarNewCustomer.php'>Go Back</a>";
		exit(0);
	}
	
	$pattern = '/[\D]/';
	
	if(preg_match($pattern, $zip)){
		echo "<script language=javascript>alert('Please enter valid zip code')</script>";
		echo "<a href='MetCarNewCustomer.php'>Go Back</a>";
		exit(0);
	}
	
	// CHECK WHETHER CUSTOMER RECORD ALREADY EXISTS
	
	$sql = "select * from customer where day_phone = '".$dayPhone."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if($row){
		
		// CUSTOMER RECORD ALREADY EXISTS
		
		$custId = $row['cust_id'];
		$oldCust = 1;
	}
	else{	
		
		// RECORD NEW CUSTOMER ENTRY
		
		$sql = "SELECT * FROM CUSTOMER";
		$result = mysql_query($sql);
		$custId = mysql_num_rows($result);
		$custId++;
	
		$sql = "insert into customer values('".$custId."', '".$firstName."', '".$lastName."', '".$street."', '".$city."', ".$zip.", '".$workPhone."', '".$dayPhone."')";
		$result = mysql_query($sql);
	}
	
	// CREATE CAR ACCOUNT
	
	$carLicence=$_POST['car_licence'];
	$carModel=$_POST['car_model'];
	
	if(empty($carLicence) || empty($carModel)){
		echo "<script language=javascript>alert('All the fields are required ! Please re-enter')</script>";
		echo "<a href='MetCarNewCustomer.php'>Go Back</a>";
		exit(0);
	}
	
	$sql = "insert into car values('".$carLicence."', ".$custId.", '".$carModel."')";
	$result = mysql_query($sql);
	
	
	// SERVICE CONTRACT FOR THE CAR
	
	$service=$_POST['service_contract'];
	if($service=='YES'){
		
		// CUSTOMER WANTS SERVICE CONTRACT FOR HIS CAR
		
		$sql = "SELECT * FROM SERVICE_CONTRACT";
		$result = mysql_query($sql);
		$contractId = mysql_num_rows($result);
		$contractId++;
	
		$amount=$_POST['contract_amount'];
	
		if(empty($amount)){
			echo "<script language=javascript>alert('Enter the Service Contract Amount')</script>";
			echo "<a href='MetCarNewCustomer.php'>Go Back</a>";
			exit(0);
		}
	
		$sql = "insert into service_contract values(".$contractId.", '".$carLicence."', CURDATE(), ADDDATE(CURDATE(), INTERVAL 3 YEAR), ".$amount.")";
		$result = mysql_query($sql);
	}
	
	
	// CREATE NEW REPAIR JOB RECORD
	
	$sql = "SELECT * FROM REPAIR_JOB";
	$result = mysql_query($sql);
	$jobId = mysql_num_rows($result);
	$jobId++;
	
	$serviceFee = $_POST['service_fee'];
	
	if($serviceFee < 80){
		echo "<script language=javascript>alert('Service Fee can not be less than $80')</script>";
		echo "<a href='MetCarNewCustomer.php'>Go Back</a>";
		exit(0);
	}
	
	// REPAIR TABLE ENTRY CONNECTING REPAIR JOB TO DIFFERENT REPAIR PROBLEMS
	
	$cost = 0;
	$repairProb = $_POST['repair_problem'];
	$num = count($repairProb);
	
	for($i=0; $i < $num; $i++){
	
		$sql="select * from repair_problem where problem_type = '".$repairProb[$i]."'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$probId = $row['problem_id'];
		$cost = $cost + $row['total_cost'];
		
		// MAKE ENTRY IN REPAIR TABLE
	
		$sql = "insert into repair values(".$jobId.", ".$probId.", ADDDATE(CURDATE(), INTERVAL 4 DAY))";
		$result = mysql_query($sql);
	}
	
	// STORE IN REPAIR JOB TABLE
	
	$totalBill = $cost;
	$supervisor = $_POST['supervisor_name'];
	
	$sql = "select * from supervisor where first_name = '".$supervisor."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$empId = $row['emp_id'];
	
	$sql = "insert into repair_job values (".$jobId.", ".$serviceFee.", CURRENT_TIMESTAMP(), TIMESTAMPADD(DAY, 4, CURRENT_TIMESTAMP()), ".$totalBill.", ".$empId.", '".$carLicence."')";
	$result = mysql_query($sql);
	
	if($oldCust==0){
		echo("Invoice created successfully!");
	}
	else{
		echo("Customer already exists in the database. New Car added to his account.");
	}
	mysql_close($db_conn);
	
	?>
	
	<br />
	<br />
	<a href="MetCarHome.html">Main menu</a>

</body>
</html>
