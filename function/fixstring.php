<?php
function fixstr($string){
	$string = str_replace("'", "''", $string);
	return $string;
}
?>