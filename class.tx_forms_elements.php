<?php

//****************************************************************
//* This class is responsible for creating the single elements
//* through inheritance.
//* 
//* Copyright 2006 Christoph Koehler, Mario Matzulla
//* 
//****************************************************************

// define tags
define('SETAG', '<%s %s />');
define('TAG', '<%1$s %2$s>%3$s</%1$s>');

class formElement {
	var $attributes;
	var $tag;

	
	function formElement(){
		$this->attributes = array();
	}
	
	function setAttributes($attr){
		foreach($attr as $key => $value) {
			$this->attributes[$key]=$value;	
		}
	}
	
	function getAttribute($key){
		return $this->attributes[$key];
	}
	
	function render(){
		echo 'You need to override this method!';	
		
	}
	
}

class singlePartElement extends formElement {
			
	function singlePartElement() {
		parent::formElement();
	}
	
	function render(){
		$attr = tx_forms_helper::implodeAttributes($this->attributes);
		$output = sprintf(SETAG, $this->tag, $attr);
		return $output;
	}	
}

class multiPartElement extends formElement {
	
	function multiPartElement($attr){
		parent::formElement($attr);
		$this->elements = array();
		
	}
	
	function render(){}
	
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
}

class form extends multiPartElement {
	//attributes are: action, target

	function form(){
		parent::multiPartElement();
		$this->type = "form";
	}
	
}

class formInput extends singlePartElement {
	
	function formInput(){
		parent::singlePartElement();
		$this->tag = 'input';
	}
	
}

class formSelect extends multiPartElement {

	var $elements;
	
	function formSelect($selectAttr, $optionsAttr, $selected, $options){
		//parent::multiPartElement();
		$this->tag = "select";
		$this->addElements($options,$optionsAttr, $selected);
		//print_r($this->elements);
		$this->attributes = $selectAttr;
	}
	
	function addElements($options,$optionsAttr, $selected) {
		
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
			
			// build option tag			
			$this->elements[] = new selectOption($optionsHere, $text);
		}
		//print_r($this->elements);
	}
	
	function render() {
		$attr = tx_forms_helper::implodeAttributes($this->attributes);
		
		$filling = null;
		foreach($this->elements as $field) {
			$filling .= $field->render();
		}
	
		$output = sprintf(TAG, $this->tag, $attr, $filling);
		return $output;
	}
}

class selectOption extends multiPartElement {

	function selectOption($attr,$text){
		parent::multiPartElement($attr);
		$this->tag = "option";
		$this->elements[] = $text;
	}
	
	function render() {
		$attr = tx_forms_helper::implodeAttributes($this->attributes);
		return sprintf(TAG, $this->tag, $attr, $this->elements[0]);
	}
}

class formButton extends formInput {
	
}

class formText extends formInput {
	
	function formText($attr) {
		parent::formInput();
		$this->attributes = $attr;
		$this->attributes['type'] = 'text';
	}
}

class formTextarea extends multiPartElement {
	
	var $text;
	
	function formTextarea($attr, $text) {
		$this->text = $text;
		$this->tag = 'textarea';
		parent::multiPartElement($attr, $text);
	}
	
	function render() {
		$attr = tx_forms_helper::implodeAttributes($this->attributes);
		return sprintf(TAG, $this->tag, $attr, $this->text);
	}
}

class formPassword extends formInput {
	
	function formPassword($attr) {
		parent::formInput();
		$this->attributes = $attr;
		$this->attributes['type'] = 'password';
	}	
}

class formHidden extends formInput {
	function formHidden($attr) {
		parent::formInput();
		$this->attributes = $attr;
		$this->attributes['type'] = 'hidden';
	}
}

class formFile extends formInput {
	
}

class formRadio extends formInput {
	
	var $checked;
	var $elements;
	function formRadio($attr, $checked, $elements) {
		parent::formInput();
		$this->checked = $checked;
		$this->attributes = $attr;
		$this->attributes['type'] = 'radio';
		$this->elements = $elements;
	}
	
	function render() {
		
		// declare output variable
		$radioTags = array();
		
		// loop through all options and render tags
		foreach($this->elements as $value) {		
			
			// make attributes unique for this tag
			$attrHere = $this->attributes;
			
			// add value attribute
			$attrHere['value'] = $value;
			
			// if selected, determine that now
			if($value == $this->checked) {
				$attrHere['checked'] = 'checked';	
			}
					
			// get attributes for inclusion
			$attrHere = tx_forms_helper::implodeAttributes($attrHere);
			
			// render tag
			$radioTags[] = sprintf(SETAG, $this->tag, $attrHere);
		
		}
		
		// implode and return radio tags
		return implode('', $radioTags);
	}
}

class formCheckbox extends formInput {
	
	var $checked;
	
	function formCheckbox($attr, $checked) {
		parent::formInput();
		$this->attributes = $attr;
		$this->attributes['type'] = 'checkbox';
		$this->checked = $checked;
	}
	
	function render() {
		// if it should be checked, do so now, but only if
		// it hasn't been defined in $attr
		if($this->checked && !isset($this->attributes['checked'])) $this->attributes['checked'] = 'checked';

		$attr = tx_forms_helper::implodeAttributes($this->attributes);
		$output = sprintf(SETAG, $this->tag, $attr);
		return $output;	
	}
}

include('class.tx_forms_helper.php');
?>