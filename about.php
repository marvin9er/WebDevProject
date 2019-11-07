<?php 
	include 'connect.php';


	$query = "SELECT * FROM posts WHERE title LIKE 'About';";
    $statement = $db->prepare($query);
    $statement->execute();
    $row = $statement->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Awakening | About</title>
	<link rel="icon" type="image/png" href="Utilities/icon.png" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Finger+Paint&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="extraCSS.css">
</head>
<body>
	<div id="mainContainer" class="container">
		<div class="jumbotron">
			<h1 class="display-4" id="fontChange"><a href="index.php">AWAKENING</a></h1>
		</div>		
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">About</li>
				<li class="breadcrumb-item"><a href="episodes.php">Episodes</a></li>
				<li class="breadcrumb-item"><a href="News.php">News</a></li>
				<li class="breadcrumb-item"><a href="faq.php">FAQ</a></li>
			</ol>
		</nav>
		<div id="content">
			<h2>About</h2>
			<p>
				<?=$row['contentDescription']?>
			</p>
		</div>
	</div>
</body>
</html>