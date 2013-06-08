<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
	<meta name=apple-mobile-web-app-capable content=yes>
	<meta name=apple-mobile-web-app-status-bar-style content=black>
	<title>Picture2Speech</title>   
	<link type="image/x-icon" href="favicon.ico" rel="shortcut icon">
	<link type="image/x-icon" href="favicon.ico" rel="icon">
	<link rel="apple-touch-icon" href="icons/favicon-57x57.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="icons/favicon-114x114.png" />
	<link rel="apple-touch-startup-image" href="icons/startup-320x460.png" /> <!-- When launched from home screen -->

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<style>
	html, body {
		height:100%;
	}
	
	body{
		margin:0;
		padding:0;
	}
	
	#wrapper{
		position: relative;
	  	width: 100%;
	  	height: 100%;
	  	margin: 0 auto;
	}
	
	/* media query */
	/* Portrait */
	@media screen and (orientation:portrait) {
   		#wrapper {
   			min-height:416px; /* for iPhone */
   			min-width: 320px; /* for iPhone */
   		}
	}
	/* Landscape */
	@media screen and (orientation:landscape) {
	    #wrapper {
	    	min-height:268px; /* for iPhone */
	    	min-width: 480px; /* for iPhone */
	    }
	}
</style>
</head>
<body>
<div id='wrapper'>
	<input type='text' placeholder="Type URL" id='imgUrl' />
	<input type='submit' value='click' id='submit' />
	<span id='response'></span>
</div>

<script>
	var page = document.getElementById('wrapper'),
	ua = navigator.userAgent,
	iphone = ~ua.indexOf('iPhone') || ~ua.indexOf('iPod'),
	ipad = ~ua.indexOf('iPad'),
	ios = iphone || ipad,
	// Detect if this is running as a fullscreen app from the homescreen
	fullscreen = window.navigator.standalone,
	android = ~ua.indexOf('Android'),
	lastWidth = 0;
	
	/* Need to put all settings here e.g. behaviour, API Details etc */
	var settings = {
		rekognition_api_key_scene : 'kQggHMhxOS2AAEC1',
		rekognition_api_secret_scene : '9R0Wx0FN297KWQgk'
	};
	
	window.addEventListener("load", function(e) {
		setTimeout(hideUrl, 100);
	}, false);
	//window.addEventListener("orientationchange", hideUrl ); //android old version doesn't support it 
	window.onresize = function() {
		hideUrl();
	};
	
	function hideUrl(){
		//var orient = (window.innerWidth == 320) ? "profile" : "landscape";
		var pageWidth = page.offsetWidth;
		if (lastWidth == pageWidth) return;
		lastWidth = pageWidth;
		if(android){
			page.style.height = (window.innerHeight + 56) + 'px';
		}	    
		window.scrollTo(0, 1);
	}
	
	$(function(){
		//Docuemnt ready function 
		
		
	});
</script>
</body>
</html>