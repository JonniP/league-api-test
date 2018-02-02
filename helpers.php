<?php

function getinfo($url){
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	$response = curl_exec($ch);
	curl_close($ch);
	return json_decode($response, true);
	

}

function getname($champId){
	return "Miss Fortune";
	}


?>
