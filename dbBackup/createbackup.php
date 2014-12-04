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
	?>

			<!-- Up to changing inputs -->

	<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="utf-8">
			<link   href="styles/bootstrap.css" rel="stylesheet">
			<script src="js/bootstrap.js"></script>
		</head>

		<body>
			<div class="container">
				<div class="col-md-10 center-block">
				<?php
					if($valid == false)
					{
				?>
				
					<div class="alert alert-danger">
						
				<?php
					foreach($errors as $error)
					{
						echo("<p>$error</p>");
					}
				?>
						
					</div>
				
				<?php
					}
				?>
					<div class="row">
						<h3>Create a User</h3>
					</div>
				<?php
					echo '<form class="form-horizontal" action="index.php?page=create&type='.$type.'" method="post" enctype="multipart/form-data">';
				?>
						<div class="control-group <?php echo !empty($emailError) ? 'error' : '';?>">
							<label class="control-label">Email</label>
							<div class="controls">
								<input name="email" type="text"  placeholder="Email" value="<?php echo !empty($email) ? $email : '' ;?>" required />
								<?php if (!empty($emailError)): ?>
								<span class="help-inline"><?php echo $emailError;?></span>
								<?php endif; ?>
							</div>
						</div>
						
						<div class="control-group <?php echo !empty($passwordError) ? 'error' : '';?>">
							<label class="control-label">Password</label>
							<div class="controls">
								<input name="password" type="password" value="<?php echo !empty($password) ? $password : ''; ?>" required />
								<?php if (!empty($passwordError)): ?>
								<span class="help-inline"><?php echo $passwordError; ?></span>
								<?php endif;?>
							</div>
						</div>
						
						<div class="control-group <?php echo !empty($firstNameError) ? 'error' : '';?>">
							<label class="control-label">First Name</label>
							<div class="controls">
								<input name="firstName" type="text"  placeholder="First name" value="<?php echo !empty($firstName) ? $firstName : '';?>" required />
								<?php if (!empty($firstNameError)): ?>
								<span class="help-inline"><?php echo $firstNameError; ?></span>
								<?php endif;?>
							</div>
						</div>
						
						<div class="control-group <?php echo !empty($lastNameError) ? 'error' : '';?>">
							<label class="control-label">Last Name</label>
							<div class="controls">
								<input name="lastName" type="text"  placeholder="Last name" value="<?php echo !empty($lastName) ? $lastName : '';?>" required />
								<?php if (!empty($lastNameError)): ?>
								<span class="help-inline"><?php echo $lastNameError; ?></span>
								<?php endif;?>
							</div>
						</div>
						
						<div class="control-group <?php echo !empty($permissionsError) ? 'error' : '';?>">
							<label class="control-label">Set Permissions</label>
							<div class="controls">
								<select name="permissions" required>
									<option value="1" <?php if( $permissions == '1' ){ echo 'selected'; } ?>>User</option>
									<option value="2" <?php if( $permissions == '2' ){ echo 'selected'; } ?>>Author</option>
									<option value="3" <?php if( $permissions == '3' ){ echo 'selected'; } ?>>Admin</option>
								</select>
								<?php if (!empty($permissionsError)): ?>
								<span class="help-inline"><?php echo $permissionsError; ?></span>
								<?php endif;?>
							</div>
						</div>
						
						<div class="control-group <?php echo !empty($avatarError) ? 'error' : '';?>">
							<label class="control-label">Avatar</label>
							<div class="controls">
								<input name="avatar" type="file" value="<?php echo !empty($avatar) ? $avatar : ''; ?>" required />
								<?php if (!empty($avatarError)): ?>
								<span class="help-inline"><?php echo $avatarError; ?></span>
								<?php endif;?>
							</div>
						</div>
						
						<div class="control-group <?php echo !empty($bioError) ? 'error' : '';?>">
							<label class="control-label">Bio</label>
							<div class="controls">
								<textarea name="bio" value="<?php echo !empty($bio) ? $bio : '';?>" required></textarea>
								<?php if (!empty($bioError)): ?>
								<span class="help-inline"><?php echo $bioError; ?></span>
								<?php endif;?>
							</div>
						</div>
						
						<div class="control-group">
							<input type="submit" class="btn btn-success" value="Create"/>
							<?php echo'<a class="btn" href="index.php?page=crud&type='.$type.'">Back</a>';?>
						</div>
					</form>
				</div>
			</div> <!-- /container -->
		</body>
	</html>
