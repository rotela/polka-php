<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>prueba jquery</title>
    <link href="<?= vista_css('style.css'); ?>" rel="stylesheet" >
</head>
<body>
	<section>
		<a href="#" id="anterior">&laquo;</a>
		<div id="marco">
			<ul>
				<li><img src="<?= base_url('aplicacion/vistas/imagenes/1.jpg') ?>" alt="1">1</li>
				<li><img src="<?= base_url('aplicacion/vistas/imagenes/2.jpg') ?>" alt="2">2</li>
				<li><img src="<?= base_url('aplicacion/vistas/imagenes/3.jpg') ?>" alt="3">3</li>
				<li><img src="<?= base_url('aplicacion/vistas/imagenes/4.jpg') ?>" alt="4">4</li>
				<li><img src="<?= base_url('aplicacion/vistas/imagenes/5.jpg') ?>" alt="5">5</li>
			</ul>
		</div>
		<a href="#" id="siguiente">&raquo;</a>
	</section>
	<footer>
	</footer>
	<script type="text/javascript" src="<?= vista_jq(); ?>" charset="utf-8"></script>
	<script type="text/javascript" src="<?= vista_js('marquesina.jquery.js'); ?>" charset="utf-8"></script>
	<script>
	$("#marco").marquesina();
	</script>
</body>
</html>