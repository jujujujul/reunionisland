<?php 

function isTheSame($a, $b) {
	if(strtolower($a) == strtolower($b)) {
		return "selected";
	} else {return ;}
}
function isChecked ($checkableItem) {
	if ($checkableItem == 1) {
		return "checked";
	}
}
function isANumber ($toVerify) {
	if (is_integer($toVerify)) {
		return true;
	} else {
		return false;
	}
}
 ?>