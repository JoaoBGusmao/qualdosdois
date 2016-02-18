<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!isset($block)) {
  $block = false;
if(isset($_GET["redirect"])) {
  $_SESSION["redirect"] = $_GET["redirect"];

}
require_once ('libraries/Google/autoload.php');

//Insert your cient ID and secret 
//You can get it from : https://console.developers.google.com/
$client_id = '643051721261-m8u2sqrrruvf57ur37u36h8ifb0i4ai9.apps.googleusercontent.com'; 
$client_secret = 'SYTMoC5UoKzoCLDgzFHhpINp';
$redirect_uri = 'http://localhost/qualdosdois/login/Google/loginwithgoogle.php';

/************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
 ************************************************/
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

/************************************************
  When we create the service here, we pass the
  client to it. The client then queries the service
  for the required scopes, and uses that when
  generating the authentication URL later.
 ************************************************/
$service = new Google_Service_Oauth2($client);

/************************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself.
*/
  
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  exit;
}

/************************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
 ************************************************/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}


//Display user info or display login url as per the info we have.
if (!isset($authUrl)){
  $user = $service->userinfo->get(); //get user info 
	$_SESSION["id"] = $user["id"];
	$_SESSION["name"] = $user["name"];
	$_SESSION["email"] = $user["email"];
	$_SESSION["picture"] = $user["picture"];
	$_SESSION["login_provider"] = "G";
  header("Location: ".$_SESSION["redirect"]);
} else {
  header("Location: ".$authUrl);
}
}
?>