<?php

/**
 * campus form_view.php
 */
require_once($_SERVER['DOCUMENT_ROOT']."/libraries/class.form.php");

//instantiate form object
$o_form = new Form();
//var_dump($o_form);
//$o_form->conn = $conn;

//set the form action
$o_form->action = "/post/";

$o_form->handle = "post";

$o_form->add_heading("Postman Hack");

$o_form->add_input("url", "URL", array("required"=>1));

$options = array(1=>"foo", 2=>"bar", 3=>"ain't nobody got time for that");
$o_form->add_select("setting", $options, "The Setting", array("required"=>1));

$o_form->add_input("my_input", "My Input", array("required"=>1));

$o_form->add_textarea("header", "Headers", array(), false);

$o_form->add_textarea("body", "Body", array("required"=>1), false, "5");

$o_form->add_submit("Submit");

$page['content'] = $o_form->show_form();

?>