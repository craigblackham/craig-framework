<?php

/**
 * Form class
 * @author Craig
 * @version 1.0
 */

class Form extends System{

	public $action;

	public $handle;

	public $maintenance_mode = false;

	public $record_key; //primary key for records

	public $values = array();

	public $rules = array();

	public $session_id;

	public $form; //html form elements

	function add_select($name, $options, $label, $rules){

		//add the rule
		$this->rules[$name] = $rules;

		//set default value
		$default = "";
		if (isset($this->values[$name])) $default = $this->values[$name];

		//set class of field based on rules for validation
		$validation = $validation = $this->get_validation($rules);

		$select = <<<EOD
		<select  name="{$name}" id="{$name}" class="{$validation['class']}">
		<option value="">None</option>
EOD;
		foreach ($options as $value=>$text){
			$sel = ""; //pre-select of name OR value
			if ($text == $default || $value == $default) $sel = "selected";
			if (count($options) == 1) $sel = "selected"; //only one option, so select automatically
			$select .= "<option $sel value=\"$value\">$text</option>
			";
		}
		$select .= "</select>";

		$this->form .= <<<EOD
		
		<div id="{$name}div" class="cf-input">
			<label for="$name">$label</label>
			$select
		</div>

EOD;

	}

	function add_input($name, $label, $rules){

		$this->rules[$name] = $rules;

		//set value of input
		$default = "";
		if (isset($this->values[$name])) $default = $this->values[$name];

		//set class of field based on rules for validation
		$validation = $this->get_validation($rules);

		$this->form .= <<<EOD

		<div id="{$name}div" class="cf-input">
			<label for="{$name}">{$label}</label>
			<input name="{$name}" id="{$name}" class="{$validation['class']}" {$validation['inline']} value="{$default}" />
		</div>

EOD;

	}

	function add_checkbox($name, $label, $value){

		//set value of input
		$is_checked = "";
		if (isset($this->values[$name]) && $this->values[$name] == $value){
			$is_checked = "checked";
		}

		$this->form .= <<<EOD
		<div id="{$name}div" class="cf-input">
			<label for="{$name}">{$label}</label>
			<input type="checkbox" name="{$name}" id="{$name}" $is_checked value="{$value}" />
		</div>
EOD;

	}

	function add_heading($string){

		$this->form .= <<<EOD

	<h3>$string</h3>

EOD;

	}

	function add_radio($name, $label, $options){

		//options should be array(value=>name) format
		//var_dump($this->values[$name]);

		//create radio buttons
		$buttons = "";
		foreach($options as $value=>$title){

			//set value of input
			$is_checked = "";
			if (!isset($this->values[$name]) && $value == 0) $is_checked = "checked";
			if (isset($this->values[$name]) && $this->values[$name] == $value){
				$is_checked = "checked";
			}

			$buttons .= <<<EOD
		<input type="radio" name="{$name}" $is_checked value="{$value}" />&nbsp;$title
EOD;

		}

		$this->form .= <<<EOD
		<div id="{$name}div" class="cf-input">
			<label for="{$name}">{$label}</label>
			$buttons
		</div>
EOD;

	}

	function add_password($name, $label, $rules){

		$this->rules[$name] = $rules;

		//set value of input
		$default = "";
		if (isset($this->values[$name])) $default = $this->values[$name];

		//set class of field based on rules for client-side validation
		$validation = "";
		if (count($rules)) $validation = $this->get_validation($rules);

		$this->form .= <<<EOD
		<div id="{$name}div" class="cf-input">
			<label for="{$name}">{$label}</label>
			<input type="password" name="{$name}" id="{$name}" class="{$validation['class']}" {$validation['inline']} value="{$default}" />
		</div>
EOD;

	}

	function add_upload($name, $label, $rule, $hidden=false){

		$this->rules[$name] = $rule;

		//add maxlength if there is a max rule
		$maxlength = "";
		if (isset($rule["max"])) $maxlength = $rule["max"];

		//set value of input
		$default = "";
		if (isset($this->form_values[$name])) $default = $this->form_values[$name];

		//set class of field to error for server side validation
		$error = "";
		if (isset($this->form_errors[$name])) $error = "error";

		//set class of field based on rules for client-side validation
		$validation = "";
		if (count($rule)) $validation = $this->get_validation($rule);

		//Add star if required
		$star = '';
		if(strpos($validation['class'], 'required') !== false)
			$star = '*';

		//make the div hidden if hidden is true
		$style = "";
		if ($hidden){
			$style = "display: none;";
		}

		$this->form .= <<<EOD
		<div id="{$name}div" class="formlist" style="$style">
			<label class="formlabel $error" for="$name">$label $star</label>
			<span class="control">
				<input type="file" name="$name" id="$name" class="formfield {$validation['class']} $error" {$validation['inline']} maxlength="$maxlength" value="$default" />
			</span>
		</div>
EOD;

	}

	function add_textarea($name, $label, $rules, $mce=false, $rows="3"){

		$this->rules[$name] = $rules;

		$default = "";
		if (isset($this->values[$name])) $default = $this->values[$name];

		//set class of field based on rules for client-side validation
		$validation = $this->get_validation($rules);
		$style = "";
		//if ( empty($height) ){
		//	$height = "20"; //default to 20px
		//}

		//$style = "style=\"height:{$height}px;\""; //set the height
		
		$tinymce = "";
		if ($mce) $tinymce = "tinymce";

		$this->form .= <<<EOD
		<div id="{$name}div" class="cf-input">
			<label for="{$name}">{$label}</label>
			<textarea name="{$name}" id="{$name}" class="{$validation['class']} $tinymce" rows="{$rows}">{$default}</textarea>
		</div>
EOD;

	}

