<?php
	// redirect to login page with log out indication
	function redirect() {
		header("Location: http://ec2-13-58-219-145.us-east-2.compute.amazonaws.com/~jackson/module2/trunk/login.php?info=logout");
		exit();
	}
	session_start();
	session_unset();
	session_destroy();

	redirect();
?>