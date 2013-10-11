<?php
/**
 * File: cron.php
 * Project: zk-smiley
 **/

//Stuff to make it not die
ignore_user_abort(true);

//Require the main configuration
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/config.php');

//Require Smiley Library
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/lib.php');

//Connect to MySQL
mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
@mysql_select_db(DB_NAME) or die("Unable to select database");

//Require the FreshDesk API Library
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/FreshdeskRest.php');

//Create New FreshDesk API Object
$fd = new FreshdeskRest(FD_URL, FD_API_USER, FD_API_PASS);

//Make sure the FD Connection Works
if ( $fd->getLastHttpStatus() != 200 ) {
	echo "Unable to connect to FreshDesk";
}

//Get Closed Tickets for Survey Checks
$tickets = theTickets($fd, CLOSED_VIEW);

foreach( $tickets as $i ) {
	
	$result = theLoop($fd, $i);
	
	if ( $result == "stop" ) {
	
		echo "No Ticket: $i ...STOP.\n";
		
		break;
		
	} else if ( $result == "danger" ) {
	
		echo "DANGER WILL ROBINSON, DANGER";
		
	} else if ( $result == "api_limit" ) {
	
		echo "\n";
		echo "*ERROR* API LIMIT REACHED\n";
		echo "LAST KNOWN TICKET: $i\n";
		
		break;
		
	} else {
		
		echo "Insert Ticket: $i\n";
		mysql_query($result);
		
	}
		
}
