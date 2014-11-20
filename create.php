<?php
     
    require 'database.php';
	
	$type = (isset($_GET['type']) ? $_GET['type'] : null);
 
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
            $nameError = 'Please enter the Article name';
            $valid = false;
        }
         
        if (empty($image)) {
            $emailError = 'Please enter feature image';
            $valid = false;
		}
         
        if (empty($content)) {
            $mobileError = 'Please enter some content';
            $valid = false;
        }
         
        if (empty($category)) {
            $mobileError = 'Please select a Category';
            $valid = false;
        }
        
		if	($type == 'archive')
		{
			if (empty($quickFacts)) {
				$mobileError = 'Please enter some quick facts';
				$valid = false;
			}
		}
         
		 
		if ($type == 'article')
		{
			// insert data
			if ($valid) {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO customers (article_name,image,content,date_created,author_id,category_id,is_archive) values(?, ?, ?, ?, ?, ?, ?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($name,$image,$content,$date,$author,$category,$isArchive));
				Database::disconnect();
				header("Location: index.php?page=crud&type=".$type);
			}
		}
		elseif ($type == 'archive')
		{
			// insert data
			if ($valid) {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//sigh confusing
				$sql = "INSERT INTO customers (article_name,image,content,date_created,author_id,category_id,is_archive) 
							values(?, ?, ?, ?, ?, ?, ?);
						INSERT INTO archive_facts ()";
				$q = $pdo->prepare($sql);
				$q->execute(array($name,$image,$content,$date,$author,$category,$isArchive));
				Database::disconnect();
				header("Location: index.php?page=crud&type=".$type);
			}
		}
    }
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