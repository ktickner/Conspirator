<?php
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}

	if ( null==$id ) {
		header("Location: index.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM article where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link   href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script>
	</head>

	<body>
		<div class="container">

			<div class="span10 offset1">
				<div class="row">
					<h3>Article ID: <?php echo $data['id'] ?></h3>
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
						<label class="control-label">Feature Image:</label>
						<div class="controls">
							<label class="checkbox">
							<?php echo $data['image'];?>
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Article Content:</label>
						<div class="controls">
							<label class="checkbox">
							<?php echo $data['content'];?>
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Date Created:</label>
						<div class="controls">
							<label class="checkbox">
							<?php echo $data['date_created'];?>
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Article Author:</label>
						<div class="controls">
							<label class="checkbox">
							<?php echo $data['author_id'];?>
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Category:</label>
						<div class="controls">
							<label class="checkbox">
							<?php echo $data['category_id'];?>
							</label>
						</div>
					</div>
					<div class="form-actions">
						<a class="btn" href="index.php?page=crud?type=<?php$type?>">Back</a>
					</div>

					

				</div>
			</div>

		</div> <!-- /container -->
	</body>
</html>