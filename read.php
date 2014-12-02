<?php
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}

	if ( null==$id ) 
	{
		header("Location: index.php");
	} 
	else 
	{
		if ($type == 'article')
		{
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM article WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			Database::disconnect();
		}
		elseif ($type == 'archive')
		{
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM archive WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			Database::disconnect();
		}
		else
		{
			header("Location: index.php");
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
				<div class="row">
					<h3>Read an Article</h3>
				</div>

				<div class="form-horizontal" >
					<div class="control-group">
						<label class="control-label">Article Name</label>
						<div class="controls">
							<label class="checkbox">
							<?php echo $data['name'];?>
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Feature Image</label>
						<div class="controls">
							<label class="checkbox">
							<?php echo $data['image'];?>
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Author</label>
						<div class="controls">
							<label class="checkbox">
							<?php echo $data['author'];?>
							</label>
						</div>
					</div>
					<div class="form-actions">
						<a class="btn" href="index.php">Back</a>
					</div>


				</div>
			</div>

		</div> <!-- /container -->
	</body>
</html>