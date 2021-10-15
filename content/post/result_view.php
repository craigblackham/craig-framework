<?php
/**
 * post/result_view.php
 */

$page['title'] = "Post Results";
 
ob_start();

echo "<textarea style='width: 600px; height: 350px;'>$result</textarea>";

if ($id){
	echo "<p>post_data record pk: $id</p>";
}else{
	echo "<p>post_data record not stored</p>";
}

$page['content'] = ob_get_contents();
ob_get_clean();

?>