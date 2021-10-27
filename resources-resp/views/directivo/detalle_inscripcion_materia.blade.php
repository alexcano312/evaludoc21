@extends("directivo.layout.main")
@section("titulohead")
	Editar Inscripción d eMateria
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->

@endsection

@section("titulo-pagina")
		Editar Inscripción de Materia
@endsection
@section("url")
	<li class="breadcrumb-item"><a href="{{route("directivo.inicio")}}">Inicio</a></li>
	<li class="breadcrumb-item"><a href="{{route("directivo.inscripciones.materias")}}">Inscripciones Materia</a></li>
	<li class="breadcrumb-item"><a href="#">{{$inscripcion->id}}</a></li>
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
								<div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Correcto</strong> ¡Información guardada!.</div>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							</div>
						@endif
					</h3>
						<form style="max-width: 100rem;" action="{{route("generales.editar.inscripcion.materia")}}" method="post">
							{{csrf_field()}}
							@foreach($errors->get("generales") as $error)
								<span class="text-danger">
									{{$error}}
								</span>
							@endforeach
							<input type="hidden" name="inscripcion_id" value="{{$inscripcion->id}}">
							<div class="form-group">
								<label for="nombre-carrera">Carrera</label>
								<select class="form-control" name="carreraId" id="nombre-carrera">
									@foreach($carreras as $carrera)
										<option value="{{$carrera->id}}" @if($carrera->id == $inscripcion->carrera_id) Selected @endif>{{$carrera->nombre}}</option>
									@endforeach
								</select>
							</div>
							@foreach($errors->get("carreraId") as $error)
								<span class="text-danger">
												{{$error}}
											</span>
							@endforeach
							<div class="form-group">
								<label for="nombre-materia">Materia</label>
								<select class="form-control" name="materiaId" id="nombre-materia">
									@foreach($materias as $materia)
										<option value="{{$materia->id}}" @if($materia->id == $inscripcion->catalogo_materia_id) Selected @endif>{{$materia->nombre}}</option>
									@endforeach
								</select>
							</div>
							@foreach($errors->get("carreraId") as $error)
								<span class="text-danger">
												{{$error}}
											</span>
							@endforeach
							<div class="form-group">
								<label for="nombre-cuatrimestre">Cuatrimestre</label>
								<select class="form-control" name="cuatrimestreId" id="nombre-cuatrimestre">
									@foreach($cuatrimestres as $cuatrimestre)
										<option value="{{$cuatrimestre->id}}" @if($cuatrimestre->id == $inscripcion->cuatrimestre_id) Selected @endif >{{$cuatrimestre->nombre}} -> ({{$cuatrimestre->clave}})</option>
									@endforeach
								</select>
							</div>
							@foreach($errors->get("cuatrimestreId") as $error)
								<span class="text-danger">
												{{$error}}
											</span>
							@endforeach
							<div class="form-group">
								<label for="nombre-plan">Plan de estudios</label>
								<select class="form-control" name="planId" id="nombre-plan">
									@foreach($planes as $plan)
										<option value="{{$plan->id}}" @if($plan->id == $inscripcion->plan_estudios_id) Selected @endif>{{$plan->nombre}}</option>
									@endforeach
								</select>
							</div>
							@foreach($errors->get("cuatrimestreId") as $error)
								<span class="text-danger">
												{{$error}}
											</span>
							@endforeach
							<center>
								<button type="submit" class="button button-border button-rounded button-aqua"><i class="icon-inbox"></i>Editar Inscripción</button>
							</center>
						</form>
					<div class="clear"></div>

				</div>
			</div>

		</div>
	</div>
@endsection

@section("js")

@endsection