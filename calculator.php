<!DOCTYPE html>
<html>
<head><title> Calculator </title></head>
<body>
<?php

// $in_a=$_GET['inputa'];
// if (empty($in_a)) {
// 	$in_a = 0;
// }
if (is_null($_GET['inputa'])) {
	echo "input a is null!";
	$in_a = 0;
}
$in_b=$_GET['inputb'];
if (empty($in_b)) {
	$in_b = 0;
}
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
