@extends("directivo.layout.main")
@section("titulohead")
	Evaluación {{$evaluacion->nombre}} | Directivo
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
@endsection

@section("titulo-pagina")
		Evaluación {{$evaluacion->nombre}}
@endsection
@section("url")
	<li class="breadcrumb-item"><a href="{{route("directivo.inicio")}}">Inicio</a></li>
	<li class="breadcrumb-item"><a href="{{route("directivo.evaluaciones")}}">evaluaciones</a></li>
	<li class="breadcrumb-item"><a href="#">{{$evaluacion->nombre}}</a></li>
@endsection


@section("contenido")

	<div class="content-wrap">
		<div class="container clearfix">

			<!-- INFORMACIÓN GENERAL -->
			<div class="row">
				<div class="col-lg-11 offset-lg-1">

					@foreach($errors->get("generales") as $error)
						<span class="text-danger">
							{{$error}}
						</span>
					@endforeach

					<h3 class="texto-naranja">
						Información General
						@if (session('success'))
							<div class="style-msg successmsg">
								<div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Well done!</strong> You successfully read this important alert message.</div>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							</div>
						@endif
					</h3>

					<form method="post"">
					{{csrf_field()}}
					<div class="form-row">
						<div class="col-lg-6 form-group">
							<input name="id" value="{{$evaluacion->id}}" type="hidden">
							<div class="form-group">
								<label>Nombre:</label>
								<input type="text" class="form-control" value="{{$evaluacion->nombre}}" name="nombre" readonly>
							</div>

							<div class="form-group">
								<label>Fecha Inicio</label>
								<input type="text" class="form-control" value="{{$evaluacion->fecha_inicio}}"  readonly>
							</div>

							<diV class="form-group">
								<label>Estatus</label>
								<input type="text" class="form-control" value="@if($evaluacion->estatus == 1)Activa @else Inactiva @endif" readonly>
							</diV>

							<div class="form-group">
								<label>Alumnos con evaluación</label>
								<input type="text" class="form-control" value="{{count($inscripcionesConEvaluacion)}}"  readonly>
							</div>
						</div>
						<div class="col-lg-6 form-group">
							<div class="form-group">
								<label>Clave</label>
								<input type="text" class="form-control" value="{{$evaluacion->slug}}"  readonly>
							</div>
							<div class="form-group">
								<label>Fecha Termino</label>
								<input type="text" class="form-control" value="{{$evaluacion->fecha_termino}}"  readonly>
							</div>
							<div class="form-group">
								<label>Alumnos totales en evaluación</label>
								<input type="text" class="form-control" value="{{count($inscripcionesConEvaluacion) + count($inscripcionesSinEvaluacion)}}"  readonly>
							</div>
							<div class="form-group">
								<label>Alumnos sin evaluación</label>
								<input type="text" class="form-control" value="{{count($inscripcionesSinEvaluacion)}}"  readonly>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="line"></div>
		</div>
	</div>
@endsection

@section("js")

@endsection