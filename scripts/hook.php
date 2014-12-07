<?php
/**
* File: cron.php
* Project: fresh-smiles
**/

//Stuff to make it not die
ignore_user_abort(true);

if (!isset($_REQUEST['freshdesk_webhook']['ticket_id']) || !is_numeric($_REQUEST['freshdesk_webhook']['ticket_id'])) {
	echo "Nothing to be done.";
	exit(0);
}

//Require the main configuration
require_once(__DIR__ . '/../inc/config.php');

//Require Smiley Library
require_once(__DIR__ . '/../inc/lib.php');

//Connect to MySQL
mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
@mysql_select_db(DB_NAME) or die("Unable to select database");

//Require the FreshDesk API Library
require_once(__DIR__ . '/../inc/FreshdeskRest.php');

//Create New FreshDesk API Object
$fd = new FreshdeskRest(FD_URL, FD_API_USER, FD_API_PASS);

//Make sure the FD Connection Works
if ( $fd->getLastHttpStatus() != 200 ) {
	echo "Unable to connect to FreshDesk";
}


$id = $_REQUEST['freshdesk_webhook']['ticket_id'];
//Get Survey Response for the received ticket id

$result = theLoop($fd, $id, true);

if ( $result == "stop" ) {
	
	echo "No Ticket: $id ...STOP.\n";
	
	break;
	
} else if ( $result == "danger" ) {
	
	echo "DANGER WILL ROBINSON, DANGER";
	
} else if ( $result == "api_limit" ) {
	
	echo "\n";
	echo "*ERROR* API LIMIT REACHED\n";
	echo "LAST KNOWN TICKET: $i\n";
	
	break;
	
} else {
	
	echo "Updated Ticket: $id\n";
	mysql_query($result);
	
}
