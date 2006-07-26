<?php

//****************************************************************
//* This class is responsible for creating the actual form. It is 
//* using other classes to generate the actual fields.
//* 
//* 
//* Copyright 2006 Christoph Koehler
//* 
//****************************************************************

// TODO: make objects of the fields
// TODO: file form
class tx_forms {
	
	var $tags;		// associative array of form tags

//****************************************
//************ constructor  **************
//****************************************

	function tx_forms() {
		
		// get tags out of the template file
		$this->tags = $this->readConfig('tags.ini.php');
	}
	
//****************************************
//******** form building methods  ********
//****************************************

	/**
	 * @name input
	 * @abstract renders a input form
	 * @param array $attr associative array that defines the attributes inside the input tag; it's not validated in any way.
	 * 	
	 */
	function input($attr) {
		
		// check for type, and if not there, use 'text'
		if(!isset($attr['type'])) $attr['type'] = 'text';
		
		// implode $attr to add to input tag
		$attrImploded 	= $this->implodeAttributes($attr);
		
		// build input tag
		$input		 	= sprintf($this->tags['input'], $attrImploded);

		// return tag
		return $input;
	}

	/**
	 * @name textarea
	 * @abstract renders a textarea form
	 * @param array $attr associative array that defines the attributes inside the input tag; it's not validated in any way.
	 */
	function textarea($attr, $value) {
		
		// implode $attr to add to textarea tag
		$implodedAttr = $this->implodeAttributes($attr);
		
		// build textarea tag
		$textarea	= sprintf($this->tags['textarea'], $implodedAttr, $value);
		
		// return textarea
		return $textarea;
	}

	/**
	 * @name select
	 * @abstract renders a select form
	 * @param array $selectAttr associative array that defines the attributes inside the select tag; it's not validated in any way.
	 * @param array $optionsAttr associative array that defines attributes inside the option tags, also not validated. 
	 * @param mixed $selected array of strings or single string that defines the selected options.
	 * @param array $options associative array that defines the options as 'value'=>'Text' pairs
	 */
	function select($selectAttr, $optionsAttr, $selected, $options) {
		
		// if the attributes for the option tags is null, make it
		// an array so implodeAttributes() doesn't complain.
		if($optionsAttr == null) {
			$optionsAttr = array();
		}
		
		// get the attributes for inclusion
		$selectAttr = $this->implodeAttributes($selectAttr);
		
		// build beginning tag
		$beginTag	= sprintf($this->tags['selectbegin'], $selectAttr);
	
		// declare array that holds all the option tags
		$optionTags = array();
		
		// loop through all the options
		foreach($options as $value => $text) {
			
			// make attributes unique from template given
			$optionsHere = $optionsAttr;
			
			// if the current option tag is the selected, mark it so;
			// if multiple ones are selected, check array for those.
			if($selected !== null && $selected == $value) {
				$optionsHere['selected'] = 'selected';
			} else if(is_array($selected) && in_array($value, $selected)) {
				$optionsHere['selected'] = 'selected';
			}

			// get attributes for inclusion
			$optionsHere = $this->implodeAttributes($optionsHere);
			
			// build option tag			
			$optionTags[] = sprintf($this->tags['option'], $value, $optionsHere, $text); 
		}
		
		// build option tags
		$optionTags = implode('', $optionTags);
		
		// build end tag
		$endTag 	= $this->tags['selectend'];
		
		// return it all
		return $beginTag . $optionTags . $endTag;
	}

	/**
	 * @name checkbox
	 * @abstract renders a checkbox
	 * @param array $attr attributes of the tag
	 * @param boolean $checked whether or not the checkbox is checked
	 */
	function checkbox($attr, $checked = false) {
		
		// if it should be checked, do so now, but only if
		// it hasn't been defined in $attr
		if($checked && !isset($attr['checked'])) $attr['checked'] = 'checked';
		
		// get attributes for inclusion
		$attr = $this->implodeAttributes($attr);
		
		// render tag
		$checkbox = sprintf($this->tags['checkbox'], $attr);
		
		// return it
		return $checkbox;
		
	}
	
