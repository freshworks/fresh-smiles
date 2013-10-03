<?php
/**
 * File: ticket_test.php
 * Project: zk-smiley
 **/

//Require the main configuration
require_once('inc/config.php');

//Require the FreshDesk API Library
require_once('inc/FreshdeskRest.php');

//Create New FreshDesk API Object
$fd = new FreshdeskRest(FD_URL, FD_API_USER, FD_API_PASS);

if ( $fd->getLastHttpStatus() != 200 ) {
	echo "Unable to connect to FreshDesk";
}

$json = $fd->getTicketSurvey(147);

print_r($json);