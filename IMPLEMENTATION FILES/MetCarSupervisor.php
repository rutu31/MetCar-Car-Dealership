<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<!-- 
	THIS FILE SHOWS ALL THE USE CASES FOR GENERATING REPORTS FOR SUPERVISORS.
	1. SHOW LIST OF ALL SUPERVISORS
	2. SHOW LIST OF SUPERVISOR'S NAME WHO WAS ASSIGNED TO MOST NO. OF JOBS - BETWEEN THE GIVEN DATES
	3. SHOW LIST OF SUPERVISOR'S NAME WHO WAS ASSIGNED TO LEAST NO. OF JOBS - BETWEEN THE GIVEN DATES
	4. SHOW AVERAGE NUMBER OF JOBS EACH SUPERVISOR WAS ASSIGNED TO - BETWEEN THE GIVEN DATES
 --> 
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
<title>MetCar Supervisor Reports</title>
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
	
	<!-- FORM THAT SHOWS ALL USE-CASES AND ACCEPTS THE START DATE AND END DATE -->
	
	<form name="supervisor_list" method="post" action="MetCarSupervisorList.php">
		<div class="job_list">
		<fieldset>
		<legend><span style="color: white">Show Supervisor List</span></legend>
			<br />
			<input type="radio" name="supervisor" value="all_supervisors" /> Show List of all Supervisors <br />
			<input type="radio" name="supervisor" value="supervisor_most_jobs" /> Show Supervisor name who was assigned to most jobs<br />
			<input type="radio" name="supervisor" value="supervisor_least_jobs" /> Show Supervisor name who was assigned to least jobs<br />
			<input type="radio" name="supervisor" value="supervisor_avg_jobs" /> Show average no. of jobs each supervisor was assigned to<br /><br />
			
			<span style="color: white">Enter Start Date:  </span><br /><br />
			&nbsp;&nbsp;MM <input type="text" name="jobList_MM1" id="jobList_MM1" /> &nbsp;
			DD <input type="text" name="jobList_DD1" id="jobList_DD1" /> &nbsp;
			YYYY  <input type="text" name="jobList_YYYY1" id="jobList_YYYY1" /><br /><br />
			
			<span style="color: white">Enter End Date: </span><br /><br />
			&nbsp;&nbsp;MM <input type="text" name="jobList_MM2" id="jobList_MM2" /> &nbsp;
			DD <input type="text" name="jobList_DD2" id="jobList_DD2" /> &nbsp;
			YYYY  <input type="text" name="jobList_YYYY2" id="jobList_YYYY2" /><br /><br /> 	
			
			<div class="submit_btn">
				<br /><input type="submit" value="Show" />
			</div>

		</fieldset>
		</div>
	</form>
	
	
	<?php mysql_close($db_conn);?>
</body>
</html>
