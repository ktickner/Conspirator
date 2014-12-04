<?php
	session_start();
	// TO BE REQUIRED IN REGISTER PAGE
	
	require_once 'database.php';
	
	//setting previous page var for redirection after process
	if(isset($_COOKIE['prevPage']))
	{
		$prevPage = $_COOKIE['prevPage'];
	}
	else
	{
		$prevPage = 'index.php';
	}
	
	# Registration #
	
	if(isset($_POST['register']))
	{
		$valid = true;
		
		$email = "";
		$emailRepeat = "";
		$password = "";
		$passwordRepeat = "";
		$firstName = "";
		$lastName = "";
		$dateJoined = "";
		$image = "";
		$bio = "";
		$permissions = "";
		
		$emailError = "";
		$passwordError = "";
		$firstNameError = "";
		$lastNameError = "";
		$imageError = "";
		$bioError = "";
		
		$errors = array();
		
		
		# Validate and Sanitize all user input #

	
		if ($_POST['email']) {
			$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
			$email = filter_var($email, FILTER_VALIDATE_EMAIL);
			if(empty($email))
			{
				$valid = false;
				$emailError = 'Email invalid, please try again.';
				$errors[] = $emailError;
			}
			else
			{
				if ($_POST['emailRepeat']) 
				{
					$emailRepeat = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
					$emailRepeat = filter_var($email, FILTER_VALIDATE_EMAIL);
					if(empty($emailRepeat))
					{
						$valid = false;
						$emailError = 'Email inputs do not match, please try again.';
						$errors[] = $emailError;
					}
					else
					{
						if($email == $emailRepeat)
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
						else
						{
							$valid = false;
							$emailError = 'Email inputs do not match, please try again.';
							$errors[] = $emailError;
						}
					}
				}
			}
		}
		else
		{
			$valid = false;
			$emailError = 'Please enter an email address.';
			$errors[] = $emailError;
		}
		
		if ($_POST['password'])
		{
			$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
			if (ctype_alnum($password) && strlen($password) > 7)
			{
				$passwordRepeat = filter_input(INPUT_POST, 'passwordRepeat', FILTER_SANITIZE_STRING);
				if (ctype_alnum($passwordRepeat) && strlen($passwordRepeat) > 7)
				{
					if($password == $passwordRepeat)
					{
						$password = password_hash($password, PASSWORD_DEFAULT);
					}
					else
					{
						$valid = false;
						$passwordError = 'Password inputs do not match, please try again';
						$errors[] = $passwordError;
					}
				}
				else
				{
					$valid = false;
					$passwordError = 'Password inputs do not match, please try again';
					$errors[] = $passwordError;
				}
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
		
		if($_POST['firstName'])
		{
			$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
			if(!preg_match('/^[a-zA-Z]{1,25}$/', $firstName))
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
		
		if($_POST['lastName'])
		{
			$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
			if(!preg_match('/^[a-zA-Z]{1,25}$/', $lastName))
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
		if(isset($_POST['avatar']))
		{
			require 'imageupload.php';
			if($uploadOk != 1)
			{
				$valid = false;
			}
		}
		else
		{
			$avatar = 'default.jpg';
		}
		
		if($_POST['bio'])
		{
			$bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING);
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
		
		# Functions to be run if all input is valid #
		if ($valid == true)
		{
			//Set non-user input variables
			$dateJoined = date("Y/m/d");
			$permissions = 1;
			
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			//Write to database table user
			$sql = "INSERT INTO user (email,password,first_name,last_name,date_joined,permissions,avatar,bio) values(?, ?, ?, ?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($email,$password,$firstName,$lastName,$dateJoined,$permissions,$avatar,$bio));
			
			//Collect current user information for session
			$sql = "SELECT id FROM user WHERE email = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($email));
			$f = $q->fetch(PDO::FETCH_ASSOC);
			$user = $f['id'];
			
			Database::disconnect();
			
			//Set log in cookie and Session vars and redirect
			setcookie("loggedIn", true); //how does this recognise the user if they close browser??
			$_SESSION['user'] = $user;
			header("Location: " . $prevPage);
		}
	}
	
	# Log In #
	elseif(isset($_POST['logIn']))
	{
		$valid = true;
		
		$email = "";
		$password = "";
		
		$error = "";
		
		# Validating and Sanatizing user inputs #
		if ($_POST['email']) {
			$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
			$email = filter_var($email, FILTER_VALIDATE_EMAIL);
			if(!$email)
			{
				$valid = false;
				$error = 'Email or password was incorrect, please try again.';
			}
			
		}
		else
		{
			$valid = false;
			$error = 'Please enter an email address.';
		}
		
		if ($_POST['password'])
		{
			$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
			if (!ctype_alnum($password) && strlen($password) < 8)
			{
				$valid = false;
				$error = 'Email or password was incorrect, please try again.';
			}
		}
		else
		{
			$valid = false;
			$error = 'Please enter a password.';
		}
		
		# Begins email/password testing against DB once all inputs are valid #
		if($valid)
		{
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT email, password FROM user";
			foreach ($pdo->query($sql) as $row)
			{
				if($row['email'] == $email && password_verify($password, $row['password']))
				{
					//Collect current user information for session
					$sql = "SELECT id FROM user WHERE email = ?";
					$q = $pdo->prepare($sql);
					$q->execute(array($email));
					$f = $q->fetch(PDO::FETCH_ASSOC);
					$user = $f['id'];
					
					Database::disconnect();
					
					//Set log in cookie and session vars and redirect
					setcookie("loggedIn", true); //how does this recognise the user if they close browser??
					$_SESSION['user'] = $user;
					header("Location: " . $prevPage);
				}
			}
			Database::disconnect();
			
			$error = 'Email or password was incorrect, please try again.';
			$_SESSION['loginError'] = $error;
			header("Location: " . $prevPage);
		}
		else
		{
			$_SESSION['loginError'] = $error;
			header("Location: " . $prevPage);
		}
	}
	
	# Log Out #
	elseif(isset($_POST['logOut']))
	{
		setcookie("loggedIn", "");
		unset($_SESSION['user']);
		header("Location: index.php");
	}
	
	# Redirect to index if script is not initiated as intended #
	else
	{
		header("Location: index.php");
	}
?>