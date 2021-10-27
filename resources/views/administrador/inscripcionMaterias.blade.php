@extends("administrador.layout.main")
@section("titulohead")
	Inscripciones de Materia | Administrador
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
@endsection

@section("titulo-pagina")
	Inscripciones de Materia
@endsection


@section("contenido")
	<div class="content-wrap">
		<div class="container clearfix">
			<div class="table-responsive">
				<a href="#" class="button button-border button-rounded button-green color-naranja" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="icon-line-circle-plus"></i>Agregar Materias</a>
				<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-body">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Agregar nueva Materia</h4>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								</div>
								<div class="modal-body">
									<p>Ingresa la siguiente información para agregar una materia nueva. </a>.</p>
									<form style="max-width: 100rem;" action="{{route("generales.agregar.inscripcion.materia")}}" method="post">
										{{csrf_field()}}
										@foreach($errors->get("generales") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach
										<div class="form-group">
											<label for="nombre-carrera">Carrera</label>
											<select class="form-control" name="carreraId" id="nombre-carrera">
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
										<div class="form-group">
											<label for="nombre-materia">Materia</label>
											<select class="form-control" name="materiaId" id="nombre-materia">
												@foreach($materias as $materia)
													<option value="{{$materia->id}}">{{$materia->nombre}}</option>
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
													<option value="{{$cuatrimestre->id}}">{{$cuatrimestre->nombre}} -> ({{$cuatrimestre->clave}})</option>
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
													<option value="{{$plan->id}}">{{$plan->nombre}})</option>
												@endforeach
											</select>
										</div>
										@foreach($errors->get("cuatrimestreId") as $error)
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
							<th>Materia</th>
							<th>Carrera</th>
							<th>Cuatrimestre</th>
							<th>Plan de estudios</th>
							<th>Editar</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>#</th>
							<th>Materia</th>
							<th>Carrera</th>
							<th>Cuatrimestre</th>
							<th>Plan de estudios</th>
							<th>Editar</th>
							<th>Eliminar</th>
						</tr>
					</tfoot>
					<tbody>
						@foreach($materiasCarreras as $materia)
							<tr class="">
								<td>{{$loop->index + 1}}</td>
								<td>{{$materia->materia->nombre}}</td>
								<td>{{$materia->carrera->nombre}}</td>
								<td>{{$materia->cuatrimestre->nombre}}</td>
								<td>{{$materia->plan->nombre}}</td>
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
		});

	</script>

@endsection