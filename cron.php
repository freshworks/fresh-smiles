<?php
/**
 * File: cron.php
 * Project: zk-smiley
 **/

//Require the main configuration
require_once('inc/config.php');

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
$i = 1;

while ( $i != 0 ) {
	$json = $fd->getTicketSurvey($i);
	
	if ( isset($json->errors->error) ) {
		if ( $i < 30000 ) {
			echo "No Ticket: $i ...Continuing.\n";
			$i++;
		} else {
			echo "No Ticket: $i ...STOP.\n";
			$i = 0;
		}
	} else if ( !isset($json[0]) ) {
		
		//Insert Basic Ticket Info so we can update later
		$query = "INSERT INTO zk_smiley(created_at, updated_at, survey_created_at, survey_updated_at, ticket_id, survey_rating) VALUES(NOW(), NOW(), NULL, NULL, '{$i}', NULL) ON DUPLICATE KEY UPDATE updated_at=NOW()";
		mysql_query($query);
		echo "No Survey for Ticket: $i\n";
		
		//Increment Ticket #
		$i++;
		
	} else if ( is_array($json) ) {
		foreach($json[0]->survey_result as $result) {
		
			$raw = array();
		
			if ( isset($result->updated_at) ) {
				$raw['survey_updated_at'] = $result->updated_at;
			}
			
			if ( isset($result->created_at) ) {
				$raw['survey_created_at'] = $result->created_at;
			}
			
			if ( isset($result->rating) ) {
				$raw['survey_rating'] = $result->rating;
			}
			
			foreach($raw as $key => $val){
				$safe[$key] = mysql_real_escape_string($val);
			}
			
			$query = "INSERT INTO zk_smiley(created_at, updated_at, survey_created_at, survey_updated_at, ticket_id, survey_rating) VALUES(NOW(), NOW(), '{$safe['survey_created_at']}', '{$safe['survey_updated_at']}', '{$i}', '{$safe['survey_rating']}') ON DUPLICATE KEY UPDATE updated_at=NOW(), survey_created_at='{$safe['survey_created_at']}', survey_updated_at='{$safe['survey_updated_at']}', survey_rating='{$safe['survey_rating']}'";
			mysql_query($query);
			
			unset($raw);
			unset($safe);
			
			echo "Survey for Ticket: $i\n";
			
		}
		
		//Increment Ticket #
		$i++;
		
	} else {
		echo "DANGER WILL ROBINSON, DANGER";
	}
}
