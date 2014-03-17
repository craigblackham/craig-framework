<?
/**
 * ip_admin/list_view.php
 */

//add the icon for add new date to toolbar
$toolbar_icons = $system->add_toolbar_icon("add", "/admin/restricted_content/edit/new/", "Add Content");

$data = $o_admin->get_contents();

if (count($data)){

	//table options
	$options['header'] = array("Label", "URL");
	$options['exclude'] = array("content_pk");
	$options['action'] = array("edit"=>"/admin/restricted_content/edit/", "delete"=>"/admin/restricted_content/delete/");

	if ($table = $system->generate_html_table($data, $options)){

		echo $table;

	}

}else{

	echo "No records found.";

}

?>
