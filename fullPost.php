<?php 
	include 'connect.php';

	if (isset($_COOKIE["User"]))
	{
		session_start();
		$userLoggedIn = 1;
	}
	else
	{
		$userLoggedIn = 0;
	}

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


    	$statement2 = $db->prepare($query);
    	$statement2->execute();
    	$postRow = $statement2->fetch();

    	$postName = substr($postRow['contentFile'], 0, strpos($postRow['contentFile'], '.'));
	}


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

	if (isset($_GET['replyID']) && filter_input(INPUT_GET, 'replyID', FILTER_VALIDATE_INT))
	{
		$replyID = filter_input(INPUT_GET, 'replyID', FILTER_SANITIZE_NUMBER_INT);
	}

	if (!isset($_POST['commentContent']))
    {
    	$errorflag = true;
    }
    else if (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT))
    {
    	$postID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    	$comment = filter_input(INPUT_POST, 'commentContent', FILTER_SANITIZE_SPECIAL_CHARS);
    	$userID = $_COOKIE['User'];


    	$commentQuery = "INSERT INTO comments (userID, postID, content) values (:userID, :postID, :content)";
    	$commentStatement = $db->prepare($commentQuery);   		
		$commentStatement->bindValue(':userID', $userID);        
		$commentStatement->bindValue(':postID', $postID);        
		$commentStatement->bindValue(':content', $comment);
		$commentStatement->execute();
    }


    $commentSelectQuery = "SELECT * FROM comments WHERE postID = {$postID} ORDER BY date_posted DESC;";
    $commentSelectStatement = $db->prepare($commentSelectQuery);
    $commentSelectStatement->execute();

    $row = $commentSelectStatement->fetch();

    $commentSelectStatement2 = $db->prepare($commentSelectQuery);
    $commentSelectStatement2->execute();

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
				<li class="breadcrumb-item"><a href="news.php">News</a></li>
				<li class="breadcrumb-item"><a href="faq.php">FAQ</a></li>
				<?php if (isset($_COOKIE["User"])):?>
					<li class="breadcrumb-item"><a href="signout.php">Sign Out</a></li>
				<?php else: ?>
					<li class="breadcrumb-item"><a href="login.php">Login</a></li>
				<?php endif ?>
			</ol>
		</nav>
		<div id="content" class="container">
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
		      					<img src="Content/<?=$postName?>.<?=$row['contentType']?>" alt="<?=$row['contentFile']?>" width="1000">
		      				<?php
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
		<?php if($userLoggedIn == 1): ?>
			<div id="commentBox" class="container">
				<form method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="commentContent">Comment</label>
						<textarea class="form-control" id="commentContent" name="commentContent" rows="5" maxlength="250"></textarea>
					</div>
					<button type="submit" class="btn btn-secondary">Submit</button>
				</form>		
			</div>
		<?php else:?>
			<div class="alert alert-secondary" role="alert">
				<a href="login.php">Log in</a> to post a Comment.
			</div>
		<?php endif?>
			<div id="comments" class="container">
				<?php while ($row2 = $commentSelectStatement2->fetch()): ?>
		      		<div class="container">
		      			<div class="row">
    						<div class="col-sm">
    							<h5>
    								<?php  
    									$userQuery = "SELECT * FROM users WHERE userID LIKE {$row2['userID']}";
    									$userStatement = $db->prepare($userQuery);
    									$userStatement->execute();

    									$user = $userStatement->fetch();

    									echo $user['username'];
    								?>    								
    							</h5>
				      			<p>
				      				<?=$row2['content']?>
				      			</p>
				      		</div>
				      	</div>	      			
		      		</div>
		   		<?php 
		   			endwhile 
		   		?>
			</div>
	</div>
</body>
</html>