<?php

//****************************************************************
//* This class is responsible for drawing basic form elements.
//* 
//* 
//* 
//* Copyright 2006 Christoph Koehler
//* 
//****************************************************************


class forms {





//*********************************
//******** Static methods  ********
//*********************************

	
	function input($name, $properties = array()) {
		$fillContent 	.= "<input type=\"text\" name=\"$name\" value=\"$value\" size=\"$length\" />";

	}

	function textarea($name, $properties = array()) {
		
		$fillContent .= "<textarea rows=\"$rows\" cols=\"$cols\" name=\"$name\">$value</textarea>";
		
	}


	function select($name, $properties = array()) {
		$values = $GLOBALS['TCA']['fe_users']['columns'][$field]['config']['items'];
		$value  = $GLOBALS['TSFE']->sL($values[$value][0]);
		
		$fillContent = '<tr><td class="' . $classLeft . '">';
		$fillContent .= $label;
		$fillContent .= '</td><td class="' . $classRight . '">';
		
		$fillContent .= "<select name=\"$name\">";
	
		for ($h = 0; $h < sizeof($values); $h++) {
			$actValue = $GLOBALS['TSFE']->sL($values[$h][0]);
	
			if ($actValue == $value) {
				
				$fillContent .= "<option value=\"$h\" selected=\"selected\">" . $actValue . "</option>";
			} else {
				
				$fillContent .= "<option value=\"$h\">" . $actValue . "</option>";
			}
		}
		$fillContent .= '</select>';
		
		$fillContent .= '</td></tr>';
	}

	function check($name, $properties) {		
		$fillContent = '<tr><td class="' . $classLeft . '">';
		$fillContent .= $label;
		$fillContent .= '</td><td class="' . $classRight . '">';
	
		if ($value == 1) {
			$fillContent .= "<input type=\"$type\" name=\"$name\" value=\"1\" size=\"$length\" checked=\"checked\" />";
		} else {
			$fillContent .= "<input type=\"$type\" name=\"$name\" value=\"1\" size=\"$length\" />";
		}
		
		$fillContent .= '</td></tr>';
	}

	function password($name, $properties) {
		$fillContent = '<tr><td class="' . $classLeft . '">';
		$fillContent .= $label;
		$fillContent .= '</td><td class="' . $classRight . '">';
		$fillContent .= '<input type="password" name="' . $this->prefixID . '[password1]" value="" size="' . $length . '" id="password1"/><br />';
		$fillContent .= '<input type="password" name="' . $this->prefixID . '[password2]" value="" size="' . $length . '" id="password2"/>';
		$fillContent .= '</td></tr>';
	}
}
?>
