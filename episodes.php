<?php 
	include 'connect.php';

	$count = 0;

	$query = "SELECT * FROM posts WHERE title LIKE '%Episode%' ORDER BY date_posted DESC;";
    $statement = $db->prepare($query);
    $statement->execute();
?>





<!DOCTYPE html>
<html lang="en">
<head>
	<title>Awakening | Episodes</title>
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
				<li class="breadcrumb-item active" aria-current="page">Episodes</li>
				<li class="breadcrumb-item"><a href="News.php">News</a></li>
				<li class="breadcrumb-item"><a href="faq.php">FAQ</a></li>
			</ol>
		</nav>

		<div id="content">
			<h2>Episodes</h2>
			<?php while (($row = $statement->fetch()) && $count < 5): ?>
		      		<div class="container">
		      			<div class="row">
    						<div class="col-sm">
				      			<p>
				      				<h5><?= $row['title'] ?></h5>
				      				<?php
	    								if(isset($row['contentDescription'])):
    								?>
	    								<?php if(strlen($row['contentDescription']) < 200) :?>						      			
	    								<?=$row['contentDescription']?>
	    								<br>
						      			<?php else:?>
						      				<?= substr($row['contentDescription'], 0, 200) ?>
						      				<br>
						      			<?php
    									endif;
    									?>
    								<?php
    								endif;
    								?>
				      				<a href="fullPost.php?id=<?=$row['postID']?>">View Episode</a>
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