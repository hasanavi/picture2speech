<?php
include_once 'api.php';


/* Test driver for IQ Engines wrapper. This should ideally be an HTML page with image.
	Add some error handling here
	
	These calls need to be run with some delay as the server take some time to process 
	and register results. 
*/
$imgloc="3.jpg";
$img_qid = objectQuery($imgloc);
echo "1. Server returned this qid: <br/>"; 
echo $img_qid;

sleep(5);

$resp = objectResult($img_qid);
echo "<br>2. Server processed image with response:<br/>";
echo $resp;

?>