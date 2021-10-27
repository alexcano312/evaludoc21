@extends("administrador.layout.main")
@section("titulohead")
	Cuatrimestres | Administrador
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
@endsection


@section("titulo-pagina")
	Cuatrimestres
@endsection


@section("contenido")
	<div class="content-wrap">				
		<div class="container clearfix">
					<div class="table-responsive">
						<a href="#" class="button button-border button-rounded button-green" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="icon-line-circle-plus"></i>Agregar Cuatrimestre</a>
						<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-body">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myModalLabel">Agregar nuevo cuatrimestre</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										</div>
										<div class="modal-body">
											<p>Ingresa la siguiente información para agregar un nuevo cuatrimestre.</p>
											<form style="max-width: 100rem;" id="form_cuatrimestre" method="post" action="{{route("generales.agregar.cuatrimestre")}}">
												{{csrf_field()}}
												@foreach($errors->get("generales") as $error)
													<span class="text-danger">
														{{$error}}
													</span>
												@endforeach
												<div class="form-group">
													<label for="nombre">Nombre</label>
													<input type="text" class="form-control" id="nombre" name="cuatrimestreNombre" placeholder="Ingresa el nombre del cuatrimestre" required="">
												</div>
												@foreach($errors->get("cuatrimestreNombre") as $error)
													<span class="text-danger">
														{{$error}}
													</span>
												@endforeach
												<div class="form-group">
													<label for="clave">Clave</label>
													<input type="number" class="form-control" id="clave" name="claveCuatrimestre" placeholder="10" required="">
													<small id="emailHelp" class="form-text text-muted">Debe ser numérico.</small>
												</div>
												@foreach($errors->get("claveCuatrimestre") as $error)
													<span class="text-danger">
														{{$error}}
													</span>
												@endforeach
												<center>
													<button type="submit" class="button button-border button-rounded button-aqua"><i class="icon-inbox"></i>Agregar Cuatrimestre</button>
												</center>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
						<br><br>
						<table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Nombre</th>
									<th>Clave</th>
									<th>Editar</th>
									<th>Eliminar</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>#</th>
									<th>Nombre</th>
									<th>Clave</th>
									<th>Editar</th>
									<th>Eliminar</th>
								</tr>
							</tfoot>
							<tbody>
								@foreach($cuatrimestres as $cuatrimestre)
								<tr>
									<td>{{$loop->index + 1}}</td>
									<td>{{$cuatrimestre->nombre}}</td>
									<td>{{$cuatrimestre->clave}}</td>
									<td>
										<center>
											<a href="#" class="button button-mini button-rounded button-aqua editar-cuatrimestre" data-toggle="modal" data-target=".bs-example-modal-lg-editar" cuatrimestre-id="{{$cuatrimestre->id}}" nombre="{{$cuatrimestre->nombre}}" clave="{{$cuatrimestre->clave}}"><i class="icon-edit2"></i>Editar</a>
										</center>
									</td>
									<td>
										<center>
											<a href="#" class="button button-mini button-rounded button-red eliminar-cuatrimestre" cuatrimestre-id="{{$cuatrimestre->id}}"><i class="icon-trash2"></i>Eliminar</a>
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
											<h4 class="modal-title" id="myModalLabel">Editar cuatrimestre</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										</div>
										<div class="modal-body">
											<p>Edita la siguiente información del cuatrimestre.</p>
											<form style="max-width: 100rem;" id="formulario-editar-cuatrimestre">
												<input type="hidden" name="id" id="editar-id">
												<div class="form-group">
													<label for="nombre">Nombre</label>
													<input type="text" class="form-control" id="editar-nombre" name="editar-nombre-cuatrimestre" name="nombreCuatrimestre" placeholder="Ingresa el nombre del cuatrimestre" required="">
												</div>
												<div class="form-group">
													<label for="clave">Clave</label>
													<input type="text" class="form-control" id="editar-clave" name="editar-clave-cuatrimestre" name="claveCuatrimestre" placeholder="Ingresa la clave del cuatrimestre" required="">
													<small id="emailHelp" class="form-text text-muted">La clave es importante.</small>
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
	<script src="/js/plugins/sweetalert.min.js"></script>
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