<?php

//***************************************
//*********** Test file *****************
//***************************************

include('class.tx_forms.php');
$attr = array('method' => 'get', 'action' => '#');
$forms 	= new tx_forms($attr);

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml11.dtd">' .
	'<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr">';
echo '<head><title>Tag Test</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head>';
echo '<body>';
echo '<div>';

if(!empty($_POST)) {
	echo '<h2>Post Vars (see source)</h2>';
	print_r($_POST);	
}

if(!empty($_GET)) {
	echo '<h2>GET Vars (see source)</h2>';
	print_r($_GET);	
}

if(!empty($_FILE)) {
	echo '<h2>File Vars (see source)</h2>';
	print_r($_FILE);	
}


echo '<h1>Individual Fields</h1>';

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


echo '<h1>Now a whole form</h1>';
echo $forms->render();

echo '</div></body></html>';
?>
