# Visual-Eyes

A web-service for  vision impaired people that provides meaningful alternative text for images on websites.

Currently we are utilizing cloud based image processing apis from rekognition.com (face and scene detection) and iqengines.com (object recognition)

# Rekognition face & scene detection
_TBD_

# IQ Engines object recognition

*objectQuery()*: 	Send an image to the IQ Engines server, which will extract
				its visual content
Parameters: Input image file name
Returns: Unique query id associated with the input image

*resultQuery()*: Request classification information for an image using unique identifier
				 that was generated when posting the image initially
Parameters: Unique image indentifier
Returns: Currenly plain json response from the server, containing all the useful bits

# Generate the sentence (story) based on picture metadata

*generateStory()*: Request metadata from an image to train into a human readable sentence. Require further training the metadata from the community...  


# Transform the sentence into speech
  
 *using built-in voiceOver function from across mobiles.

## API endpoints
We currently use only the following calls:

*queryApi*: http://api.iqengines.com/v1.2/query/
docs: https://www.iqengines.com/apidocs/apis/query-api.html

*resultApi*:  http://api.iqengines.com/v1.2/result/
docs https://www.iqengines.com/apidocs/apis/result-api.html

## API caveats
	1. Each API call should be associated with a unique api_sig hash
    2. api_sig is generated by hashing input variables in _alphabatical_ order
    3. The api_sig that is computed while posting an image to the server, needs to be
    	tracked as it is used as a unique identifier to fetch the results on that
    	image in all subsequent calls.
    4. Each and every api call should have its own unique api_sig.
    5. The query sends image as HTML multipart POST



## Additions for config.php

    define('IQ_KEY','dc5a9b2a0e234576803410282ea7931d');
    define ('IQ_SECRET','c0afe3842d004ce6ac5bb9014dd45ea2');
    define ('QUERYAPI','http://api.iqengines.com/v1.2/query/');
    define ('RESULTAPI','http://api.iqengines.com/v1.2/result/');


*/
