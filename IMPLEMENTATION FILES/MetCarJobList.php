<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<!-- 
	THIS FILE DISPLAYS THE LIST OF REPAIR JOBS WITHIN THE GIVEN DURATION.
 --> 
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
<title>MetCar Repair Job List</title>
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

	?>
	
	<div class="main_menu_link">
		<a href="MetCarHome.html">Main menu</a>
	</div>

	<div class="repair_job_list">
	<fieldset>
	
		<legend><span style="color: white">List Repair Jobs</span></legend>
		<div class="service_contract">
		<table border="1" cellspacing="2" cellpadding="2">
		<tr><th><h3>Repair Job Id</h3></th><th><h3>Repair Problems</h3></th><th><h3>Supervisor in-charge</h3></th><th><h3>Date/Time Car Out</h3></th><th><h3>Total Repair Charges</h3></th><th><h3>Service Fee</h3></th><th><h3>Car Licence No.</h3></th><th><h3>Car Model</h3></th></tr>	
	<?php 

		// DISPLAY LIST OF REPAIR JOBS AND THEIR DETAILS IN TABULAR FORMAT
	
		$sql = "select * from repair_job where DATE(date_time_car_out) >= '".$startDate."' and DATE(date_time_car_out) <= '".$endDate."'";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			
			$supervisor = $row['emp_id'];
			$licence = $row['car_licence'];
			$jobId = $row['job_id'];
			
			$sql1 = "select * from supervisor where emp_id = ".$supervisor;
			$result1 = mysql_query($sql1);
			$row1 = mysql_fetch_array($result1);
			
			$sql2 = "select * from car where licence_no = '".$licence."'";
			$result2 = mysql_query($sql2);
			$row2 = mysql_fetch_array($result2);
						
			$sql3 = "select * from repair_problem where problem_id in (select problem_id from repair where job_id = ".$jobId." )";
			$result3 = mysql_query($sql3);
			
	?>		
			<tr>
			<td><?php echo $row['job_id']?></td>
			<td>
			<?php while($row3 = mysql_fetch_array($result3)){
				echo $row3['problem_type'];?><br />
			<?php } ?>
			</td>
			<td><?php echo $row1['first_name']; echo ' '; echo $row1['last_name'];?></td>
			<td><?php echo $row['date_time_car_out']?></td>
			<td><?php echo '$ '; echo $row['total_repair_charges']?></td>
			<td><?php echo '$ '; echo $row['service_fee']?></td>
			<td><?php echo $row['car_licence']?></td>
			<td><?php echo $row2['car_model']?></td>
			</tr>
	<?php }
	
	?>

	</table>	
	</div>	
	</fieldset>	
	</div>
	<?php mysql_close($db_conn);?>		

</body>
</html>