<?php
    require 'database.php';
    $id = 0;
    $type = (isset($_GET['type']) ? $_GET['type'] : null);
	 
	 
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( !empty($_POST)) {
        // keep track post values
        $id = $_POST['id'];
         
        // delete data
		
		if($type == 'article')
		{
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM article  WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
        header("Location: index.php?page=crud&type=article");         
		}
		
		elseif($type == 'archive')
		{
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM archive  WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
        header("Location: index.php?page=crud&type=archive");         
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
		 
			<div class="span10 offset1">
			
			<?php
				if ($type == 'article')
				{
			?>
				<div class="row">
					<h3>Delete an Article</h3>
				</div>
			<?php
				}
				elseif ($type == 'archive')
				{
			?>	
				
				<div class="row">
					<h3>Delete an Archive</h3>
				</div>
				
			<?php
				}

				echo '<form class="form-horizontal" action="index.php?page=delete&type='.$type.'" method="post">';
			?>
			
				<input type="hidden" name="id" value="<?php echo $id;?>"/>
				<p class="alert alert-error">Are you sure you want to delete ?</p>
				<div class="form-actions">
					<button type="submit" class="btn btn-danger">Yes</button>
					
					<?php
						echo '<a class="btn" href="index.php?page=crud&type='.$type.'">No</a>';
					?>
					
				</div>
			</form>
		</div>

		</div> <!-- /container -->
	</body>
</html>