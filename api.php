<?php
include_once 'config.php';

/*

This bit should go in test driver or client side.

if(isset($_GET['imgloc']) && strlen($_GET['imgloc']) > 0){
	$imgloc = $_GET['imgloc'];
	
	//$faceInfo = detectFaceScene($imgloc,'face');
	//$sceneInfo = detectFaceScene($imgloc,'scene');
	
}else{
	echo 'Error: Invalid image location';
}
*/


function detectFaceScene($imgloc,$detection){
	$url= "http://rekognition.com/func/api/?"
			."api_key=".REKOGNITION_API_KEY
			."&api_secret=".REKOGNITION_SECRET_SCENE;
	if($detection == 'face')
		$url .=	"&jobs=".FACE_DETECTION_STRING;
	else
		$url .=	"&jobs=".SCENE_UNDERSTANDING_STRING;
	$url .= "&urls=".$imgloc;
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	if($httpCode == 200){
		$peopleInfo = json_decode($result);
		echo '<pre>';
		print_r($peopleInfo);
		echo '</pre>';die;
		//write your data to human string here
		
	}else
		return 'notvalid';
}


/* 
 Calling wrappers for IQ Engines for doing object detection.

 objectQuery() receives filename, sends it to the server for analysis and returns unique 
 image identifier needed later for fetching processed information.
  
 objectResult() sends unique image identifier receives the classification information

*/

function objectQuery($url) {
    date_default_timezone_set('UTC');
	date_default_timezone_set('UTC');
		//get file content from url
		define('ALLOWED_FILENAMES', 'jpg|jpeg|gif|png');          
		define('IMAGE_DIR', '.');       
		// validate url and get filename
		if(!preg_match('#^http://.*([^/]+\.('.ALLOWED_FILENAMES.'))$#', $url, $m)) { die('Invalid url given');  }    
		if(!$filename = file_get_contents($url))  {  echo "Not valid url";   }      
		if(!$f = fopen(IMAGE_DIR.'/'.time().'.'.$m[2], 'w')) { echo "file not open"; }       
		if (fwrite($f, $filename) === FALSE) {  
			echo "file not write";     
			}    
		else $filename = time().'.'.$m[2];       
		fclose($f); 
	
    $url = "http://api.iqengines.com/v1.2/query/";
    
    $api_key = IQ_KEY;
    $api_secret = IQ_SECRET;
    //$filename = "target-dog.jpg"; keep it here for testing
    $img = '@'.realpath($filename);
    $json = '1';
    $time_stamp = date('YmdHis');

    // Compose the api signature by alphabatically arranging input parameters
    $raw_string = 'api_key'.$api_key.'img'.$filename.'json'.$json.'time_stamp'.$time_stamp;
    
    // Hash the api signature with secret key
    $api_sig = hash_hmac("sha1", $raw_string, $api_secret, false);
    
    $fields = array(
        'api_key' => $api_key,
        'img' => $img,
        'api_sig' => $api_sig,
        'time_stamp' => $time_stamp,
        'json' => $json
    );
    
    $fields_string = "";
    foreach($fields as $key=>$value) { 
        $fields_string .= $key.'='.$value.'&'; 
    }
    rtrim($fields_string,'&');
    
    // generate a curl request at api endpoint
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // RETURN THE CONTENTS OF THE CALL
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_HEADER, false);  // DO NOT RETURN HTTP HEADERS 
    $response = curl_exec($ch);

    /*
	Below is a quick hack which returns api_siq if server replies with error=0.
	Really this needs to be fixed properly.
	*/
    
    if ($response[19] == 0) {  
    	return $api_sig;  
    	} else {
    		// We should handle this failure properly so user can retry
    		echo "Error: Image 	upload failed <br/>";
    }
  
}  



function objectResult($qid){
  	date_default_timezone_set('UTC');
	 
    $url = "http://api.iqengines.com/v1.2/result/";
    
    $api_key = IQ_KEY;
    $api_secret = IQ_SECRET;
    $timestamp = date('YmdHis');
    $json = '1';
    
    
     // Compose the api signature by alphabatically arranging input parameters
    $raw_string = 'api_key'.$api_key.'json'.$json.'qid'.$qid.'time_stamp'.$timestamp;
    $api_sig = hash_hmac("sha1", $raw_string, $api_secret,false);
    $fields = array(
    	'qid' => $qid,
        'api_key' => $api_key,
        'api_sig' => $api_sig,
        'time_stamp' => $timestamp,
        'json' => $json
    );
    $fields_string = "";
    foreach($fields as $key=>$value) { 
        $fields_string .= $key.'='.$value.'&'; 
    }
    rtrim($fields_string,'&');
    
    // generate a curl request at api endpoint
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // RETURN THE CONTENTS OF THE CALL
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_HEADER, false);  // DO NOT RETURN HTTP HEADERS 
    $response = curl_exec($ch);
    /* Currently we just return the server response as json. This contains the object 
       recognition info that needs to be extracted and made into readble text
    */
    return $response;

}
	
  
  
  
  
  


?>