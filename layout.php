<?php

/**
 * layout.php the html frame that all content goes into
 *
 **/


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Craig <?php echo $page['title']; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<base href="http://<?php echo $_SERVER['HTTP_HOST']; ?>">
	<link rel="shortcut icon" type="image/ico" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/favicon.ico">
	<link rel="stylesheet" type="text/css" href="theme/css/main.css">
	<link rel="stylesheet" type="text/css" media="print" href="theme/css/print.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script type="text/javascript" src="js/autoload.js"></script>
</head>
<body>

<div class="cf-header">
	<div class="cf-header-logo"><a class="logo" href="http://<?=$_SERVER['HTTP_HOST']?>/">craig.local</a></div>
	<div class="cf-header-user"><?php echo $system->get_user_control(); ?></div>
</div>

<div class="cf-topnav">
	<div class="cf-topnav-menu">
		<div class="cf-topnav-menu-icon"><img id="menu-toggle" class="menu" src="theme/images/menu.svg" border="0" hspace="9"></div>
		<div class="cf-topnav-menu-links"><?php echo $page['menu']; ?></div>
	</div>
	<div class="cf-topnav-search">
		<div class="cf-topnav-search-icon"><img class="menu" src="theme/images/search.svg" border="0" hspace="9"></div>
		<div class="cf-topnav-search-form"><?php echo $page['search']; ?></div>
	</div>
</div>

<div class="cf-appbar">
	<div class="cf-appbar-title"><?php echo $page['title']; ?></div>
	<div class="cf-appbar-alert"><?php echo $page['alert']; ?></div>
	<div class="cf-appbar-icons"><?php echo $page['icons']; ?></div>
</div>

<div class="cf-content">
	<div class="cf-content-side"><?php echo $page['sidebar']; ?></div>
	<div class="cf-content-main"><?php echo $page['content']; ?></div>
</div>

<div class="cf-footer">
	<div class="cf-footer-copy">Copyright &copy; <?php echo date("Y"); ?> Craig Blackham</div>
</div>

</body>
</html>
