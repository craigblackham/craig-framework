<?php

/**
 * post.php
 */
$page['title'] = "Post";

$page['content'] = "";

$page['sidebar'] = $system->get_side_bar_nav($url_array);

//form has been posted
if($_POST){

	//make the cURL request based on POST parameters
	$result = $system->get_cURL_response($_POST['url'], $_POST['body'], $_POST['header']);
	
	//store the request and result in a table
	$id = $system->store_post_data($_POST['url'], $_POST['body'], $_POST['header'], $result);

	//show the result
	require_once($_SERVER['DOCUMENT_ROOT']."/content/post/result_view.php");

}else{
	
	require_once($_SERVER['DOCUMENT_ROOT']."/content/post/form_view.php");
	
}

?>
