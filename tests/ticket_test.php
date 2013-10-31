<?php
/**
 * File: ticket_test.php
 * Project: fresh-smiles
 **/

//Require the main configuration
require_once('../inc/config.php');

//Require the FreshDesk API Library
require_once('../inc/FreshdeskRest.php');

//Require Smiley Library
require_once('../inc/lib.php');

assert_options(ASSERT_CALLBACK,
  function($script, $line, $message) {
    echo "FAIL: $script:$line\n- $message";
    exit(1);
  }
);

//Connect to MySQL
mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
@mysql_select_db(DB_NAME) or die("Unable to select database");

//Create New FreshDesk API Object
$fd = new FreshdeskRest(FD_URL, FD_API_USER, FD_API_PASS);

assert($fd->getLastHttpStatus() == 200, "Unable to connect to FreshDesk.")
assert(strpos($fd->getLastHttpResponseText(), "requests per hour") !== false, "API Limit reached.");

//Returns 300 tickets from Closed View
$tickets = theTickets($fd, CLOSED_VIEW);
assert(count($tickets) == 300, "Three hundred tickets should have been closed.");

//This is a ticket that doesn't exist
assert(theLoop($fd, 40000) == "stop", "We simply should not have this many tickets.");

//This is a ticket that exists with no Survey
echo theLoop($fd, 32000) . "\n";

//This is a ticket that exists with a survey
echo theLoop($fd, 23195) . "\n";
