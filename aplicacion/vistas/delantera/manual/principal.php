<div class="jumbotron">
	<div class="container">
		<h1><?= pk_titulo(); ?> <span class="label label-default"><?= pk_version(); ?></span></h1>
		<hr>
		<a class="btn btn-primary btn-lg" href="https://github.com/joeblack0/polka-php">descargar</a>
	</div>
</div>
<div class="row">
	<div class="col-md-8 col-md-offset-2">

		<div id="carousel-example-generic" class="carousel slide">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
			<li data-target="#carousel-example-generic" data-slide-to="2"></li>
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner">

			<div class="item active">
			  <img src="<?= vista_img('carrusel01.jpg'); ?>" alt="item">
			  <div class="carousel-caption">
				<p>Item 1</p>
			  </div>
			</div>

			<div class="item">
			  <img src="<?= vista_img('carrusel02.jpg'); ?>" alt="item">
			  <div class="carousel-caption">
				<p>Item 2</p>
			  </div>
			</div>

			<div class="item">
			  <img src="<?= vista_img('carrusel03.jpg'); ?>" alt="item">
			  <div class="carousel-caption">
				<p>Item 3</p>
			  </div>
			</div>

		  </div>
			  <!-- Controls -->
			  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
				<span class="icon-prev"></span>
			  </a>
			  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
				<span class="icon-next"></span>
			  </a>
		</div>
	</div>

</div>