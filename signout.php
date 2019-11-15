<?php
	
	if (isset($_COOKIE["User"])) {
		session_start();
	}

	setcookie("User", $_COOKIE["User"], time() - (3600), "/");
	session_destroy();
	session_abort();



	header("Location: http://localhost:31337/WebDevProject/index.php");
	die();
?>