<?
/**
 * i_p_address/list_view.php
 */

//add the icon for add new date to toolbar
$toolbar_icons = $system->add_toolbar_icon("add", "/admin/i_p_address/edit/new/", "Add IP Address");

$data = $o_admin->get_ip_addresses();

if (count($data)){

	//table options
	$options['header'] = array("Address", "Note");
	$options['exclude'] = array("auth_pk");
	$options['action'] = array("edit"=>"/admin/i_p_address/edit/", "delete"=>"/admin/i_p_address/delete/");

	if ($table = $system->generate_html_table($data, $options)){

		echo $table;

	}

}else{

	echo "No records found.";

}

?>
