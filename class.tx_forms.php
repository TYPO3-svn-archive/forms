<?php

//****************************************************************
//* This class is responsible for creating the actual form. It is 
//* using other classes to generate the actual fields.
//* 
//* 
//* Copyright 2006 Christoph Koehler
//* 
//****************************************************************

// TODO: add some kind of error if name isn't given in the form building methods
class tx_forms {
	
	var $fields;		// array of all the field objects
	var $attributes;	// attributes for the form itself

//****************************************
//************ constructor  **************
//****************************************

	/**
	 * @name tx_forms
	 * @param array $attr assoc array of attributes that go directly into the form tag
	 * @abstract creates a form object; takes an assoc array of attributes as argument
	 */
	function tx_forms($attr) {
		
		// initialize fields array
		$this->tags = array();
		
		// make attributes global
		$this->attributes = $attr;
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

		// get the name from the attribute array	
		$name = $attr['name'];

		// add new field to global array in form object		
		$this->fields[$name] = new formText($attr);
	}

	/**
	 * @name textarea
	 * @abstract renders a textarea form
	 * @param array $attr associative array that defines the attributes inside the input tag; it's not validated in any way.
	 */
	function textarea($attr, $value) {

		// get the name from the attribute array		
		$name = $attr['name'];

		// add new field to global array in form object		
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

		// get the name from the attribute array		
		$name = $selectAttr['name'];

		// add new field to global array in form object	
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

		// get the name from the attribute array		
		$selectAttr['multiple'] = 'multiple';

		// add new field to global array in form object
		$this->select($selectAttr, $optionsAttr, $selected, $options);
	}
	

	/**
	 * @name checkbox
	 * @abstract renders a checkbox
	 * @param array $attr attributes of the tag
	 * @param boolean $checked whether or not the checkbox is checked
	 */
	function checkbox($attr, $checked = false) {
	
		// get the name from the attribute array
		$name = $attr['name'];
		
		// add new field to global array in form object
		$this->fields[$name] = new formCheckbox($attr, $checked);
	}
	
	/**
	 * @name radio
	 * @abstract renders radio buttons
	 * @param array $attr holds all attributes for each radio tag
	 * @param string $checked value of the radio button that is to be selected
	 * @param array $options array of options, or values.
	 * TODO: need to figure something out with labels.
	 */
	function radio($attr, $checked, $options) {

		// get the name from the attribute array	
		$name = $attr['name'];
		
		// add new field to global array in form object
		$this->fields[$name] = new formRadio($attr, $checked, $options);
	}
	
	/**
	 * @name password
	 * @abstract renders a password form
	 * @param array $attr associative array that defines the attributes inside the password tag; it's not validated in any way.
	 * 	
	 */
	function password($attr) {

		// get the name from the attribute array	
		$name = $attr['name'];

		// add new field to global array in form object		
		$this->fields[$name] = new formPassword($attr);
	}
	
	/**
	 * @name hidden
	 * @abstract renders a hidden form
	 * @param array $attr associative array that defines the attributes inside the hidden tag; it's not validated in any way.
	 * 	
	 */
	function hidden($attr) {

		// get the name from the attribute array
		$name = $attr['name'];
		
		// add new field to global array in form object
		$this->fields[$name] = new formHidden($attr);
	}
	
	/**
	 * @name file
	 * @abstract renders a file form
	 * @param array $attr associative array that defines the attributes inside the file field; it's not validated in any way.
	 * 	
	 */
	function file($attr) {
		
		// get the name from the attribute array
		$name = $attr['name'];
		
		// add new field to global array in form object
		$this->fields[$name] = new formFile($attr);
	}

	/**
	 * @name submit
	 * @abstract renders a submit button
	 * @param array $attr associative array that defines the attributes of the button; it's not validated in any way.
	 * 	
	 */
	function submit($attr) {

		// get the name from the attribute array
		$name = $attr['name'];
		
		// add new field to global array in form object
		$this->fields[$name] = new formSubmit($attr);
	}
	
	/**
	 * @name reset
	 * @abstract renders a reset button
	 * @param array $attr associative array that defines the attributes of the button; it's not validated in any way.
	 * 	
	 */
	function reset($attr) {

		// get the name from the attribute array
		$name = $attr['name'];
		
		// add new field to global array in form object
		$this->fields[$name] = new formReset($attr);
	}
	
//****************************************
//******** rendering methods  ************
//****************************************

	/**
	 * @name render
	 * @abstract renders the complete form
	 * @return string complete form as html
	 * 
	 * TODO: add <form> stuff
	 */
	function render() {
		
		// initialize output
		$output = null;
		
		// check for enctype
		$this->getEnctype();
		
		// get form attributes for inline
		$attr = tx_forms_helper::implodeAttributes($this->attributes);
		
		// make first part of form
		$output = '<form ' . $attr . '>';
		
		// loop through all the fields and call render
		// method on each and add return value to output
		foreach($this->fields as $field) {
			$output .= $field->render();
		}
		
		// append closing forms tag
		$output .= '</form>';
		
		return $output;
	}
	
	/**
	 * @name renderSingle
	 * @abstract renders a single field of the form
	 * @param string $name name of the field to be rendered
	 * @return string field as html
	 * 
	 * TODO: add form rendering
	 */	
	function renderSingle($name) {
		
		// get field object by name
		$field = $this->fields[$name];

		return $field->render();
	}
	
//****************************************
//********** private methods  ************
//****************************************

	/**
	 * @name getEnctype
	 * @return correct encoding type for the form
	 * @abstract checks for a file form field and returns another encoding type if found
	 */
	function getEnctype() {
		
		// if enctype is already set, leave it
		if(!empty($this->attributes['enctype'])) return;
		
		// initialize check var
		$file = false;
		
		// loop through all the fields and check for class name.
		// If file is present, change enctype
		foreach($this->fields as $field) {
			if(get_class($field) == 'formFile') {
				$file = true;
			}
		}
		
		// interpret results
		if($file == true) $this->attributes['enctype'] = 'multipart/form-data';	
	}
}

include('class.tx_forms_elements.php');

?>
