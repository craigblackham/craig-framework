<?php

/**
 * source.php
 * @author Craig
 * reads data from tab-delimited file
 **/

//error reporting
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set("display_errors", "1");
ini_set("html_errors", "1");

set_time_limit(180);

$start_time = time();

require_once($_SERVER['DOCUMENT_ROOT']."/libraries/class.parse.php");
$o_parse = new Parser();

$database = "marketing";
if (! $conn = $o_parse->db_connect($database) ) die("<b>ERROR:</b> could not connect database $database");

$line_count = 0;

//set file pointer
$filename = "Souce_2014.02.11.txt";

if ( $fp = fopen($_SERVER['DOCUMENT_ROOT']."/content/parser/".$filename, "r") ){

	echo "<p>file opened: $filename</p>";

	while (($data = fgetcsv($fp, 1024, "\t")) !== FALSE){

		$line_count++;

		if ($line_count > 1){

			//var_dump($data); exit;

			//escape all data
			foreach($data as $key=>$value){
				//$value = preg_replace($allowed, "", $value);
				$value = str_replace('?á','',$value);
				$data[$key] = mysql_escape_string($value);
			}

			//lead_source_id convert to integer
			if ($data[8] == "") $data[8] = 0;

			if (! empty($data[1]) ){
				if (! $data[1] = $o_parse->date_to_iso($data[1]) )
					die("<b>ERROR on line $line_count:</b> could not convert date {$data[1]}");
			}

			$query = "INSERT INTO source
			(modified_date, modified_by, vanity_phone, dnis_phone, vendor,
			source_group, campaign_title, lead_source_id, adv_content,
			adv_campaign, adv_source, source_note, five9_campaign, form_display,
			active)
			VALUES
			('{$data[1]}', '{$data[2]}', '{$data[3]}', '{$data[4]}', '{$data[5]}',
			'{$data[6]}', '{$data[7]}', '{$data[8]}', '{$data[9]}', '{$data[10]}',
			'{$data[11]}', '{$data[12]}', '{$data[13]}', '{$data[14]}', '{$data[15]}')";
			//echo "<p>$query</p>";
			if (!$result = mysql_query($query, $conn)){
				die("<b>ERROR on line $line_count:</b> query failed $query". mysql_error());
			}

		}else{
			echo "<p>column headings:</p>";
			var_dump($data);
		}

	}

	echo "<p>lines: $line_count</p>";

	fclose($fp);

}else{
	die("<b>ERROR:</b> could not open file $filename");
}


$end_time = time();
$seconds_elapsed = $end_time - $start_time;
echo "execution time: $seconds_elapsed s";

$page['content'] = ob_get_contents();
ob_get_clean();

?>
