<?php

require_once($_SERVER['DOCUMENT_ROOT']."/libraries/class.form.php");

//instantiate inquire object
$form = new Form();

//set the form action
$form->action = "/admin/restricted_content/";

//$form->maintenance_mode = true;
$form->handle = "restricted_content";

//set form values
if (is_numeric($url_array[3])){
	$primary_key = (int)$url_array[3];
	$data = $o_admin->get_content($primary_key);
	if (count($data)){
		$form->record_key = $primary_key;
		foreach($data[$primary_key] as $key=>$value){
			$form->values[$key] = $value;
		}
	}
}

//$name, $label, $rules
$form->add_input("content_label", "Label", array("required"=>1));

$form->add_input("content_url", "URL", array("required"=>1));

$form->add_submit("Save");

echo $form->show_form();


?>
