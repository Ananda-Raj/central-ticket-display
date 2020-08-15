<?php


#Centralized ticket display system
#Author: Ananda Raj
#Date: 03/06/2020
#Version: 0.1.03062020


$db_table_ar = 'REPLACE-VALUE-HERE';  // Awaiting Reply
//Example: IamClient_ar
$db_table_ip = 'REPLACE-VALUE-HERE';  // In Progress
//Example: IamClient_ip
$db_table_summ = 'REPLACE-VALUE-HERE'; // Summary Results
//Example: IamClient_summ

// Fetch database connection details
include_once('connect-info.php');

if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Collect details from DB
$sql_query_ar = "SELECT * FROM $db_table_ar";
$sql_result_ar = mysql_query($sql_query_ar);

$sql_query_ip = "SELECT * FROM $db_table_ip";
$sql_result_ip = mysql_query($sql_query_ip);

$sql_query_summ = "SELECT * FROM $db_table_summ";
$sql_result_summ = mysql_query($sql_query_summ);

?>

<!DOCTYPE html> 
<html> 

<style>
body {font-family: Arial, Helvetica, sans-serif;}
tr:hover {background-color: #f5f5f5;}

.hr1 {
width: 75%;
height: 10px;
background-color: black;
}

.hr2 {
width: 50%;
height: 3px;
background-color: black;
}

.container {
  background-color: #f2f2f2;
  padding: 5px;
  width:600px;
  line-height:40px;
  text-align: center;
  border: 1px solid #ccc;
}
</style>


	<head> 
		<title> Centralized Ticket Display </title> 
	</head> 

	<body> 
	<div>
		<h1 align="center">Centralized Ticket Display</h1>
	</div>
       		<hr class="hr1">
	</div>

<!-- Edit here to change page URL -->
	<div align="center">		
		<br>
		<a href="./index.html">&nbsp&nbsp HOME &nbsp&nbsp</a>
		<a href="./client1-display.php">&nbsp&nbsp CLIENT1 &nbsp</a>
		<a href="./client2-display.php">&nbsp&nbsp CLIENT2 &nbsp&nbsp</a>
		<a href="./client3-display.php">&nbsp&nbsp CLIENT3 &nbsp&nbsp</a>
		<a href="./client4-display.php">&nbsp&nbsp CLIENT4 &nbsp&nbsp</a>
		<a href="./client5-display.php">&nbsp&nbsp CLIENT5 &nbsp&nbsp</a>
	</div>
		<br>
	<div>       	
		<hr class="hr2">

		<h2 align="center">Summary information - REPLACE-VALUE-HERE</h2>
		<!-- Example: CLIENT1 -->
	</div>
	<div>
<!-- Table to display summary results -->
	<table class="container" align="center" border="1px" style="height: 100%"> 
		<?php while($rows_summ=mysql_fetch_assoc($sql_result_summ)) 
		{ 
		?> 
		<tr>
			<td><?php echo $rows_summ['type']; ?></td> 
			<td><?php echo $rows_summ['number']; ?></td> 
		<?php 
        	} 
	        ?> 
		</tr>
	</table> 
	</div>
		<br>
       		<hr class="hr2">
		<br>
       		
	<div>
		<div>
<!-- Table to disaplay Awaiting Reply -->
		<table class="container" align="left" border="1px" style="height: 100%"> 
			<tr> 
				<th colspan="2"><h2>Tickets awaiting reply</h2></th> 
			</tr> 
			<tr>
				<th> SL </th> 
				<th> Ticket ID </th> 
			</tr> 
			<?php while($rows_ar=mysql_fetch_assoc($sql_result_ar)) 
			{ 
			?> 
			<tr>
				<td><?php echo $rows_ar['id']; ?></td> 
				<td><?php echo $rows_ar['ticket']; ?></td> 
			<?php 
			} 
			?> 
			</tr>
		</table> 
		</div>
<!-- Table to disaplay In Progress -->
		<div>
		<table class="container" align="right" border="1px" style="height: 100%"> 
			<tr> 
				<th colspan="2"><h2>Tickets in progress</h2></th> 
			</tr> 
			<tr>
				<th> SL </th> 
				<th> Ticket ID </th> 
			</tr> 
			<?php while($rows_ip=mysql_fetch_assoc($sql_result_ip)) 
			{ 
			?> 
			<tr>
				<td><?php echo $rows_ip['id']; ?></td> 
				<td><?php echo $rows_ip['ticket']; ?></td> 
			<?php 
			} 
			?> 
			</tr>
		</table> 
		</div>
	</div>
	</body>
</html>

