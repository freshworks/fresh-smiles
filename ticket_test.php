<?php
/**
 * File: ticket_test.php
 * Project: zk-smiley
 **/

//Require the main configuration
require_once('inc/config.php');

//Require the FreshDesk API Library
require_once('inc/FreshdeskRest.php');

//Require Smiley Library
require_once('inc/lib.php');

//YES Debugging in TEST
define('DEBUG', TRUE);

//Create New FreshDesk API Object
$fd = new FreshdeskRest(FD_URL, FD_API_USER, FD_API_PASS);

if ( $fd->getLastHttpStatus() != 200 ) {
	echo "Unable to connect to FreshDesk";
}

//This is a ticket that doesn't exist
echo theLoop($fd, 40000, UPPER_LIMIT) . "\n";

//This is a ticket that exists with no Survey
echo theLoop($fd, 32000, UPPER_LIMIT) . "\n";

//This is a ticket that exists with a survey
echo theLoop($fd, 32882, UPPER_LIMIT) . "\n";
