<?php

/**
 * home.php
 */
$page['title'] = "Bookmarks";

//show the database property of the system object
//var_dump($system->db);

//get a list of bookmarks
$sites = $system->get_bookmarks();
//var_dump($sites);

//sitelist is a list of bookmarks
$sitelist = "";

foreach ($sites as $category=>$links){

	$sitelist .= "<div class='sitelist'><h3>$category</h3>";
	
	foreach ($links as $key=>$val){
		//var_dump($val);
		$sitelist .= <<<EOD
		<a target="_blank" href="{$val['href']}">{$val['text']}</a><br />	
EOD;

	}

	$sitelist .= "</div>";
		
}

$page['sidebar'] = "&nbsp;";

//for a single list
$page['content'] = $sitelist;

//for a side-by-side list
$page['content'] = <<<EOD

<div style="display: flex; flex-direction: row; flex-wrap: wrap; align-items: left;">
	<div style="display: flex; flex-direction: column; align-items: left; flex-grow: 1;">
		$sitelist
	</div>
	<div style="display: flex; flex-direction: column; align-items: center; flex-grow: 2;">
		<div><img src="theme/images/countdown/jazz.png" border="0" hspace="9" vspace="12"></div>
		<div id="countdown">00d 00:00:00</div>
	</div>
</div>

<script type="text/javascript" src="js/countdown.js"></script>
<script>
	CountDownTimer('10/21/2021 4:00 PM', 'countdown');
</script>

EOD;

?>