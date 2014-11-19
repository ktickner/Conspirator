<?php
	include 'database.php';
	$pdo = Database::connect();
	$type = (isset($_GET['type']) ? $_GET['type'] : null);
	if ($type == null)
	{
		$sql = null;
	}
	elseif ($type == "archive")
	{
	$sql = 'SELECT * FROM article WHERE is_archive=1 ORDER BY id DESC';
	}
	elseif ($type == "article")
	{
	$sql = 'SELECT * FROM article WHERE is_archive=0 ORDER BY id DESC';
	}
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link   href="styles/bootstrap.css" rel="stylesheet">
		<script src="js/bootstrap.js"></script>
		<title></title>
	</head>

	<body>
		<div class="container">
			<div class="row">
				<h3>The Conspirator CRUD Grid</h3>
			</div>
			<div class="row">
				<p>
				<?php
					echo'<a href="index.php?page=create&type='.$type.'" class="btn btn-success">Create</a>';
				?>
				</p>
				
				<?php
					if ($sql == null)
					{
				?>
				
				<div class="alert alert-warning">
					<h3>There's nothing here</h3>
				</div>
				
				<?php
					}
					
					else
					{
				?>
				
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Date Created</th>
							<th>Category</th>
						</tr>
					</thead>
					<tbody>
					
				<?php	
							foreach ($pdo->query($sql) as $row) {
								echo '<tr>';
								echo '<td>'. $row['id'] . '</td>';
								echo '<td>'. $row['article_name'] . '</td>';
								echo '<td>'. $row['date_created'] . '</td>';
								echo '<td>'. $row['category_id'] . '</td>';
								echo '<td width=250>';
								echo '<a class="btn" href="index.php?page=read&type='.$type.'&id='.$row['id'].'">Read</a>';
								echo ' ';
								echo '<a class="btn" href="index.php?page=update&type='.$type.'&id='.$row['id'].'">Update</a>';
								echo ' ';
								echo '<a class="btn" href="index.php?page=delete&type='.$type.'&id='.$row['id'].'">Delete</a>';
								echo '</td>';
								echo '</tr>';
							}
						}
						Database::disconnect();
				?>
					
					</tbody>
				</table>
			</div>
		</div> <!-- /container -->
	</body>
</html>