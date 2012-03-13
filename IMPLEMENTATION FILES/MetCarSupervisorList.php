<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<!-- 
	THIS FILE DISPLAYS REPORTS FOR SUPERVISORS
--> 
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
<title>MetCar Supervisor Reports</title>
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
	
	?>
	
	<div class="main_menu_link">
		<a href="MetCarHome.html">Main menu</a>
		<br />
		<a href="MetCarSupervisor.php"> Go Back</a>
	</div>
	
	<?php
		// FIND OUT THE USE-CASE SELECTED AND CALL FUNCTIONS ACCORDINGLY
	
		$case = $_POST['supervisor'];
		
		if($case == "all_supervisors"){
			case_all_supervisors();
		}
		else if($case == "supervisor_most_jobs"){
			case_supervisor_most_jobs();
		}
		else if($case == "supervisor_least_jobs"){
			case_supervisor_least_jobs();
		}
		else if($case == "supervisor_avg_jobs"){
			case_supervisor_avg_jobs();
		}
	?>
	
	<?php 
		// FUNCTION THAT DISPLAYS LIST OF ALL SUPERVISORS
	
		function case_all_supervisors(){?>
			<table border="1" cellspacing="2" cellpadding="2">
			<tr><th>Supervisor Id</th><th>Supervisor Name</th><th>Phone Number</th></tr>
			<?php $sql = "select * from supervisor";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){?>
				<tr>
				<td><?php echo $row['emp_id']?></td>
				<td><?php echo $row['first_name']; echo ' '; echo $row['last_name'];?></td>
				<td><?php echo $row['phone']?></td>
				</tr>
			<?php }?>
			
			</table>
		<?php }
	?>
	<?php 
		// FUNCTION THAT DISPLAYS SUPERVISOR NAMES ASSIGNED TO MOST NO. OF JOBS BETWEEN GIVEN DATES
		
		function case_supervisor_most_jobs(){?>
		
		<table border="1" cellspacing="2" cellpadding="2">
		<tr><th>Supervisor Id</th><th>Supervisor Name</th><th>Phone Number</th></tr>
		
		<?php 	
					
			$MM1 = $_POST['jobList_MM1'];
			$DD1 = $_POST['jobList_DD1'];
			$YYYY1 = $_POST['jobList_YYYY1'];		
			
			$MM2 = $_POST['jobList_MM2'];
			$DD2 = $_POST['jobList_DD2'];
			$YYYY2 = $_POST['jobList_YYYY2'];	
	
			$startDate = $YYYY1."-".$MM1."-".$DD1;
			$endDate = $YYYY2."-".$MM2."-".$DD2;
			
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
			
			$sql = "select emp_id, count(job_id) from repair_job where DATE(date_time_car_out) >= '".$startDate."' and DATE(date_time_car_out) <= '".$endDate."' group by emp_id having count(job_id) >= all(select count(job_id) from repair_job where DATE(date_time_car_out) >= '".$startDate."' and DATE(date_time_car_out) <= '".$endDate."' group by emp_id)";
			$result = mysql_query($sql);
			
			while($row = mysql_fetch_array($result)){
				
			$supervisor = $row['emp_id'];
						
			$sql1 = "select * from supervisor where emp_id = ".$supervisor;
			$result1 = mysql_query($sql1);
			$row1 = mysql_fetch_array($result1);
		?>
		
			<tr>
				<td><?php echo $row1['emp_id']?></td>
				<td><?php echo $row1['first_name']; echo ' '; echo $row1['last_name'];?></td>
				<td><?php echo $row1['phone']?></td>
			</tr>
		<?php }?>
			</table>
		<?php }
	?>
	<?php 
		// FUNCTION THAT DISPLAYS SUPERVISOR NAMES ASSIGNED TO LEAST NO. OF JOBS BETWEEN GIVEN DATES
	
		function case_supervisor_least_jobs(){
					
			$MM1 = $_POST['jobList_MM1'];
			$DD1 = $_POST['jobList_DD1'];
			$YYYY1 = $_POST['jobList_YYYY1'];		
			
			$MM2 = $_POST['jobList_MM2'];
			$DD2 = $_POST['jobList_DD2'];
			$YYYY2 = $_POST['jobList_YYYY2'];		
			
			$startDate = $YYYY1."-".$MM1."-".$DD1;
			$endDate = $YYYY2."-".$MM2."-".$DD2;
			
			if(empty($MM1) || empty($MM2) || empty($DD1) || empty($DD2) || empty($YYYY1) || empty($YYYY2)){
				echo "<script language=javascript>alert('All fields are required ! Please re-enter')</script>";
				exit(0);		
			}
			
			if($YYYY1 > $YYYY2){
				echo "<script language=javascript>alert('End Date cannot be greater than Start Date ! Please re-enter')</script>";
				exit(0);					
			}
			
			if(!checkdate($MM1,$DD1,$YYYY1) || !checkdate($MM2,$DD2,$YYYY2)){
				echo "<script language=javascript>alert('Incorrect Date ! Please re-enter')</script>";
				echo "<a href='MetCarRepairJob.php'>Go Back</a>";
				exit(0);		
			}
			
			?>
			
			<table border="1" cellspacing="2" cellpadding="2">
			<tr><th>Supervisor Id</th><th>Supervisor Name</th><th>Phone Number</th></tr>
			
			<?php 
			
			$sql = "select emp_id, count(job_id) from repair_job where DATE(date_time_car_out) >= '".$startDate."' and DATE(date_time_car_out) <= '".$endDate."' group by emp_id having count(job_id) <= all(select count(job_id) from repair_job where DATE(date_time_car_out) >= '".$startDate."' and DATE(date_time_car_out) <= '".$endDate."' group by emp_id )";
			$result = mysql_query($sql);
			
			while($row = mysql_fetch_array($result)){
				
			
			$supervisor = $row['emp_id'];
			
			$sql1 = "select * from supervisor where emp_id = ".$supervisor;
			$result1 = mysql_query($sql1);
			$row1 = mysql_fetch_array($result1);?>
			
			<tr>
				<td><?php echo $row1['emp_id']?></td>
				<td><?php echo $row1['first_name']; echo ' '; echo $row1['last_name'];?></td>
				<td><?php echo $row1['phone']?></td>
			</tr>
			<?php }?>
			</table>
		<?php }
	?>
	<?php 
		// FUNCTION THAT DISPLAYS AVERAGE NO. OF JOBS EACH SUPERVISOR WAS ASSIGNED BETWEEN THE GIVEN DATES
	
		function case_supervisor_avg_jobs(){
			
			$MM1 = $_POST['jobList_MM1'];
			$DD1 = $_POST['jobList_DD1'];
			$YYYY1 = $_POST['jobList_YYYY1'];		
			
			$MM2 = $_POST['jobList_MM2'];
			$DD2 = $_POST['jobList_DD2'];
			$YYYY2 = $_POST['jobList_YYYY2'];		
			
			$startDate = $YYYY1."-".$MM1."-".$DD1;
			$endDate = $YYYY2."-".$MM2."-".$DD2;
			
			if(empty($MM1) || empty($MM2) || empty($DD1) || empty($DD2) || empty($YYYY1) || empty($YYYY2)){
				echo "<script language=javascript>alert('All fields are required ! Please re-enter')</script>";
				exit(0);		
			}
			
			if($YYYY1 > $YYYY2){
				echo "<script language=javascript>alert('End Date cannot be greater than Start Date ! Please re-enter')</script>";
				exit(0);					
			}
			
			if(!checkdate($MM1,$DD1,$YYYY1) || !checkdate($MM2,$DD2,$YYYY2)){
				echo "<script language=javascript>alert('Incorrect Date ! Please re-enter')</script>";
				echo "<a href='MetCarRepairJob.php'>Go Back</a>";
				exit(0);		
			}
			
			$sql = "select avg(job_id) from (select count(job_id) as job_id from repair_job where DATE(date_time_car_out) >= '".$startDate."' and DATE(date_time_car_out) <= '".$endDate."' group by emp_id) as temp";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			
			echo '<br /><br />';
			echo 'Average number of repair jobs each supervisor is assigned to between the given duration is = '.$row['avg(job_id)'];
		}
	?>
	
<?php mysql_close($db_conn);?>
</body>
</html>