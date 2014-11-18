<?php
	$page = (isset($_GET['page']) ? $_GET['page'] : null);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>The Conspirators</title>

		<!-- Bootstrap -->
		<link href="styles/bootstrap.css" rel="stylesheet" type="text/css">
		<link href="styles/main.css" rel="stylesheet" type="text/css">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	
	<body>
	
	<div class="container-fluid">
		<!--Banner-->
		<div class="row">
			<a href="index.php"><img src="images/Colour_Masthead.jpg" class="img-responsive center-block masthead"></a>  
		</div>
		<!--End of Banner-->

		<!--Header-->
		<nav class="nav navbar " role="navigation">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="navLink"><a href="index.php">Home</a></li>
						<li class="navLink"><a href="index.php?page=articlenav">Articles</a></li>
						<li class="navLink"><a href="index.php?page=archivenav">Theory Archive</a></li>
						<li class="navLink"><a href="index.php?page=contact">Contact</a></li>
						<li class="dropdown navLink"> 

								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-search"></span>
									<span class="caret"></span>
								</a>
									<ul class="dropdown-menu" role="menu">
										<form class="navbar-form navbar-left" role="search">
											<div class="input-group form-group">
												<input type="text" class="form-control" placeholder="Search" id="navSearch">
												<span class="input-group-btn">
													<button type="submit" class="btn btn-nav btn-default"><span class="glyphicon glyphicon-search"></span></button>
												</span>
											</div>
										</form>   
									</ul>
									 

							</ul>
						</li>
					</ul>
				

				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav> 
		<!--End of Header-->

		<!-- PLACEHOLDER AREA FOR CONTENT SCRIPTS -->
		<?php
			if ($page != null)
			{
				include("$page.php");
			}
			else
			{
				include("home.html");
			}
		?>
		
		
		
		
		
		<!-- /PLACEHOLDER AREA FOR CONTENT SCRIPTS -->
		
		<!--Footer-->
		<div class="footer">
			<div class="container">
				<div class="col-md-12 hidden-sm hidden-xs">
					<div class="row">
						<img src="Images/Colour_Masthead.jpg" width="200px" class="center-block">
					</div>
					<div class="row">
						<div class="col-md-8 centered">
							<div class="row">
								<div class="col-md-3">
									<ul class="list-unstyled footer-list">
										<li>Home</li>
									</ul>
								</div>
								
								<div class="col-md-3">
									<ul class="list-unstyled footer-list">
										<li>Articles</li>
										<li>History</li>
										<li>Government and Evil Corporations</li>
										<li>Aliens</li>
										<li>Exotic Creatures</li>
										<li>Urban Myths</li>
										<li>End of Days</li>
									</ul>
								</div>
								
								<div class="col-md-3">
									<ul class="list-unstyled footer-list">
										<li>Archives</li>
									</ul>
								</div>
								
								<div class="col-md-3">
									<ul class="list-unstyled footer-list">
										<li>Contact</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--End of Footer-->
		
	</div>


		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
		
	
	</body>
</html> 