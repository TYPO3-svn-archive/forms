<?php

//****************************************************************
//* This class is responsible for creating the single elements
//* through inheritance.
//* 
//* Copyright 2006 Christoph Koehler, Mario Matzulla
//* 
//****************************************************************

// TODO: do we need the addElement() methods??

// define single, self-closing tag and normal tag
// for use with sprintf
define('SETAG', '<%s %s />'."\n");
define('TAG', '<%1$s %2$s>'."\n".'%3$s</%1$s>'."\n");

// basic abstract form class
class formElement {
	
	// class variables: all form fields have
	// attributes and a tag name (e.g. input, select)
	var $attributes;
	var $tag;

	/**
	 * @name formElement
	 * @abstract constructor of basic class for a single form element
	 * @param [none]
	 */
	function formElement(){
		
		// initialize attributes
		$this->attributes = array();
	}
	
	/*
	function setAttributes($attr){
		foreach($attr as $key => $value) {
			$this->attributes[$key]=$value;	
		}
	}
	
	function getAttribute($key){
		return $this->attributes[$key];
	}
	*/
	
	// basic render method. Needs to be overridden
	/*
	 * @name render
	 * @abstract basic render method. Needs to be overridden
	 * @param [none]
	 */
	function render(){
		echo 'You need to override this method!';	
		
	}
	
}

// describes a self enclosed element, like <input />
// also abstract
class singlePartElement extends formElement {
			
	/*
	 * @name singlePartElement
	 * @abstract constructor
	 * @param [none]
	 */
	function singlePartElement() {
		
		// call parent's constructor
		parent::formElement();
	}
	
	// renders a basic single element tag. Used by most of the
	// input type fields since it's the same
	/*
	 * @name singlePartElement
	 * @abstract constructor
	 * @param [none]
	 */
	function render(){
		
		// implode attributes to inline html
		$attr = tx_forms_helper::implodeAttributes($this->attributes);
		
		// substitute tag and attributes in field blueprint defined at
		// the top; then return
		$output = sprintf(SETAG, $this->tag, $attr);
		return $output;
	}	
}

// defines label
class label extends multiPartElement {
	
	var $label;
	
	/*
	 * @name label
	 * @abstract constructor, creates label properties
	 * @param string $for
	 * @param string $label
	 * @param array $attr e.g. array('id' => 'someId', 'onmouseover' => 'draw();');
	 */
	function label($for, $label, $attr) {
		
		// call parent's constructor
		parent::multiPartElement();
		
		$this->tag = 'label';
		$this->label = $label;
		$attr['for'] = $for;
		$this->attributes = $attr;
	}
	
	/*
	 * @name render
	 * @abstract renders XHTML of label
	 * @param [none]
	 */
	function render() {
		
		// implode attributes to inline html
		$attr = tx_forms_helper::implodeAttributes($this->attributes);
		
		// substitute tag and attributes in field blueprint defined at
		// the top; then return
		$output = sprintf(TAG, $this->tag, $attr, $this->label);
		return $output;
	}
}
// multi part element, like <select>bla</select>
// also abstract
class multiPartElement extends formElement {
	
	/**
	 * @name multiPartElement
	 * @abstract calls parent contstructor
	 * @param [none]
	 */
	function multiPartElement(){
		
		// call parent's constructor
		parent::formElement();		
	}
	
	/*
	function addElement($element){
		$this->elements[] = $element;
		return count($this->elements) -1;
	}
	
	function removeElementById($id){
		array_splice($this->elements,$id,1);
	}
	
	function getElementById($id){
		return $this->elements[$id];
	}
	*/
}

// basic input class, extended by the different 
// types. Also abstract.
class formInput extends singlePartElement {
	
	// constructor
	function formInput(){
		
		// call parent's constructor
		parent::singlePartElement();
		
		// define tag name
		$this->tag = 'input';
	}	
}

// select field
class formSelect extends multiPartElement {

	// holds the various <option> elements
	var $elements;
	
