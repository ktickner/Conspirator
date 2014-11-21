<?php
     
    require 'database.php';
	
	//getting page "type" from url to distinguish between archive and article
	$type = (isset($_GET['type']) ? $_GET['type'] : null);
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $imageError = null;
        $contentError = null;
        $dateError = null;
        $authorError = null;
        $categoryError = null;
		
		
		//adding in quickfacts vars in case of archive
		if ($type == 'archive')
		{
        $quickFactsError = null;
        $quickFacts = $_POST['quickFacts'];
		}
		
        // keep track post values
        $name = $_POST['name'];
        $image = $_POST['image'];
        $content = $_POST['content'];
        $date = $_POST['date'];
        $author = $_POST['author'];
        $category = $_POST['category'];
		 
		 
        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter the '.$type.'\'s name';
            $valid = false;
        }
         
        if (empty($image)) {
            $imageError = 'Please upload a feature image';
            $valid = false;
        }
         
        if (empty($content)) {
            $contentError = 'Please enter some content';
            $valid = false;
        }
         
        if (empty($category)) {
            $categoryError = 'Please choose a category';
            $valid = false;
        }
        
		if ($type == 'archive')
		{
			if (empty($quickfacts)) {
				$quickfactsError = 'Please enter the archive\'s quick facts';
				$valid = false;
			}
		}
         
        // insert data
        if ($valid) {
			if ($type == 'archive')
			{
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO archive (archive_name,image,content,date_created,author_id,category_id,quick_facts) values(?, ?, ?, ?, ?, ?, ?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($name,$email,$mobile));
				Database::disconnect();
				header("Location: index.php?page=crud&type=article");
			}
			elseif ($type == 'article')
			{
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO article (article_name,image,content,date_created,author_id,category_id) values(?, ?, ?, ?, ?, ?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($name,$email,$mobile));
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
				<h3>I'm not sure you're meant to be here! Please return to the homepage <a href="index.php">here</a></h3>
			</div>
			
			<?php
			}
			?>

		</div> <!-- /container -->
	</body>
</html>