<?

/**
 * home.php
 */
$page['title'] = "Bookmarks";

$sites = $system->get_bookmarks();

$sitelist = "";

foreach ($sites as $category=>$links){

	$sitelist .= "<div class='category'>$category</div>";

	foreach ($links as $url){

		$sitelist .= "<div class='linklist'>";
		$sitelist .= "<a target='_blank' href='http://{$url}'>{$url}</a>";
		$sitelist .= "</div>";

	}

	$sitelist .= "<br />";

}

$page['content'] = <<<EOD

<script type="text/javascript" src="js/countdown.js"></script>
<script>
	CountDownTimer('4/15/2014 9:00 AM', 'countdown');
</script>

<div id="bookmarks">
$sitelist
</div>

<div id="countdown-wrap">
<img src="theme/images/weigh-in.png" border="0" hspace="9">
<div id="countdown"></div>
</div>

EOD;

?>
