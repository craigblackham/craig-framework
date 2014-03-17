<?php

$page['title'] = "Wallpaper Chooser";

//list the files in the wallpaper folder
$path = "content/wallpaper";
$list = scandir($path);

//var_dump($list);
$index = 1;
$images = array();

foreach($list as $file){
	if (substr($file, 0, 1) != "."){
		$images[$index] = $file;
		$index ++;
	}
}

$left_list = "";
$right_list = "";
$center_list = "";

foreach ($images as $index=>$file){

	$image_tag = "<p><img class='thumbnail' src='content/wallpaper/$file' border=0></p>";
	if ( $index % 3 == 0 ){
		$right_list .= $image_tag;
	}else if ( $index % 2 == 0 ){
		$center_list .= $image_tag;
	}else{
		$left_list .= $image_tag;
	}

}

//three table cells: left right, center
$output = <<<EOD
<table class='wallpaper' border=0>
	<tr style='vertical-align: top;'>
		<td class='wallpaper left'>$left_list</td>
		<td class='wallpaper center'>$center_list</td>
		<td class='wallpaper right'>$right_list</td>
 </tr>
</table>
EOD;

$page['content'] = $output;

?>
