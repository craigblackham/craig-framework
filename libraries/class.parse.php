<?php

//parser class

class Parser extends System{

	function parse_db_connect($db_name){

		try {

			$db = new PDO("mysql:host=localhost;dbname=".$db_name, $_SERVER['DB_USER'], $_SERVER['DB_PASS']);
	
			if ( $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ){
				return $db;
			}
		
		} catch (PDOException $e) {
			$this->display( $e->getMessage() );
		}

		return false;
	}

	function old_db_connect($db_name){

		if ( $connection_object = mysql_connect($_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASS']) ){
			if ( mysql_select_db($db_name) ){
				$this->conn = $connection_object;
				return $connection_object;
			}
		}

		return false;
	}

	function date_to_iso($date){

		if ( $timestamp = strtotime($date) ){
			if ( $iso_date = date("Y-m-d", $timestamp) ){
				return $iso_date;
			}
		}

		return false;
	}

	function get_campus_timezones(){

		$query = "select * from campus_tz";
		if ( $result = mysql_query($query, $this->conn) ){
			while ( $row = mysql_fetch_assoc($result) ){
				$data[$row['campus']] = $row['time_zone'];
			}
		}

		if ( count($data) ){
			return($data);
		}

		return false;
	}

} //end class
?>
