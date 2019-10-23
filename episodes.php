<?php 
	$podcast_names = [
		'BJ²', 
		'Autism Lite', 
		'The Random Shit Burrito', 
		'Grand Stimulation Center', 
		'3 dudes 1 mic', 
		'Whole Lotta weird'
	];


	$name_number = rand(0, count($podcast_names)-1);
?>





<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=$podcast_names[$name_number]?></title>
</head>
<body>
	<div id="header">
		<h1><?=$podcast_names[$name_number]?></h1>
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
		<h2>Episodes</h2>
		<p>Episode 0</p>
		<p><iframe width="25%" height="265" src="https://www.youtube-nocookie.com/embed/C0DPdy98e4c" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>
	</div>
	<div id="footer">
		
	</div>
</body>
</html>