<?
/**
 * users.php manage users
 */

require_once($_SERVER['DOCUMENT_ROOT']."/libraries/class.admin.php");

//instantiate leads class
$o_admin = new Admin();
$o_admin->conn = $conn;

//process post if present
if($_POST){

	$save_ok = false;

	if(empty($_POST['record_key'])){
		if ($user_id = $o_admin->insert_user($_POST)){
			$save_ok = true;
			$_SESSION['sysmsg'] = "Record Added";
		}
	}else{
		if ($o_admin->update_user($_POST)){
			$user_id = $_POST['record_key'];
			$save_ok = true;
			$_SESSION['sysmsg'] = "Record Updated";
		}
	}

	if ($save_ok){

		$roles = $o_admin->get_contents();

		if (!$o_admin->set_user_acl($user_id, $_POST, $roles)) $save_ok = false;

	}

	if (!$save_ok) $_SESSION['sysmsg'] = "ERROR: problem saving form data";

	$system->redirect("/admin/users/");

}

if (isset($url_array[2]) && $url_array[2] == "edit"){

	require_once("users/form_view.php");

}else{

	require_once("users/list_view.php");

}

$page_content = ob_get_contents();
ob_get_clean();
?>
