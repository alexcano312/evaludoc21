@extends("directivo.layout.main")
@section("titulohead")
	Inicio | Directivo
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->

@endsection

@section("titulo-pagina")
	
@endsection

@section("contenido")
	<div class="content-wrap">
		<div class="container clearfix">
			<div class="row grid-container" data-layout="masonry" style="overflow: visible">

				<div class="col-lg-4 mb-4">
					<div class="flip-card text-center">
						<div class="flip-card-front dark" style="background-image: url('/images/inicio/alumnos.png')">
							<div class="flip-card-inner">
								<div class="card nobg noborder text-center">
									<div class="card-body">
										<i class="icon-line2-user h1"></i>
										<h3 class="card-title">Alumnos</h3>
										<p class="card-text t400">Registrados.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="flip-card-back" style="background-image: url('/images/inicio/alumnos.png');">
							<div class="flip-card-inner">
								<p class="mb-2 text-white">Información de todos los usuarios.</p>
								<a href="{{route("directivo.alumnos")}}" class="btn btn-outline-light mt-2">Ver detalles</a>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 mb-4">
					<div class="flip-card text-center top-to-bottom">
						<div class="flip-card-front dark" style="background-image: url('/images/inicio/grupos.png')">
							<div class="flip-card-inner">
								<div class="card nobg noborder text-center">
									<div class="card-body">
										<i class="icon-line2-users h1"></i>
										<h3 class="card-title">Grupos</h3>
										<p class="card-text t400"> Registrados.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="flip-card-back" style="background-image: url('/images/inicio/grupos.png');">
							<div class="flip-card-inner">
								<p class="mb-2 text-white">Información de todos los grupos.</p>
								<a href="{{route("directivo.grupos")}}" class="btn btn-outline-light mt-2">Ver detalles</a>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 mb-4">
					<div class="flip-card text-center">
						<div class="flip-card-front dark" data-height-xl="505" style="background-image: url('/images/inicio/resultados.png');">
							<div class="flip-card-inner">
								<div class="card nobg noborder text-center">
									<div class="card-body">
										<i class="icon-line2-check h1"></i>
										<h3 class="card-title">Resultados</h3>
										<p class="card-text t400"> Registrados.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="flip-card-back" data-height-xl="505" style="background-image: url('/images/inicio/resultados.png');">
							<div class="flip-card-inner">
								<p class="mb-2 text-white">Información de todos los resultados de evaluaciones.</p>
								<a href="{{route("directivo.evaluaciones")}}" class="btn btn-outline-light mt-2">Ver detalles</a>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 mb-4">
					<div class="flip-card top-to-bottom">
						<div class="flip-card-front dark" data-height-xl="200" style="background-image: url('/images/inicio/evaluados.png');">
							<div class="flip-card-inner">
								<div class="card nobg noborder">
									<div class="card-body">
										<h3 class="card-title mb-0">Evaluados</h3>
										<span class="font-italic">Registrados.</span>
									</div>
								</div>
							</div>
						</div>
						<div class="flip-card-back" data-height-xl="200" style="background-image: url('/images/inicio/evaluados.png');">
							<div class="flip-card-inner">
								<p class="mb-2 text-white">Información de todos los evaluados.</p>
								<a href="" class="btn btn-outline-light mt-2">Ver detalles</a>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 mb-4">
					<div class="flip-card top-to-bottom">
						<div class="flip-card-front dark" data-height-xl="200" style="background-image: url('/images/inicio/inscripcion-evaluados.png');">
							<div class="flip-card-inner">
								<div class="card nobg noborder">
									<div class="card-body">
										<h3 class="card-title mb-0">Inscripción de evaluados a grupos</h3>
										<span class="font-italic">Registrados.</span>
									</div>
								</div>
							</div>
						</div>
						<div class="flip-card-back" data-height-xl="200" style="background-image: url('/images/inicio/inscripcion-evaluados.png');">
							<div class="flip-card-inner">
								<p class="mb-2 text-white">Información de todos las inscripciones de evaluados.</p>
								<a href="{{route("directivo.grupos.activos")}}" class="btn btn-outline-light mt-2">Ver detalles</a>
							</div>
						</div>
					</div>
				</div>



				<div class="col-lg-4 mb-4">
					<div class="flip-card text-center">
						<div class="flip-card-front dark" data-height-xl="505" style="background-image: url('/images/inicio/tutores.png');">
							<div class="flip-card-inner">
								<div class="card nobg noborder text-center">
									<div class="card-body">
										<i class="icon-line2-user h1"></i>
										<h3 class="card-title">Tutores</h3>
										<p class="card-text t400">Registrados.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="flip-card-back" data-height-xl="505" style="background-image: url('/images/inicio/tutores.png');">
							<div class="flip-card-inner">
								<p class="mb-2 text-white">Información de Tutores</p>
								<a href="{{route("directivo.tutores")}}" class="btn btn-outline-light mt-2">Ver detalles</a>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 mb-4">
					<div class="flip-card text-center">
						<div class="flip-card-front dark" style="background-image: url('/images/inicio/inscripcion-tutores.png')">
							<div class="flip-card-inner">
								<div class="card nobg noborder text-center">
									<div class="card-body">
										<i class="icon-line2-user-follow h1"></i>
										<h3 class="card-title">Inscripción de tutores a grupos</h3>
										<p class="card-text t400">Registrados.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="flip-card-back" style="background-image: url('/images/inicio/inscripcion-tutores.png');">
							<div class="flip-card-inner">
								<p class="mb-2 text-white">Información de todos los tutores en grupos</p>
								<a href="{{route("directivo.inscripciones.grupos.tutores")}}" class="btn btn-outline-light mt-2">Ver detalles</a>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 mb-4">
					<div class="flip-card text-center top-to-bottom">
						<div class="flip-card-front dark" style="background-image: url('/images/inicio/materias.png')">
							<div class="flip-card-inner">
								<div class="card nobg noborder text-center">
									<div class="card-body">
										<i class="icon-line2-doc h1"></i>
										<h3 class="card-title">Materias</h3>
										<p class="card-text t400"> Registradas.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="flip-card-back" style="background-image: url('/images/inicio/materias.png');">
							<div class="flip-card-inner">
								<p class="mb-2 text-white">Información de materias.</p>
								<a href="{{route("directivo.materias")}}" class="btn btn-outline-light mt-2">Ver detalles</a>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 mb-4">
					<div class="flip-card top-to-bottom">
						<div class="flip-card-front dark" data-height-xl="200" style="background-image: url('/images/inicio/registro-materias.png');">
							<div class="flip-card-inner">
								<div class="card nobg noborder">
									<div class="card-body">
										<h3 class="card-title mb-0">Registro de Materias a Carrera</h3>
										<span class="font-italic">Registradas.</span>
									</div>
								</div>
							</div>
						</div>
						<div class="flip-card-back" data-height-xl="200" style="background-image: url('/images/inicio/registro-materias.png');">
							<div class="flip-card-inner">
								<p class="mb-2 text-white">Información de las materias que pertenecen a cada cuatrimestre.</p>
								<a href="{{route("directivo.inscripciones.materias")}}" class="btn btn-outline-light mt-2">Ver detalles</a>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 mb-4">
					<div class="flip-card top-to-bottom">
						<div class="flip-card-front dark" data-height-xl="200" style="background-image: url('/images/inicio/salir.png');">
							<div class="flip-card-inner">
								<div class="card nobg noborder">
									<div class="card-body">
										<h3 class="card-title mb-0">Cerrar Sesion</h3>
										<span class="font-italic">Salir.</span>
									</div>
								</div>
							</div>
						</div>
						<div class="flip-card-back" data-height-xl="200" style="background-image: url('/images/inicio/salir.png');">
							<div class="flip-card-inner">
								<p class="mb-2 text-white">Tendrás que iniciar nuevamente.</p>
								<a href="{{route("directivo.cerrar.sesion")}}" class="btn btn-outline-light mt-2">¡Estoy segur@!</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section("js")

@endsection