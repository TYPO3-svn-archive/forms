<?php

//***************************************
//*********** Test file *****************
//***************************************

include('class.tx_forms.php');
$forms 	= new tx_forms;

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml11.dtd">' .
	'<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr">';
echo '<head><title>Tag Test</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head>';
echo '<body>';
echo '<div>';

// create input tag
echo '<h3>input tag [text]</h3>';
$attr 	= array('name' => 'texttest');
$forms->input($attr);
echo $forms->renderSingle('texttest');
echo '<br />';

// create select tag, single
echo '<h3>select tag [single]</h3>';
$selectAttr 	= array('name' => 'selectsingle');
$optionsAttr 	= null;
$options 		= array('test1' => 'Test1', 'test2' => 'Test2', 'test3' => 'Test3', 'test4' => 'Test4');
$selected 		= 'test2';

$forms->select($selectAttr, $optionsAttr, $selected, $options);
echo $forms->renderSingle('selectsingle');
echo '<br />';

// create select tag, multiple
echo '<h3>select tag [multiple]</h3>';
$selectAttr 	= array('name' => 'selectmultiple', 'size'=>6);
$optionsAttr 	= null;
$options 		= array('test1' => 'Test1', 'test2' => 'Test2', 'test3' => 'Test3', 'test4' => 'Test4');
$selected 		= array('test2', 'test4');

$forms->selectList($selectAttr, $optionsAttr, $selected, $options);
echo $forms->renderSingle('selectmultiple');
echo '<br />';


// create textarea
echo '<h3>textarea</h3>';
$attr 	= array('name' => 'textarea', 'cols'=> 25, 'rows'=> 10);
$value 	= 'This is some example text for this great textarea!!!';

$forms->textarea($attr, $value);
echo $forms->renderSingle('textarea');

echo '<br />';

// create checkbox
echo '<h3>checkbox</h3>';
$attr	= array('name' => 'checkbox');
$checked= true;
echo 'Some label:';
$forms->checkbox($attr, $checked);
echo $forms->renderSingle('checkbox');
echo '<br />';


// create radiobuttons
echo '<h3>radio buttons</h3>';
$attr	 = array('name' => 'radio_buttons');
$checked = 'third';
$options = array('first', 'second', 'third', 'fourth');

$forms->radio($attr, $checked, $options);
echo $forms->renderSingle('radio_buttons');
echo '<br />';


// create password field
echo '<h3>password field</h3>';
$attr	 = array('name' => 'password', 'value'=>'somePass');
$forms->password($attr);
echo $forms->renderSingle('password');
echo '<br />';


// create hidden field
echo '<h3>hidden field (check source, obviously :))</h3>';
$attr	 = array('name' => 'hidden', 'value'=>'someHiddenValue');
$forms->hidden($attr);
echo $forms->renderSingle('hidden');
echo '<br />';

// create file field
echo '<h3>file field</h3>';
$attr	 = array('name' => 'file');
$forms->file($attr);
echo $forms->renderSingle('file');
echo '<br />';


echo '</div></body></html>';
?>
