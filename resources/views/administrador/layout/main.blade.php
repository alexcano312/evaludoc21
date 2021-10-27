<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<!--Color FA7527-->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="Emmanuel Torres" content="Emmanuel Torres" />

	<!-- Stylesheets
	============================================= -->
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Raleway:300,400,500,600,700|Crete+Round:400i" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="/css/style.css" type="text/css" />
	<link rel="stylesheet" href="/css/dark.css" type="text/css" />
	<link rel="stylesheet" href="/css/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="/css/animate.css" type="text/css" />
	<link rel="stylesheet" href="/css/magnific-popup.css" type="text/css" />

	<link rel="stylesheet" href="/css/responsive.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="/images/logo_original.png" />
	<title>
		@yield("titulohead")
	</title>
@yield("css")
	<!-- Document Title
	============================================= -->



</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Header
		============================================= -->
		<header id="header" >

			<div id="header-wrap" >

				<div class="container clearfix">

					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

					<!-- Logo
					============================================= -->
					<div id="logo">
						<a href="{{route("administrador.inicio")}}" class="standard-logo" data-dark-logo="/images/logo-dark.png"><img src="/images/logo.png" alt="Canvas Logo"></a>
						<a href="{{route("administrador.inicio")}}" class="retina-logo" data-dark-logo="/images/logo-dark@2x.png"><img src="/images/logo@2x.png" alt="Canvas Logo"></a>
					</div><!-- #logo end -->

					<!-- Primary Navigation
					============================================= -->
					<nav id="primary-menu" class="style-2">
						<ul>
							@if(Session::has('administrador'))
								<li class="current"><a href="/administrador/inicio"><div>Inicio</div></a></li>
								<li><a href="{{route("administrador.alumnos")}}"><div>Alumnos</div></a></li>
								<li><a href="{{route("administrador.grupos")}}"><div>Grupos</div></a></li>
								<li class="sub-menu"><a href="#" class="sf-with-ul"><div>Asignaciones</div></a>
									<ul style="display: none;">
										<li><a href="{{route("administrador.alumnos.actividades")}}"><div>Actividades a Alumnos</div></a></li>
										<li><a href="#"><div>Alumnos a Grupo</div></a></li>
										<li><a href="{{route("administrador.inscripciones.grupos.materias")}}"><div>Evaluados a Grupos</div></a></li>
										<li><a href="{{route('administrador.inscripciones.materias')}}"><div>Materias a Carreras</div></a></li>
										<li><a href="#"><div>Recursadores a Materia</div></a></li>
										<li><a href="{{route("administrador.inscripciones.grupos.tutores")}}"><div>Tutores a Grupos</div></a></li>
									</ul>
								</li>
								<li class="sub-menu"><a href="#" class="sf-with-ul"><div>Evaluaciones</div></a>
									<ul style="display: none;">
										<li class="sub-menu"><a href="#" class="sf-with-ul"><div>Cuestionario</div></a>
											<ul class="menu-pos-invert" style="display: none;">
												<li><a href="{{route('administrador.preguntas')}}"><div>Preguntas</div></a></li>
												<li><a href="{{route('administrador.temas')}}"><div>Temas</div></a></li>
											</ul>
										</li>
										<li class="sub-menu"><a href="#" class="sf-with-ul"><div>Respuestas</div></a>
											<ul class="menu-pos-invert" style="display: none;">
												<li><a href="#"><div>Respuestas Actividades Extracurriculares</div></a></li>
												<li><a href="#"><div>Respuestas Materias</div></a></li>
												<li><a href="#"><div>Respuestas Tutores</div></a></li>
											</ul>
										</li>
										<li class="sub-menu"><a href="#" class="sf-with-ul"><div>Comentarios</div></a>
											<ul class="menu-pos-invert" style="display: none;">
												<li><a href="#"><div>Comentarios Actividades Extracurriculares</div></a></li>
												<li><a href="#"><div>Comentarios Materias</div></a></li>
												<li><a href="#"><div>Comentarios Tutores</div></a></li>
											</ul>
										</li>
									</ul>
								</li>
								<li class="sub-menu"><a href="#" class="sf-with-ul"><div>Otros</div></a>
									<ul style="display: none;">
										<li><a href="{{route("administrador.actividades")}}"><div>Actividades Extracurriculares</div></a></li>
										<li><a href="{{route("administrador.areas")}}"><div>Areas</div></a></li>
										<li><a href="{{route("administrador.carreras")}}"><div>Carreras</div></a></li>
										<li><a href="{{route("administrador.cuatrimestres")}}"><div>Cuatrimestres</div></a></li>
										<li><a href="{{route("administrador.generaciones")}}"><div>Generaciones</div></a></li>
										<li><a href="{{route("administrador.materias")}}"><div>Materias</div></a></li>
										<li><a href="{{route("administrador.personal")}}"><div>Personas</div></a></li>
										<li><a href="{{route("administrador.planes")}}"><div>Planes de estudio</div></a></li>
										<li><a href="#"><div>Movimientos de directivos</div></a></li>
										<li class="sub-menu"><a href="#" class="sf-with-ul"><div>Personal</div></a>
											<ul class="menu-pos-invert" style="display: none;">
												<li><a href="{{route("administrador.directivos")}}"><div>Directivos</div></a></li>
												<li><a href="{{route("administrador.evaluados")}}"><div>Evaluados</div></a></li>
												<li><a href="{{route("administrador.entrenadores")}}"><div>Entrenadores</div></a></li>
												<li><a href="{{route("administrador.tutores")}}"><div>Tutores</div></a></li>
											</ul>
										</li>
										<li><a href="{{route("administrador.evaluados.tipos")}}"><div>Tipo de Evaluados</div></a></li>
										<li><a href="{{route("administrador.configuraciones")}}"><div>Configuraciones</div></a></li>
									</ul>
								</li>
								<li ><a href="{{route("administrador.cerrar.sesion")}}"><div>Cerrar Sesión</div></a></li>
							@else
								<li><a href="{{route("administrador.login")}}"><div>Iniciar Sesion</div></a></li>x
							@endif
						</ul>
						<!-- Top Search
						============================================= -->
						<div id="top-search">
							<a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
							<form action="search.html" method="get">
								<input type="text" name="q" class="form-control" value="" placeholder="Escribe y preciona entrar...">
							</form>
						</div><!-- #top-search end -->
					</nav><!-- #primary-menu end -->
				</div>
			</div>
		</header>
		<!-- #header end -->
		<section id="page-title">

			<div class="container clearfix">
				<h1 style="color: #FA7527" class="texto-naranja">
					@yield("titulo-pagina")
				</h1>
				<br>
				<span>@yield("subtitulo")Administrador</span>
				<ol class="breadcrumb">
					@yield("url")
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Widgets</a></li>
					<li class="breadcrumb-item active" aria-current="page">Real Estate Enquiry Form</li>
				</ol>
			</div>

		</section>

		<!-- Content
		============================================= -->
		<section id="content">
			@yield("contenido")
		</section><!-- #content end -->

		<!-- Footer
		============================================= -->
		<footer id="footer" class="dark">
			<!-- Copyrights
			============================================= -->
			<div id="copyrights" style="background-color: #A1B1A7; color: #0b0b0b">

				<div class="container clearfix">

					<div class="col_half">
						Copyrights &copy; 2018 All Rights Reserved by Andocodeando Inc.<br>
						<div class="copyright-links"><a href="#" style="color: #0b0b0b;">Terminos y condiciones</a> / <a href="#" style="color: #0b0b0b;">Politica de privacidad</a></div>
					</div>

					<div class="col_half col_last tright">
						<div class="fright clearfix">
							<a href="#" class="social-icon si-small si-borderless si-facebook">
								<i class="icon-facebook"></i>
								<i class="icon-facebook"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-twitter">
								<i class="icon-twitter"></i>
								<i class="icon-twitter"></i>
							</a>
						</div>

						<div class="clear"></div>

						<i class="icon-phone"></i> 01(55) 59388670<br>
						<i class="icon-envelope2"></i> control_escolar@uptecamac.edu.mx

					</div>

				</div>

			</div><!-- #copyrights end -->

		</footer><!-- #footer end -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- External JavaScripts
	============================================= -->
	<script src="/js/jquery.js"></script>
	<script src="/js/plugins.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script src="/js/functions.js"></script>
	@yield("js")
</body>
</html>