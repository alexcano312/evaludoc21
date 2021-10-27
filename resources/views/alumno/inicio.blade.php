@extends("alumno.layout.main")

@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
@endsection


@section("titulo")
<title>Inicio | Alumno</title>
@endsection

@section("titulo-pagina")

@endsection

@section("contenido")
<div class="content-wrap">
				<div class="container clearfix">
					<div class="row grid-container" data-layout="masonry" style="overflow: visible">
						<div class="col-lg-4 mb-4"></div>
						@if($alumno->evaluacion == 0 && $alumno->grupoactual() && $evaluacion)
						<div class="col-lg-4 mb-4">
							<div class="flip-card text-center">
								<div class="flip-card-front dark" data-height-xl="505" style="background-image: url('/images/generales/evaluacion.png');">
									<div class="flip-card-inner">
										<div class="card nobg noborder text-center">
											<div class="card-body">
												<i class="icon-line2-briefcase h1"></i>
												<h3 class="card-title">Evaluación Disponible</h3>
												<p class="card-text t400">Evaluación Docente disponible para contestar.</p>
											</div>
										</div>
									</div>
								</div>
								<div class="flip-card-back" data-height-xl="505" style="background-image: url('/images/generales/evaluacion_2.png');">
									<div class="flip-card-inner">
										<p class="mb-2 text-white">Es importante que contestes de forma honesta cada una de las preguntas.</p>
										<a href="{{route('alumno.contestar.evaluacion',['slug'=>$evaluacion->slug])}}" class="btn btn-outline-light mt-2">Contestar</a>
									</div>
								</div>
							</div>
						</div>
						@endif
						@if($alumno->evaluacion == 1 && $alumno->grupoactual() && $evaluacion)
						<div class="col-lg-4 mb-4">
							<div class="flip-card text-center">
								<div class="flip-card-front dark" data-height-xl="505" style="background-image: url('/images/generales/codigos.png');">
									<div class="flip-card-inner">
										<div class="card nobg noborder text-center">
											<div class="card-body">
												<i class="icon-qrcode1 h1"></i>
												<h3 class="card-title">Código de Evaluación</h3>
												<p class="card-text t400">Aquí puedes volver a generar tu código de evaluación concluida.</p>
											</div>
										</div>
									</div>
								</div>
								<div class="flip-card-back" data-height-xl="505" style="background-image: url('/images/generales/codigos_2.png');">
									<div class="flip-card-inner">
										<p class="mb-2 text-white">Recuerda que solo es posible volver a generar el código si concluiste la evaluación.</p>
										<a href="{{route('alumno.codigo.evaluacion',["slug" => $evaluacion->slug,"correo" => 1])}}" class="btn btn-outline-light mt-2">Ver Código</a>
									</div>
								</div>
							</div>
						</div>
						@endif
					</div>				
				</div>
			</div>
@endsection

@section("js")
@endsection