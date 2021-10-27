<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<!-- Stylesheets
	============================================= -->

	<meta name="viewport" content="width=device-width, initial-scale=1" />

<!-- Document Title
	============================================= -->



</head>

<body class="stretched">

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

	<!-- Header
    ============================================= -->
	<header id="header">

		<div id="header-wrap">

			<div class="container clearfix">

				<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
				<!-- Logo
                ============================================= -->
				<center>
				<div id="logo">
					<a href="" class="retina-logo" data-dark-logo="images/logo-dark@2x.png"><img src="images/logo@2x.png" alt="Upt Logo"></a>
				</div><!-- #logo end -->
				</center>

			</div>
		</div>
	</header>
	<!-- #header end -->

	<center>
			<h1>Evaluación</h1>
			<h3>{{$evaluacion->nombre}}</h3>
			<h4>{{Session::get("alumno")->nombre}} {{Session::get("alumno")->apellidos}}</h4>
			<h5>{{$codigo->created_at}}</h5>
			<br><br><br>
			<img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(250)->generate('http://189.254.6.230/upt/eva_doc/valida/'.$codigo->contructrorCodigo)) }} ">
			<b><u><h4 style="letter-spacing: 4px;">{{$codigo->codigo}}</h4></u></b>
	</center>

	<center>
		<img src="images/logos_carreras.png" style="width: 85%; height: 50%;">
	</center>
	<h4>Prolongación 5 de Mayo #10, Colonia Felipe Villanueva, Centro Tecámac, CP 55740, Estado de México</h4>



	<!-- Content
    ============================================= -->

</div><!-- #wrapper end -->


</body>
</html>