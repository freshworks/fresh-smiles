<?php
/**
 * File: cron.php
 * Project: zk-smiley
 **/

//Require the main configuration
require_once('inc/config.php');

//Require Smiley Library
require_once('inc/lib.php');

mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
@mysql_select_db(DB_NAME) or die("Unable to select database");

//Require the FreshDesk API Library
require_once('inc/FreshdeskRest.php');

//Create New FreshDesk API Object
$fd = new FreshdeskRest(FD_URL, FD_API_USER, FD_API_PASS);

if ( $fd->getLastHttpStatus() != 200 ) {
	echo "Unable to connect to FreshDesk";
}

//Set the Variables for the Loop
$i = LOWER_LIMIT;

while ( $i != 0 ) {
	
	$result = theLoop($fd, $i, UPPER_LIMIT);
	
	if ( $result == "continue" ) {
		
		echo "No Ticket: $i ...Continuing.\n";
		
	} else if ( $result == "stop" ) {
	
		echo "No Ticket: $i ...STOP.\n";
		$i = -1;
		
	} else if ( $result == "danger" ) {
	
		echo "DANGER WILL ROBINSON, DANGER";
		
	} else {
		
		echo "Put stuff in Database.\n";
		mysql_query($result);
		
	}
	
	//Increment the counter
	$i++;
		
}
