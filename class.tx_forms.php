<?php

//****************************************************************
//* This class is responsible for creating the actual form. It is 
//* using other classes to generate the actual fields.
//* 
//* 
//* Copyright 2006 Christoph Koehler
//* 
//****************************************************************

// TODO: file form
class tx_forms {
	
	var $fields;		// array of all the field objects

//****************************************
//************ constructor  **************
//****************************************

	function tx_forms() {
		
		// initialize fields array
		$this->tags = array();
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
		
		$name = $attr['name'];
		
		$this->fields[$name] = new formText($attr);
	}

	/**
	 * @name textarea
	 * @abstract renders a textarea form
	 * @param array $attr associative array that defines the attributes inside the input tag; it's not validated in any way.
	 */
	function textarea($attr, $value) {
		
		$name = $attr['name'];
		
		$this->fields[$name] = new formTextarea($attr, $value);
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
		
		$name = $selectAttr['name'];
		
		$this->fields[$name] = new formSelect($selectAttr, $optionsAttr, $selected, $options);
		
	}
	
	/**
	 * @name selectList
	 * @abstract renders a select list form
	 * @param array $selectAttr associative array that defines the attributes inside the select tag; it's not validated in any way.
	 * @param array $optionsAttr associative array that defines attributes inside the option tags, also not validated. 
	 * @param mixed $selected array of strings or single string that defines the selected options.
	 * @param array $options associative array that defines the options as 'value'=>'Text' pairs
	 */
	function selectList($selectAttr, $optionsAttr, $selected, $options) {
		
		$selectAttr['multiple'] = 'multiple';
		$this->select($selectAttr, $optionsAttr, $selected, $options);
	
	}
	

	/**
	 * @name checkbox
	 * @abstract renders a checkbox
	 * @param array $attr attributes of the tag
	 * @param boolean $checked whether or not the checkbox is checked
	 */
	function checkbox($attr, $checked = false) {
		
		$name = $attr['name'];
		
		$this->fields[$name] = new formCheckbox($attr, $checked);
	
	}
	
	/**
	 * @name radio
	 * @abstract renders radio buttons
	 * @param array $attr holds all attributes for each radio tag
	 * @param string $checked value of the radio button that is to be selected
	 * @param array $options array of options, or values.
	 * TODO: see on top, need to figure something out with labels.
	 */
	function radio($attr, $checked, $options) {
		
		$name = $attr['name'];
		
		$this->fields[$name] = new formRadio($attr, $checked, $options);

	}
	
	/**
	 * @name password
	 * @abstract renders a password form
	 * @param array $attr associative array that defines the attributes inside the password tag; it's not validated in any way.
	 * 	
	 */
	function password($attr) {
		
		$name = $attr['name'];
		
		$this->fields[$name] = new formPassword($attr);
	}
	
	/**
	 * @name hidden
	 * @abstract renders a hidden form
	 * @param array $attr associative array that defines the attributes inside the hidden tag; it's not validated in any way.
	 * 	
	 */
	function hidden($attr) {

		$name = $attr['name'];
		
		$this->fields[$name] = new formHidden($attr);
	}

	function render() {
		
		$output = null;
		foreach($this->fields as $field) {
			$output .= $field->render();
		}
		return $output;
	}
	
	function renderSingle($name) {
		$field = $this->fields[$name];
		//print_r($field);
		return $field->render();
	}
}

include('class.tx_forms_elements.php');

?>
