@extends("alumno.layout.main")

@section("css")
@endsection


@section("titulo")
<title>Login - Evaluación Docente | Alumno</title>
@endsection

@section("titulo-pagina")

@endsection

@section("contenido")
<div class="content-wrap">
	<div class="container clearfix">

		<div class="accordion accordion-lg divcenter nobottommargin clearfix" style="max-width: 550px;">
			@foreach($errors->get("generales") as $error)
				<span class="text-danger ">
					{{$error}}
				</span>
			@endforeach
			@if (session('success'))
				<h3>
					<label class="form-check-label text-success float-right" for="defaultCheck1">
						¡Cuenta creada!
					</label>
				</h3>
			@endif
			<div class="acctitle"><i class="acc-closed icon-lock3"></i><i class="acc-open icon-unlock"></i>Inicia con tu cuenta</div>
			<div class="acc_content clearfix">
				<form id="login-form" name="login-form" class="nobottommargin" action="{{route("alumno.verifica.credenciales")}}" method="post">
					{{csrf_field()}}
					<div class="col_full">
						<label for="login-form-username">Matricula:</label>
						<input type="number" id="login-form-username" name="matricula" class="form-control" required="" />
					</div>

					<div class="col_full">
						<label for="login-form-username">Ingresa la Matricula Nuevamente:</label>
						<input type="number" id="login-form-username-2" name="matricula_2" class="form-control" required="" />
					</div>

					<div class="col_full nobottommargin">
						<input type="submit" class="button button-3d nomargin float-right fondo-naranja" id="login-form-submit" name="login-form-submit" value="Iniciar">
					</div>
				</form>
			</div>

			<div class="acctitle"><i class="acc-closed icon-user4"></i><i class="acc-open icon-ok-sign"></i>¿Necesitas una cuenta?</div>
			<div class="acc_content clearfix">
				<form id="register-form" name="register-form" class="nobottommargin" action="{{route("generales.agregar.alumno")}}" method="post">
					{{csrf_field()}}
					<div class="col_full">
						<label for="register-form-nombre">Nombre:</label>
						<input type="text" id="register-form-nombre" name="nombre" value="" class="form-control text-uppercase" required="" autocomplete="off"/>
					</div>
					@foreach($errors->get("nombre") as $error)
						<span class="text-danger">
							{{$error}}
						</span>
					@endforeach
					<div class="col_full">
						<label for="register-form-username">Apellidos:</label>
						<input type="text" id="register-form-apellidos-paterno" name="apellidos" value="" class="form-control text-uppercase" autocomplete="off" required/>
					</div>
					@foreach($errors->get("apellidos") as $error)
						<span class="text-danger">
							{{$error}}
						</span>
					@endforeach
					<div class="col_full">
						<label for="register-form-matricula">Matricula:</label>
						<input type="number" id="register-form-matricula" name="matricula" value="" class="form-control" required="" autocomplete="off"/>
					</div>
					@foreach($errors->get("matricula") as $error)
						<span class="text-danger">
							{{$error}}
						</span>
					@endforeach
					<div class="col_full">
						<label for="register-form-sexo">Sexo:</label>
						<select class="form-control" name="sexo">
							<option value="1">Masculino</option>
							<option value="0">Femenino</option>
						</select>
					</div>

					<div class="col_full">
						<label for="register-form-sexo">Generación:</label>
						<select class="form-control" name="generacionId">
							@foreach($generaciones as $generacion)
								<option value="{{$generacion->id}}">{{$generacion->nombre}}</option>
							@endforeach
						</select>
					</div>
					@foreach($errors->get("generacionId") as $error)
						<span class="text-danger">
							{{$error}}
						</span>
					@endforeach
					<div class="col_full">
						<label for="register-form-sexo">Carrera:</label>
						<select class="form-control" name="carreraId">
							@foreach($carreras as $carrera)
								<option value="{{$carrera->id}}">{{$carrera->nombre}}</option>
							@endforeach
						</select>
					</div>
					@foreach($errors->get("carreraId") as $error)
						<span class="text-danger">
							{{$error}}
						</span>
					@endforeach
					<div class="col_full">
						<label for="register-form-sexo">Actividad Extracurricular:</label>
						<select class="form-control" name="actividadId">
							<option value="0">Sin Actividad</option>
							@foreach($actividades as $actividad)
								<option value="{{$actividad->id}}">{{$actividad->nombre}}</option>
							@endforeach
						</select>
					</div>
					@foreach($errors->get("actividadId") as $error)
						<span class="text-danger">
							{{$error}}
						</span>
					@endforeach
					<div class="col_full">
						<label for="register-form-sexo">Grupo:</label>
						<select class="form-control" name="grupoId">
							@foreach($grupos as $grupo)
								<option value="{{$grupo->id}}">{{$grupo->nombre}}</option>
							@endforeach
						</select>
					</div>
					@foreach($errors->get("actividadId") as $error)
						<span class="text-danger">
							{{$error}}
						</span>
					@endforeach
					<input type="hidden" name="estatus" value="Activo">
					<input type="hidden" name="tipo" value="0">
					<div class="col_full nobottommargin">
						<input type="submit" class="button button-3d nomargin float-right fondo-naranja" id="register-form-submit" name="register-form-submit" value="Registrar ahora">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section("js")
@endsection