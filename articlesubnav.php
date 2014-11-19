<!--Banner Ad-->
<div class="container">
	<div class="row">
		<div class="center-block text-center">
			Banner Ad
		</div>
		<!--Sort by Filters; Date & Name-->
		<div class="dropdown pull-right">
			<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
				Filter<span class="caret"></span>
			</button>
			
			<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
				<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Newest-Oldest</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Oldest-Newest</a></li>
			</ul>
		</div> 
		<!--End of Filters-->
	</div> 
</div>
<!--End of Banner Ad-->




<!--Carousel-->
<div class="container"> 
	<div class="row">
		<div id="carousel-example-generic myCarousel" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				<li data-target="#carousel-example-generic" data-slide-to="1"></li>
				<li data-target="#carousel-example-generic" data-slide-to="2"></li>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<div class="row">
						<div class="col-md-3">
							<img src="images/Aliens.png" alt="...">
							<div class="carousel-caption">
								hello?
							</div>
						</div>

						<div class="col-md-3">
							<img src="images/Aliens.png" alt="...">
							<div class="carousel-caption">
								hello?
							</div>
						</div>

						<div class="col-md-3">
							<img src="images/Aliens.png" alt="...">
							<div class="carousel-caption">
								hello?
							</div>
						</div>
					</div>
				</div>
				<div class="item">
					<img src="images/Aliens.png" alt="..." />
					<div class="carousel-caption">
						...
					</div>
				</div>
			</div>

			<!-- Controls -->
			<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>

	<div class="row carouselOuter">
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				<li data-target="#carousel-example-generic" data-slide-to="1"></li>
				<li data-target="#carousel-example-generic" data-slide-to="2"></li>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<div class="row">
						<div class="col-md-3">
							<img src="images/ally.jpg" alt="...">
							<div class="carousel-caption">
								hello?
							</div>
						</div>

						<div class="col-md-3">
							<img src="images/ally.jpg" alt="...">
							<div class="carousel-caption">
								hello?
							</div>
						</div>

						<div class="col-md-3">
							<img src="images/ally.jpg" alt="...">
							<div class="carousel-caption">
								hello?
							</div>
						</div>
					</div>
				</div>

				<div class="item">
					<img src="images/Aliens.png" alt="...">
					<div class="carousel-caption">
						...
					</div>
				</div>
			</div>

			<!-- Controls -->
			<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>
</div> 

<script type="text/javascript">
	$(document).ready(function() {
	$('.carousel').carousel();
	});
</script>
<!--End of Carousel--> 