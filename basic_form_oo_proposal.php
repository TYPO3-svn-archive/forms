<?php

class formElement {
	var $attributes;
	var $type;
	function form_base(){
		$this->attributes = array();
	}
	
	function setName(&$name){
		$this->attributes['name']=$name;
	}
	
	function getName(){
		return $this->attributes['name'];
	}
	
	//other attributes: onChange, onClick, onDblClick, onKeyDown, onKeyPress, onKeyUp, onSelect, onMouseDown, onMouseOver, onMouseOut, onMouseMove, onMouseUp, onSubmit, onReset
	
	function render(){}
	
}

class singlePartElement extends formElement {
	
	function singlePartElement() {
	}
	
	function render(){
		$output = "<".$this->getType();
		foreach($this->attributes as $key => $attribute){
			$output .= " ".$key."=\"".$attribute."\"";
		}
		$output .= "/>\n";
		return $output;
	}	
}

class multiPartElement extends formElement {
	
	var $elements;
	
	function multiPartElement(){
		$this->elements = array();
	}
	
	function render(){
		$output = "<".$this->getType();
		foreach($this->attributes as $key => $attribute){
			$output .= " ".$key."=\"".$attribute."\"";
		}
		$output .= ">\n";
		foreach($this->elements as $element){
			$output .= $element->render();
			$output .= "\n";
		}
		$output .= "</".$this->getType().">\n";
		return $output;
	}	
	
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
		$this->type = "input";
	}
}

class formSelect extends formElement {

	function formSelect(){
		parent::multiPartElement();
		$this->type = "select";
	}
}

class selectOption extends singlePartElement {

	function selectOption(){
		parent::singlePartElement();
		$this->type = "option";
	}
}

class formButton extends formInput {
	
}

class formText extends formInput {
	
}

class formTextarea extends formInput {
	
}

class formPassword extends formInput {
	
}

class formHidden extends formInput {
	
}

class formFile extends formInput {
	
}

class formRadioButton extends formInput {
	
}

class formCheckbox extends formInput {
	
}

class formSelectList extends formSelect {
	
}
?>