<?php
	session_start();

	if (!isset($_COOKIE["User"]) && !$_SESSION['isAdmin'] == 1)
	{
		header('Location: http://localhost:31337/WebDevProject/index.php');
		die();
	}

	include 'connect.php';

	$title = filter_input(INPUT_GET, 'title', FILTER_SANITIZE_MAGIC_QUOTES);

	$postID = "";

	if(filter_input(INPUT_GET, 'postID', FILTER_VALIDATE_INT))
	{
		$postID = filter_input(INPUT_GET, 'postID', FILTER_SANITIZE_NUMBER_INT);

		$query = "SELECT * FROM posts WHERE postID = {$postID}";

		$statement2 = $db->prepare($query);
    	$statement2->execute();
    	$postRow = $statement2->fetch();

    	$postName = substr($postRow['contentFile'], 0, strpos($postRow['contentFile'], '.'));
	}

	$query = "SELECT * FROM posts WHERE title LIKE '$title' AND postID LIKE '$postID';";
    $statement = $db->prepare($query);
    $statement->execute();

    $row = $statement->fetch();


    function getContent($contentType, $contentFile)
	{
		$image_extensions = ['gif', 'jpg', 'jpeg', 'png'];



		if($contentType == 'txt')
		{
			return 0;
		}else if($contentType == 'mp4')
		{
			return 1;
		}else if(in_array($contentType, $image_extensions))
		{
			return 2;
		}else
		{
			return 3;
		}
	}
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
				<?php
			      			
			      			switch (getContent($row['contentType'],$row['contentFile'])) {
			      				case 0:
			      					$myfile = fopen("Content/".$postName.".txt", "r") or die("Unable to open file!");
									echo fread($myfile,filesize("Content/".$postName.".txt"));
									fclose($myfile);
		      					break;

			      				case 1:
			      					?>
			      					<video controls>
			      					<source src="Content/<?=$postName?>.<?=$row['contentType']?>" type="video/<?=$row['contentType']?>">
									Your browser does not support the video tag.
									</video>
								<?php
			      					break;
			      				
			      				case 2:
			      				?>
			      					<img src="Content/<?=$postName?>.<?=$row['contentType']?>" alt="<?=$row['contentFile']?>" width="300">
			      				<?php
			      					break;
			      			}
			      	?>
			    <?php if (!$row['contentFile'] == null || !$row['contentType'] == null): ?>			    		    	
				    <br>
				    <input type="checkbox" name="remove" value="file"> Remove File<br>
			    <?php endif ?>
				<br>
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