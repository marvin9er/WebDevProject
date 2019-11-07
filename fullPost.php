<?php 
	include 'connect.php';

	$errorflag = false;

	if(!filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT))
	{
		$errorflag = true;
	}else
	{
		$postID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

		$query = "SELECT * FROM posts WHERE postID = {$postID}";
    	$statement = $db->prepare($query);
    	$statement->execute();

    	$titleStatement = $db->prepare($query);
    	$titleStatement->execute();
    	$titleRow = $titleStatement->fetch();
	}


	function getContent($contentType, $contentFile)
	{
		if($contentType == 'txt')
		{
			return 0;
		}else if($contentType == 'mp4')
		{
			return 1;
		}else if($contentType == 'jpg')
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
	<title>Awakening | <?=$titleRow['title']?></title>
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
				<li class="breadcrumb-item"><a href="about.php">About</a></li>
				<li class="breadcrumb-item"><a href="episodes.php">Episodes</a></li>
				<li class="breadcrumb-item"><a href="News.php">News</a></li>
				<li class="breadcrumb-item"><a href="faq.php">FAQ</a></li>
			</ol>
		</nav>
		<div id="content">
			<?php while (($row = $statement->fetch())): ?>
		      		<div>
		      			<h2><?= $row['title'] ?></h2>
		      			<p>	      					      			
		      				<label>Posted: <?= $row['date_posted'] ?></label>
		      			</p>   			
		      			<p>
		      			<?php
		      			
		      			switch (getContent($row['contentType'],$row['contentFile'])) {
		      				case 0:
		      					$myfile = fopen("content/".$row['contentFile'].".txt", "r") or die("Unable to open file!");
								echo fread($myfile,filesize("content/".$row['contentFile'].".txt"));
								fclose($myfile);
	      					break;

		      				case 1:
		      					?>
		      					<video controls>
		      					<source src="content/<?=$row['contentFile']?>.<?=$row['contentType']?>" type="video/<?=$row['contentType']?>">
								Your browser does not support the video tag.
								</video>
							<?php
		      					break;
		      				
		      				case 2:
		      				?>
		      					<img src="content/<?=$row['contentFile']?>.<?=$row['contentType']?>" alt="$row['contentFile']">
		      				<?php
		      					break;

		      				default:
		      					echo "No content associated with this ID.";
		      					break;
		      			}
		      			?>
		      			</p>
		      			<p>
		      				<?=$row['contentDescription']?>
		      			</p>
		      		</div>
		   	<?php endwhile ?>
		</div>
	</div>
</body>
</html>