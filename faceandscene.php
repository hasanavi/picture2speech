<?php
$ch = curl_init($geocode);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if($httpCode == 200){
	$geo = json_decode($result);
		
	/*echo '<pre>';
	 print_r($geo);
	echo '</pre>';die;*/
	if(strtoupper($geo->status) == 'OK' && substr_compare($geo->results[0]->formatted_address, 'UK','-2',true) == 0){
		$lat = $geo->results[0]->geometry->location->lat;
		$lng = $geo->results[0]->geometry->location->lng;
		return $lat.'^'.$lng;
	}else
		return 'notvalid';
}else
	return 'notvalid';