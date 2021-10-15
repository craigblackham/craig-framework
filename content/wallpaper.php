<?php

$page['title'] = "Wallpaper Chooser";

//list the files in the wallpaper folder
$path = "content/wallpaper";
$list = scandir($path);
$image_list = "";
//var_dump($list);

foreach($list as $file){
	if (substr($file, 0, 1) != "."){ //not a directory folder
		//$images[$index] = $file;
		$image_list .= <<<EOD
		
	<img class="thumbnail" src="content/wallpaper/$file" border=0 />
	
EOD;
	}
}

//three table cells: left right, center
$output = <<<EOD

<div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-evenly;">
$image_list
</div>
EOD;

$page['content'] = $output;

?>
