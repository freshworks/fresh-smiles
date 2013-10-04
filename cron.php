<?php
/**
 * File: cron.php
 * Project: zk-smiley
 **/

//Require the main configuration
require_once('inc/config.php');

//Require Smiley Library
require_once('inc/lib.php');

//Connect to MySQL
mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
@mysql_select_db(DB_NAME) or die("Unable to select database");

//Require the FreshDesk API Library
require_once('inc/FreshdeskRest.php');

//Create New FreshDesk API Object
$fd = new FreshdeskRest(FD_URL, FD_API_USER, FD_API_PASS);

//Make sure the FD Connection Works
if ( $fd->getLastHttpStatus() != 200 ) {
	echo "Unable to connect to FreshDesk";
}

//Determine the Lower Limit
$lowerLimit = lowerLimitSurvey();
if ( empty($lowerLimit) ) {
	$lowerLimit = lowerLimitTicket();
} else {
	//DO NOTHING
}

//Set the Variables for the Loop
$i = $lowerLimit;
$max = upperLimit($fd);

while ( $i != 0 ) {
	
	$result = theLoop($fd, $i, $max);
	
	if ( $result == "continue" ) {
		
		echo "No Ticket: $i ...Continuing.\n";
		
	} else if ( $result == "stop" ) {
	
		echo "No Ticket: $i ...STOP.\n";
		
		//This causes us to Abort
		$i = -1;
		
	} else if ( $result == "danger" ) {
	
		echo "DANGER WILL ROBINSON, DANGER";
		
	} else if ( $result == "api_limit" ) {
	
		echo "\n";
		echo "*ERROR* API LIMIT REACHED\n";
		echo "LAST KNOWN TICKET: $i\n";
		
		//This Causes us to Abort
		$i = -1;
		
	} else {
		
		echo "Insert Ticket: $i\n";
		mysql_query($result);
		
	}
	
	//Increment the counter
	$i++;
		
}
