<?php

/**
 * layout.php the html frame that all content goes into
 *
 **/

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<title>Craig <?=$page['title']?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<base href="http://<?=$_SERVER['HTTP_HOST']?>">
	<link rel="shortcut icon" type="image/ico" href="http://<?=$_SERVER['HTTP_HOST']?>/favicon.ico">
	<link rel="stylesheet" type="text/css" href="theme/css/main.css">
	<link rel="stylesheet" type="text/css" media="print" href="theme/css/print.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script type="text/javascript" src="js/autoload.js"></script>
</head>
<body>

<div id="cf-header">
	<div id="cf-header-logo"><a id="logo" href="http://<?=$_SERVER['HTTP_HOST']?>/">Craig.local</a></div>
	<div id="cf-header-user">
		<?=$system->get_user_control();?>
	</div>
	<div id="cf-header-message"><?=$page['alert']?></div>
</div>

<div id="cf-topnav">
	<div>
		<ul>
			<?=$page['menu']?>
		</ul>
	</div>
</div>

<div id="cf-appbar">
	<h1> <?=$page['title']?> </h1>
	<ul>
	 <?=$page['toolbar']?>
	 <li><img id="icon_print" src="theme/images/icon_print.png" border=0 /></li>
	</ul>
</div>

<div id="cf-main">

	<div id="cf-sidebar">
		<?=$page['sidebar']?>
	</div> <!-- cf-sidebar -->

	<div id="cf-content">
		<?=$page['content']?>
	</div> <!-- cf-content -->

	<div id="cf-footer">
		<p>Copyright &copy; <?=date("Y")?> Craig Blackham</p>
	</div> <!-- cf-footer -->

</div> <!-- cf-main -->

</body>
</html>
