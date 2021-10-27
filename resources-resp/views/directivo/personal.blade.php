@extends("directivo.layout.main")
@section("titulohead")
	Personal | Directivo
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
@endsection

@section("titulo-pagina")
	Personal
@endsection


@section("contenido")
	<div class="content-wrap">
		<div class="container clearfix">
			<div class="table-responsive">
				<a href="#" id="abrir-registro" class="button button-border button-rounded button-green color-naranja" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="icon-line-circle-plus"></i>Agregar Persona</a>
				<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-body">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Agregar nueva persona</h4>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								</div>
								<div class="modal-body">
									<p>Ingresa la siguiente información para agregar una persona nueva</a>.</p>
									<form style="max-width: 100rem;" action="{{route("generales.agregar.persona")}}" method="post">
										{{csrf_field()}}
										@foreach($errors->get("generales") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach
										<div class="form-group">
											<label for="nombre-persona">Nombre</label>
											<input type="text" class="form-control" id="nombre-persona" name="nombrePersona" placeholder="Ingresa el nombre de la persona" required="">
										</div>
										@foreach($errors->get("nombrePersona") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach
										<div class="form-group">
											<label for="apellidos-persona">Apellidos</label>
											<input type="text" class="form-control" id="apellidos-persona" name="apellidosPersona" placeholder="Ingresa los apellidos de la persona" required="">
										</div>
										@foreach($errors->get("apellidosPersona") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach
										<div class="form-group">
											<label for="apellidos-persona">Sexo</label>
											<select class="form-control" name="sexo">
												<option value="0">Femenino</option>
												<option value="1">Masculino</option>
											</select>
										</div>
										@foreach($errors->get("sexo") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach
										<div class="form-group">
											<label for="matricula-persona">Matricula</label>
											<input class="form-control" id="matricula-persona" name="matriculaPersona" placeholder="Ingresa la matricula">
										</div>
										@foreach($errors->get("matriculaPersona") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach
										<div class="form-group">
											<label for="correo-persona">Correo</label>
											<input type="email" class="form-control" id="correo-persona" name="correoPersona" placeholder="Ingresa el correo">
										</div>
										@foreach($errors->get("correoPersona") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach
										<div class="form-group">
											<label for="password-persona">Contraseña</label><input type="button" id="generar-codigo" class="button float-right" value="Generar Contraseña">
											<input type="text" class="form-control" id="password-persona" name="passwordPersona" required readonly>
										</div>
										@foreach($errors->get("passwordPersona") as $error)
											<span class="text-danger">
												{{$error}}
											</span>
										@endforeach

										<center>
											<button type="submit" class="button button-border button-rounded button-aqua"><i class="icon-inbox"></i>Agregar Persona</button>
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
							<th>Matricula</th>
							<th>Correo</th>
							<th>Confirmación</th>
							<th>Detalle</th>
							<th>Editar</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>#</th>
							<th>Nombre</th>
							<th>Matricula</th>
							<th>Correo</th>
							<th>Confirmación</th>
							<th>Detalle</th>
							<th>Editar</th>
							<th>Eliminar</th>
						</tr>
					</tfoot>
					<tbody>
						@foreach($personal as $persona)
							<tr class="">
								<td>{{$loop->index + 1}}</td>
								<td>{{$persona->nombre}} {{$persona->apellidos}}</td>
								<td>{{$persona->matricula}}</td>
								<td>{{$persona->correo}}</td>
								@if($persona->confirmacion == 1)
									<td>Confirmado</td>
								@else
									<td>
										<center>
											<a href="#" class="button button-mini button-rounded button-warning" data-toggle="modal" data-target=".bs-example-modal-lg-editar"><i class="icon-edit2"></i>Enviar</a>
										</center>
									</td>
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
									<p>Edita la siguiente información de la persona</a>.</p>
									<form style="max-width: 100rem;">
										<div class="form-group">
											<label for="nombre">Nombre</label>
											<input type="text" class="form-control" id="editar-nombre-personal" name="nombrePersonal" placeholder="Ingresa el nombre de la persona" required="">
										</div>
										<div class="form-group">
											<label for="clave">Clave</label>
											<input type="text" class="form-control" id="editar-clave-personal" name="clavePersonal" placeholder="Ingresa la clave de la persona" required="">
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

			$('#generar-codigo').click(function() {
				var codigo = generarCodigo();
				$("#password-persona").val(codigo);
			});

			$('#abrir-registro').click(function() {
				var codigo = generarCodigo();
				$("#password-persona").val(codigo);
			});
			// -- Genera un código aleatorio
			function generarCodigo(){

				var chars = "0123456789abcdefABCDEF";
				var lon = 6;

				code = "";
				for (x=0; x < lon; x++)
				{
					rand = Math.floor(Math.random()*chars.length);
					code += chars.substr(rand, 1);
				}
				return code;
			}

		});

	</script>

@endsection