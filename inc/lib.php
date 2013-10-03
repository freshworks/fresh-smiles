<?php
/**
 * File: lib.php
 * Project: zk-smiley
 **/
 
function theLoop($fd, $i, $max) {

	$json = $fd->getTicketSurvey($i);

	if ( isset($json->errors->error) ) {
		//This is a really stupid hack job... 
		if ( $i < $max ) {
			$result = "continue";
		} else {
			$result = "stop";
		}
	} else if ( !isset($json[0]) ) {
		
			$result = "no_survey";
		
	} else if ( is_array($json) ) {
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
		
	} else {
		$result = "DANGER WILL ROBINSON, DANGER";
	}
	
	return $result;
	
}

