@extends("directivo.layout.main")
@section("titulohead")
	Tutotres | Directivo
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
@endsection


@section("titulo-pagina")
	Tutores
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
				<a href="#" id="abrir-registro" class="button button-border button-rounded button-green color-naranja" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="icon-line-circle-plus"></i>Agregar Tutor</a>
				<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-body">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Agregar Nuevo Tutor</h4>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								</div>
								<div class="modal-body">
									<p>Agrega la siguiente información para agregar un tutor nuevo</a>.</p>
									<form style="max-width: 100rem;" action="{{route("generales.agregar.tutor")}}" method="post">
										{{csrf_field()}}
										@foreach($errors->get("generales") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach
										<div class="form-group">
											<label for="nombre-persona">Selecciona la persona</label>
											<input type="text" class="form-control buscar" autocomplete="off" id="nombre-tutor" name="buscarTutor" placeholder="Selecciona el nombre de la persona" required="">
											<small id="emailHelp" class="form-text text-muted">Si no encuentras la persona, preciona <a target="_blank" href="{{route("directivo.personal")}}">aquí</a> para agregar una persona nueva.</small>
											<input type="hidden" name="personaId" id="idPersona">
										</div>
										<div class="form-group">
											<label for="area">Area</label>
											<select class="form-control" id="area" name="areaId">
												@foreach($areas as $area)
													<option value="{{$area->id}}">{{$area->nombre}}</option>
												@endforeach
											</select>
										</div>
										@foreach($errors->get("areaId") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach
										<div class="form-group">
											<label for="area">Estatus</label>
											<select class="form-control" id="estatus" name="estatus">
												<option value="1">Activo</option>
												<option value="2">Inactivo</option>
											</select>
										</div>
										<center>
											<button type="submit" class="button button-border button-rounded button-aqua"><i class="icon-inbox"></i>Agregar Tutor</button>
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
							<th>Nombre</th>
							<th>Estatus</th>
							<th>Detalle</th>
							<th>Editar</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>#</th>
							<th>Nombre</th>
							<th>Estatus</th>
							<th>Detalle</th>
							<th>Editar</th>
							<th>Eliminar</th>
						</tr>
					</tfoot>
					<tbody>
						@foreach($tutores as $tutor)
							<tr class="">
								<td>{{$loop->index + 1}}</td>
								<td>{{$tutor->personal->nombre}} {{$tutor->personal->apellidos}}</td>
								@if($tutor->estatus == 1)
									<td>
										Activo
									</td>
								@else
									<td>Inactivo</td>
								@endif

								<td>
									<center>
										<a href="#" class="button button-mini button-rounded button-dark" data-toggle="modal" data-target=".bs-example-modal-lg-editar"><i class="icon-edit2"></i>Ver</a>
									</center>
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
				<div class="modal fade bs-example-modal-lg-editar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-body">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Editar </a></h4>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								</div>
								<div class="modal-body">
									<p>Edita la siguiente información del alumno</a>.</p>
									<form style="max-width: 100rem;">
										<div class="form-group">
											<label for="nombre">Nombre</label>
											<input type="text" class="form-control" id="nombre" placeholder="Ingresa el nombre del </a>" required="">
										</div>
										<div class="form-group">
											<label for="clave">Clave</label>
											<input type="text" class="form-control" id="clave" placeholder="Ingresa la clave del </a>" required="">
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

			var ruta = "{{route('general.buscar.personal')}}?q=%QUERY%";

			var personal = new Bloodhound({
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
				source: personal,
			});

			$('.buscar').bind('typeahead:select', function(ev, dato) {
				console.log(dato);
				$("#idPersona").val(dato.id);
			});


		});

	</script>

@endsection