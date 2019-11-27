<?php 
	include 'connect.php';

	$userLoggedIn = 0;

	if (isset($_COOKIE["User"])) {
		session_start();
		$userLoggedIn = 1;
	}


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
				<li class="breadcrumb-item"><a href="news.php">News</a></li>
				<li class="breadcrumb-item"><a href="faq.php">FAQ</a></li>
				<?php if ($userLoggedIn == 1):?>
					<li class="breadcrumb-item"><a href="signout.php">Sign Out</a></li>
				<?php else: ?>
					<li class="breadcrumb-item"><a href="login.php">Login</a></li>
				<?php endif ?>
			</ol>
		</nav>
		<div id="content">
			<h2>About</h2>
			<?php 
				if (isset($_SESSION) && isset($_SESSION['isAdmin']) == 1):
			?>
			<a href="edit.php?title=<?=$row['title']?>&postID=<?=$row['postID']?>">Edit</a>
    		<?php 
    			endif 
    		?>
			<p>
				<?=$row['contentDescription']?>
			</p>
		</div>
	</div>
</body>
</html>