	function add_phone($index, $label, $required=false, $hidden=false){

		$fields = "";
		$any_error = "";

		$phone = array("area"=>3, "prefix"=>3, "suffix"=>4);
		foreach($phone as $name=>$size){
			$field_name = "{$name}_{$index}";
			$star = '';

			$this->rules[$field_name] = array("digits"=>1, "min"=>$size, "max"=>$size);
			if ($required){
				$this->rules[$field_name]["required"] = 1;
				$star = '*';
			}

			$default = "";
			if (isset($this->form_values[$field_name])) $default = $this->form_values[$field_name];

			//set class of field to error for server side validation
			$error = "";
			if (isset($this->form_errors[$field_name])){
				$error = "error";
				$any_error = "error";
			}

			//set class of field based on rules for client-side validation
			$validation = "";
			if (count($this->rules[$field_name])) $validation = $this->get_validation($this->rules[$field_name]);

			$separator = " ";
			if ($name == "area" || $name == "prefix") $separator .= " - ";
			$fields .= <<<EOD
			<input name="$field_name" id="$field_name" size="{$size}" maxlength="{$size}" class="formfield $name {$validation['class']} $error" {$validation['inline']} value="$default" /> $separator
EOD;
	}

		$this->form .= <<<EOD
		<div class="formlist">
			<label class="formlabel $any_error" for="area_1 prefix_1 suffix_1">$label $star</label>
			<span class="control">
				$fields
			</span>
		</div>
EOD;

	}

	function add_submit($value = "Submit"){

		$this->form .= <<<EOD
		<div class="cf-input">
			<input type="submit" class="button" id="form_submit" name="form_submit" default="1" value="$value" alt="$value">
		</div>
EOD;

	}

	public function show_form(){

		$timestamp = time();
		$this->session_id = session_id();

		if ($this->maintenance_mode){

			$output = <<<EOD
			<p>
			<img class="align-right" src="theme/images/robot.png" alt="maintenance" width="120" />
			<b>We're sorry...</b> This resource is temporarily undergoing maintenance.
			<br>Please try back in a few minutes.
			</p>
EOD;

		}else{

			//set the rules for the form in the session
			$_SESSION[$this->handle]['rules'] = $this->rules;

			$custom_javascript = '';
			if (file_exists($_SERVER['DOCUMENT_ROOT']."/js/".$this->handle.".js")){
				$custom_javascript = '<script src="/js/'.$this->handle.'.js" type="text/javascript"></script>';
			}

			$referrer = '';
			if (isset($_SERVER['HTTP_REFERER'])) $referrer = $_SERVER['HTTP_REFERER'];

			$output = <<<EOD
			$custom_javascript
			<form class="cf-form" action="$this->action" name="form1" id="form1" method="post">

			<div>
				<input type="hidden" name="timestamp" value="$timestamp">
				<input type="hidden" name="session" id="session" value="$this->session_id">
				<input type="hidden" name="form_handle" value="$this->handle">
				<input type="hidden" name="record_key" value="$this->record_key">
				<input type="hidden" name="referrer" value="$referrer">

				$this->form

			</div>

			</form>
EOD;

		}

		return $output;

	}

	//gets validation for the jquery validate library
	function get_validation($rules){

		$validation['class'] = "";
		$validation['inline'] = "";

		if (isset($rules['required'])) $validation['class'] .= "required ";
		if (isset($rules['digits'])) $validation['class'] .= "digits ";
		if (isset($rules['email'])) $validation['class'] .= "email ";
		if (isset($rules['date'])) $validation['class'] .= "datepicker ";

		if (isset($rules['min'])) $validation['inline'] .= 'minlength="'.$rules['min'].'" ';
		if (isset($rules["max"])) $validation['inline'] .= 'maxlength="'.$rules['max'].'" ';

		$validation['class'] = trim($validation['class']);

		return $validation;
	}

	function get_states(){
		$states_arr = array('AL'=>"Alabama",'AK'=>"Alaska",'AZ'=>"Arizona",'AR'=>"Arkansas",'CA'=>"California",
		'CO'=>"Colorado",'CT'=>"Connecticut",'DE'=>"Delaware",'DC'=>"District Of Columbia",'FL'=>"Florida",
		'GA'=>"Georgia",'HI'=>"Hawaii",'ID'=>"Idaho",'IL'=>"Illinois", 'IN'=>"Indiana", 'IA'=>"Iowa",
		'KS'=>"Kansas",'KY'=>"Kentucky",'LA'=>"Louisiana",'ME'=>"Maine",'MD'=>"Maryland", 'MA'=>"Massachusetts",
		'MI'=>"Michigan",'MN'=>"Minnesota",'MS'=>"Mississippi",'MO'=>"Missouri",'MT'=>"Montana",'NE'=>"Nebraska",
		'NV'=>"Nevada",'NH'=>"New Hampshire",'NJ'=>"New Jersey",'NM'=>"New Mexico",'NY'=>"New York",
		'NC'=>"North Carolina",'ND'=>"North Dakota",'OH'=>"Ohio",'OK'=>"Oklahoma", 'OR'=>"Oregon",'PA'=>"Pennsylvania",
		'RI'=>"Rhode Island",'SC'=>"South Carolina",'SD'=>"South Dakota",'TN'=>"Tennessee",'TX'=>"Texas",'UT'=>"Utah",
		'VT'=>"Vermont",'VA'=>"Virginia",'WA'=>"Washington",'WV'=>"West Virginia",'WI'=>"Wisconsin",'WY'=>"Wyoming");

		return $states_arr;
	}

	function simplify_array($array, $index){

		$output = array();

		foreach($array as $key=>$sub_array){
			$output[$key] = $sub_array[$index];
		}

		return $output;
	}


}//end class

?>
