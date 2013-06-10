<?php
include_once 'api.php';

require_once('facebook-php-sdk/src/facebook.php');

session_unset();
$facebook = new Facebook(array(
		'appId'  => FB_APP_ID,
		'secret' => FB_SECRET_ID,
));

$user = $facebook->getUser();
$result_string = '';

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
    $user_post = $facebook->api('/737515020_10152446735575021');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl(array('scope' => 'read_stream, email'));
}

if(isset($_GET['init_fb']) && $_GET['init_fb'] == 1){
	$imgloc = IMG_URL;
	$imgName = IMG_NAME;
	//$img_qid = objectQuery($imgName);
// 	echo "1. Server returned this qid: <br/>";
// 	echo $img_qid;
	
	$faceData = detectFaceScene($imgloc,'face');
	$sceneData = detectFaceScene($imgloc,'scene');
	
	//sleep(5);
	//$objectData = (array) json_decode(objectResult($img_qid));
	
// 	echo '<pre>';
// 		print_r($faceData);
// 	echo '</pre>';
	
// 	$first = $faceData->face_detection[0];
// 	$second = $faceData->face_detection[1];
	
// 	echo '<pre>';
// 		print_r($sceneData);
// 	echo '</pre>';
	
	//print_r($objectData);die;
	
	//$obj = $objectData['data']->results->labels == 'Dog' ? 'black, dog' : $objectData['data']->results->labels;
// 	$numberOfPeople = count($faceData->face_detection);
	$result_string = 'Hasan Azizul Haque\'s status. This is a sample status for accessibility hackathon. The image should read to the vision impaired people. He has posted a picture with the status. The picture was taken in Capetown South Africa beside a beach.'.
					'It was a sunny day. There are 2 person. First person is a young female. Second person is a young male, He is smiling. he is wearing a glass. There is a black dog beside them';
}
?>

<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
  	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Visual-Eyes</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
        background: #EFEFEF;
        text-align: left;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
      #abc{
      	color: #FFF;
      	text-decoration: none;
      	margin: 0 auto;
      	display: block;
      	width: 80%;
      	margin-top: 40px;
      }
      .bigAnchor{
      	font-size: 30px;
      	display:block;
      	background: #3d3d3d;
      	color: #FFF;
      	width: 100%;
      	text-decoration: none;
      	text-align: center;
      	margin: 10px 0;
      }
      
      #result{
      	background: #2d2d2d;
      	height: 100px;
      	overflow: auto;
      	display: block;
      	clear: both;
      	color: #FFFFFF;
      }
    </style>
  </head>
  <body>
    <h1>Visual-Eyes</h1>
	<?php if(isset($_GET['init_fb']) && $_GET['init_fb'] == 1){ ?>
	    <?php if ($user): ?>
	      <a href="<?php echo $logoutUrl; ?>">Facebook Logout</a>
	    <?php else: ?>
	      <div>
	        Login using OAuth 2.0 handled by the PHP SDK:
	        <a href="<?php echo $loginUrl; ?>">Logout from Facebook</a>
	      </div>
	    <?php endif ?>
			
	    <?php if ($user): ?>
	      <h3>Your Post Object (/me)</h3>
	    <?php else: ?>
	      <strong><em>You are not Connected.</em></strong>
	    <?php endif ?>
    <?php } ?>
    	<span id='result'><?php echo $result_string; ?></span>
    	<a id='abc' href='index.php?init_fb=1'><span class='bigAnchor'>Get Facebook Status</span></a>
  </body>
</html>
