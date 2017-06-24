<!--  This file retrieves directory path from session variable: dirpath
				retrieves file name from seesion variable     : filename
				updates directory if filename is actually folder -->

<?php
	session_start();
	function redirect() {
		header("Location: http://ec2-13-58-219-145.us-east-2.compute.amazonaws.com/~jackson/module2/trunk/login.php");
		exit();
	}

	// check current permission status
	$user = $_SESSION['username'];
	$userlist = file_get_contents('~/users/UserList.txt')
	// if not permitted, redirect to login
	if (strpos($userlist, $user) == FALSE) {
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
		// functions
		function getPath($sessionVar) {
			$userName = $sessionVar['username'];
			$dirPath = "~/users/".$userName;			
			$pathArray = $sessionVar['dirpath'];
			foreach ($pathArray as $value) {
				# form path
				$dirPath .= "/".$value;
			}
			return $dirPath;
		}

		function listContent($dirPath) {
			$items = scandir($dirPath);
			if ($items !== FALSE) {
				// it the folder is not empty
				foreach ($items as $value) {
					//traverse the folder
					$newPath = $dirPath."/".$value;
					if (is_dir($newPath) == TRUE) {
						echo "<a href=\"http://ec2-13-58-219-145.us-east-2.compute.amazonaws.com/~jackson/module2/trunk/open.php?filename=".$value."\">".$value."/</a><br>";
					}
					else{
						echo "<a href=\"http://ec2-13-58-219-145.us-east-2.compute.amazonaws.com/~jackson/module2/trunk/open.php?filename=".$value."\">".$value."</a><br>";
					}
				}
			}
		}

		function openFile($filePath) {
			$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
			if (!$finfo) {
			 	echo "Opening fileinfo database failed";
			}

			$mime=finfo_file($finfo, $filePath);
			finfo_close($finfo);

			header('content-type:'. $mime);
			readfile($filePath);
		}

		function backWard() {
			if ($_SESSION['username'] !== end($_SESSION['dirpath'])) {   
				echo "<a href=\"http://ec2-13-58-219-145.us-east-2.compute.amazonaws.com/~jackson/module2/trunk/open.php?filename=NULL\">..</a><br>";
			}
		}

		// return to the last repo
		if ($_SESSION['filename'] == NULL) {
			// delete the last element in path array
			array_pop($_SESSION['dirpath']);
			// generate new path
			$dirPath = getPath($_SESSION);
			// whether there should exist a go back option
			backWard();
			// show current folder 
			listContent($dirPath);
		}
		else {
			// add filename to path array
			array_push($_SESSION['dirpath'], $filename);
			// generate new path
			$dirPath = getPath($_SESSION);
			// type of directory
			if (is_dir($dirPath) == TRUE) {
				// whether there should exist a go back option
				backWard();
				// show current folder 
				listContent($dirPath);
			}
			// type of file
			else {
				// open the file
				openFile($dirPath);
			}
		}
	?>

	<form action="http://ec2-13-58-219-145.us-east-2.compute.amazonaws.com/~jackson/module2/trunk/upload.php" method="GET">
		<input type="submit" name="Upload">
	</form>

	<form action="http://ec2-13-58-219-145.us-east-2.compute.amazonaws.com/~jackson/module2/trunk/newfolder.php" method="GET">
		<input type="submit" name="New folder">
	</form>
</body>
</html>