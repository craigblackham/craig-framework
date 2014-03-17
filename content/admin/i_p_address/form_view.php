<?php

require_once($_SERVER['DOCUMENT_ROOT']."/libraries/class.form.php");

//instantiate inquire object
$form = new Form();

//set the form action
$form->action = "/admin/i_p_address/";

//$form->maintenance_mode = true;
$form->handle = "i_p_address";

//set form values
if (is_numeric($url_array[3])){
	$primary_key = (int)$url_array[3];
	$data = $o_admin->get_ip_address($primary_key);
	if (count($data)){
		$form->record_key = $primary_key;
		foreach($data[$primary_key] as $key=>$value){
			$form->values[$key] = $value;
		}
	}
}

//$name, $label, $rules
$form->add_input("auth_ip", "IP Address", array("required"=>1));

$form->add_input("auth_note", "Note", array("required"=>1));

$form->add_submit("Save");

echo $form->show_form();


?>
