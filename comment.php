<?php

	//PLAN AND PSUEDOCODE COMMENTS SECTIONS
	
	//ONLY AVAILABLE ON ARTICLES, NOT ARCHIVES... NEED TO REDO DB AGAIN OTHERWISE
	//INCLUDE COMMENTS SECTION INTO ARTICLE PAGES?!?
	//CAN DO IT ALL HERE PHP then HTML AND HAVE IT ALL DONE IN ONE PAGE
	
	require 'database.php';
	
	//setting previous page var for redirection after process
	if(isset($_COOKIE['prevPage']))
	{
		$prevPage = $_COOKIE['prevPage'];
	}
	else
	{
		$prevPage = 'index.php';
	}
	
	# Write comment #
	if($_POST['submitComment'])
	{
		$valid = true;
		$commentError = "";	
		
		$comment = "";
		$userId = "";
		$articleId = "";
		$dateCreated = "";
		
		//Ensures a user is logged in
		if(isset($_SESSION['user']))
		{
			//Ensures script is run on a singular article
			if($_GET['type'] == 'article' && isset($_GET['article']))
			{	
				//Validation and Sanitization of user inputs
				if($_POST['comment'])
				{
					$comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
					if(strlen($comment) > 2500)
					{
						$valid = false;
						$commentError = 'Your comment is too long, please shorten it and resubmit';
					}
				}
				else
				{
					$valid = false;
					$commentError = 'Your comment was empty, please try again.';
				}
			}
			else
			{
				header("Location: index.php");
			}
		}
		else
		{
			$valid = false;
			$commentError = 'Please log in to comment.';
		}
		
		//Writes to DB only if valid
		if($valid == true)
		{
			//setting non-user input vars
			$userId = $_SESSION['user'];
			$userId = filter_var($userId, FILTER_SANITIZE_INT);
			
			$articleId = $_GET['article'];
			$articleId = filter_var($articleId, FILTER_SANITIZE_INT);
			
			$dateCreated = date("Y/m/d");
			
			
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			//Write to database table comment
			$sql = "INSERT INTO comment (user_id,article_id,date_created,comment) values(?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($userId,$articleId,$dateCreated,$comment));
			
			Database::disconnect();
			
			header("Location: " . $prevPage);
		}
	}
	
	# Read comments #
	else
	{
		if(isset($_GET['article']))
		{
			//Retrieving and sanitizing article id from url
			$article = $_GET['article'];
			$article = filter_var($article, FILTER_SANITIZE_INT);
			
			
			//needs to join to user table, need to figure that one out
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT comment.comment, comment.date_created, user.first_name, user.last_name 
				FROM comment 
				INNER JOIN user 
				ON comment.user_id=user.id 
				WHERE article_id=$article
				ORDER BY date_created DESC";
		}
		else
		{
			header: ("index.php");
		}
	}
			//Open DB
			//run article id into comment table order by date_written DESC??
			//write to an array for looping into HTML

?>