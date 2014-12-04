<?php

	//getting page "type" from url to distinguish between archive, article and user
	$type = (isset($_GET['type']) ? $_GET['type'] : null);
	
	$errors = array();
	
	# Another crud if it's creating a user #
	if($type == 'user')
	{
		if(isset($_SESSION['user']))
		{
			$userId = $_SESSION['user'];
			$userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
			
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT permissions FROM user WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($userId));
			$f = $q->fetch(PDO::FETCH_ASSOC);
			$permissions = $f['permissions'];
			Database::disconnect();
			
			if($permissions != 3)
			{
				header("Location: index.php");
			}
		}
		else
		{
			header("Location: index.php");
		}
		
			
		$email = null;
		$password = null;
		$firstName = null;
		$lastName = null;
		$dateJoined = null;
		$permissions = null;
		$avatar = null;
		$bio = null;
		
		
	 
		if (!empty($_POST)) {
			// keep track validation errors
			$emailError = null;
			$passwordError = null;
			$firstNameError = null;
			$lastNameError = null;
			$permissionsError = null;
			$avatarError = null;
			$bioError = null;
			
			// keep track post values
			$email = $_POST['email'];
			$password = $_POST['password'];
			$firstName = $_POST['firstName'];
			$lastName = $_POST['lastName'];
			$permissions = $_POST['permissions'];
			$avatar = $_POST['avatar'];
			$bio = $_POST['bio'];
			 
			 
			// validate input
			$valid = true;
			
			# Validate and Sanitize all user input #

	
			if (!empty($email)) 
			{
				$email = filter_var($email, FILTER_SANITIZE_EMAIL);
				$email = filter_var($email, FILTER_VALIDATE_EMAIL);
				if(empty($email))
				{
					$valid = false;
					$emailError = 'Email invalid, please try again.';
					$errors[] = $emailError;
				}
				else
				{
					$pdo = Database::connect();
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "SELECT email FROM user";
					foreach ($pdo->query($sql) as $row)
					{
						if($row['email'] == $email)
						{
							$valid = false;
							$emailError = 'Email address is already in use, please try a different one.';
							$errors[] = $emailError;
						}
					}
					Database::disconnect();
				}
			}
			else
			{
				$valid = false;
				$emailError = 'Please enter an email address.';
				$errors[] = $emailError;
			}
			
			if (!empty($password))
			{
				$password = filter_var($password, FILTER_SANITIZE_STRING);
				if (ctype_alnum($password) && strlen($password) > 7)
				{
					$password = password_hash($password, PASSWORD_DEFAULT);
					$errors[] = $passwordError;
				}
				else
				{
					$valid = false;
					$passwordError = 'Password is invalid, please review the guidelines and try again.';
					$errors[] = $passwordError;
				}
			}
			else
			{
				$valid = false;
				$passwordError = 'Please enter a password.';
				$errors[] = $passwordError;
			}
			
			if(!empty($firstName))
			{
				$firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
				if(!preg_match('^[a-zA-Z]{1,25}$', $firstName))
				{
					$valid = false;
					$firstNameError = 'First name input is invalid, please review the guidelines and try again.';
					$errors[] = $firstNameError;
				}
			}
			else
			{
				$valid = false;
				$firstNameError = 'Please enter your first name.';
				$errors[] = $firstNameError;
			}
			
			if(!empty($lastName))
			{
				$lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
				if(!preg_match('^[a-zA-Z]{1,25}$', $lastName))
				{
					$valid = false;
					$lastNameError = 'Last name input is invalid, please review the guidelines and try again.';
					$errors[] = $lastNameError;
				}
			}
			else
			{
				$valid = false;
				$lastNameError = 'Please enter your last name.';
				$errors[] = $lastNameError;
			}
			
			//Sets avatar image and string
			if(!empty($avatar))
			{
				require 'imageupload.php';
				if($uploadOk != 1)
				{
					$valid = false;
					$errors[] = $imageError;
				}
			}
			else
			{
				$image = 'default.jpg';
			}
			
			if(!empty($bio))
			{
				$bio = filter_var($bio, FILTER_SANITIZE_STRING);
				if(strlen($password) > 512)
				{
					$valid = false;
					$bioError = 'Your bio is too long, please reduce to 512 characters and resubmit.';
					$errors[] = $bioError;
				}
			}
			else
			{
				$valid = false;
				$bioError = 'Please enter a short personal bio.';
				$errors[] = $bioError;
			}
			
			if(!empty($permissions))
			{
				$permissions = filter_var($permissions, FILTER_SANITIZE_NUMBER_INT);
				if($permissions < 1 && $permissions > 3)
				{
					$permissionsError = 'Set permissions are invalid, please revise.';
					$valid = false;
					$errors[] = $permissonsError;
				}
			}
			else
			{
				$permissionsError = 'User permissions need to be set, please try again.';
				$valid = false;
				$errors[] = $permissonsError;
			}
			
			# Functions to be run if all input is valid #
			if ($valid == true)
			{
				//Set non-user input variables
				$dateJoined = date("Y/m/d");
				
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
				//Write to database table user
				$sql = "INSERT INTO user (email,password,first_name,last_name,date_joined,permissions,avatar,bio) values(?, ?, ?, ?, ?, ?, ?, ?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($email,$password,$firstName,$lastName,$dateJoined,$permissions,$avatar,$bio));
				
				Database::disconnect();
			}
		}
	}
	
	# If changing article or archive #
	else
	{
		if(isset($_SESSION['user']))
		{
			$userId = $_SESSION['user'];
			$userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
			
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT permissions FROM user WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($userId));
			$f = $q->fetch(PDO::FETCH_ASSOC);
			$permissions = $f['permissions'];
			Database::disconnect();
			
			if($permissions < 2 || $permissions > 3)
			{
				header("Location: index.php");
			}
		}
		else
		{
			header("Location: index.php");
		}
		
		$valid = true;
			
		$name = null;
		$image = null;
		$content = null;
		$date = null;
		$author = null;
		$category = null;
	 
		if (!empty($_POST)) {
			// keep track validation errors
			$nameError = null;
			$imageError = null;
			$contentError = null;
			$categoryError = null;
			
			
			//including image upload scripts
			require 'imageupload.php';
			
			echo($valid);
			
			
			//adding in quickfacts vars in case of archive
			if ($type == 'archive')
			{
			$quickFactsError = null;
			$quickFacts = $_POST['quickFacts'];
			}
			
			// keep track post values
			$name = $_POST['name'];
			$content = $_POST['content'];
			$category = $_POST['category'];
			
			// validate input
			$valid = true;
			if (empty($name)) {
				$nameError = 'Please enter the '.$type.'\'s name';
				$valid = false;
				$errors[] = $nameError;
			}
			 
			if (empty($image)) {
				//$imageError = 'Please upload a feature image';
				$valid = false;
				$errors[] = $imageError;
			}
			
			
			//need to set up image errors
			 
			if (empty($content)) {
				$contentError = 'Please enter some content';
				$valid = false;
				$errors[] = $contentError;
			}
			 
			if (empty($category)) {
				$categoryError = 'Please choose a category';
				$valid = false;
				$errors[] = $categoryError;
			}
			
			if ($type == 'archive')
			{
				if (empty($quickFacts)) {
					$quickFactsError = 'Please enter the archive\'s quick facts';
					$valid = false;
					$errors[] = $quickFactsError;
				}
			}
			 
			// insert data
			if ($valid == true) {
				//setting non-user input vars
				$date = date("Y/m/d");
				$author = $userId;
				echo ($date);
				echo($author);
				if ($type == 'archive')
				{
					$pdo = Database::connect();
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "INSERT INTO archive (archive_name,image,content,date_created,author_id,category,quick_facts) values(?, ?, ?, ?, ?, ?, ?)";
					$q = $pdo->prepare($sql);
					$q->execute(array($name,$image,$content,$date,$author,$category,$quickFacts));
					Database::disconnect();
					header("Location: index.php?page=crud&type=article");
				}
				elseif ($type == 'article')
				{
					$pdo = Database::connect();
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "INSERT INTO article (article_name,image,content,date_created,author_id,category) values(?, ?, ?, ?, ?, ?)";
					$q = $pdo->prepare($sql);
					$q->execute(array($name,$image,$content,$date,$author,$category));
					Database::disconnect();
					header("Location: index.php?page=crud&type=article");
				}
				else
				{
					header("Location: index.php");
				}
			}
		}
	}
?>