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

//there are two lists of sites for side by side listing - this would be better to put into a flexbox
$sitelist = "";
$sitelist_1 = "";
$sitelist_2 = "";
$count = 0;

foreach ($sites as $category=>$links){

	$count++;
	if ($count > 4) {
		
		$sitelist_2 .= "<h3>$category</h3>";
	
		foreach ($links as $key=>$val){
			//var_dump($val);
			$sitelist_2 .= <<<EOD
			<a target="_blank" href="{$val['href']}">{$val['text']}</a><br />	
EOD;

		}
		
		$sitelist_2 .= "<br />";
	}else{
		
		$sitelist_1 .= "<h3>$category</h3>";
	
		foreach ($links as $key=>$val){
			//var_dump($val);
			$sitelist_1 .= <<<EOD
			<a target="_blank" href="{$val['href']}">{$val['text']}</a><br />	
EOD;

		}

		$sitelist_1 .= "<br />";
	}

}

$page['sidebar'] = "&nbsp;";

//for a single list
$page['content'] = $sitelist;

//for a side-by-side list
$page['content'] = <<<EOD

<div style="display: flex; flex-direction: row; flex-wrap: wrap;">
	<div style="margin-right: 120px;">$sitelist_1</div>
	<div style="margin-right: 120px;">$sitelist_2</div>
	<div style="display: flex; flex-direction: column; align-items: center;">
		<div><img src="theme/images/countdown/starrynight.png" border="0" hspace="9"></div>
		<div id="countdown">00d 00:00:00</div>
	</div>
</div>

<script type="text/javascript" src="js/countdown.js"></script>
<script>
	CountDownTimer('10/02/2021 3:00 PM', 'countdown');
</script>

EOD;

?>