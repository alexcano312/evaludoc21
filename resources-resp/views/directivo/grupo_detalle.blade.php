@extends("directivo.layout.main")
@section("titulohead")
	Grupo {{$grupo->nombre}} | Directivo
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
@endsection

@section("titulo-pagina")
		Grupo {{$grupo->nombre}}
@endsection
@section("url")
	<li class="breadcrumb-item"><a href="{{route("directivo.inicio")}}">Inicio</a></li>
	<li class="breadcrumb-item"><a href="{{route("directivo.grupos")}}">Grupos</a></li>
	<li class="breadcrumb-item"><a href="#">{{$grupo->nombre}}</a></li>
@endsection

<style>
	.tt-query {
		-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
	}

	.tt-hint {
		color: #999
	}

	.tt-menu {    /* used to be tt-dropdown-menu in older versions */
		width: 422px;
		margin-top: 4px;
		padding: 4px 0;
		background-color: #fff;
		border: 1px solid #ccc;
		border: 1px solid rgba(0, 0, 0, 0.2);
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
		-webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
		-moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
		box-shadow: 0 5px 10px rgba(0,0,0,.2);
	}

	.tt-suggestion {
		padding: 3px 20px;
		line-height: 24px;
	}

	.tt-suggestion.tt-cursor,.tt-suggestion:hover {
		color: #fff;
		background-color: #0097cf;

	}
