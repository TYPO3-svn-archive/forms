<?php

//***************************************
//*********** Test file *****************
//***************************************

include('class.tx_forms_basic.php');
$forms 	= new tx_forms_basic;

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml11.dtd">' .
	'<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr">';
echo '<head><title>Tag Test</title></head>';
echo '<body>';
echo '<div>';
// create input tag
echo '<h3>input tag [text]</h3>';
$attr 	= array('name' => 'texttest', 'type' => 'text');
echo $forms->input($attr);
echo '<br />';

// create select tag, single
echo '<h3>select tag [single]</h3>';
$selectAttr 	= array('name' => 'selectsingle');
$optionsAttr 	= null;
$options 		= array('test1' => 'Test1', 'test2' => 'Test2', 'test3' => 'Test3', 'test4' => 'Test4');
$selected 		= 'test2';

echo $forms->select($selectAttr, $optionsAttr, $selected, $options);
echo '<br />';

// create select tag, multiple
echo '<h3>select tag [multiple]</h3>';
$selectAttr 	= array('name' => 'selectmultiple', 'multiple'=>'multiple', 'size'=>6);
$optionsAttr 	= null;
$options 		= array('test1' => 'Test1', 'test2' => 'Test2', 'test3' => 'Test3', 'test4' => 'Test4');
$selected 		= array('test2', 'test4');

echo $forms->select($selectAttr, $optionsAttr, $selected, $options);
echo '<br />';

// create textarea
echo '<h3>textarea</h3>';
$attr 	= array('name' => 'textarea', 'cols'=> 25, 'rows'=> 10);
$value 	= 'This is some example text for this great textarea!!!';

echo $forms->textarea($attr, $value);
echo '<br />';

// create checkbox
echo '<h3>checkbox</h3>';
$attr	= array('name' => 'checkbox');
$checked= true;
echo 'Some label:';
echo $forms->checkbox($attr, $checked);
echo '<br />';

// create radiobuttons
echo '<h3>radio buttons</h3>';
$attr	 = array('name' => 'radio buttons');
$checked = 'third';
$options = array('first', 'second', 'third', 'fourth');

echo $forms->radio($attr, $checked, $options);
echo '<br />';


echo '</div></body></html>';
?>
