<?php

?>





<!DOCTYPE html>
<html lang="en">
<head>
	<title>BJ²</title>
</head>
<body>
	<div id="header">
		<h1>BJ²</h1>
	</div>
	<div id="menubar">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="about.php">About</a></li>
			<li><a href="episodes.php">Episodes</a></li>
			<li><a href="faq.php">FAQ</a></li>
		</ul>
	</div>
	<div id="content">
		<?php
			$myfile = fopen("index.txt", "r") or die("Unable to open file!");
			echo fread($myfile,filesize("index.txt"));
			fclose($myfile);
		?> 
	</div>
	<div id="footer">
		
	</div>
</body>
</html>