<?
/**
 * users/list_view.php shows start dates
 */

//add the icon for add new user to toolbar
$toolbar_icons = $system->add_toolbar_icon("user_add", "/admin/users/edit/new/", "Add User");

$users = $o_admin->get_users();

if (count($users)){

	//table options
	$options['header'] = array("ID", "Name", "Active");
	$options['exclude'] = array("user_token");
	$options['format'] = array("user_active"=>"boolean");
	$options['action'] = array("edit"=>"/admin/users/edit/");

	if ($user_table = $system->generate_html_table($users, $options)){

		echo $user_table;

	}

}else{

	echo "No records found.";

}

?>
