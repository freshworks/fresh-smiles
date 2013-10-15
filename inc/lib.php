<?php
/**
 * File: lib.php
 * Project: fresh-smiles
 **/
 
 
//This is used to return closed ticket IDs for Checking Survey Data
function theTickets($fd, $viewId) {

	$tickets = array();

	//$i can be increased to check more tickets
	for( $i = 1; $i <= 15; $i++ ) {
		$json = $fd->getTicketView($viewId, $i);
		
		foreach( $json as $ticket ){
			array_push( $tickets, $ticket->display_id );
		}
	}
	
	return $tickets;

}

//The main loop used to get survey data 
function theLoop($fd, $i) {

	$json = $fd->getTicketSurvey($i);
	
	$response = $fd->getLastHttpResponseText();
	
	//Stupid FreshDesk doesn't give you status codes for this...
	if ( $response == "You have exceeded the limit of requests per hour" ) {
		$result = "api_limit";
	}

	else if ( isset($json->errors->error) ) { 
		$result = "stop";
	}
	
	else if ( !isset($json[0]) ) {
		
		$result = "INSERT INTO zk_smiley(created_at, updated_at, survey_created_at, survey_updated_at, ticket_id, survey_rating) VALUES(NOW(), NOW(), NULL, NULL, '{$i}', NULL) ON DUPLICATE KEY UPDATE updated_at=NOW()";
		
	}
	
	else if ( is_array($json) ) {
		foreach($json[0] as $survey_result) {
		
			$raw = array();
		
			if ( isset($survey_result->updated_at) ) {
				$raw['survey_updated_at'] = $survey_result->updated_at;
			}
			
			if ( isset($survey_result->created_at) ) {
				$raw['survey_created_at'] = $survey_result->created_at;
			}
			
			if ( isset($survey_result->rating) ) {
				$raw['survey_rating'] = $survey_result->rating;
			}
			
			foreach($raw as $key => $val){
				$safe[$key] = mysql_real_escape_string($val);
			}
			
			$result = "INSERT INTO zk_smiley(created_at, updated_at, survey_created_at, survey_updated_at, ticket_id, survey_rating) VALUES(NOW(), NOW(), '{$safe['survey_created_at']}', '{$safe['survey_updated_at']}', '{$i}', '{$safe['survey_rating']}') ON DUPLICATE KEY UPDATE updated_at=NOW(), survey_created_at='{$safe['survey_created_at']}', survey_updated_at='{$safe['survey_updated_at']}', survey_rating='{$safe['survey_rating']}'";
						
			unset($raw);
			unset($safe);
			
		}
	}
	
	else {
		$result = "danger";
	}
		
	return $result;

}

//Gravatars for Support
function gravatarHash($user) {
	$hash = md5($user);
	return $hash;
}

//Last 100 Surveys
function hundredSmiles() {
	$query = "SELECT * FROM `zk_smiley` WHERE NOT survey_rating = 'NULL' ORDER BY survey_updated_at DESC LIMIT 100";
	$ratings = mysql_query($query);
	if (!$ratings) {
		die('Invalid query: ' . mysql_error());
	} else {
		while( $rating = mysql_fetch_object($ratings) ) {
			if ( $rating->survey_rating == '1' ) {
				echo '<i class="icon-3x hundred icon-smile happy"></i>';
			}
			else if ( $rating->survey_rating == '2' ) {
				echo '<i class="icon-3x hundred icon-meh meh"></i>';
			}
			else if ( $rating->survey_rating == '3' ) {
				echo '<i class="icon-3x hundred icon-frown unhappy"></i>';
			}
			else {
				//Do Nothing
			}
		}
	}
}

//Counts for the Rating Card
function smileyRatings() {
	$query = "SELECT count(1) as count, survey_rating FROM (SELECT survey_rating FROM `zk_smiley` WHERE NOT survey_rating = 'NULL' ORDER BY survey_updated_at DESC LIMIT 100) t GROUP BY survey_rating";
	$ratings = mysql_query($query);
	if (!$ratings) {
		die('Invalid query: ' . mysql_error());
	} else {
		while( $rating = mysql_fetch_object($ratings) ) {
			if ( $rating->survey_rating == '1' ) {
				echo '<div class="overall">';
				echo '<i class="overall-score icon-smile happy"></i> <label class="label happy-score">' . $rating->count . '% said AWESOME!</label>';
				echo '</div>';
			}
			else if ( $rating->survey_rating == '2' ) {
				echo '<ul class="small-block-grid-2">';
				echo '<li class="rating-text"><i class="icon-2x icon-meh meh"></i> ' . $rating->count . ' said just OK</li>';
			}
			else if ( $rating->survey_rating == '3' ) {
				echo '<li class="rating-text"><i class="icon-2x icon-frown unhappy"></i> ' . $rating->count . ' said not good</li>';
				echo '</ul>';
			}
			else {
				//Do Nothing
			}
		}
	}
}