<?php
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
	?>

			<!-- Up to changing inputs -->

	<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="utf-8">
			<link   href="styles/bootstrap.css" rel="stylesheet">
			<script src="js/bootstrap.js"></script>
		</head>

		<body>
			<div class="container">
				<div class="col-md-10 center-block">
				<?php
					if($valid != true)
					{
				?>
				
					<div class="alert alert-danger">
						
				<?php
						foreach($errors as $error)
						{
							echo("<p>$error</p>");
						}
				?>
						
					</div>
				
				<?php
					}
				?>
					<div class="row">
				<?php
					if ($type == 'article' || $type == 'archive')
					{
					
						if($type == 'archive')
						{
							echo('<h3>Write an Archive</h3>');
						}
						else
						{
							echo('<h3>Write an Article</h3>');
						}
					
				?>
				
					</div>
				</div>
				
				<?php	
					echo '<form class="form-horizontal" action="index.php?page=create&type='.$type.'" method="post" enctype="multipart/form-data">';
				?>
						<div class="control-group <?php echo !empty($nameError) ? 'error' : '';?>">
							<label class="control-label">Article Name</label>
							<div class="controls">
								<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name) ? $name : '' ;?>" required />
								<?php if (!empty($nameError)): ?>
								<span class="help-inline"><?php echo $nameError;?></span>
								<?php endif; ?>
							</div>
						</div>
						
						<div class="control-group <?php echo !empty($imageError) ? 'error' : '';?>">
							<label class="control-label">Feature Image</label>
							<div class="controls">
								<input name="image" type="file" value="<?php echo !empty($image) ? $image : ''; ?>" required />
								<?php if (!empty($imageError)): ?>
								<span class="help-inline"><?php echo $imageError; ?></span>
								<?php endif;?>
							</div>
						</div>
						
						<div class="control-group <?php echo !empty($categoryError) ? 'error' : '';?>">
							<label class="control-label">Select a Category</label>
							<div class="controls">
								<select name="category" required>
									<option value="1" <?php if( $category == '1' ){ echo 'selected'; } ?>>History</option>
									<option value="2" <?php if( $category == '2' ){ echo 'selected'; } ?>>Government / Evil Corporations</option>
									<option value="3" <?php if( $category == '3' ){ echo 'selected'; } ?>>Aliens</option>
									<option value="4" <?php if( $category == '4' ){ echo 'selected'; } ?>>Exotic Creatures</option>
									<option value="5" <?php if( $category == '5' ){ echo 'selected'; } ?>>Urban Legends</option>
									<option value="6" <?php if( $category == '6' ){ echo 'selected'; } ?>>End of Days</option>
								</select>
								<?php if (!empty($categoryError)): ?>
								<span class="help-inline"><?php echo $categoryError; ?></span>
								<?php endif;?>
							</div>
						</div>
						
						<?php
							if ($type == 'archive')
							{
						?>
						
						<div class="control-group <?php echo !empty($quickFactsError) ? 'error' : '';?>">
							<label class="control-label">Quick Facts</label>
							<div class="controls">
								<textarea name="quickFacts" rows="10" class="MCEcontent" value="<?php echo !empty($quickFacts) ? $quickFacts : '';?>"></textarea>
								<?php if (!empty($quickFactsError)): ?>
								<span class="help-inline"><?php echo $quickFactsError; ?></span>
								<?php endif;?>
							</div>
						</div>
						
						<?php
							}
						?>
						
						<div class="control-group <?php echo !empty($contentError) ? 'error' : '';?>">
							<label class="control-label">Article Content</label>
							<div class="controls">
								<textarea class="MCEcontent" name="content" rows="10" value="<?php echo !empty($content) ? $content : '';?>"></textarea>
								<?php if (!empty($contentError)): ?>
								<span class="help-inline"><?php echo $contentError; ?></span>
								<?php endif;?>
							</div>
						</div>
						
						<div class="control-group">
							<input type="submit" name="create" class="btn btn-success" value="Create">
							<?php echo'<a class="btn" href="index.php?page=crud&type='.$type.'">Back</a>';?>
						</div>
					</form>
				</div>
				
				<?php
				}
				else
				{
				?>
				
				<div class="alert alert-danger">
					<h3>I'm not sure you're meant to be here! Please return to the homepage <a href="index.php">here</a></h3>
				</div>
				
				<?php
				}
				?>

			</div> <!-- /container -->
		</body>
	</html>
<?php
	}
?>