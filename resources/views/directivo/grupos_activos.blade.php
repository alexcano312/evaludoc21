@extends("directivo.layout.main")
@section("titulohead")
	Grupo Activos | Directivo
@endsection
@section("css")
	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="/css/components/bs-datatable.css" type="text/css" xmlns="http://www.w3.org/1999/html"/>
@endsection

@section("titulo-pagina")
		Grupo Activo
@endsection
@section("url")
	<li class="breadcrumb-item"><a href="{{route("directivo.inicio")}}">Inicio</a></li>
	<li class="breadcrumb-item"><a href="{{route("directivo.grupos")}}">Grupos</a></li>
	<li class="breadcrumb-item"><a href="#">Activos</a></li>
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
			@foreach($errors->get("generales") as $error)
			<span class="text-danger">
				{{$error}}
			</span>
			@endforeach
			<br>
			<div class="row">
				<div class="col-lg-2">
					<div class="form-row">
						<center><h3 class="text-center texto-naranja">Filtro</h3></center>
						<div class="col-lg-12">

								<div class="form-group">
									<label>Carrera: </label>
									<select class="form-control" id="carrera" name="carrera">
										<option>Selecciona...</option>
										@foreach($carreras as $carrera)
											<option value="{{$carrera->id}}">{{$carrera->nombre}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Cuatrimestre: </label>
									<select class="form-control" id="cuatrimestre" name="cuatrimestre">
										<option>Selecciona...</option>
										@foreach($cuatrimestres as $cuatrimestre)
											<option value="{{$cuatrimestre->id}}">{{$cuatrimestre->nombre}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Evaluación:</label>
									<select class="form-control" id="evaluacion" name="evaluacion">
										<option>Selecciona...</option>
										@foreach($evaluaciones as $evluacion)
											<option value="{{$evluacion->id}}">{{$evluacion->nombre}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Año</label>
									<select class="form-control" id="anio" name="anio">
										<option>Selecciona...</option>
										<?php
										for ($x = 2016; $x < 2026; $x++){
											echo "<option value='$x'>$x</option>";
										}
										?>
									</select>
								</div>
							<input type="hidden" value="{{route("directivo.filtro.grupos")}}" id="ruta">
								<center><button class="button button-rounded button-aqua" id="filtrar-btn">Buscar</button</center>

						</div>
					</div>
				</div>
				<div class="col-lg-10">
					<div class="form-row">
						<center><h3 class="text-center texto-naranja">Grupos</h3></center>
						<div class="clear"></div>
						<div class="col-lg-12">
							<table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th>#</th>
									<th>Nombre</th>
									<th>Clave</th>
									<th>Evaluación</th>
									<th>Carrera</th>
									<th>Cuatrimestre</th>
									<th>Año</th>
									<th>Editar</th>
									<th>Eliminar</th>
								</tr>
								</thead>
								<tfoot>
								<tr>
									<th>#</th>
									<th>Nombre</th>
									<th>Clave</th>
									<th>Evaluación</th>
									<th>Carrera</th>
									<th>Cuatrimestre</th>
									<th>Año</th>
									<th>Editar</th>
									<th>Eliminar</th>
								</tr>
								</tfoot>
								<tbody id="tabla-filtro">
								@foreach($grupos as $grupo)
									<tr class="">
										<td>{{$loop->index + 1}}</td>
										<td>{{$grupo->nombre}}</td>
										<td>{{$grupo->slug}}</td>
										<td>{{$grupo->evaluacion->nombre}}</td>
										<td>{{$grupo->carrera->nombre}}</td>
										<td>{{$grupo->cuatrimestre->nombre}}</td>
										<td>{{$grupo->anio}}</td>
										<td>
											<center>
                                                <a href="{{route("directivo.grupos.filtrados",[$grupo->id])}}" class="button button-mini button-rounded button-aqua"><i class="icon-edit2"></i>Editar</a>

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
	<input type="hidden" id="ruta-filtro" value="{{route("directivo.grupos.filtrados")}}">
@endsection

@section("js")
	<!-- Bootstrap Data Table Plugin -->
	<script src="/js/components/bs-datatable.js"></script>
	<script src="/js/typehead.js"></script>
	<script>

		$(document).ready(function() {

			var gruposFiltrados = [];

			$('#filtrar-btn').click(function () {

				var carrera = $("#carrera").val();
				var cuatrimestre = $("#cuatrimestre").val();
				var evaluacion = $("#evaluacion").val();
				var anio = $("#anio").val();
				var ruta = $("#ruta").val();

				$.ajax({
					url: ruta+"/"+carrera+"/"+cuatrimestre+"/"+evaluacion+"/"+anio,
					dataType: 'json',
					cache: false,
					success:function (respuesta) {


						$("#tabla-filtro").empty();

						var texto = "";

						respuesta.forEach(function (elemento) {
							texto = texto + '<tr class=""><td><input type="checkbox" valor="'+elemento.id+'" class="filtro-aplicado"></td><td>'+elemento.nombre+'</td><td>'+elemento.slug+'</td><td>'+elemento.nombreEvaluacion+'</td><td>'+elemento.nombreCarrera+'</td><td>'+elemento.nombreCuatrimestre+'</td><td>'+elemento.anio+'</td><td></td><td></td></tr>';
						});

						// -- Insertar elementos en la tabla
						$("#tabla-filtro").html(texto);

						$('.filtro-aplicado').click(function () {

							var idGrupo = $(this).attr("valor");

							// -- Si el id ya esta en el array entonces eliminarlo
							if(!$(this).prop('checked')){
								 var i = gruposFiltrados.indexOf( idGrupo );

								 if ( i !== -1 ) {
									 gruposFiltrados.splice( i, 1 );
									 if(gruposFiltrados.length < 1){
										 $("#datatable1_filter").empty();
									 }
									 return;
								 }
							}

							// -- Si no se encuentra en el array agregarlo
							if(jQuery.inArray(idGrupo,gruposFiltrados)){
								gruposFiltrados.push($(this).attr("valor"));
							}


							if(gruposFiltrados.length > 0){
								$("#datatable1_filter").html('<button class="button button-rounded button-aqua" id="editar-grupos-btn">Editar Grupos</button');
							}

							$('#editar-grupos-btn').click(function () {

								var urlFiltro = $("#ruta-filtro").val();
								window.location.href = urlFiltro+"/"+gruposFiltrados;

							});
						});

					},
					error:function () {
						console.log(":(");
					}
				});

			});




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
