@extends("administrador.layout.main")
@section("titulohead")
	Inscripción de Materias a Grupo | Administrador
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
@endsection

@section("titulo-pagina")
	Inscripción de Materias a Grupo
@endsection


@section("contenido")
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

	<div class="content-wrap">
		<div class="container clearfix">
			<div class="table-responsive">
				<a href="#" class="button button-border button-rounded button-green color-naranja" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="icon-line-circle-plus"></i>Agregar Materias a Grupo</a>
				<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-body">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Agregar nueva Materia a grupo</h4>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								</div>
								<div class="modal-body">
									<p>Ingresa la siguiente información para agregar una materia nueva. </a>.</p>
									<form style="max-width: 100rem;" action="{{route("generales.agregar.grupo.materia")}}" method="post">
										{{csrf_field()}}
										@foreach($errors->get("generales") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach
										<div class="form-group">
											<label for="nombre-persona">Selecciona evaluado</label>
											<input type="text" class="form-control" autocomplete="off" id="buscarNombre" name="buscarNombre" placeholder="Selecciona el nombre de la persona" required="">
											<small id="emailHelp" class="form-text text-muted">Si no encuentras la persona, preciona <a target="_blank" href="{{route("administrador.personal")}}">aquí</a> para agregar una persona nueva.</small>
											<input type="hidden" name="evaluadoId" id="idEvaluado">
										</div>
										@foreach($errors->get("nombrePersona") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach
										<div class="form-group">
											<label for="buscarGrupo">Selecciona Grupo</label>
											<input type="text" class="form-control" autocomplete="off" id="buscarGrupo" name="buscarGrupo" placeholder="Selecciona el nombre del grupo" required="">
											<small id="emailHelp" class="form-text text-muted">Si no encuentras el grupo, preciona <a target="_blank" href="{{route("administrador.grupos")}}">aquí</a> para agregar una grupo nuevo.</small>
											<input type="hidden" name="grupoId" id="idGrupo">
										</div>
										@foreach($errors->get("nombrePersona") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach
										<div class="form-group">
											<label for="buscarGrupo">Selecciona Materia</label>
											<input type="text" class="form-control" autocomplete="off" id="buscarMateria" name="buscarMateria" placeholder="Selecciona el nombre de la materia" required="">
											<small id="emailHelp" class="form-text text-muted">Si no encuentras la materia, preciona <a target="_blank" href="{{route("administrador.grupos")}}">aquí</a> para agregar una materia nueva.</small>
											<input type="hidden" name="materiaId" id="idMateria">
										</div>
										@foreach($errors->get("buscarMateria") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach
										<center>
											<button type="submit" class="button button-border button-rounded button-aqua"><i class="icon-inbox"></i>Agregar Carrera</button>
										</center>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				@foreach($errors->get("generales") as $error)
					<span class="text-danger">
						{{$error}}
					</span>
				@endforeach
				<br><br>
				<table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>#</th>
							<th>Evaluado</th>
							<th>Materia</th>
							<th>Grupo</th>
							<th>Editar</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>#</th>
							<th>Evaluado</th>
							<th>Materia</th>
							<th>Grupo</th>
							<th>Editar</th>
							<th>Eliminar</th>
						</tr>
					</tfoot>
					<tbody>
						@foreach($inscripciones as $inscripcion)
							<tr class="">
								<td>{{$loop->index + 1}}</td>
								<td>{{$inscripcion->evaluado->persona->nombre}} {{$inscripcion->evaluado->persona->apellidos}}</td>
								<td>{{$inscripcion->materia->materia->nombre}}</td>
								<td>{{$inscripcion->grupo->nombre}}</td>
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
				<div class="modal fade bs-example-modal-lg-editar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-body">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Editar </a></h4>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								</div>
								<div class="modal-body">
									<p>Edita la siguiente información de la inscripción de la materia</a>.</p>
									<form style="max-width: 100rem;">
										<div class="form-group">
											<label for="nombre">Nombre</label>
											<input type="text" class="form-control" id="editar-nombre-inscripcionMateria" name="nombreInscripcionMateria" placeholder="Ingresa el nombre de la inscripción de materia" required="">
										</div>
										<div class="form-group">
											<label for="clave">Clave</label>
											<input type="text" class="form-control" id="editar-clave-inscripcionMateria" name="claveInscripcionMateria" placeholder="Ingresa la clave de la inscripción de materia" required="">
											<small id="emailHelp" class="form-text text-muted">La clave es importante, es para utilizarla.</small>
										</div>
										<center>
											<button type="submit" class="button button-border button-rounded button-aqua"><i class="icon-edit2"></i>Editar</button>
										</center>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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

			var rutaEvalaudos = "{{route('general.buscar.evaluados')}}?q=%QUERY%";
			var personal = new Bloodhound({
				datumTokenizer: Bloodhound.tokenizers.obj.whitespace('q'),
				queryTokenizer: Bloodhound.tokenizers.whitespace,
				prefetch: rutaEvalaudos,
				remote: {
					url: rutaEvalaudos,
					wildcard: '%QUERY%'
				},
			});

			// -- Buscar Personal
			$('#buscarNombre').typeahead(null, {
				name: 'personal',
				display: 'nombreCompleto',
				source: personal,
			});

			$('#buscarNombre').bind('typeahead:select', function(ev, dato) {
				console.log(dato);
				$("#idEvaluado").val(dato.id);
			});

			// -- Buscar Grupo
			var rutaGrupos = "{{route('general.buscar.grupos')}}?q=%QUERY%&";

			var grupo = new Bloodhound({
				datumTokenizer: Bloodhound.tokenizers.obj.whitespace('q'),
				queryTokenizer: Bloodhound.tokenizers.whitespace,
				prefetch: rutaGrupos,
				remote: {
					url: rutaGrupos,
					wildcard: '%QUERY%'
				},
			});
			$('#buscarGrupo').typeahead(null, {
				name: 'personal',
				display: 'nombre',
				source: grupo,
			});

			$('#buscarGrupo').bind('typeahead:select', function(ev, dato) {

				$("#idGrupo").val(dato.id);

				var rutaMateriasInscripciones = "{{route('general.buscar.inscripciones.materias')}}?q=%QUERY%&g="+dato.id+"";

				var inscripciones = new Bloodhound({
					datumTokenizer: Bloodhound.tokenizers.obj.whitespace('q'),
					queryTokenizer: Bloodhound.tokenizers.whitespace,
					prefetch: rutaMateriasInscripciones,
					remote: {
						url: rutaMateriasInscripciones,
						wildcard: '%QUERY%'
					},
				});

				$('#buscarMateria').typeahead(null, {
					name: 'inscripciones',
					display: 'nombreMateria',
					source: inscripciones,
				});

				$('#buscarMateria').bind('typeahead:select', function(ev, dato) {
					console.log(dato);
					$("#idMateria").val(dato.id);
				});
			});

			// -- Buscar Materia





		});

	</script>

@endsection