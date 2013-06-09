<?php
include_once 'api.php';


/* Test driver for IQ Engines wrapper. This should ideally be an HTML page with image.
	Add some error handling here
	
	These calls need to be run with some delay as the server take some time to process 
	and register results. 
*/
$imgloc="3.jpg";
$img_qid = objectQuery($imgloc); 
echo $img_qid;

sleep(5);

$resp = objectResult($img_qid);
echo "<br> Received following server response";
echo $resp;

?>