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

if(!empty($_POST)) {
	echo '<h2>Post Vars</h2>';
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';	
}

if(!empty($_GET)) {
	echo '<h2>GET Vars</h2>';
	echo '<pre>';
	print_r($_GET);
	echo '</pre>';
}

if(!empty($_FILES)) {
	echo '<h2>File Vars</h2>';
	echo '<pre>';
	print_r($_FILES);
	echo '</pre>';	
}



// create input tag
$attr 	= array('name' => 'texttest');
$label = 'text test:';
$forms->input($attr, $label);

// create select tag, single
$selectAttr 	= array('name' => 'selectsingle');
$optionsAttr 	= null;
$options 		= array('test1' => 'Test1', 'test2' => 'Test2', 'test3' => 'Test3', 'test4' => 'Test4');
$selected 		= 'test2';
$label 			= 'select single:';
$forms->select($selectAttr, $optionsAttr, $selected, $options, $label);


// create select tag, multiple
$selectAttr 	= array('name' => 'selectmultiple', 'size'=>6);
$optionsAttr 	= null;
$options 		= array('test1' => 'Test1', 'test2' => 'Test2', 'test3' => 'Test3', 'test4' => 'Test4');
$selected 		= array('test2', 'test4');
$label 			= 'select multiple:';
$forms->selectList($selectAttr, $optionsAttr, $selected, $options, $label);



// create textarea
$attr 	= array('name' => 'textarea', 'cols'=> 25, 'rows'=> 10);
$value 	= 'This is some example text for this great textarea!!!';
$label  = 'text area:';
$forms->textarea($attr, $value, $label);

// create checkbox
$attr	= array('name' => 'checkbox');
$checked= true;
$label  = 'checkbox:';
$forms->checkbox($attr, $checked, $label);

// create radiobuttons
$attr	 = array('name' => 'radio_buttons');
$checked = 'third';
$options = array(array('first', 'First Label'), array('second', 'Second label'),
	 array('third', 'Third Label'), array('fourth', 'Fourth Label'));
$label = 'bla: ';
$forms->radio($attr, $checked, $options, $label);

// create password field
$attr	 = array('name' => 'password', 'value'=>'somePass');
$label   = 'password:';
$forms->password($attr, $label);

// create hidden field
$attr	 = array('name' => 'hidden', 'value'=>'someHiddenValue');
$forms->hidden($attr);

// create file field
$attr	 = array('name' => 'file');
$label   = 'file:';
$forms->file($attr, $label);

// create submit button
$attr 	= array('name' => 'submit');
$forms->submit($attr);

// create reset button
$attr 	= array('name' => 'reset');
$forms->reset($attr);

echo '<h1>Render a whole form</h1>';
echo '<div>';
echo $forms->render();
echo '</div>';
echo '</div></body></html>';
?>
