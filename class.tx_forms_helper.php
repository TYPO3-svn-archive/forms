<?php

class tx_forms_helper {

	/**
	 * @name implodeAttributes
	 * @abstract Takes an array and makes a space-separated list of parameters to include in the tag; $key = "$value".
	 * @param array() $params associative array that is imploded
	 */
	function implodeAttributes($attr) {

		// if null, make empty array
		if($attr == null) {
			$attr = array();
		}
		
		// initialize the returned value
		$implodedAttr = null;

		//loop through $params array and implode
		foreach($attr as $key => $value) {
			
			// add new key-value pair to returned variable
			$implodedAttr .= $key . '="' . $value . '" ';
		}
		
		// return the imploded value
		return $implodedAttr;
		
	}
	
	function debug($array) {	
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}
}
?>
