<?php
	if (isset($_COOKIE["User"]))
	{
		header('Location: http://localhost:31337/WebDevProject/index.php');		
		die();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Awakening | Login</title>
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
				<li class="breadcrumb-item"><a href="login.php">About</li></a>
				<li class="breadcrumb-item"><a href="episodes.php">Episodes</a></li>
				<li class="breadcrumb-item"><a href="news.php">News</a></li>
				<li class="breadcrumb-item"><a href="faq.php">FAQ</a></li>				
				<li class="breadcrumb-item active" aria-current="page">Login</a></li>
			</ol>
		</nav>
		<div id="content">
			<form action="index.php" method="post">
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" name="username" id="username">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" name="password" id="password">
				</div>
				<button type="submit" class="btn btn-secondary">Submit</button>
			</form>
		</div>
	</div>
</body>
</html>