<!DOCTYPE html>
<html>
<head><title> Calculator </title></head>
<body>
<?php

// $in_a=$_GET['inputa'];
// if (empty($in_a)) {
// 	$in_a = 0;
// }
if (!array_key_exists('inputa', $_GET) || 
	!array_key_exists('inputb', $_GET) ||
	!array_key_exists('method', $_GET) ) {
	echo "Invalid access!";
	exit();
}

$in_a=$_GET['inputa'];
$in_b=$_GET['inputb'];
$method=$_GET['method'];

if ($in_b == 0 && $method == 'div') {
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
