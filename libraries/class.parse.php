<?

//parser class

class Parser extends System{

	function date_to_iso($date){

		if ( $timestamp = strtotime($date) ){
			if ( $iso_date = date("Y-m-d", $timestamp) ){
				return $iso_date;
			}
		}

		return false;
	}

} //end class
?>
