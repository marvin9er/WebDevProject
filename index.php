<?php
	include 'connect.php';

	if(isset($_POST['username']) && isset($_POST['password']))
	{
		$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_EMAIL);

		$stmt = $db->prepare("SELECT * FROM users WHERE username LIKE '$username' AND password LIKE '$password'");
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
        	ini_set('session.gc_maxlifetime', 60);

        	session_start();

        	$row = $stmt->fetch();

        	$_SESSION['username'] = $username;
        	$_SESSION['isAdmin'] = $row['isAdmin'];

        	$cookie_name = "User";
			$cookie_value = $row['userID'];
			setcookie($cookie_name, $cookie_value, time() + (3600), "/");
        }
	}

	if (isset($_POST['contentArea']) && filter_input(INPUT_GET, 'postID', FILTER_VALIDATE_INT)) 
	{

		$postID = filter_input(INPUT_GET, "postID", FILTER_SANITIZE_NUMBER_INT);
		$contentDescription = filter_input(INPUT_POST, "contentArea", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
   		$statement = $db->prepare("UPDATE posts SET contentDescription=:description WHERE postID=:id");
   		$statement->bindParam(':description', $contentDescription);
    	$statement->bindParam(':id', $postID);
    	$statement->execute();
	}




?>





<!DOCTYPE html>
<html lang="en">
<head>
	<title>Awakening</title>
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
				<li class="breadcrumb-item active" aria-current="page">Home</li>
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
			<p>
				
			</p>
		</div>
	</div>
</body>
</html>