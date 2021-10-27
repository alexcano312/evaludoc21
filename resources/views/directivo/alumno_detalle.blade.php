@extends("directivo.layout.main")
@section("titulohead")
	Alumno {{$alumno->nombre}} | Directivo
@endsection
@section("css")
@endsection

@section("titulo-pagina")
		Alumno {{$alumno->nombre}}
@endsection
@section("url")
	<li class="breadcrumb-item"><a href="{{route("directivo.inicio")}}">Inicio</a></li>
	<li class="breadcrumb-item"><a href="{{route("directivo.alumnos")}}">Alumnos</a></li>
	<li class="breadcrumb-item active" aria-current="page">{{$alumno->nombre}} {{$alumno->apellidos}}</li>
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

					<h3 class="texto-naranja">Información General
						@if (session('success'))
							<label class="form-check-label text-success float-right" for="defaultCheck1">
								¡Información guardada!
							</label>
						@endif
					</h3>

						<form method="post" action="{{route("generales.directivo.editar.alumno")}}">
							{{csrf_field()}}
							<input type="hidden" value="{{$alumno->id}}" name="id">
							<div class="form-row">
								<div class="col-lg-6 form-group">
									<label>Nombre:</label>
									<input type="text" class="form-control" name="nombre" value="{{$alumno->nombre}}" autocomplete="off">
								</div>
								<div class="col-lg-6 form-group">
									<label>Apellidos</label>
									<input type="text" class="form-control" name="apellidos" value="{{$alumno->apellidos}}" autocomplete="off">
								</div>
							</div>
							<div class="form-row">
								<div class="col-lg-6 form-group">
									<label>Matricula:</label>
									<input type="text" class="form-control" name="matricula" value="{{$alumno->matricula}}" autocomplete="off">
								</div>
								<div class="col-lg-6 form-group">
									<label>Generación</label>
									<select class="form-control" name="generacion">
										@foreach($generaciones as $generacion)
											<option value="{{$generacion->id}}" @if($alumno->generacion_id == $generacion->id) selected @endif>{{$generacion->nombre}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-row">

								<div class="col-lg-6 form-group">
									<label>Sexo:</label>
									<select class="form-control" name="sexo">
										@if($alumno->sexo == 1)
											<option value="1" selected>Masculino</option>
											<option value="0">Femenino</option>
										@else
											<option value="1">Masculino</option>
											<option value="0" selected>Femenino</option>
										@endif
									</select>
								</div>

								<div class="col-lg-6 form-group">
									<label>Carrera:</label>
									<select class="form-control" name="carrera">
										@foreach($carreras as $carrera)
											<option value="{{$carrera->id}}" @if($carrera->id == $alumno->carrera_id) selected @endif>{{$carrera->nombre}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-row">

								<div class="col-lg-6 form-group">
									<label>Estatus</label>
									<select class="form-control" name="estatus">
										<option value="Activo" @if($alumno->estatus == "Activo") selected @endif>Activo</option>
										<option value="Inactivo" @if($alumno->estatus != "Activo") selected @endif>Inactivo</option>
									</select>
									<input type="submit" class="button button-max button-rounded button-aqua float-right" style="margin-top: 5%;" value="Guardar">
								</div>

								<div class="col-lg-6 form-group">
									<label>Tipo</label>
									<select class="form-control" name="tipo">
										<option value="0" @if($alumno->tipo == "0") selected @endif>Regular</option>
										<option value="1" @if($alumno->tipo != "0") selected @endif>Recursador</option>
									</select>
								</div>
							</div>
						</form>
					<div class="clear"></div>
				</div>
			</div>
			<div class="line"></div>
			<!-- TERMINA INFORMACIÓN GENERAL -->

		</div>
	</div>
@endsection


@section("js")
	<!-- Bootstrap Data Table Plugin -->
	<script>

		$(document).ready(function() {


		});
	</script>

@endsection