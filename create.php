<?php

	if(!isset($_SESSION['user']))
	{
		header("Location: index.php");
	}
	
    require 'database.php';
		
	$name = null;
	$image = null;
	$content = null;
	$date = null;
	$author = null;
	$category = null;
	
	//getting page "type" from url to distinguish between archive and article
	$type = (isset($_GET['type']) ? $_GET['type'] : null);
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $imageError = null;
        $contentError = null;
        $categoryError = null;
		
		
		//including image upload scripts
		
		require 'imageupload.php';
		
		
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
        }
         
        if (empty($image)) {
            $imageError = 'Please upload a feature image';
            $valid = false;
        }
		
		
		//need to set up image errors
         
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
			if (empty($quickFacts)) {
				$quickFactsError = 'Please enter the archive\'s quick facts';
				$valid = false;
			}
		}
         
        // insert data
        if ($valid) {
			//setting non-user input vars
			$date = date("Y/m/d");
			$author = $_SESSION['user'];
			$author = filter_var($author, FILTER_SANITIZE_INT);
		
			if ($type == 'archive')
			{
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO archive (archive_name,image,content,date_created,author_id,category_id,quick_facts) values(?, ?, ?, ?, ?, ?, ?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($name,$image,$content,$date,$author,$category,$quickFacts));
				Database::disconnect();
				header("Location: index.php?page=crud&type=article");
			}
			elseif ($type == 'article')
			{
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO article (article_name,image,content,date_created,author_id,category_id) values(?, ?, ?, ?, ?, ?)";
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
					
					<?php
						if ($type == 'archive')
						{
					?>
					
					<div class="control-group <?php echo !empty($quickFactsError) ? 'error' : '';?>">
						<label class="control-label">Quick Facts</label>
						<div class="controls">
							<input name="content" type="text"  placeholder="Placeholder for quick facts input" value="<?php echo !empty($quickFacts) ? $quickFacts : '';?>" required />
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
							<textarea name="content" value="<?php echo !empty($content) ? $content : '';?>" required></textarea>
							<?php if (!empty($contentError)): ?>
							<span class="help-inline"><?php echo $contentError; ?></span>
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
					
					<div class="control-group">
						<input type="submit" class="btn btn-success" value="Create"/>
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