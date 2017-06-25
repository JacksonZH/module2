<!--  
	This file is designed for accessing files and directory,
	which will directly interact with all other PHP files. 
	In particular, it gives the links of files ,directories
	as well as buttons for uploading files and constructing
	new folders. 

	The file also get the user info from login.php and check 
	its correctness. If the info is correct, it will list 
	the user's contents with presenting them hierachically, 
	otherwise, redirect to the login.php.

	It retrieves username from session variable      :     username
	   retrieves directory path from session variable:     directorypath
	   retrieves file name from seesion variable     :     filename
-->

<?php
	session_start();
	// redirect to login page with indicating the identity validation failed
	function redirect() {
		header("Location: http://ec2-13-58-219-145.us-east-2.compute.amazonaws.com/~jackson/module2/trunk/login.php?info=invalid");
		exit;
	}
	// parameters
	$uname = "username";
	$dpath = "directorypath";
	$fname = "filename";

	$watcher_1 = "";


	// check current permission status
	if (array_key_exists($uname, $_SESSION)) { 
		$watcher_1 = "if";
		// Normally, if the key exists, the value must not be nonempty, this is just a double check
		if (!empty($_SESSION[$uname])) {  
			$user = $_SESSION[$uname];
			// check user list
			if (!strpos(file_get_contents('~/users/UserList.txt'), $user)) {
				redirect();
			}
		}
		else {
			redirect();
		}
	}
	// if the key does not exist, this access to open.php must be the first time
	elseif (!array_key_exists($uname, $_SESSION) && !empty($GET[$uname])) { 
		$watcher_1 = "elseif";
		$user = $_GET[$uname];
		// check whether the username matches the names in the user list
		if (!strpos(file_get_contents('~/users/UserList.txt'), $user)) {
			redirect();
		}
		// initialize session variables
		$_SESSION[$uname] = $user;
		// $_SESSION[$dpath] = array();
		$_GET[$fname] = $_SESSION[$uname];
		unset($_GET[$uname]);
	}
	else {
		$watcher_1 = "else";
		redirect();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Files</title>
</head>
<body>
	<?php
		// form the path of current directory using directory names 
		// stored in session variable
		function getDirPath() {
			// refer the global vars
			$uname = $GLOBALS['uname'];
			$dpath = $GLOBALS['dpath'];

			$userName = $_SESSION[$uname];
			$dirPath = "~/users/".$userName;			
			$pathArray = $_SESSION[$dpath];
			foreach ($pathArray as $value) {
				// form path
				$dirPath .= "/".$value;
			}
			return $dirPath;
		}

		// form the path of the given file
		function getFilePath() {
			// refer the global vars
			$fname = $GLOBALS['fname'];

			$fileName = $_GET[$fname];
			$dirPath = getDirPath();
			return $dirPath."/".$fileName;
		}

		// this function will list all the files and directories 
		// under current path by presenting them as link form
		function listContent() {
			$dirPath = getDirPath();
			$items = scandir($dirPath);
			// check if, in current repo, we need a return link
			if (!empty($_SESSION[$dpath])) {
				if ($_SESSION[$uname] !== end($_SESSION[$dpath])) {   
					echo "<a href=\"http://ec2-13-58-219-145.us-east-2.compute.amazonaws.com/~jackson/module2/trunk/open.php?filename=\">..</a><br>";
				}
			}
			// check if current folder contain any item 
			if (!empty($items)) {
				// if nonempty, traverse the folder
				foreach ($items as $value) {
					$itemPath = $dirPath."/".$value;
					if (is_dir($itemPath)) {
						echo "<a href=\"http://ec2-13-58-219-145.us-east-2.compute.amazonaws.com/~jackson/module2/trunk/open.php?filename=".$value."\">".$value."/</a><br>";
					}
					else{
						echo "<a href=\"http://ec2-13-58-219-145.us-east-2.compute.amazonaws.com/~jackson/module2/trunk/open.php?filename=".$value."\">".$value."</a><br>";
					}
				}
			}
		}

		// this function will open selected file with original form
		// which means if the file is .pdf, it will be viewed as PDF 
		function openFile() {
			$filePath = getFilePath();
			$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
			if (!$finfo) {
			 	echo "Opening fileinfo database failed";
			}

			$mime=finfo_file($finfo, $filePath);
			finfo_close($finfo);

			header('content-type:'. $mime);
			readfile($filePath);
		}

		//debug
		echo $watcher_1;

		// check if returned
		if (empty($_GET[$fname])) {
			if (end($_SESSION[$dpath]) !== $_SESSION[$uname]) {
				$_GET[$fname] = array_pop($_SESSION[$dpath]);
			}
			listContent();
		}
		elseif (file_exists(getFilePath())) {

			// for debug
			echo "file/directory existx";
			if (is_dir(getFilePath())) {
				array_push($_SESSION[$dpath], $_GET[$fname]);
				listContent();
			}
			else {
				openFile();
			}
		}
		else {
			echo "No such file or directory!";
			exit;
		}
	?>

	<form action="http://ec2-13-58-219-145.us-east-2.compute.amazonaws.com/~jackson/module2/trunk/upload.php" method="GET">
		<input type="submit" name="Upload" value="Upload">
	</form>

	<form action="http://ec2-13-58-219-145.us-east-2.compute.amazonaws.com/~jackson/module2/trunk/newfolder.php" method="GET">
		<input type="submit" name="New folder" value="New folder">
	</form><br>

	<form action="http://ec2-13-58-219-145.us-east-2.compute.amazonaws.com/~jackson/module2/trunk/logout.php" method="GET">
		<input type="submit" name="Logout" value="Logout">
	</form>
</body>
</html>