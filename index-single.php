<?php

//***************************************
//*********** Test file *****************
//***************************************

include('class.tx_forms.php');
$attr = array('method' => 'post', 'action' => '#');
$forms 	= new tx_forms($attr);

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml11.dtd">' .
	'<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr">';
echo '<head><title>Tag Test</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />';
echo '<link rel="stylesheet" type="text/css" href="styles.css" />';
echo '</head>';
echo '<body>';
echo '<div>';

echo '<h1>Individual Fields</h1>';

// create input tag
echo '<h3>input tag [text]</h3>';
$attr 	= array('name' => 'texttest');
$label = 'text test:';
$forms->input($attr, $label);
echo $forms->renderSingle('texttest');
echo '<br />';

// create select tag, single
echo '<h3>select tag [single]</h3>';
$selectAttr 	= array('name' => 'selectsingle');
$optionsAttr 	= null;
$options 		= array('test1' => 'Test1', 'test2' => 'Test2', 'test3' => 'Test3', 'test4' => 'Test4');
$selected 		= 'test2';
$label 			= 'select single:';

$forms->select($selectAttr, $optionsAttr, $selected, $options, $label);
echo $forms->renderSingle('selectsingle');
echo '<br />';

// create select tag, multiple
echo '<h3>select tag [multiple]</h3>';
$selectAttr 	= array('name' => 'selectmultiple', 'size'=>6);
$optionsAttr 	= null;
$options 		= array('test1' => 'Test1', 'test2' => 'Test2', 'test3' => 'Test3', 'test4' => 'Test4');
$selected 		= array('test2', 'test4');
$label 			= 'select multiple:';

$forms->selectList($selectAttr, $optionsAttr, $selected, $options, $label);
echo $forms->renderSingle('selectmultiple');
echo '<br />';


// create textarea
echo '<h3>textarea</h3>';
$attr 	= array('name' => 'textarea', 'cols'=> 25, 'rows'=> 10);
$value 	= 'This is some example text for this great textarea!!!';
$label  = 'text area:';

$forms->textarea($attr, $value, $label);
echo $forms->renderSingle('textarea');

echo '<br />';

// create checkbox
echo '<h3>checkbox</h3>';
$attr	= array('name' => 'checkbox');
$checked= true;
$label  = 'checkbox:';

$forms->checkbox($attr, $checked, $label);
echo $forms->renderSingle('checkbox');
echo '<br />';


// create radiobuttons
echo '<h3>radio buttons</h3>';
$attr	 = array('name' => 'radio_buttons');
$checked = 'third';
$options = array(array('first', 'First Label'), array('second', 'Second label'),
	 array('third', 'Third Label'), array('fourth', 'Fourth Label'));
$label = 'bla: ';

$forms->radio($attr, $checked, $options, $label);
echo $forms->renderSingle('radio_buttons');
echo '<br />';


// create password field
echo '<h3>password field</h3>';
$attr	 = array('name' => 'password', 'value'=>'somePass');
$label   = 'password:';

$forms->password($attr, $label);
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
$label   = 'file:';

$forms->file($attr, $label);
echo $forms->renderSingle('file');
echo '<br />';

// create submit button
echo '<h3>submit</h3>';
$attr 	= array('name' => 'submit');
$forms->submit($attr);
echo $forms->renderSingle('submit');
echo '<br />';

// create reset button
echo '<h3>reset</h3>';
$attr 	= array('name' => 'reset');
$forms->reset($attr);
echo $forms->renderSingle('reset');
echo '<br />';

echo '</div></body></html>';
?>