</style>

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

					<form method="post" action="{{route("generales.directivo.editar.grupo")}}">
					{{csrf_field()}}
					<div class="form-row">
						<div class="col-lg-6 form-group">
							<input name="id" value="{{$grupo->id}}" type="hidden">
							<div class="form-group">
								<label>Nombre:</label>
								<input type="text" class="form-control" value="{{$grupo->nombre}}" name="nombre" autocomplete="off">
							</div>
							<div class="form-group">
								<label>Clave</label>
								<input type="text" class="form-control" value="{{$grupo->slug}}"  readonly>
							</div>
							<div class="form-group">
								<label>Año</label>
								<select class="form-control" name="anio">
									<?php
										for ($x = 2016; $x < 2026; $x++){
											if($grupo->anio == $x){
												echo "<option value='$x' selected>$x</option>";
											}
											echo "<option value='$x'>$x</option>";
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-lg-6 form-group">
							<div class="form-group">
								<label>Carrera</label>
								<select class="form-control" name="carrera">
									@foreach($carreras as $carrera)
										<option value="{{$carrera->id}}" @if($grupo->carrera->id == $carrera->id) selected @endif>{{$carrera->nombre}}</option>
									@endforeach
								</select>
							</div>
							<diV class="form-group">
								<label>Cuatrimestre</label>

								<select class="form-control" name="cuatrimestre">
									@foreach($cuatrimestres as $cuatrimestre)
										<option value="{{$cuatrimestre->id}}" @if($grupo->cuatrimestre->id == $cuatrimestre->id) selected @endif>{{$cuatrimestre->nombre}}</option>
									@endforeach
								</select>
							</diV>

							<diV class="form-group">
								<label>Estatus</label>
								<select class="form-control" name="estatus">
									<option value="1" @if($grupo->estatus == 1) selected @endif>Activo</option>
									<option value="0" @if($grupo->estatus == 0) selected @endif>Inactivo</option>
								</select>
							</diV>
							<input style="margin-top: 7%;" type="submit" class="button button-rounded button-aqua float-right" value="Editar Grupo">
						</div>
					</div>
					</form>
					<div class="clear"></div>

				</div>
			</div>
			<div class="line"></div>
			<!-- TERMINA INFORMACIÓN GENERAL -->
			@foreach($errors->get("generales") as $error)
			<span class="text-danger">
				{{$error}}
			</span>
			@endforeach
			<br>
			<!-- INFORMACIÓN ALUMNOS -->
			<div class="row">
				<div class="col-lg-3">
					<h3 class="texto-naranja">Agregar Alumno</h3>
					<form action="{{route("generales.agregar.alumno.grupo")}}" method="post">
						{{csrf_field()}}
						<div class="w-100"></div>
						<div class="col-12 form-group">
							<label>Nombre:</label>
							<input type="text" name="buscarNombre" id="buscar-nombre" class="form-control buscar" placeholder="Nombre del alumno" autocomplete="off" required>
							<input type="hidden" value="" id="idAlumno" name="alumnoId">
							<input type="hidden" name="grupoId" value="{{$grupo->id}}">
							@foreach($errors->get("alumnoId") as $error)
								<span class="text-danger">
								{{$error}}
							</span>
							@endforeach
						</div>

						<div class="col-12 form-group">
							<label>Estatus:</label>
							<select class="form-control" name="estatus">
								<option value="1">Activo</option>
								<option value="0">Inactivo</option>
							</select>
						</div>

						<div class="col-12">
							<button type="submit" class="button button-border button-rounded button-aqua"><i class="icon-inbox"></i>Agregar Alumno</button>
						</div>
					</form>
				</div>

				<div class="col-lg-8 offset-lg-1">
						<div class="form-row">
							<center><h3 class="text-center texto-naranja">Alumnos en el Grupo</h3></center>
							<div class="clear"></div>
							<div class="col-lg-12">
								<table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
									<tr>
										<th>#</th>
										<th>Nombre</th>
										<th>Tipo</th>
										<th>Evaluación</th>
										<th>Estatus</th>
										<th>Editar</th>
										<th>Eliminar</th>
									</tr>
									</thead>
									<tfoot>
									<tr>
										<th>#</th>
										<th>Nombre</th>
										<th>Tipo</th>
										<th>Evaluación</th>
										<th>Estatus</th>
										<th>Editar</th>
										<th>Eliminar</th>
									</tr>
									</tfoot>
									<tbody>
									@foreach($inscripciones as $inscripcion)
										<tr class="">
											<td>{{$loop->index + 1}}</td>
											<td>{{$inscripcion->alumno->nombre}} {{$inscripcion->alumno->apellidos}}</td>
											<td>
												@if($inscripcion->alumno->tipo == 1)
													Recursador
												@else
													Regular
												@endif
											</td>
											<td>Si</td>
											<td>
												@if($inscripcion->alumno->estatus == "Activo")
													Activo
												@else
													Inactivo
												@endif
											</td>
											<td>
												<center>
													<a href="#" class="button button-mini button-rounded button-aqua" data-toggle="modal" data-target=".bs-example-modal-lg-editar"><i class="icon-edit2"></i>Editar</a>
												</center>
											</td>
											<td>
												<center>
													<a href="#" class="button button-mini button-rounded button-red"><i class="icon-trash2"></i>Eliminar</a>
												</center>
											</td>
										</tr>
									@endforeach
									</tbody>
								</table>
							</div>
						</div>

					<div class="clear"></div>

				</div>
			</div>
			<!-- TERMINA INFORMACIÓN ALUMNOS -->

			<!-- COMIENZA INFORMACIÓN MATERIAS -->
			<div class="line"></div>
			<div class="row">
				<div class="col-lg-3">
					<h3 class="texto-naranja">Agregar Materia</h3>
					@foreach($errors->get("generales") as $error)
						<span class="text-danger">
							{{$error}}
						</span>
					@endforeach
					<form action="{{route("generales.agregar.grupo.materia")}}" method="post">
						{{csrf_field()}}
						<div class="w-100"></div>
						<div class="col-12 form-group">
							<label>Nombre Evaluado:</label>
							<input type="text" name="buscarNombre" id="buscar-nombre-evaluado" class="form-control" placeholder="Nombre del evaluado" autocomplete="off" required>
							<input type="hidden" value="" id="idEvaluado" name="evaluadoId">
							<input type="hidden" name="grupoId" value="{{$grupo->id}}">
							@foreach($errors->get("evaluadoId") as $error)
								<span class="text-danger">
								{{$error}}
							</span>
							@endforeach
						</div>
						<div class="col-12 form-group">
							<label>Materia:</label>
							<select class="form-control" name="materiaId" required>
								@foreach($materias as $materia)
									<option value="{{$materia->id}}">{{$materia->materia->nombre}}</option>
								@endforeach
							</select>
							<small id="emailHelp" class="form-text text-muted">Si no encuentras la materia, preciona <a target="_blank" href="{{route("administrador.materias")}}">aquí</a> para agregar una materia nueva.</small>
							@foreach($errors->get("materiaId") as $error)
								<span class="text-danger">
								{{$error}}
							</span>
							@endforeach
						</div>

						<div class="col-12">
							<button type="submit" class="button button-border button-rounded button-aqua"><i class="icon-inbox"></i>Agregar Materia</button>
						</div>
					</form>
				</div>

				<div class="col-lg-8 offset-lg-1">
					<div class="form-row">
						<center><h3 class="text-center texto-naranja">Materias del grupo</h3></center>
						<div class="clear"></div>
						<div class="col-lg-12">
							<table id="datatable2" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th>#</th>
									<th>Materia</th>
									<th>Evaluado</th>
									<th>Editar</th>
									<th>Eliminar</th>
								</tr>
								</thead>
								<tfoot>
								<tr>
									<th>#</th>
									<th>Materia</th>
									<th>Evaluado</th>
									<th>Editar</th>
									<th>Eliminar</th>
								</tr>
								</tfoot>
								<tbody>
								@foreach($inscripcionesMaterias as $inscripcion)
									<tr class="">
										<td>{{$loop->index + 1}}</td>
										<td>{{$inscripcion->materia->materia->nombre}}</td>
										<td>{{$inscripcion->evaluado->persona->nombre}} {{$inscripcion->evaluado->persona->apellidos}}</td>
										<td>
											<center>
												<a href="#" class="button button-mini button-rounded button-aqua" data-toggle="modal" data-target=".bs-example-modal-lg-editar"><i class="icon-edit2"></i>Editar</a>
											</center>
										</td>
										<td>
											<center>
												<a href="#" class="button button-mini button-rounded button-red"><i class="icon-trash2"></i>Eliminar</a>
											</center>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>

					<div class="clear"></div>

				</div>
			</div>
			<!-- TERMINA INFORMACIÓN MATERIAS -->
		</div>
	</div>
@endsection

@section("js")
	<!-- Bootstrap Data Table Plugin -->
	<script src="/js/components/bs-datatable.js"></script>
	<script src="/js/typehead.js"></script>
	<script>

		$(document).ready(function() {
			$('#datatable1').dataTable({
			    language: {
			        "decimal": "",
			        "emptyTable": "No hay información",
			        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
			        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
			        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
			        "infoPostFix": "",
			        "thousands": ",",
			        "lengthMenu": "Mostrar _MENU_ Entradas",
			        "loadingRecords": "Cargando...",
			        "processing": "Procesando...",
			        "search": "Buscar:",
			        "zeroRecords": "Sin resultados encontrados",
			        "paginate": {
			            "first": "Primero",
			            "last": "Ultimo",
			            "next": "Siguiente",
			            "previous": "Anterior"
			        }
			    },			    
			});
			$('#datatable2').dataTable({
				language: {
					"decimal": "",
					"emptyTable": "No hay información",
					"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
					"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
					"infoFiltered": "(Filtrado de _MAX_ total entradas)",
					"infoPostFix": "",
					"thousands": ",",
					"lengthMenu": "Mostrar _MENU_ Entradas",
					"loadingRecords": "Cargando...",
					"processing": "Procesando...",
					"search": "Buscar:",
					"zeroRecords": "Sin resultados encontrados",
					"paginate": {
						"first": "Primero",
						"last": "Ultimo",
						"next": "Siguiente",
						"previous": "Anterior"
					}
				},
			});

		});

		var ruta = "{{route('general.buscar.alumnos')}}?q=%QUERY%";

		var alumnos = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('q'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: ruta,
			remote: {
				url: ruta,
				wildcard: '%QUERY%'
			},
		});

		$('.buscar').typeahead(null, {
			name: 'personal',
			display: 'nombreCompleto',
			source: alumnos,
		});

		$('.buscar').bind('typeahead:select', function(ev, dato) {
			console.log(dato);
			$("#idAlumno").val(dato.id);
		});

		// -- BUSCAR EVALUADOS
		var ruta = "{{route('general.buscar.evaluados')}}?q=%QUERY%";

		var evaluados = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('q'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: ruta,
			remote: {
				url: ruta,
				wildcard: '%QUERY%'
			},
		});

		$('#buscar-nombre-evaluado').typeahead(null, {
			name: 'evaluados',
			display: 'nombreCompleto',
			source: evaluados,
		});

		$('#buscar-nombre-evaluado').bind('typeahead:select', function(ev, dato) {
			console.log(dato.evaluado);
			$("#idEvaluado").val(dato.evaluado.id);
		});


	</script>

@endsection