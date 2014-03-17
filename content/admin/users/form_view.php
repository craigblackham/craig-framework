<?php

require_once($_SERVER['DOCUMENT_ROOT']."/libraries/class.form.php");

//get valid roles from restricted content
$roles = $o_admin->get_contents();
//var_dump($roles);

//instantiate form object
$form = new Form();

//set the form action
$form->action = "/admin/users/";

//$form->maintenance_mode = true;
$form->handle = "users";

//set form values
if (is_numeric($url_array[3])){
	$primary_key = (int)$url_array[3];
	$user = $o_admin->get_user($primary_key);
	//var_dump($user);
	if (count($user)){
		$form->record_key = $primary_key;
		foreach($user[$primary_key] as $key=>$value){
			if ($key == "user_acl"){ //special processing for the acl
				foreach($value as $content_pk=>$acl_level){
					$form->values["content_pk_".$content_pk] = $acl_level;
				}
			}else{
				$form->values[$key] = $value;
			}
		}
	}
}

//$options = array(0=>"none",1=>"view"); //,2=>"edit"

$form->add_input("user_name", "User Name", array("required"=>1));

$form->add_input("user_token", "User Token", array("required"=>1));

$form->add_checkbox("user_active", "Active", "1");

$form->add_heading("Restricted Content");

//get_user_acl($user_id, $conn)
foreach ($roles as $role){

	//$form->add_radio("pk_".$role['content_pk'], $role['content_url'], $options);
	$form->add_checkbox("content_pk_".$role['content_pk'], $role['content_label'], "1");

}

$form->add_submit("Save");

echo $form->show_form();


?>