	/**
	 * @name radio
	 * @abstract renders radio buttons
	 * @param array $attr holds all attributes for each radio tag
	 * @param string $checked value of the radio button that is to be selected
	 * @param array $options array of options, or values.
	 * TODO: see on top, need to figure something out with labels. Maybe only render one radio button?
	 */
	function radio($attr, $checked, $options) {
		
		// declare output variable
		$radioTags = array();
		
		// loop through all options and render tags
		foreach($options as $value) {		
			
			// make attributes unique for this tag
			$attrHere = $attr;
			
			// if selected, determine that now
			if($value == $checked) {
				$attrHere['checked'] = 'checked';	
			}
					
			// get attributes for inclusion
			$attrHere = $this->implodeAttributes($attrHere);
			
			// render tag
			$radioTags[] = sprintf($this->tags['radio'], $attrHere);
		
		}
		
		// build radio tags
		$radioTags = implode('', $radioTags);
		
		// return it
		return $radioTags;
	}
	
	/**
	 * @name password
	 * @abstract renders a password form
	 * @param array $attr associative array that defines the attributes inside the password tag; it's not validated in any way.
	 * 	
	 */
	function password($attr) {
		
		// implode $attr to add to input tag
		$attrImploded 	= $this->implodeAttributes($attr);
		
		// build input tag
		$password	 	= sprintf($this->tags['password'], $attrImploded);

		// return tag
		return $password;
	}
	
	/**
	 * @name hidden
	 * @abstract renders a hidden form
	 * @param array $attr associative array that defines the attributes inside the hidden tag; it's not validated in any way.
	 * 	
	 */
	function hidden($attr) {

		// implode $attr to add to input tag
		$attrImploded 	= $this->implodeAttributes($attr);
		
		// build input tag
		$hidden		 	= sprintf($this->tags['hidden'], $attrImploded);

		// return tag
		return $hidden;
	}
	
	/**
	 * @name tag
	 * @abstract renders a general tag
	 * @param string $tag name of the tag (i.e. a,div, etc).
	 * @param array $attr associative array that defines the attributes inside the tag; it's not validated in any way.
	 * @param string $filling if set, the tag will have an end tag with the $filling in between.
	 */
	function tag($tag, $attr = array(), $filling = null) {
		
		// make sure $attr is an array
		if (!is_array($attr))
			$attr = array ();
		
		// get attributes for inclusion
		$implodedAttr = $this->implodeAttributes($attr);
		
		// check whether or not the tag should be self enclosed
		if($filling != null) {
			$tag = sprintf($this->tags['tag'], $tag, $implodedAttr, $filling);
		} else {
			$tag = sprintf($this->tags['tagse'], $tag, $implodedAttr);
		}
		
		// return it
		return $tag;
	}


//**********************************
//******** Private methods  ********
//**********************************

	/**
	 * @name implpdeAttributes
	 * @abstract Takes an array and makes a space-separated list of parameters to include in the tag; $key = "$value".
	 * @param array() $params associative array that is imploded
	 */
	function implodeAttributes($attr) {
		
		// initialize the returned value
		$implodedAttr = null;

		//loop through $params array and implode
		foreach($attr as $key => $value) {
			
			// add new key-value pair to returned variable
			$implodedAttr .= $key . '="' . $value . '" ';
		}
		
		// return the imploded value
		return $implodedAttr;
		
	}
	
	function readConfig($file) {
		
		// read lines into an array
		$linesArray = file($file);
		
		// declare array to hold tag template
		$tags = array();
		
		// loop through the array and filter out unwanted stuff
		foreach($linesArray as $line) {
			$line = trim($line);
			// get first character
			$firstChar = substr($line, 0,1);
			
			// if it starts with ; or blank, we don't want it
			if($firstChar != ';' && $firstChar != '') {
				
				// get position of delimiter
				$delimiter = strpos($line, '=');
				
				// get key, the first part
				$key = trim(substr($line, 0, $delimiter));
				
				// get value, the second part
				$value = trim(substr($line, $delimiter+1));
				
				// if it's enclosed in ", remove them
				if (substr($value, 0, 1) == '"' && substr($value, -1) == '"') {
					$value = substr($value, 1, -1);
				}
				
				// add it to tags array as key => value
				$tags[$key] = $value;
			}
		}
		
		// return it
		return $tags;
	}
}
?>
