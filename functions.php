<?php

// these are awesome functions that are coolio.

function removeSpecialChars($input) {
	return preg_replace('/[^(\x20-\x7F)]*/','', $input);
	// it's a little aggressive, but whatever.'
}

function getElementById($idName, $dom) {
	$Elements = $dom->getElementsByTagName("*");
	$length = $Elements->length;
	for($i = 0; $i< $length; $i++) {
		if($Elements->item($i)->attributes->getNamedItem('id')->nodeValue == $idName) {
			return $Elements->item($i);
		}
	}
}
	
function getElementsByClassName($ClassName, $dom) {
	$Elements = $dom->getElementsByTagName("*");
	$Matched = array();
	for($i=0;$i<$Elements->length;$i++) {
		if($Elements->item($i)->attributes->getNamedItem('class')->nodeValue == $ClassName) {
			$Matched[]=$Elements->item($i);
		}			
	}
	return $Matched;
}
