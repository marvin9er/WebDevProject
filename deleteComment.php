<?php
	include 'connect.php';

	if (!isset($_COOKIE["User"]) && !$_SESSION['isAdmin'] == 1)
	{
		header('Location: http://localhost:31337/WebDevProject/index.php');
		die();
	}

	if(!filter_input(INPUT_GET, 'commentIDtoDelete', FILTER_VALIDATE_INT))
	{
			$errorflag = true;
	}else
	{
		$commentID = filter_input(INPUT_GET, 'commentIDtoDelete', FILTER_SANITIZE_NUMBER_INT);
		$id = $commentID;

		$headerStatement = $db->prepare("SELECT * FROM comments WHERE commentID = :id");
		$headerStatement->bindParam(':id', $id);
		$headerStatement->execute();
		
		$row = $headerStatement->fetch();

		$postID = $row['postID'];

		if(isset($commentID))
		{
			$stmt = $db->prepare( "DELETE FROM comments WHERE commentID =:id" );
    		$stmt->bindParam(':id', $id);
    		$stmt->execute();
		}
	}

	header("Location: http://localhost:31337/WebDevProject/fullPost.php?id=$postID");
?>