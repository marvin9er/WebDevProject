<?php
	include 'connect.php';

	$count = 0;

	$userLoggedIn = 0;

	if (isset($_COOKIE["User"])) {
		session_start();
		$userLoggedIn = 1;
	}

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
		$postID2 = filter_input(INPUT_GET, "postID", FILTER_SANITIZE_NUMBER_INT);
		$contentDescription = filter_input(INPUT_POST, "contentArea", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		if(!empty($_POST["remove"]))
		{
			$fileStatement = $db->prepare("SELECT contentFile FROM posts WHERE postID=:id;");
			$fileStatement->bindParam(':id', $postID);
			$fileStatement->execute();
			$filename = $fileStatement->fetch();

			unlink("content/".$filename['contentFile']);
			

   			$statement = $db->prepare("UPDATE posts SET contentDescription=:description, contentType=null, contentFile=null WHERE postID=:postId");
   			$statement->bindParam(':description', $contentDescription);
    		$statement->bindParam(':postId', $postID2);
    		$statement->execute();
    	}
		else
		{		
   			$statement = $db->prepare("UPDATE posts SET contentDescription=:description WHERE postID=:id");
   			$statement->bindParam(':description', $contentDescription);
    		$statement->bindParam(':id', $postID);
    		$statement->execute();
		}
		
	}



	$selectQuery = "SELECT * FROM posts ORDER BY date_posted DESC;";
    $selectStatement = $db->prepare($selectQuery);
    $selectStatement->execute();
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
				<?php if ($userLoggedIn == 1):?>
					<li class="breadcrumb-item"><a href="signout.php">Sign Out</a></li>
				<?php else: ?>
					<li class="breadcrumb-item"><a href="login.php">Login</a></li>
				<?php endif ?>
			</ol>

		</nav>
		<div id="content">
			<?php while (($row = $selectStatement->fetch()) && $count < 5): ?>
		      		<div class="container">
		      			<div class="row">
    						<div class="col-sm">
    							<h5><?=$row['title']?></h5>
    							<p>    								
    								<?php
	    								if(isset($row['contentDescription'])):
    								?>	
    									<p>
	    								<?php if(strlen($row['contentDescription']) < 200) :?>						      			
	    								<?=$row['contentDescription']?>
	    								<br>
						      			<?php else:?>
						      				<?= substr($row['contentDescription'], 0, 200) ?>
						      				<br>
						      			<?php
    									endif;
    									?>
    									</p>
    								<?php
    								endif;
    								?>
    								<a href="fullPost.php?id=<?=$row['postID']?>">View Post</a>
				      				<?php 
				      					if (isset($_SESSION) && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1):
				      				?>
    										| 
    									<a href="news.php?delete=1&id=<?=$row['postID']?>">Delete Post</a>
    										| 
    									<a href="edit.php?title=<?=$row['title']?>&postID=<?=$row['postID']?>">Edit Post</a>
    								<?php 
    									endif 
    								?>
    							</p>
    						</div>
		      			</div>	      			
		      		</div>
		   		<?php
		   			$count++;
		   			endwhile 
		   		?>
		</div>
	</div>
</body>
</html>