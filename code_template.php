<?php


#Centralized ticket display system
#Author: Ananda Raj
#Date: 03/06/2020
#Version: 0.1.03062020


// Set authentication details
$api_identifier = 'REPLACE-VALUE-HERE';
//Example: NFoqyGNz7rpA4jKWtzYlththtrniHmOl
$api_secret = 'REPLACE-VALUE-HERE';
//Example: 88v2P6XZXRlK3rthrgt6xXWUZM6jfVOm
$api_whmurl = 'REPLACE-VALUE-HERE';
//Example: https://panel.eglueweb.com/includes/api.php

$db_host = "localhost";
$db_name = "cti_db";
$db_user = "cti_user";
$db_pass = "cti_WtoDCP7yrMbW2";
$db_table_ar = 'REPLACE-VALUE-HERE_ar';  // Awaiting Reply
//Example: eglueweb_ar
$db_table_ip = 'REPLACE-VALUE-HERE_ip';  // In Progress
//Example: eglueweb_ip
$db_table_summ = 'REPLACE-VALUE-HERE_summ'; // Summary Results
//Example: eglueweb_summ

#### List Awaiting Reply Tickets <start> ####
#Includes ticket status -- Open, Customer-Reply from all departments

// Set post values
$postfields = array(
    'username' => $api_identifier,
    'password' => $api_secret,
    'status' => 'Awaiting Reply',
    'limitnum' => '20000',
    'action' => 'GetTickets',
    'responsetype' => 'json',
);


// Call the API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_whmurl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
$response = curl_exec($ch);
if (curl_error($ch)) {
    die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
}
curl_close($ch);


// Decode response
$jsonData = json_decode($response, true);


$ticket_number = $jsonData['totalresults']; 
$items_1 = $jsonData['tickets']; 
$items_1 = $items_1['ticket'];

echo "Number of -Awaiting Reply- tickets: $ticket_number\n";
echo "List of -Awaiting Reply- tickets:\n";


// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


// Create new table
$sql_create = "CREATE TABLE $db_table_ar (id int(50),  ticket VARCHAR(20))";
if ($conn->query($sql_create) === TRUE) {
	echo "\nTable created successfully";
} 
else {
	echo "\nNew table creation failed";
	echo "\nError: " . $sql_create . " : " . $conn->error;
}

$sql_create = "CREATE TABLE $db_table_summ (type VARCHAR(100), number int(50))";
if ($conn->query($sql_create) === TRUE) {
	echo "\nTable created successfully";
} 
else {
	echo "\nNew table creation failed";
	echo "\nError: " . $sql_create . " : " . $conn->error;
}


// Empty the table
$sql_truncate = "TRUNCATE $db_table_ar";
if ($conn->query($sql_truncate) === TRUE) {
	echo "\nTable truncated successfully";
} 
else {
	echo "\nTable truncate failed";
	echo "\nError: " . $sql_truncate . " : " . $conn->error;
}

$sql_truncate = "TRUNCATE $db_table_summ";
if ($conn->query($sql_truncate) === TRUE) {
	echo "\nTable truncated successfully";
} 
else {
	echo "\nTable truncate failed";
	echo "\nError: " . $sql_truncate . " : " . $conn->error;
}


// Add values to table 
$sql_summ = "INSERT INTO $db_table_summ (type, number) VALUES ('Tickets Awaiting Reply', '$ticket_number')";
if ($conn->query($sql_summ) === TRUE) {
	echo "\nNew record created successfully\n";
} 
else {
	echo "\nCouldn't add record";
	echo "\nError: " . $sql_summ . " : " . $conn->error;
}

for ($i=0; $i<$ticket_number; $i++) {
	$items_2 = $items_1[$i];
	$items_2 = $items_2['tid']; 
	$sql_insert = "INSERT INTO $db_table_ar (id, ticket) VALUES ('$i', '$items_2')";
	if ($conn->query($sql_insert) === TRUE) {
  		echo "New record created successfully ";
	} 
	else {
		echo "\nCouldn't add record ";
 		echo "\nError: " . $sql_insert . " : " . $conn->error;
	}
	print_r($items_2);
	echo "\n";
}


$conn->close();
echo "\n";

#### List Awaiting Reply Tickets <end> ####



#### List In Progress Tickets <start> ####
#Includes ticket status -- In Progress 

// Set post values
$postfields = array(
    'username' => $api_identifier,
    'password' => $api_secret,
    'status' => 'In Progress',
    'limitnum' => '20000',
    'action' => 'GetTickets',
    'responsetype' => 'json',
);


// Call the API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_whmurl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
$response = curl_exec($ch);
if (curl_error($ch)) {
    die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
}
curl_close($ch);


// Decode response
$jsonData = json_decode($response, true);


$ticket_number = $jsonData['totalresults']; 
//$ticket_number = 5;
$items_1 = $jsonData['tickets']; 
$items_1 = $items_1['ticket'];

echo "Number of -In Progress- tickets: $ticket_number\n";
echo "Listing -In Progress- tickets..\n";

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


// Create new table
$sql_create = "CREATE TABLE $db_table_ip (id int(50), ticket VARCHAR(20))";
if ($conn->query($sql_create) === TRUE) {
	echo "\nTable created successfully";
} 
else {
	echo "\nNew table creation failed";
	echo "\nError: " . $sql_create . " : " . $conn->error;
}

// Empty the table
$sql_truncate = "TRUNCATE $db_table_ip";
if ($conn->query($sql_truncate) === TRUE) {
	echo "\nTable truncated successfully";
} 
else {
	echo "\nTable truncate failed";
	echo "\nError: " . $sql_truncate . " : " . $conn->error;
}


// Add values to table 
$sql_summ = "INSERT INTO $db_table_summ (type, number) VALUES ('Ticket In Progress', '$ticket_number')";
if ($conn->query($sql_summ) === TRUE) {
	echo "\nNew record created successfully\n";
} 
else {
	echo "\nCouldn't add record";
	echo "\nError: " . $sql_summ . " : " . $conn->error;
}

for ($i=0; $i<$ticket_number; $i++) {
	$items_2 = $items_1[$i];
	$items_2 = $items_2['tid']; 
	$sql_insert = "INSERT INTO $db_table_ip (id, ticket) VALUES ('$i', '$items_2')";
	if ($conn->query($sql_insert) === TRUE) {
  		echo "New record created successfully ";
	} 
	else {
		echo "\nCouldn't add record";
 		echo "\nError: " . $sql_insert . " : " . $conn->error;
	}
	print_r($items_2);
	echo "\n";
}


$conn->close();
echo "\n";

#### List In Progress Tickets <end> ####

?>
