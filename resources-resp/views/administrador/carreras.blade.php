@extends("administrador.layout.main")
@section("titulohead")
	Carreras | Administrador
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
@endsection



@section("titulo-pagina")
	Carreras
@endsection


@section("contenido")
	<div class="content-wrap">
		<div class="container clearfix">
			<div class="table-responsive">
				<a href="#" class="button button-border button-rounded button-green color-naranja" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="icon-line-circle-plus"></i>Agregar Carrera</a>
				<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-body">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Agregar nueva Carrera</h4>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								</div>
								<div class="modal-body">
									<p>Ingresa la siguiente información para agregar una carrera nueva. </a>.</p>
									<form style="max-width: 100rem;" action="{{route("generales.agregar.carrera")}}" method="post">
										{{csrf_field()}}
										@foreach($errors->get("generales") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach
										<div class="form-group">
											<label for="nombre-area">Nombre</label>
											<input type="text" class="form-control" id="nombre-area" name="nombreCarrera" placeholder="Ingresa el nombre de la carrera" required="">
										</div>
										@foreach($errors->get("nombre") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach
										<div class="form-group">
											<label for="nombre-area">Area</label>
											<select class="form-control" name="areaId" id="nombre-area">
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
							<th>Nombre</th>
							<th>Area</th>
							<th>Clave</th>
							<th>Detalle</th>
							<th>Editar</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>#</th>
							<th>Nombre</th>
							<th>Area</th>
							<th>Clave</th>
							<th>Detalle</th>
							<th>Editar</th>
							<th>Eliminar</th>
						</tr>
					</tfoot>
					<tbody>
						@foreach($carreras as $carrera)
							<tr class="">
								<td>{{$loop->index + 1}}</td>
								<td>{{$carrera->nombre}}</td>
								<td>{{$carrera->area->nombre}}</td>
								<td>{{$carrera->slug}}</td>
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
									<p>Edita la siguiente información de la carrera</a>.</p>
									<form style="max-width: 100rem;">
										<div class="form-group">
											<label for="nombre">Nombre</label>
											<input type="text" class="form-control" id="editar-nombre-carrera" name="nombreCarrera" placeholder="Ingresa el nombre de la carrera " required="">
										</div>
										<div class="form-group">
											<label for="clave">Clave</label>
											<input type="text" class="form-control" id="editar-clave-carrera" name="claveCarrera" placeholder="Ingresa la clave de la carrera " required="">
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