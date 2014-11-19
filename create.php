<?php
     
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $imageError = null;
        $contentError = null;
        $dateError = null;
        $authorError = null;
        $categoryError = null;
        $isArchiveError = null;
        $quickFactsError = null;
         
        // keep track post values
        $name = $_POST['name'];
        $image = $_POST['image'];
        $content = $_POST['content'];
        $date = $_POST['date'];
        $author = $_POST['author'];
        $category = $_POST['category'];
        $isArchive = $_POST['isArchive'];
        $quickFacts = (isset($_POST['quickFacts']) ? $_POST['quickFacts'] : null;
         
		 //up to editing validations
		 
		 
        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }
         
        if (empty($email)) {
            $emailError = 'Please enter Email Address';
            $valid = false;
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $emailError = 'Please enter a valid Email Address';
            $valid = false;
        }
         
        if (empty($mobile)) {
            $mobileError = 'Please enter Mobile Number';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$email,$mobile));
            Database::disconnect();
            header("Location: index.php");
        }
    }
	
	$type = (isset($_GET['type']) ? $_GET['type'] : null);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link   href="styles/bootstrap.css" rel="stylesheet">
		<script src="js/bootstrap.js"></script>
	</head>

	<body>
		<div class="container">
			<?php
				if ($type == 'article' || $type == 'archive')
				{
				
					if($type == 'archive')
					{
			?>

			<div class="col-md-10 center-block">
				<div class="row">
					<h3>Write an Archive</h3>
				</div>

			<?php
					}
					else
					{
			?>
			
			<div class="col-md-10 center-block">
				<div class="row">
					<h3>Write an Article</h3>
				</div>
				
			<?php
					}
			?>
				
				<form class="form-horizontal" action="create.php" method="post">
					<div class="control-group <?php echo !empty($nameError)?'error':'';?>">
						<label class="control-label">Name</label>
						<div class="controls">
							<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
							<?php if (!empty($nameError)): ?>
							<span class="help-inline"><?php echo $nameError;?></span>
							<?php endif; ?>
						</div>
					</div>
					<div class="control-group <?php echo !empty($emailError)?'error':'';?>">
						<label class="control-label">Email Address</label>
						<div class="controls">
							<input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
							<?php if (!empty($emailError)): ?>
							<span class="help-inline"><?php echo $emailError;?></span>
							<?php endif;?>
						</div>
					</div>
					<div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
						<label class="control-label">Mobile Number</label>
						<div class="controls">
							<input name="mobile" type="text"  placeholder="Mobile Number" value="<?php echo !empty($mobile)?$mobile:'';?>">
							<?php if (!empty($mobileError)): ?>
							<span class="help-inline"><?php echo $mobileError;?></span>
							<?php endif;?>
						</div>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn btn-success">Create</button>
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
				<h3>I'm not sure you're meant to be here! PLease return to the homepage <a href="index.php">here</a></h3>
			</div>
			
			<?php
			}
			?>

		</div> <!-- /container -->
	</body>
</html>