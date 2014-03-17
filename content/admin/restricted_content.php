<?
/**
 * ip_admin.php manage authorized ip address
 */

require_once($_SERVER['DOCUMENT_ROOT']."/libraries/class.admin.php");

//instantiate leads class
$o_admin = new Admin();
$o_admin->conn = $conn;

//process post if present
if($_POST){

	$save_ok = false;

	if(empty($_POST['record_key'])){
		if ($save_ok = $o_admin->insert_content($_POST)){
			$_SESSION['sysmsg'] = "Record Added";
		}
	}else{
		if ($save_ok = $o_admin->update_content($_POST)){
			$_SESSION['sysmsg'] = "Record Updated";
		}
	}

	if (!$save_ok) $_SESSION['sysmsg'] = "ERROR: problem saving form data";

	$system->redirect("/admin/restricted_content/");

}

if (isset($url_array[2]) && $url_array[2] == "delete"){
	if (is_numeric($url_array[3])){
		if ($result = $o_admin->delete_content($url_array[3])){
			$_SESSION['sysmsg'] = "Record Deleted";
			$system->redirect("/admin/restricted_content/");
		}
	}
}

if (isset($url_array[2]) && $url_array[2] == "edit"){

	require_once("restricted_content/form_view.php");

}else{

	require_once("restricted_content/list_view.php");

}

$page_content = ob_get_contents();
ob_get_clean();
?>
