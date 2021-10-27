@extends("administrador.layout.main")
@section("titulohead")
	Alumno {{$alumno->nombre}} | Administrador
@endsection
@section("css")
@endsection

@section("titulo-pagina")
		Alumno {{$alumno->nombre}}
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
					<h3 class="texto-naranja">Información General</h3>

						<form>
							<div class="form-row">
								<div class="col-lg-6 form-group">
									<label>Nombre:</label>
									<input type="text" class="form-control" value="{{$alumno->nombre}}" autocomplete="off">
								</div>
								<div class="col-lg-6 form-group">
									<label>Apellidos</label>
									<input type="text" class="form-control" value="{{$alumno->apellidos}}" autocomplete="off">
								</div>
							</div>
							<div class="form-row">
								<div class="col-lg-6 form-group">
									<label>Matricula:</label>
									<input type="text" class="form-control" value="{{$alumno->matricula}}" autocomplete="off">
								</div>
								<div class="col-lg-6 form-group">
									<label>Generación</label>
									<select class="form-control" name="estatus">
										@foreach($generaciones as $generacion)
											<option value="{{$generacion->id}}">{{$generacion->nombre}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-lg-6 form-group">
									<label>Carrera:</label>
									<select class="form-control" name="estatus">
										@foreach($carreras as $carrera)
											<option value="{{$carrera->id}}">{{$carrera->nombre}}</option>
										@endforeach
									</select>
								</div>
								<div class="col-lg-6 form-group">
									<label>Estatus</label>
									<select class="form-control" name="estatus">
										<option value="Activo">Activo</option>
										<option value="Inactivo">Inactivo</option>
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