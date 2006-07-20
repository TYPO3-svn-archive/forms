<?php

//****************************************************************
//* This class is responsible for drawing basic form elements.
//* 
//* 
//* 
//* Copyright 2006 Christoph Koehler
//* 
//****************************************************************

// TODO: maybe make templates for tags and use sprintf to insert values
class tx_forms_basic {

//****************************************
//******** form building methods  ********
//****************************************

	/**
	 * @name input
	 * @abstract renders a input form
	 * @param array() $attr associative array that defines the attributes inside the input tag; it's not validated in any way.
	 * 	
	 */
	function input($attr) {
		
		// check for type, and if not there, use 'text'
		if(!isset($attr['type'])) $attr['type'] = 'text';
		
		// implode $attr to add to input tag
		$attrImploded 	= $this->implodeAttributes($attr);
		
		// build input tag
		$input		 	= '<input' . $attrImploded . '/>';

		// return tag
		return $input;
	}

	/**
	 * @name textarea
	 * @abstract renders a textarea form
	 * @param array() $attr associative array that defines the attributes inside the input tag; it's not validated in any way.
	 */
	function textarea($attr, $value) {
		
		// implode $attr to add to textarea tag
		$implodedAttr = $this->implodeAttributes($attr);
		
		// build textarea tag
		$textarea	= '<textarea' . $implodedAttr . '>' . $value . '</textarea>';
		
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
		$beginTag	= '<select' . $selectAttr . '>';
	
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
			$optionTags .= '<option value="' . $value . '"' . $optionsHere . '>' . $text . '</option>'; 
		}
		
		// build end tag
		$endTag 	= '</select>';
		
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
		$checkbox = '<input type="checkbox"' . $attr . ' />';
		
		// return it
		return $checkbox;
		
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
			$implodedAttr .= ' ' . $key . '="' . $value . '"';
		}
		
		// return the imploded value
		return $implodedAttr;
		
	}
}
?>
