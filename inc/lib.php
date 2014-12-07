<?php
/**
 * File: lib.php
 * Project: fresh-smiles
 **/
 
 
//This is used to return closed ticket IDs for Checking Survey Data
function theTickets($fd, $viewId) {

	$tickets = array();

	//$i can be increased to check more tickets
	for( $i = 1; $i <= 3; $i++ ) {
		$json = $fd->getTicketView($viewId, $i);
		
		foreach( $json as $ticket ){
			array_push( $tickets, $ticket->display_id );
		}
	}
	
	return $tickets;

}

//The main loop used to get survey data 
function theLoop($fd, $i, $use_current_time = false) {

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
		$result = "continue";
		// $result = "INSERT INTO fresh_smiles(created_at, updated_at, survey_created_at, survey_updated_at, ticket_id, survey_rating) VALUES(NOW(), NOW(), NULL, NULL, '{$i}', NULL) ON DUPLICATE KEY UPDATE updated_at=NOW()";
		
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
      
      if ($use_current_time) {
        $raw['survey_updated_at'] = 'NOW()';
        $raw['survey_created_at'] = 'NOW()';
      }
			
			$result = "INSERT INTO fresh_smiles(created_at, updated_at, survey_created_at, survey_updated_at, ticket_id, survey_rating) VALUES(NOW(), NOW(), '{$safe['survey_created_at']}', '{$safe['survey_updated_at']}', '{$i}', '{$safe['survey_rating']}') ON DUPLICATE KEY UPDATE updated_at=NOW(), survey_created_at='{$safe['survey_created_at']}', survey_updated_at='{$safe['survey_updated_at']}', survey_rating='{$safe['survey_rating']}'";
						
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
	$query = "SELECT * FROM `fresh_smiles` WHERE NOT survey_rating = 'NULL' ORDER BY survey_updated_at DESC LIMIT 100";
	$ratings = mysql_query($query);
	$results = array();
	if (!$ratings) {
		die('Invalid query: ' . mysql_error());
	} else {
		while( $rating = mysql_fetch_object($ratings) ) {
			$results[] = $rating->survey_rating;
		}

		return "[" . implode(', ', $results) . "]";
	}
}

//Counts for the Rating Card
function smileyRatings() {
	$query = "SELECT count(1) as count, survey_rating FROM (SELECT survey_rating FROM `fresh_smiles` WHERE NOT survey_rating = 'NULL' ORDER BY survey_updated_at DESC LIMIT 100) t GROUP BY survey_rating";
	$ratings = mysql_query($query);
	if (!$ratings) {
		die('Invalid query: ' . mysql_error());
	} else {
		$result = array();
		$total = 0;
		while( $rating = mysql_fetch_object($ratings) ) {
			
			error_log(print_r($rating, true));
			if ( $rating->survey_rating == '1' || $rating->survey_rating == '2' || $rating->survey_rating == '3' ) {
				$result[$rating->survey_rating] = $rating->count;
				$total += $rating->count;
			}
		}
		$result['percent'] = isset($ratings['1']) ? ceil($ratings[1] * 100 / $total) : 0;
		return $result;
	}
}

function displayOverall() {
	$ratings = smileyRatings();
	$checks = array('1','2','3');
	$total = 0;
	foreach ($checks as $value) {
		if (!isset($ratings[$value])) 
			$ratings[$value] = 0;
		else
			$total += $ratings[$value];
	}
	foreach ($checks as $value) {
		$percent[$value] = ceil($ratings[$value] * 100 / $total);
	}
	echo '<div class="report_message text_center happy ">
                                    ' . $percent['1'] . '% said AWESOME!
                                </div>
                                 <div class="cr_sub_report top_space cf">
                                    <div class="okay_text">
                                        <img src="img/smiley_okay.png" alt="Customer_okay"> 
                                        <span>' . ($percent['2']). '% said just OK </span>
                                    </div>
                                    <div class="sad_text">
                                        <img src="img/smiley_sad.png" alt="Customer_okay"> 
                                        <span>' . ($percent['3'] ). '% said not so good</span>
                                    </div>
                                </div>';
}