	// constructor, see class.tx_forms.php for more info on arguments
	function formSelect($selectAttr, $optionsAttr, $selected, $options){
		
		// call parent's constructor
		parent::multiPartElement();
		
		// define tag name
		$this->tag = "select";
		
		// add elements based on arguments given
		$this->addElements($options,$optionsAttr, $selected);
		
		// set attributes global
		$this->attributes = $selectAttr;
	}
	
	// adds <option> elements to select tag
	function addElements($options,$optionsAttr, $selected) {
		
		// loop through all the options
		foreach($options as $value => $text) {
			
			// make attributes unique from template given
			$optionsHere = $optionsAttr;
			
			// add value to array
			$optionsHere['value'] = $value;
			
			// if the current option tag is the selected, mark it so;
			// if multiple ones are selected, check array for those.
			if($selected !== null && $selected == $value) {
				$optionsHere['selected'] = 'selected';
			} else if(is_array($selected) && in_array($value, $selected)) {
				$optionsHere['selected'] = 'selected';
			}
			
			// build option tag			
			$this->elements[] = new selectOption($optionsHere, $text);
		}
	}
	
	// renders the select field
	function render() {
		
		// implode attributes to inline html
		$attr = tx_forms_helper::implodeAttributes($this->attributes);
		
		// initialize the content between the select tags
		// aka options 
		$filling = null;
		
		// loop through all the options and render them
		foreach($this->elements as $field) {
			$filling .= $field->render();
		}
	
		// make the tag and return it
		$output = sprintf(TAG, $this->tag, $attr, $filling);
		return $output;
	}
}

// defines an option tag
class selectOption extends multiPartElement {
	
	// holds text between tags
	var $text;

	// constructor
	function selectOption($attr,$text){
		
		// call parent's constructor
		parent::multiPartElement();
		
		// define tag name
		$this->tag = "option";
		
		// make text global
		$this->text= $text;
		
		// set attributes
		$this->attributes = $attr;
	}
	
	// renders the option tag
	function render() {
		
		// implode attributes for inline html
		$attr = tx_forms_helper::implodeAttributes($this->attributes);
		
		// make and return tag
		return sprintf(TAG, $this->tag, $attr, $this->text);
	}
}

// makes a submit button
class formSubmit extends formInput {
	
	// constructor
	function formSubmit($attr) {
		
		// call parent's constructor
		parent::formInput();
		
		// make attributes global
		$this->attributes = $attr;
		
		// define type
		$this->attributes['type'] = 'submit';
	}
}

// makes a reset button
class formReset extends formInput {
	
	// constructor
	function formReset($attr) {
		
		// call parent's constructor
		parent::formInput();
		
		// make attributes global
		$this->attributes = $attr;
		
		// define type
		$this->attributes['type'] = 'reset';
	}
}

// shows a input type text field
class formText extends formInput {
	
	// constructor
	function formText($attr) {
		
		// call parent's constructor
		parent::formInput();
		
		// make attributes global
		$this->attributes = $attr;
		
		// define type
		$this->attributes['type'] = 'text';
	}
}

// makes a textarea
class formTextarea extends multiPartElement {
	
	// variable to hold content between tags
	var $text;
	
	// constructor
	function formTextarea($attr, $text) {
		
		// call parent's constructor
		parent::multiPartElement();
		
		// make text and attributes global
		$this->text = $text;
		$this->attributes = $attr;
		
		// define tag
		$this->tag = 'textarea';
	}
	
	// renders the form
	function render() {
		
		// implode attributes to inline html
		$attr = tx_forms_helper::implodeAttributes($this->attributes);
		
		// generate field and return it
		return sprintf(TAG, $this->tag, $attr, $this->text);
	}
}

// makes input type password
class formPassword extends formInput {
	
	// constructor
	function formPassword($attr) {
		
		// call parent's constructor
		parent::formInput();
		
		// make attributes global and define type
		$this->attributes = $attr;
		$this->attributes['type'] = 'password';
	}	
}

