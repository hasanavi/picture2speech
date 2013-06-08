<?php
include_once 'config.php';

if(isset($_GET['imgloc']) && strlen($_GET['imgloc']) > 0){
	$imgloc = $_GET['imgloc'];
	
	$faceSceneInfo = faceAndSceneDetection($imgloc);
	
}else{
	echo 'sory not a valid image location';
}

function faceAndSceneDetection($imgloc){
	$url= "http://rekognition.com/func/api/?"
			."api_key=".REKOGNITION_API_KEY
			."&api_secret=".REKOGNITION_SECRET_SCENE
			."&jobs=".DETECTION_STRING
			."&urls=".$imgloc;
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	if($httpCode == 200){
		$peopleInfo = json_decode($result);
		echo '<pre>';
		print_r($peopleInfo);
		echo '</pre>';die;
		
	}else
		return 'notvalid';
}

function objectDetection(){
	
}

?>