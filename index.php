<?php
/**
 * index.php main file
 *
 * @author Craig
 */

session_start();
ob_start();

//set document root
if($_SERVER['DOCUMENT_ROOT'] == "") $_SERVER['DOCUMENT_ROOT'] = "/mnt/c/www";

//include common classes
require_once($_SERVER['DOCUMENT_ROOT']."/libraries/class.phpmailer.php");
require_once($_SERVER['DOCUMENT_ROOT']."/libraries/class.system.php");

//instantiate the system object
$system = new System();

//set error display
$system->debug = true;
$system->set_error_display();
//$system->send_error("foo", "bar");

//connect to database
$system->db_name = "framework";
if ( !$conn = $system->db_connect() ){
	$_SESSION['alert'] = "ERROR: database {$system->db_name} not connected";
}

//see if cookie has been set for persistent sign-in
$cookie_token = "no cookie";
if (isset($_COOKIE['cf_token'])) $cookie_token = $_COOKIE['cf_token'];

//parse the url for system variables
$url_array = $system->get_url_vars();

if (isset($url_array[0])){

	//check for api request and exit
	if ($url_array[0] == "api"){
		require_once("api/api_controller.php");
		mysql_close($system->conn);
		exit;
	}

	//sign out request
	if ($url_array[0] == "sign_out") $system->sign_out();

}

//set default page attributes
$page = $system->get_default_page($url_array);

//default content
$content_file = "content/home.php";

if ($conn){ //db is connected

	//get the signed in user
	if (isset($_COOKIE['auth_token'])) $system->user = $system->get_user_by_token($_COOKIE['auth_token']);

	//set the acl for signed in users
	if ($system->user) $system->acl = $system->get_acl();

	//determine content file to load
	if (count($url_array)){
		$content_file = "content/{$url_array[0]}.php";
		//leave it to the parent content file to load sub-pages
		//if (!empty($url_array[1])){
		//	$content_file = "content/{$url_array[0]}/{$url_array[1]}.php";
		//}
	}

	//check for restricted page access
	if ($system->url_is_restricted()){  //check for page restriction
		if ($system->user){
			if (!$system->user_is_authorized()){
				$system->error = 'acl';
			}
		}else{
			$system->error = 'user';
		}
	}

	//check ip is authorized for non-logged in users
	if (! $system->user){
		if (! $system->ip_is_authorized($_SERVER['REMOTE_ADDR']) ) $system->error = 'ip';
	}

	//over-ride sign_in so it looks in /system instead of /content
	if (!empty($url_array[0]) && $url_array[0] == "sign_in") $content_file = "system/sign_in.php";

	//check for file exists
	if (!file_exists($_SERVER['DOCUMENT_ROOT']."/".$content_file)){
		$system->error = 'not_found';
	}

}

//load the content file if there are no problems(overrides default page attributes)
if ($system->error){
	$page = $system->get_notice_page();
}else{
	require_once($content_file);
}

//$system->show_debug_info($page);

//set the alert message
if (!empty($_SESSION['alert'])) $page['alert'] = $_SESSION['alert'];

//set up toolbar - can be overwritten or added to in content file
$page['icons'] = $system->get_toolbar_icon("print", "#", "Print");

//show the content with html layout
require_once("theme/layout.php");

//unset session records so they don't persist across pages
unset($_SESSION['last_update'], $_SESSION['alert']);

?>
