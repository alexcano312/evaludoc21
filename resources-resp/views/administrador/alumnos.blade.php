@extends("administrador.layout.main")
@section("titulohead")
	Alumnos | Administrador
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" />
	<link rel="stylesheet" href="/css/components/bs-switches.css" type="text/css" />
@endsection

@section("titulo-pagina")
	Alumnos
@endsection

@section("contenido")
	<div class="content-wrap">
				<div class="container clearfix">
					<div class="table-responsive">
						<a href="#" class="button button-border button-rounded button-green color-naranja" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="icon-line-circle-plus"></i>Agregar Alumno</a>
						@foreach($errors->get("generales") as $error)
							<span class="text-danger">
								{{$error}}
							</span>
						@endforeach
						<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-body">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myModalLabel">Agregar nuevo alumnos</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										</div>
										<div class="modal-body">
											<p>Agrega la siguiente información para agregar un nuevo </a>.</p>
											<form style="max-width: 100rem;" method="post" action="{{route("generales.agregar.alumno")}}">
												{{csrf_field()}}
												@foreach($errors->get("generales") as $error)
													<span class="text-danger">
														{{$error}}
													</span>
												@endforeach
												<div class="form-group">
													<label for="nombre">Nombre</label>
													<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa el nombre del alumno" required="" autocomplete="off">
												</div>
												@foreach($errors->get("nombre") as $error)
													<span class="text-danger">
														{{$error}}
													</span>
												@endforeach
												<div class="form-group">
													<label for="apellidos">Apellidos</label>
													<input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ingresa los apellidos" required="" autocomplete="off">
												</div>
												@foreach($errors->get("apellidos") as $error)
													<span class="text-danger">
														{{$error}}
													</span>
												@endforeach
												<div class="form-group">
													<label for="matricula">Matricula</label>
													<input type="text" class="form-control" name="matricula" id="matricula" placeholder="Ingresa la matricula" required="" autocomplete="off">
												</div>
												@foreach($errors->get("matricula") as $error)
													<span class="text-danger">
														{{$error}}
													</span>
												@endforeach
												<div class="form-group">
													<label for="sexo">Sexo</label>
													<select class="form-control" id="sexo" name="sexo">
														<option value="1">Masculino</option>
														<option value="0">Femenino</option>
													</select>
													<small id="emailHelp" class="form-text text-muted">El estatus permite utilizar la actividad.</small>
												</div>
												<div class="form-group">
													<label for="tipo">Tipo</label>
													<select class="form-control" id="tipo" name="tipo">
														<option value="0">Regular</option>
														<option value="1">Recursador</option>
													</select>
												</div>
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
													<label for="nombre-generacion">Generación</label>
													<select class="form-control" name="generacionId" id="nombre-generacion">
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
												<div class="form-group">
													<label for="estatus">Estatus</label>
													<select class="form-control" id="estatus" name="estatus">
														<option value="1">Activo</option>
														<option value="0">Inactivo</option>
													</select>
												</div>
												<center>
													<button type="submit" class="button button-border button-rounded button-aqua"><i class="icon-inbox"></i>Agregar Alumno</button>
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
									<th>Tipo</th>
									<th>Matricula</th>
									<th>Sexo</th>
									<th>Generación</th>
									<th>Carrera</th>
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
                                    <th>Tipo</th>
									<th>Matricula</th>
									<th>Sexo</th>
                                    <th>Generación</th>
									<th>Carrera</th>
                                    <th>Estatus</th>
									<th>Detalle</th>
                                    <th>Editar</th>
									<th>Eliminar</th>
								</tr>
							</tfoot>
							<tbody>
								@foreach($alumnos as $alumno)
									<tr>
										<td>{{$loop->index + 1}}</td>
										<td>{{$alumno->nombre}} {{$alumno->apellidos}}</td>
										<td>
											@if($alumno->tipo == 0)
												Regular
											@else
												Recursador
											@endif
										</td>
										<td>{{$alumno->matricula}}</td>
										<td>
											@if($alumno->sexo == 0)
												Femenino
											@else
												Masculino
											@endif
										</td>
										<td>{{$alumno->generacion->nombre}}</td>
										<td>{{$alumno->carrera->nombre}}</td>
										<td>
											<div class="pts-switcher">
												<div class="switch">
													<input id="switch-toggle-pricing-tenure" class="switch-toggle switch-toggle-round" type="checkbox">
													<label for="switch-toggle-pricing-tenure"></label>
												</div>
											</div>
										</td>
										<td>
											<center>
												<a href="#" class="button button-mini button-rounded button-dark"><i class="icon-edit2"></i>Ver</a>
											</center>
										</td>
										<td>
											<center>
												<a href="{{route("administrador.vista-alumno.detalle",["id" =>$alumno->id])}}" class="button button-mini button-rounded button-aqua"><i class="icon-edit2"></i>Editar</a>
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

			function pricingSwitcher( elementCheck, elementParent, elementPricing ) {
				elementParent.find('.pts-left,.pts-right').removeClass('pts-switch-active');
				elementPricing.find('.pts-switch-content-left,.pts-switch-content-right').addClass('hidden');

				if( elementCheck.filter(':checked').length > 0 ) {
					elementParent.find('.pts-right').addClass('pts-switch-active');
					elementPricing.find('.pts-switch-content-right').removeClass('hidden');
				} else {
					elementParent.find('.pts-left').addClass('pts-switch-active');
					elementPricing.find('.pts-switch-content-left').removeClass('hidden');
				}
			}

			$('.pts-switcher').each( function(){
				var element = $(this),
						elementCheck = element.find(':checkbox'),
						elementParent = $(this).parents('.pricing-tenure-switcher'),
						elementPricing = $( elementParent.attr('data-container') );

				pricingSwitcher( elementCheck, elementParent, elementPricing );

				elementCheck.on( 'change', function(){
					pricingSwitcher( elementCheck, elementParent, elementPricing );
				});
			});

		});

	</script>

@endsection