<?php
	if (!isset($_COOKIE["User"]))
	{
		header('Location: http://localhost:31337/WebDevProject/index.php');
	}

	include 'connect.php';

	$title = filter_input(INPUT_GET, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$postID = "";

	if(filter_input(INPUT_GET, 'postID', FILTER_VALIDATE_INT))
	{
		$postID = filter_input(INPUT_GET, 'postID', FILTER_SANITIZE_NUMBER_INT);
	}

	$query = "SELECT * FROM posts WHERE title LIKE '$title' AND postID LIKE '$postID';";
    $statement = $db->prepare($query);
    $statement->execute();

    $row = $statement->fetch();



?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Awakening | Edit</title>
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
		<div id="menubar">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</li></a>
				<li class="breadcrumb-item"><a href="about.php">About</a></li>
				<li class="breadcrumb-item"><a href="episodes.php">Episodes</a></li>
				<li class="breadcrumb-item"><a href="news.php">News</a></li>
				<li class="breadcrumb-item"><a href="faq.php">FAQ</a></li>
				<?php if (isset($_COOKIE["User"])):?>
					<li class="breadcrumb-item"><a href="signout.php">Sign Out</a></li>
				<?php else: ?>
					<li class="breadcrumb-item"><a href="login.php">Login</a></li>
				<?php endif ?>
			</ol>

		</nav>
		<div id="content">
			<h2><?=$row['title']?></h2>
			<form action="index.php?postID=<?=$postID?>" method="post">
				<div class="form-group">
					<label for="contentArea">Content</label>
					<textarea class="form-control" id="contentArea" name="contentArea" rows="10"><?=$row['contentDescription']?></textarea>
				</div>
				<button type="submit" class="btn btn-secondary">Submit</button>
			</form>
		</div>
	</div>
</body>
</html>