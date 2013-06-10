<?php
include_once 'api.php';

require_once('facebook-php-sdk/src/facebook.php');

session_unset();
$facebook = new Facebook(array(
		'appId'  => '161035304079259',
		'secret' => '869fb8f64259e9337d138d6e15b7db3a',
));

$user = $facebook->getUser();

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

//$myPost = $facebook->api('/737515020_10152446735575021');

//print_r($myPost);

/* Test driver for IQ Engines wrapper. This should ideally be an HTML page with image.
	Add some error handling here
	
	These calls need to be run with some delay as the server take some time to process 
	and register results. 
*/
//$imgloc="3.jpg";
//$imgloc = 'http://www.capetowndailyphoto.com/uploaded_images/couple_dog_beach_IMG_0419-794455.jpg';
//$img_qid = objectQuery($imgloc);
// echo "1. Server returned this qid: <br/>";
// echo $img_qid;

//sleep(5);

//detectFaceScene('http://www.capetowndailyphoto.com/uploaded_images/couple_dog_beach_IMG_0419-794455.jpg','face');
//detectFaceScene('http://www.capetowndailyphoto.com/uploaded_images/couple_dog_beach_IMG_0419-794455.jpg','scene');

//$resp = objectResult($img_qid);

//echo $faceInfo;
//echo $sceneInfo;

?>

<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>Picture2Speech</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <h1>Picture2Speech</h1>

    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Facebook Logout</a>
    <?php else: ?>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

    <h3>PHP Session</h3>
    <pre><?php print_r($_SESSION); ?></pre>

    <?php if ($user): ?>
<!--       <h3>You</h3> -->
<!--       <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">-->

      <h3>Your Post Object (/me)</h3>
      <pre><?php print_r($user_post); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>
  </body>
</html>
