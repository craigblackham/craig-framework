<?php
/**
 * noauth.php
 */

$page['title'] = "Sign In";

require_once($_SERVER['DOCUMENT_ROOT']."/libraries/class.form.php");

//process post if present
if($_POST){

	if($user = $system->get_user_by_token($_POST['token'])){

		setcookie("auth_token", $_POST['token'], time()+60*60*24*10, "/");

		$redir = $_POST['referrer'];
		header("location: $redir");
		exit;
	}

	$_SESSION['alert'] = "ERROR: user not found";
	$system->redirect("/sign_in/");

}

?>

<div class="notice_img">
		<img src="theme/images/robot.png" width="150" alt="robot" />
</div>
<div class="notice">
	<p>Please enter your access token to sign in.</p>

<?php

//instantiate object
$o_form = new Form();

//set the form action
$o_form->action = $_SERVER['REQUEST_URI'];

$o_form->handle = "sign_in";

$o_form->add_input("token", "Access Token", array("required"=>1));

$o_form->add_submit("Submit");

echo $o_form->show_form();

?>

</div>

<script type="text/javascript">

	document.form1.token.focus();

</script>

<?php

$page['content'] = ob_get_contents();
ob_get_clean();

?>
