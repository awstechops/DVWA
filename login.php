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

checkToken( $_REQUEST[ 'user_token' ], $session_token, 'login.php' );

$user = $_POST[ 'username' ];
$user = stripslashes( $user );
$user = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $user ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

$pass = $_POST[ 'password' ];
$pass = stripslashes( $pass );
$pass = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $pass ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
$salt = rand();
$result = md5($salt);

$pass =  hash('sha256',$pass. $result);


$query = ("SELECT table_schema, table_name, create_time
			FROM information_schema.tables
			WHERE table_schema='{$_DVWA['db_database']}' AND table_name='users'
			LIMIT 1");
$result = @mysqli_query($GLOBALS["___mysqli_ston"],  $query );
if
<a href=\"#solutions\">Solutions</a>
<a href=\"#help\">Help</a>
</div>

<br />

</div> <!--<div id=\"header\">-->