// makes input type hidden
class formHidden extends formInput {
	
	// constructor
	function formHidden($attr) {
		
		// call parent's constructor
		parent::formInput();
		
		// make attributes global and define type
		$this->attributes = $attr;
		$this->attributes['type'] = 'hidden';
	}
}

// make input type file
class formFile extends formInput {
	
	// constructor
	function formFile($attr) {
		
		// call parent's constructor
		parent::formInput();
		
		// make attributes global and define type		
		$this->attributes = $attr;
		$this->attributes['type'] = 'file';
	}
}

// makes a radio button
// TODO: make sure this is a good way to make the field
class formRadio extends formInput {
	
	// need extra vars: whether it's checked, 
	// and the different elements
	var $checked;
	var $elements;
	
	// constructor - see class.tx_forms.php for argument info
	function formRadio($attr, $checked, $elements) {
		
		// call parent's constructor
		parent::formInput();
		
		// make attributes global and define type
		$this->checked = $checked;
		$this->attributes = $attr;
		$this->attributes['type'] = 'radio';
		$this->elements = $elements;
	}
	
	// renders radio buttons
	function render() {
		
		// declare output variable
		$radioTags = array();
		
		$tagNumber = 1;
		
		// loop through all options and render tags
		foreach($this->elements as $value) {		
			
			// make attributes unique for this tag
			$attrHere = $this->attributes;
			
			// change id for this radio button
			$attrHere['id'] = $attrHere['id'] . '-' . $tagNumber;

			// add value attribute
			$attrHere['value'] = $value[0];
			
			// if selected, determine that now
			if($value[0] == $this->checked) {
				$attrHere['checked'] = 'checked';	
			}
					
			// create label for this radio button
			$label = new label($attrHere['id'], $value[1], array('id' => $attrHere['id'] . '-label'));
			$label = $label->render();
			$tagNumber ++;
			
			
			// get attributes for inclusion
			$attrHere = tx_forms_helper::implodeAttributes($attrHere);
			
			// render tag
			$radioTags[] = $label . sprintf(SETAG, $this->tag, $attrHere);
		
		}
		
		// implode and return radio tags
		return implode('', $radioTags);
	}
}

// makes a checkbox
class formCheckbox extends formInput {
	
	// need to know whether or not it's checked
	var $checked;
	
	// constructor
	function formCheckbox($attr, $checked) {
		
		// call parent's constructor
		parent::formInput();
		
		// make attributes global and define type
		$this->attributes = $attr;
		$this->attributes['type'] = 'checkbox';
		$this->checked = $checked;
	}
	
	// render checkbox
	function render() {

		// if it should be checked, do so now, but only if
		// it hasn't been defined in $attr
		if($this->checked && !isset($this->attributes['checked'])) $this->attributes['checked'] = 'checked';

		// implode attributes into inline html
		$attr = tx_forms_helper::implodeAttributes($this->attributes);
		
		// make field and return
		return sprintf(SETAG, $this->tag, $attr);	
	}
}

class container extends multiPartElement {
	var $components;
	
	function container() {
		parent::multiPartElement();
		$this->components = array();
	}
	
	function add($component) {
		
		$this->components[] = $component;
	}
	
	function render() {
		die('Need to subclass render() method in container children');
	}
}

class fieldset extends container {
	
	var $legend;
	
	function fieldset($legend, $attr) {
		parent::container();
		$this->legend = $legend;
		$this->tag = 'fieldset';
		$this->attributes = $attr;
	}
	

	
	function render() {

		// implode attributes to inline html
		$attr = tx_forms_helper::implodeAttributes($this->attributes);
		$filling = sprintf(TAG,'legend', null, $this->legend);
		
		foreach ($this->components as $comp) {
			$filling .= $comp->render();
		}
		
		$output = sprintf(TAG, $this->tag, $attr, $filling);
		
		return $output;
	}
}
// include the helper class
include('class.tx_forms_helper.php');
?>