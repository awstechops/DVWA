<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( ) );

dvwaDatabaseConnect();

if( isset( $_POST[ 'Login' ] ) ) {
	// Anti-CSRF
	if (array_key_exists ("session_token", $_SESSION)) {
		$session_token = $_SESSION[ 'session_token' ];
	} else {
		$session_token = "";
	}

	checkToken( $_REQUEST[ 'user_token' ], $session_token, 'login_1.php' );

	$user = $_POST[ 'username' ];
	$user = stripslashes( $user );
	$user = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $user ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

	$pass = $_POST[ 'password' ];
	$pass = stripslashes( $pass );
	$pass = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $pass ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
	//$pass = hash('sha256', $pass );
	$pass = md5($pass);

	$query = ("SELECT table_schema, table_name, create_time
			FROM information_schema.tables
			WHERE table_schema='{$_DVWA['db_database']}' AND table_name='users'
			LIMIT 1");
	$result = @mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	if( mysqli_num_rows( $result ) != 1 ) {
		dvwaMessagePush( "First time using DVWA.<br />Need to run 'setup.php'." );
		dvwaRedirect( DVWA_WEB_PAGE_TO_ROOT . 'setup.php' );
	}

	$query  = "SELECT * FROM `users` WHERE user='$user' AND password='$pass';";
	$result = @mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '.<br />Try <a href="setup.php">installing again</a>.</pre>' );
	if( $result && mysqli_num_rows( $result ) == 1 ) {    // Login Successful...
		dvwaMessagePush( "You have logged in as '{$user}'" );
		dvwaLogin( $user );
		dvwaRedirect( DVWA_WEB_PAGE_TO_ROOT . 'mfa.php' );
	}

	// Login failed
	dvwaMessagePush( 'Login failed' );
	dvwaRedirect( 'login_1.php' );
}

$messagesHtml = messagesPopAllToHtml();

Header( 'Cache-Control: no-cache, must-revalidate');    // HTTP/1.1
Header( 'Content-Type: text/html;charset=utf-8' );      // TODO- proper XHTML headers...
Header( 'Expires: Tue, 23 Jun 2009 12:00:00 GMT' );     // Date in the past

// Anti-CSRF
generateSessionToken();

echo "<!DOCTYPE html>

<html lang=\"en-GB\">

	<head>

		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />

		<title>Login :: Damn Vulnerable Web Application (DVWA)</title>

		<link rel=\"stylesheet\" type=\"text/css\" href=\"" . DVWA_WEB_PAGE_TO_ROOT . "dvwa/css/login.css\" />

		<style>
		body {
  
			   background-color: #ffffff;
			   font-family: Arial, sans-serif;
			   margin: 0;
			   padding: 0;
		 }

		 h1 {
			   text-align: center;
			   margin-bottom: 30px;
		 }

 		input[type=\"text\"],
 		input[type=\"password\"] {
			   width: 100%;
			   padding: 12px 20px;
			   margin: 8px 0;
			   display: inline-block;
			   border: 1px solid #ccc;
			   box-sizing: border-box;
			   border-radius: 4px;
		 }
	 button {
			   background-color: #4CAF50;
			   color: white;
			   padding: 14px 20px;
			   margin: 8px 0;
			   border: none;
			   cursor: pointer;
			   width: 100%;
			   border-radius: 4px;
		 }

		 button:hover {
			   opacity: 0.8;
		 }

		 .center {
			   text-align: center;
		 }
 </style>

	</head>

	<body>

	<div id=\"wrapper\">

	<div id=\"header\">

	<img src=\"" . DVWA_WEB_PAGE_TO_ROOT. "dvwa/images/TBBank.png\" width=\"500\" height=\"300\"/>

	</div> <!--<div id=\"header\">-->
	
	<div id=\"content\" style=\" max-width: 400px; margin: 100px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); padding: 40px;\">

	<form action=\"login_1.php\" method=\"post\">

	<fieldset>

			<label for=\"user\">Username</label> <input type=\"text\" class=\"loginInput\" size=\"20\" name=\"username\" required maxlength=\"30\" pattern=\"[A-Za-z0-9]+\" title=\"Username should not have spaces or special characters\"><br />

			<label for=\"pass\">Password</label> <input type=\"password\" class=\"loginInput\" AUTOCOMPLETE=\"off\" size=\"20\" name=\"password\" required pattern=\"^(?@=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$\" title=\"Password Requirements Not met\"><br />

			<button class=\"submit\" input type=\"submit\" value=\"Login\" name=\"Login\">Log In</button>

	</fieldset>

	" . tokenField() . "

	</form>

	{$messagesHtml}

	<!-- <img src=\"" . DVWA_WEB_PAGE_TO_ROOT . "dvwa/images/RandomStorm.png\" /> -->
	</div > <!--<div id=\"content\">-->

	
	</div> <!--<div id=\"wrapper\"> -->

	</body>

</html>";

?>
