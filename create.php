<?php
	if (!isset($_COOKIE["User"]))
	{
		header('Location: http://localhost:31337/WebDevProject/index.php');		
		die();
	}	

	include 'connect.php';
	session_start();

    function file_upload_path($original_filename, $upload_subfolder_name = 'Content') {
       $current_folder = dirname(__FILE__);
       $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
       return join(DIRECTORY_SEPARATOR, $path_segments);
    }

    $errorflag = 0;
    			
    $image_upload_detected = isset($_FILES['image']);
    			
    if ($image_upload_detected) {

    	if(($_POST['title'] == null))
    	{
    		$errorflag = 1;
    	}
    	else
    	{
    		$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    		$description = filter_input(INPUT_POST, 'contentArea', FILTER_SANITIZE_SPECIAL_CHARS);

    		$upload_filename       = $_FILES['image']['name'];
    		$temporary_file_path = $_FILES['image']['tmp_name'];
    		$new_file_path       = file_upload_path($upload_filename);
    		$upload_filetype = pathinfo($new_file_path, PATHINFO_EXTENSION);
    		$userID = $_COOKIE['User'];

    		$newPostQuery = "INSERT INTO posts (userID, title, contentType, contentFile, contentDescription) values (:userID, :title, :contentType, :contentFile, :contentDescription)";
   			$newPostStatement = $db->prepare($newPostQuery);   		
   			$newPostStatement->bindValue(':userID', $userID);        
    		$newPostStatement->bindValue(':title', $title);        
    		$newPostStatement->bindValue(':contentType', $upload_filetype);        
    		$newPostStatement->bindValue(':contentFile', $upload_filename);        
    		$newPostStatement->bindValue(':contentDescription', $description);
  			$newPostStatement->execute();
    	}
    }
    function file_type($temporary_path, $new_path) {
        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png', 'video/mp4', 'text/plain'];
        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png', 'mp4', 'txt'];

        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = mime_content_type($temporary_path);

        if(!$actual_mime_type)
        {
        	$finfo = finfo_open( FILEINFO_MIME_TYPE );
        	$tmpname = $temporary_path;
    		$mtype = finfo_file( $finfo, $tmpname );
        	
    		if($mtype == ( "application/pdf" ) )
    		{
    			$actual_mime_type = $mtype;
    		}
        }
        
        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);


        
        return $file_extension_is_valid && $mime_type_is_valid;
    }

	


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Awakening | Create</title>
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
				<?php if (isset($_COOKIE["User"])):?>
					<li class="breadcrumb-item"><a href="signout.php">Sign Out</a></li>
				<?php else: ?>
					<li class="breadcrumb-item"><a href="login.php">Login</a></li>
				<?php endif ?>
			</ol>
		</nav>
		<div id="content">
			<?php
				if($errorflag):
			?>
				<p class="text-danger">
					Post wasn't created, please try again making sure there is a Title.
				</p>
			<?php
				die();
				else:
			?>
				<form method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" class="form-control" name="title" id="title">
					</div>
					<div class="form-group">
						<label for="image">Filename:</label>
	        			<input type="file" name="image" id="image">
					</div>
					<div class="form-group">
						<label for="contentArea">Description</label>
						<textarea class="form-control" id="contentArea" name="contentArea" rows="10"></textarea>
					</div>
					<button type="submit" class="btn btn-secondary">Submit</button>
				</form>
				
				<?php if (isset($_FILES['image']))

		    		if (file_type($temporary_file_path, $new_file_path)) {        		

		    			move_uploaded_file($temporary_file_path, $new_file_path);

		    			file_upload_path($upload_filename);
		    		}
	    		?>
		    <?php 	endif; ?>
		</div>
	</div>
</body>
</html>