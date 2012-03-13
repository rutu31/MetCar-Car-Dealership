<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<!-- 
	THIS FILE SHOWS THE CASH COLLECTED BETWEEN THE GIVEN DATES.
 --> 
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
<title>MetCar Show Balance</title>
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
	
	<?php 
		$MM1 = $_POST['jobList_MM1'];
		$DD1 = $_POST['jobList_DD1'];
		$YYYY1 = $_POST['jobList_YYYY1'];		
		
		$MM2 = $_POST['jobList_MM2'];
		$DD2 = $_POST['jobList_DD2'];
		$YYYY2 = $_POST['jobList_YYYY2'];		

		// FORM VALIDATIONS
		
		if(empty($MM1) || empty($MM2) || empty($DD1) || empty($DD2) || empty($YYYY1) || empty($YYYY2)){
			echo "<script language=javascript>alert('All fields are required ! Please re-enter')</script>";
			echo "<a href='MetCarRepairJob.php'>Go Back</a>";
			exit(0);		
		}
			
		if($YYYY1 > $YYYY2){
			echo "<script language=javascript>alert('End Date cannot be greater than Start Date ! Please re-enter')</script>";
			echo "<a href='MetCarRepairJob.php'>Go Back</a>";
			exit(0);					
		}
		
		if(!checkdate($MM1,$DD1,$YYYY1) || !checkdate($MM2,$DD2,$YYYY2)){
			echo "<script language=javascript>alert('Incorrect Date ! Please re-enter')</script>";
			echo "<a href='MetCarRepairJob.php'>Go Back</a>";
			exit(0);		
		}
		
		$startDate = $YYYY1."-".$MM1."-".$DD1;
		$endDate = $YYYY2."-".$MM2."-".$DD2;
		
		$TOTAL = 0;

		// CALCULATE THE CASH GENERATED WITHIN GIVEN DATES 
		
		$sql = "select * from repair_job where DATE(date_time_car_out) >= '".$startDate."' and DATE(date_time_car_out) <= '".$endDate."'";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$TOTAL1 = 0;
			$TOTAL1 = $TOTAL1 + $row['service_fee'] + $row['total_repair_charges'];
			
			// CHECK FOR SERVICE CONTRACT DETAILS
			
			$licence = $row['car_licence'];
			$sql1 = "select * from service_contract where car_licence = ".$licence;
			$result1 = mysql_query($sql1);
			$row1 = mysql_fetch_array($result1);
			if($row1){
				$repairJobId = $row['job_id'];
				
				$flag = 0;
				$sql2 = "select * from repair_problem where problem_id in (select problem_id from repair where job_id = ".$repairJobId." )";
				$result2 = mysql_query($sql2);
				
				while($row2 = mysql_fetch_array($result2)){
					
					// CHECK IF ANY CAR HAD TRANSMISSION PROBLEM 
					
					if($row2['problem_type'] == "Transmission"){
						$flag = 1;
					}
				}
				if($flag){
					$TOTAL1 -= $TOTAL1/5;
				}
			}
			$TOTAL += $TOTAL1;
		}
	?>
	
	<!-- DISPLAY TOTAL CASH GENERATED -->
	
	<div class="final_balance_display">
		Total amount generated within the given duration is <span style="color:white">$ <?php echo $TOTAL;?></span>
	</div>


	<?php mysql_close($db_conn);?>
</body>
</html>
