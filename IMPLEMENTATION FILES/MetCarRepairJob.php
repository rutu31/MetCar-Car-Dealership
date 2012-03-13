<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!-- 
	THIS FILE TAKES AS INPUT START & END DATES FOR DISPLAYING REPAIR JOBS DONE WITHIN THAT DURATION.   
-->
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
<title>MetCar Repair Job</title>
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
	
	<!-- FORM ACCEPTING START DATE & END DATE -->
	
	<form name="repair_job" method="post" action="MetCarJobList.php">
		<div class="job_list">
		<fieldset>
		<legend><span style="color: white">Show Repair Job List</span></legend>
		
			<br />
			<span style="color: white">Enter Start Date:  </span><br /><br />
			&nbsp;&nbsp;MM <input type="text" name="jobList_MM1" id="jobList_MM1" /> &nbsp;
			DD <input type="text" name="jobList_DD1" id="jobList_DD1" /> &nbsp;
			YYYY  <input type="text" name="jobList_YYYY1" id="jobList_YYYY1" /><br /><br />
			
			<span style="color: white">Enter End Date: </span><br /><br />
			&nbsp;&nbsp;MM <input type="text" name="jobList_MM2" id="jobList_MM2" /> &nbsp;
			DD <input type="text" name="jobList_DD2" id="jobList_DD2" /> &nbsp;
			YYYY  <input type="text" name="jobList_YYYY2" id="jobList_YYYY2" /><br /><br /> 			
			
			<div class="submit_btn">
				<br /><input type="submit" value="Show List" />
			</div>
		</fieldset>
		</div>
	</form>
	
	<?php mysql_close($db_conn);?>
	
</body>
</html>