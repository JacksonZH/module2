<!DOCTYPE html>
<html>
<head><title> Calculator </title></head>
<body>
<?php

$in_a=$_GET['inputa'];
$in_b=$_GET['inputb'];
$method=$_GET['method'];


if (is_null($_GET['inputa']) || is_null($_GET['inputb']) || is_null($_GET['method'])) {
	echo "Inputs should not be empty";
}
elseif ($in_b == 0 && $method == 'div') {
	echo "divisor cannot be 0!";
}
else {
	echo "Result: ";
	switch ($method) {

	case "add":
		echo ($in_a + $in_b);
		break;
	case "sub":
		echo ($in_a - $in_b);
		break;
	case "mul":
		echo ($in_a * $in_b);
		break;
	case "div":
		echo ($in_a / $in_b);
		break;
	default:
		break;
	}
}
?>
</body>
</html>
